@extends('customer.layout.dashboardMaster')
@section('dashboardContent')
    <h3>جزییات سفارش {{ $orderItem->id }}</h3>
    <hr>
    <div class="col-xs-12">
        <div class="panel panel-default" id="panel">
            <div class="panel-body">
                <h4>محصول انتخابی :</h4>
                <p>{{ $orderItem->category->name." ".$orderItem->product->title }}</p>
                <h4>
                    مشخصات محصول :
                </h4>
                <p>{!! $orderItem->getData() !!} </p>
                <h4>قیمت نهایی : </h4>
                <p>{{ ta_persian_num(number_format($orderItem->getTotalPrice())) }} ریال</p>
            </div>
        </div>
    </div>

@endsection