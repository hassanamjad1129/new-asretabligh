<?php

namespace App\Http\Controllers\Admin;

use App\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OrderItem::where('status', '>', 0)->where('status', '<', 3)->latest()->get();
        return view('admin.orders.index', ['orders' => $orders]);
    }

    public function finished()
    {
        $orders = OrderItem::where('status', '>=', 3)->latest()->get();
        return view('admin.orders.finished', ['orders' => $orders]);
    }

    public function orderDetail(orderItem $orderItem)
    {
        return view('admin.orders.detail', ['orderItem' => $orderItem]);
    }

    private function updateOrderValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'status' => ['required', Rule::in([0, 1, 2, 3, 4])]
        ]);
    }

    public function updateOrder(orderItem $orderItem, Request $request)
    {
        $validator = $this->updateOrderValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->all(), 'failed');
        $orderItem->status = $request->status;
        $orderItem->save();
        $order = $orderItem->order;
        $order->address = $request->address;
        $order->save();
        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
