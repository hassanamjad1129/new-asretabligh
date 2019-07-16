@extends('customer.layout.dashboardMaster')
@section('dashboardContent')
    <h3>جزییات سفارش {{ $orderItem->id }}</h3>
    <hr>
    <div class="col-xs-12">
        <div class="panel panel-default" id="panel">
            <div class="panel-body">
                <div class="col-md-6">
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold">محصول انتخابی :</h5>
                        <p>{{ $orderItem->category->name." ".$orderItem->product->title }}</p>
                    </div>
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold">
                            مشخصات محصول :
                        </h5>
                        <p>سایز فایل : {{ $orderItem->paper->name }}</p>
                        <p>{!! $orderItem->getData() !!} </p>
                        <p>نوع سفارش : {{ $orderItem->getType() }}</p>
                    </div>
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold">قیمت نهایی : </h5>
                        <p>{{ ta_persian_num(number_format($orderItem->getTotalPrice())) }} ریال</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold">تاریخ ثبت سفارش :</h5>
                        <p>{{ jdate(strtotime($orderItem->created_at))->format('H:i Y/m/d') }}</p>
                    </div>
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold">وضعیت سفارش :</h5>
                        <p style="padding: 1rem;background: #329941;color: #FFF;">{{ $orderItem->getStatus() }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection