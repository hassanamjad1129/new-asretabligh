@extends('customer.layout.dashboardMaster')
@section('dashboardContent')
    <style>
        .table-striped td, .table-striped th {
            padding: 20px 10px;
            font-size: 1.2rem;
            text-align: center;
        }
    </style>
    <h3>لیست سفارشات</h3>
    <hr>
    <div class="col-xs-12">
        <div class="panel panel-default" id="panel">
            <div class="panel-body">
                <div style="margin-top: 1rem">
                <a href="" style="border-radius:5px;background-image: linear-gradient(#D60000, #ee5046);color:#FFF;padding:1rem;margin-top: 1rem;margin-bottom: 1rem;font-size:1.2rem">سفارشات آماده شده</a>
                <a href="" style="border-radius:5px;background-image: linear-gradient(#D60000, #ee5046);color:#FFF;padding:1rem;margin-top: 1rem;margin-bottom: 1rem;font-size:1.2rem">سفارشات در حال انجام</a>
                </div>
                <div class="clearfix"></div>
                <table class="table-striped table-bordered table-hover" style="width: 100%;margin-top:2rem">
                    <thead>
                    <tr>
                        <th>شماره سفارش</th>
                        <th>عنوان سفارش</th>
                        <th>تاریخ ثبت سفارش</th>
                        <th>سری</th>
                        <th>مبلغ</th>
                        <th>وضعیت</th>
                        <th>جزییات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ ta_persian_num($order->id) }}</td>
                            <td>{{ $order->category->name."-".$order->product->title }}</td>
                            <td>{{ ta_persian_num(jdate(strtotime($order->created_at))->format(' H:i Y/m/d')) }}</td>
                            <td>{{ ta_persian_num($order->qty) }}</td>
                            <td>{{ta_persian_num(number_format($order->getTotalPrice())) }} ریال</td>
                            <td>عادی</td>
                            <td><a href="{{ route('customer.orderDetail',[$order]) }}" style="border-radius:5px;background-image: linear-gradient(#D60000, #ee5046);color:#FFF;padding:0.2rem 1rem;margin-top: 1rem;margin-bottom: 1rem">جزییات</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection