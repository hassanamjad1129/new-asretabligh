<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\MoneyBagReport;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MoneyBagController extends Controller
{

    /**
     * @param Customer $customer
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function index(Customer $customer)
    {
        $this->authorize('moneybag');

        $reports = $customer->moneybagReport;
        return view('admin.users.moneybag.index', [
            'reports' => $reports,
            'customer' => $customer
        ]);
    }

    /**
     * @param Customer $customer
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create(Customer $customer)
    {
        $this->authorize('moneybag');

        return view('admin.users.moneybag.create', ['customer' => $customer]);
    }

    /**
     * @param Customer $customer
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Customer $customer, Request $request)
    {
        $this->authorize('moneybag');

        $validator = $this->storeValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->all(), 'failed');
        $report = new MoneyBagReport();
        $report->user_id = $customer->id;
        $report->price = str_replace(",", "", $request->price);
        $report->operation = $request->operation;
        $report->description = $request->description;
        $report->save();
        if ($request->operation == 'increase')
            $customer->credit = $customer->credit + $report->price;
        else
            $customer->credit = $customer->credit - $report->price;
        $customer->save();
        return redirect(route('admin.moneybag.index', [$customer]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    private function storeValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'operation' => ['required', Rule::in(['increase', 'decrease'])],
            'price' => ['required'],
        ], [
            'operation.required' => 'عملیات کیف پول الزامیست',
            'operation.in' => 'عملیات کیف پول نامعتبر است',
            'price.required' => 'قیمت الزامیست'
        ]);
    }

    /**
     * @param Customer $customer
     * @param MoneyBagReport $report
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function destroy(Customer $customer, MoneyBagReport $report)
    {
        $this->authorize('moneybag');

        if ($report->operation == 'increase')
            $customer->credit = $customer->credit - $report->price;
        else
            $customer->credit = $customer->credit + $report->price;
        $customer->save();
        $report->delete();
        return redirect(route('admin.moneybag.index', [$customer]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
