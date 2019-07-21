<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\MoneyBagReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MoneyBagController extends Controller
{
    public function index(Customer $customer)
    {
        $reports = $customer->moneybagReport;
        return view('admin.users.moneybag.index', [
            'reports' => $reports,
            'customer' => $customer
        ]);
    }

    public function create(Customer $customer)
    {
        return view('admin.users.moneybag.create', ['customer' => $customer]);
    }

    public function store(Customer $customer, Request $request)
    {
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

    public function destroy(Customer $customer, MoneyBagReport $report)
    {
        if ($report->operation == 'increase')
            $customer->credit = $customer->credit - $report->price;
        else
            $customer->credit = $customer->credit + $report->price;
        $customer->save();
        $report->delete();
        return redirect(route('admin.customer.moneybag.index', [$customer]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
