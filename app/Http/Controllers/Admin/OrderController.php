<?php

namespace App\Http\Controllers\Admin;

use App\OrderItem;
use App\shipping;
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
        $ratio = $request->qty / $orderItem->qty;
        $diff = $orderItem->price * $ratio - $orderItem->price;
        $orderItem->price = $orderItem->price * $ratio;
        $orderItem->qty = $request->qty;
        $orderItem->save();

        foreach ($orderItem->services as $service) {
            $diff += ($service->price * $ratio - $service->price);
            $service->price = $service->price * $ratio;
            $service->save();
        }

        $order = $orderItem->order;
        $order->address = $request->address;
        $oldDeliveryMethod = shipping::find($order->delivery_method);
        $newDeliveryMethod = shipping::find($request->delivery);
        $diff += $newDeliveryMethod->price - $oldDeliveryMethod->price;
        $order->delivery_method = $request->delivery;
        $order->save();


        $user = $orderItem->user;
        $user->credit = $user->credit - $diff;
        $user->save();

        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
