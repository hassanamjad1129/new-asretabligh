<?php

namespace App\Http\Controllers\Customer;

use App\MoneyBagReport;
use App\Services\Gateway;
use App\Services\Mellat\Mellat;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            $gateway->price($request->price * 10)->ready();
            return $gateway->redirect();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
