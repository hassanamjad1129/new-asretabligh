@extends('customer.layout.dashboardMaster')
@section('dashboardContent')
    <h4>جزییات سفارش {{ ta_persian_num($orderItem->id) }}</h4>
    <hr>
    <div class="col-xs-12">
        <div class="panel panel-default" id="panel">
            <div class="panel-body">
                <div class="col-md-6">
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">محصول انتخابی :</h5>
                        <p style="display: inline-block">{{ $orderItem->category->name." ".$orderItem->product->title }}</p>
                    </div>
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold">
                            مشخصات محصول :
                        </h5>
                        <p style="line-height: 2rem;">سایز فایل : {{ $orderItem->getPaperName() }}</p>
                        <p style="line-height: 2rem;">{!! $orderItem->getData() !!} </p>
                        <p style="line-height: 2rem;">نوع سفارش : {{ $orderItem->getType() }}</p>
                    </div>
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">قیمت نهایی : </h5>
                        <p style="display: inline-block">{{ ta_persian_num(number_format($orderItem->getTotalPrice())) }}
                            ریال</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">تاریخ ثبت سفارش :</h5>
                        <p style="display: inline-block">{{ $orderItem->getOrderDate() }}</p>
                    </div>
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">وضعیت سفارش :</h5>
                        <p style="    padding: 0.5rem;
    background: #329941;
    color: #FFF;
    width: auto;
    display: inline-block;
    border-radius: 2rem;">{{ $orderItem->getStatus() }}</p>
                    </div>
                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">سری سفارش :</h5>
                        <p style="display: inline-block">{{ ta_persian_num($orderItem->qty) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection