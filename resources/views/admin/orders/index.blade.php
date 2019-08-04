@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <p>سفارشات در حال انجام</p>
        </div>
        <div class="card-block">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>مشتری</th>
                    <th>محصول</th>
                    <th>قیمت</th>
                    <th>تاریخ</th>
                    <th>وضعیت</th>
                    <th>جزییات</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                ?>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->category->name."|".$order->product->title }}</td>
                        <td>{{ ta_persian_num(number_format($order->getTotalPrice())) }} ریال</td>
                        <td>{{ $order->getOrderDate() }}</td>
                        <td>{{ $order->getStatus() }}</td>
                        <td><a href="{{ route('admin.orders.orderDetail',[$order]) }}" class="btn btn-danger">جزییات</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection