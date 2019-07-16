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

                    <div style="margin-bottom: 1rem">
                        <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">فایل های سفارش :</h5>
                        <div class="col-md-6">
                            <?php
                            $format = explode('.', $orderItem->files)[1];
                            if($format == 'pdf'){
                            ?>
                            <a href="{{ url($orderItem->files->front_file) }}">
                                <img src="{{ asset('/clientAssets/img/icons8-pdf-128.png') }}" style="width: 100%"
                                     alt="">
                            </a>
                            <?php
                            }else{
                            ?>
                            <a href="{{ url($orderItem->files->front_file) }}">
                                <img src="{{ asset($orderItem->files->front_file) }}" style="width: 100%"
                                     alt="">
                            </a>

                            <?php
                            }
                            ?>
                        </div>

                    </div>

                </div>
                <div class="col-xs-12">
                    <h5 style="margin-bottom: 0.5rem;font-weight: bold">توضیحات مشتری :</h5>
                    <p style="line-height: 2rem">{!! $orderItem->description?nl2br($orderItem->description):"توضیحات ندارد" !!}</p>
                    <hr>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12">
                    <h4 style="font-weight: bold;margin-bottom: 1rem">خدمات پس از چاپ</h4>
                </div>
                @foreach($orderItem->services as $service)
                    <div class="col-md-6">
                        <div style="margin-bottom: 1rem">
                            <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">عنوان خدمت :</h5>
                            <p style="display: inline-block">{{ $service->service->name }}</p>
                        </div>
                        <div style="margin-bottom: 1rem">
                            <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">مشخصات :</h5>
                            <p style="line-height: 2rem">{!! $service->getData() !!}</p>
                            @if($service->type)
                                <p style="line-height: 2rem">نوع کار : {{ $service->getType() }}</p>
                            @endif
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div style="margin-bottom: 1rem">
                            <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">هزینه خدمت :</h5>
                            <p style="display: inline-block">{{ ta_persian_num(number_format($service->price)) }}
                                ریال</p>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>

@endsection