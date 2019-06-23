@extends("client.layout.master")
@section('content')
    <style>
        li {
            list-style: none;
        }

        .table tr:first-child td {
            border: none;
        }

    </style>
    <div class="col-xs-11">
        <h3>جزییات سفارش شماره {{ $order->id }}</h3>
        <hr>
    </div>
    <div class="col-xs-1">
        <a href="#" onClick="/customers/orders" class="btn btn-primary">بازگشت <i class="fa fa-arrow-left"></i></a>
    </div>
    @if(count($errors->feild)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->feild->all() as $error)
                    <li><i class="fa fa-warning"></i> {!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(count($errors->success)>0)
        <div class="alert alert-success">
            <ul>
                @foreach($errors->success->all() as $error)
                    <li><i class="fa fa-check"></i> {!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-info-circle" aria-hidden="true"></i> مشخصات سفارش</h4>
            </div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>عنوان سفارش</td>
                        <td>{{ $order->cart->category->catName }}</td>
                    </tr>
                    <tr>
                        <td>مشخصات سفارش</td>
                        <td>
                            <?php
                            $values = unserialize($order->cart->attr_values);
                            foreach ($values as $item) {
                                $value = \App\attr_value::find($item);
                                echo $value->attr->attr_name . " : " . explode('$', $value->value)[0] . "<br /><br />";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>تعداد</td>
                        <td>{{ $order->cart->qty }} عدد</td>
                    </tr>
                    <tr>
                        <td>مبلغ کل سفارش(بدون مالیات)</td>
                        <td>{{ number_format((str_replace(",","",$order->cart->total_price))) }} ریال</td>
                    </tr>
                    <tr>
                        <td>مبلغ کل سفارش(با مالیات)</td>
                        <td>{{ number_format((str_replace(",","",$order->cart->total_price))*(1+(0.01*\App\option::where('option_name','tax')->first()->option_value))) }}
                            ریال
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        $files = $order->cart->uploads;
        ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-file-image-o" aria-hidden="true"></i>@if($files->count()) فایل های ارسالی@else رنگ
                    انتخابی @endif</h4>
            </div>
            <div class="panel-body">
                <table class="table">
                    @if($files->count())
                        @foreach($files as $file)
                            <tr>
                                <td><?php echo $file->filesID->upload_name; ?></td>
                                <td><a href="{{ url('/customer/download/'.$file->fileName) }}">نمایش </a></td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-truck" aria-hidden="true"></i> مشخصات ارسال</h4>
            </div>
            <div class="panel-body">
                <span style="font-weight: bold;font-size: 16px">آدرس ارسال :</span>
                <br>
                <br>
                <p>@if($order->address) {{ $order->address }}@else تحویل در چاپخانه@endif</p>
                <br>

            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-credit-card-alt" aria-hidden="true"></i> مشخصات پرداخت</h4>
            </div>
            <div class="panel-body">
                <?php
                $pays = $order->pay;
                $i = 1;
                foreach ($pays as $pay):
                echo "<strong>پرداخت شماره " . $i++ . "</strong>";
                ?>
                <table class="table">
                    <tr>
                        <td>وضعیت کلی پرداخت</td>
                        <td>@if($pay->status==-2) انصراف از پرداخت@elseif($pay->status==-1) تراکنش
                            ناموفق @elseif($pay->status==0) در انتظار پرداخت@elseif($pay->status==1)
                                پرداخت موفقیت آمیز@else حساب دفتری (همکاری) @endif</td>
                    </tr>
                    <tr>
                        <td>شماره پیگیری</td>
                        <td>@if($pay->ref_code) {{ $pay->ref_code }} @else ندارد @endif</td>
                    </tr>
                    <tr>
                        <td>مبلغ پرداختی</td>
                        <td>{{ number_format($pay->price) }} ریال</td>
                    </tr>
                    <tr>
                        <td>زمان آخرین وضعیت پرداخت</td>
                        <td style="direction: ltr;text-align: right;">{{ jdate(strtotime($pay->created_at))->format('datetime') }}</td>
                    </tr>
                </table>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    توضیحات سفارش
                </h4>
            </div>
            <div class="panel-body">
                {!! nl2br($order->description) !!}
            </div>
        </div>
    </div>
    <div class="page-content-wrap">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">وضعیت سفارش</div>
                    <div class="panel-body">
                        <div class="block">
                            <div class="wizard">

                                <ul>
                                    <li>
                                        <a href="#step-1" @if($order->status>=0) class="done" @endif>
                                            <span class="stepNumber">1</span>
                                            <span class="stepDesc">مرحله آغازین سفارش<br/><small>تایید نشده</small></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-2" @if($order->status>=1) class="done" @endif>
                                            <span class="stepNumber">2</span>
                                            <span class="stepDesc">مرحله 2<br/><small>تایید اولیه</small></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-3" @if($order->status>=2) class="done" @endif>
                                            <span class="stepNumber">3</span>
                                            <span class="stepDesc">مرحله 3<br/><small>در دست چاپ</small></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-4" @if($order->status>=3) class="done" @endif>
                                            <span class="stepNumber">4</span>
                                            <span class="stepDesc">مرحله 4<br/><small>اماده تحویل</small></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END DEFAULT WIZARD -->
@endsection