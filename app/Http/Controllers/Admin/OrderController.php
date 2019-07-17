<?php

namespace App\Http\Controllers\Admin;

use App\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
