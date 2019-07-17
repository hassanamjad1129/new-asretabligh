@extends('admin.layout.master')
@section('content')
    <h4>جزییات سفارش {{ ta_persian_num($orderItem->id) }}</h4>
    <hr>
    <div class="col-xs-12">
        <div class="card">
            <div class="card-block">
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
                        <div class="clearfix"></div>
                        <div class="col-md-3" style="    padding: 0.5rem;border: 1px solid rgba(0,0,0,.45);
    border-radius: 0.8rem;">
                            <?php
                            $format = explode('.', $orderItem->files->front_file)[1];
                            if($format == 'pdf'){
                            ?>
                            <a href="{{ url('/orderFiles/'.$orderItem->files->front_file) }}" target="_blank">
                                <img src="{{ asset('/clientAssets/img/icons8-pdf-128.png') }}" style="width: 100%"
                                     alt=""/>
                                <p style="text-align: center;color: #545454;font-weight: bold;
    font-size: 1.3rem;">فایل رو</p>

                            </a>
                            <?php
                            }else{
                            ?>
                            <a href="{{ url('/orderFiles/'.$orderItem->files->front_file) }}" target="_blank">
                                <img src="{{ asset('/orderFiles/'.$orderItem->files->front_file) }}" style="width: 100%"
                                     alt="">
                                <p style="text-align: center;    color: #545454;
    font-weight: bold;
    font-size: 1.3rem;">فایل رو</p>

                            </a>
                            <?php
                            }
                            ?>
                        </div>
                        @if($orderItem->type=='double' and $orderItem->product->typeRelatedFile)
                            <div class="col-md-3" style="    padding: 0.5rem;border: 1px solid rgba(0,0,0,.45);
    border-radius: 0.8rem;">
                                <?php
                                $format = explode('.', $orderItem->files->back_file)[1];
                                if($format == 'pdf'){
                                ?>
                                <a href="{{ url('/orderFiles/'.$orderItem->files->back_file) }}" target="_blank">
                                    <img src="{{ asset('/clientAssets/img/icons8-pdf-128.png') }}" style="width: 100%"
                                         alt=""/>
                                    <p style="text-align: center;    color: #545454;
    font-weight: bold;
    font-size: 1.3rem;">فایل پشت</p>
                                </a>
                                <?php
                                }else{
                                ?>
                                <a href="{{ url('/orderFiles/'.$orderItem->files->back_file) }}" target="_blank">
                                    <img src="{{ asset('/orderFiles/'.$orderItem->files->back_file) }}"
                                         style="width: 100%"
                                         alt="">
                                    <p style="text-align: center;    color: #545454;
    font-weight: bold;
    font-size: 1.3rem;">فایل پشت</p>

                                </a>
                                <?php
                                }
                                ?>
                            </div>
                        @endif
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
                        @if($service->type)
                            <div style="margin-bottom: 1rem">
                                <h5 style="margin-bottom: 0.5rem;font-weight: bold;display: inline-block">فایل های خدمت
                                    :</h5>
                                <div class="clearfix"></div>
                                <div class="col-md-3" style="padding: 0.5rem;border: 1px solid rgba(0,0,0,.45);
    border-radius: 0.8rem;">
                                    <?php
                                    $format = explode('.', $service->files->front_file)[1];
                                    if($format == 'pdf'){
                                    ?>
                                    <a href="{{ url($service->files->front_file) }}" target="_blank">
                                        <img src="{{ asset('/clientAssets/img/icons8-pdf-128.png') }}"
                                             style="width: 100%"
                                             alt=""/>
                                        <p style="text-align: center;    color: #545454;
    font-weight: bold;
    font-size: 1.3rem;">فایل رو</p>

                                    </a>
                                    <?php
                                    }else{
                                    ?>
                                    <a href="{{ url($service->files->front_file) }}" target="_blank">
                                        <img src="{{ asset($service->files->front_file) }}" style="width: 100%"
                                             alt="">
                                        <p style="text-align: center;    color: #545454;
    font-weight: bold;
    font-size: 1.3rem;">فایل رو</p>

                                    </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                                @if($service->type=='double')
                                    <div class="col-md-3" style="    border: 1px solid rgba(0,0,0,.45);
    border-radius: 0.8rem;    padding: 0.5rem;">
                                        <?php
                                        $format = explode('.', $service->files->back_file)[1];
                                        if($format == 'pdf'){
                                        ?>
                                        <a href="{{ url($service->files->back_file) }}"
                                           target="_blank">
                                            <img src="{{ asset('/clientAssets/img/icons8-pdf-128.png') }}"
                                                 style="width: 100%"
                                                 alt=""/>
                                            <p style="text-align: center;    color: #545454;
    font-weight: bold;
    font-size: 1.3rem;">فایل پشت</p>
                                        </a>
                                        <?php
                                        }else{
                                        ?>
                                        <a href="{{ url($service->files->back_file) }}"
                                           target="_blank">
                                            <img src="{{ asset($service->files->back_file) }}" style="width: 100%"
                                                 alt="">
                                            <p style="text-align: center;    color: #545454;
    font-weight: bold;
    font-size: 1.3rem;">فایل پشت</p>
                                        </a>
                                        <?php } ?>
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                    <div class="clearfix"></div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
@endsection