<?php

namespace App\Http\Controllers\Customer;

use App\MoneyBagReport;
use App\Services\Gateway;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Larautility\Gateway\Exceptions\RetryException;
use Larautility\Gateway\Mellat\Mellat;

class MoneybagController extends Controller
{
    public function index()
    {
        $reports = MoneyBagReport::where('user_id', auth()->guard('customer')->user()->id)->latest()->get();
        return view('customer.moneybag.index', ['reports' => $reports]);
    }

    public function increaseCredit(Request $request)
    {
        if ($request->price < 100) {
            return back()->withErrors(['مبلغ وارد شده کمتر از حد تعیین شده است'], 'failed');
        }
        try {
            $gateway = Gateway::make(new Mellat());
            $gateway->setCallback(route('customer.moneybag.verifyPayment'));
            $gateway->price($request->price)->ready();
            return $gateway->redirect();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function verifyIncreaseMoneybag(Request $request)
    {
        try {

            $gateway = Gateway::verify();
            $transaction_id = $request->input('transaction_id');
            $transaction = DB::table('gateway_transactions')->where('id', $transaction_id)->first();
            $profile = auth()->guard('customer')->user();
            $profile->increment('credit', $transaction->price);
            $profile->save();

            $log = new MoneyBagReport();
            $log->user_id = auth()->guard('customer')->user()->id;
            $log->price = $transaction->price;
            $log->operation = "increase";
            $log->description = "افزایش اعتبار از طریق درگاه";
            $log->save();
            return redirect(route('customer.moneybag'))->withErrors(['پرداخت با موفقیت انجام شد'], 'success');

        } catch (RetryException $e) {
            return redirect(route('customer.moneybag'))->withErrors([$e->getMessage()], 'failed');

        } catch (\Exception $e) {
            return redirect(route('customer.moneybag'))->withErrors([$e->getMessage()], 'failed');
        }
    }
}
