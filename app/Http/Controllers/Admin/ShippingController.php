<?php

namespace App\Http\Controllers\Admin;

use App\shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    public function create()
    {
        return view('admin.shippings.create');
    }

    public function store(Request $request)
    {
        $shipping = new shipping();
        $shipping->name = $request->name;
        $shipping->description = $request->description;
        $shipping->take_address = $request->take_address ? $request->take_address : 0;
        $shipping->icon = $request->filepath;
        $shipping->price = $request->price;
        $shipping->save();
        return redirect(route('admin.shipping.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function edit(shipping $shipping)
    {
        return view('admin.shippings.edit', ['shipping' => $shipping]);
    }

    public function update(shipping $shipping, Request $request)
    {
        $shipping->name = $request->name;
        $shipping->description = $request->description;
        $shipping->take_address = $request->take_address ? $request->take_address : 0;
        $shipping->icon = $request->filepath;
        $shipping->price = $request->price;
        $shipping->save();
        return redirect(route('admin.shipping.index'))->withErrors(['عملیات با موفقیت انجام شد.'], 'success');
    }

    public function index()
    {
        $shippings = shipping::all();
        return view('admin.shippings.index', ['shippings' => $shippings]);
    }

    public function destroy(shipping $shipping)
    {
        $shipping->delete();
        return redirect(route('admin.shipping.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function restore(shipping $shipping)
    {
        $shipping->status = 0;
        $shipping->save();
        return redirect(route('admin.shipping.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

}
