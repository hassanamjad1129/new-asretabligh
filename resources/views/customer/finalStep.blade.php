@extends('client.layout.master')
@section('content')
    <style>
        .table-striped td, .table-striped th {
            padding: 20px 10px;
            font-size: 1.2rem;
            text-align: center;
        }

        input[type="radio"] + label > div, input[type="checkbox"] + label > div {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        input[type="radio"]:checked + label > div, input[type="checkbox"]:checked + label > div {
            border: 3px solid #e52531 !important;
        }


    </style>
    <div class="container">
        <div class="col-xs-12">
            <h3 style="text-align: center;font-weight: bold;margin-bottom: 2rem">تایید نهایی سبد خرید</h3>
            <form action="{{ route('customer.storeOrder') }}" method="post">
                @csrf
                <div class="col-xs-12" style="margin-top: 2rem">
                    <h4 style="width: 250px;background: #444;color: #FFF;text-align: center;padding: 1rem 0;border-radius: 10px;border-bottom-left-radius: 0;border-bottom-right-radius: 0">
                        فاکتورهای شما</h4>
                    <div class="panel panel-default" id="panel">
                        <div class="panel-body">
                            <div style="margin-top: 1rem">
                                <table class="table-striped table-bordered table-hover" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> عنوان سفارش</th>
                                        <th>جزییات سفارش</th>
                                        <th>فایل های ارسالی</th>
                                        <th>وضعیت سبد</th>
                                        <th>مبلغ کل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    $sum = 0;?>
                                    @if($carts)
                                        @foreach($carts as $key=>$cart)
                                            <tr>
                                                <td style="font-weight: bold">{{ ta_persian_num($i++) }}</td>
                                                <?php
                                                $product = \App\Models\Product::find($cart['product']);
                                                ?>
                                                <td>{{ $product->category->name.' '.$product->name }}</td>
                                                <td><?php
                                                    $data = explode('-', $cart['data']);
                                                    foreach ($data as $value) {
                                                        $value = \App\Models\ProductValue::find($value);
                                                        echo ta_persian_num($value->property->name) . ':' . ta_persian_num($value->name) . '<br/>';
                                                    }
                                                    if ($cart['type'] == 'single') {
                                                        echo "نوع کار : یک رو";
                                                    } else {
                                                        echo "نوع کار : دو رو";
                                                    }
                                                    ?></td>
                                                <td>
                                                    <?php
                                                    $fileSplited = explode('.', $cart['files']['front']);
                                                    ?>
                                                    <img src="{{ $fileSplited[count($fileSplited)-1]=='pdf'?'/clientAssets/img/icons8-pdf-128.png':asset('orderFiles/'.$cart['files']['front']) }}"
                                                         style="width: 100px" alt="">
                                                    <?php
                                                    if($cart['files']['back']){
                                                    $fileSplited = explode('.', $cart['files']['back']);
                                                    ?>

                                                    <img src="{{ $fileSplited[count($fileSplited)-1]=='pdf'?'/clientAssets/img/icons8-pdf-128.png':asset('orderFiles/'.$cart['files']['back']) }}"
                                                         style="width: 100px;" alt="">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo "در انتظار پرداخت";
                                                    ?></td>
                                                <?php
                                                $sum += $cart['price'];
                                                $servicePrice = 0;
                                                if (isset($cart['services'])) {
                                                    foreach ($cart['services'] as $service) {
                                                        $servicePrice += ($service['price'] * $cart['qty']);
                                                    }
                                                    $sum += $servicePrice;
                                                }
                                                ?>
                                                <td>{{ ta_persian_num(number_format($cart['price']+$servicePrice)) }}
                                                    ریال
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" style="text-align: center;font-size: 1.7rem">آیتمی در سبد
                                                خرید شما وجود
                                                ندارد
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4" style="text-align: left;border:none"></td>
                                        <td colspan="1" style="text-align: left">جمع فاکتور :</td>
                                        <td colspan="1">{{ ta_persian_num(number_format($sum)) }} ریال</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: left;border:none"></td>
                                        <td colspan="1" style="text-align: left">میزان تخفیف :</td>
                                        <td colspan="1" id="discountField">{{ ta_persian_num(0) }} ریال</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: left;border:none"></td>
                                        <td colspan="1" style="text-align: left">جمع کل :</td>
                                        <td colspan="1" id="sumPrice">{{ ta_persian_num(number_format($sum)) }}ریال
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: left">کد تخفیف دارید؟
                                            <span id="discountMessage"></span>
                                        </td>
                                        <td colspan="1">
                                            <div style="display: inline-block" class="form-inline">
                                                <input name="code" class="form-control" id="discount"/>
                                                <button type="button" class="btn btn-danger" onclick="checkDiscount()">
                                                    اعمال
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if($indexes)
                    @foreach($indexes as $cart)
                        <input type="hidden" name="cart[]" value="{{ $cart }}">
                    @endforeach
                @endif
                <div class="col-xs-12" style="margin-top: 2rem">
                    <h4 style="width: 250px;background: #444;color: #FFF;text-align: center;padding: 1rem 0;border-radius: 10px;border-bottom-left-radius: 0;border-bottom-right-radius: 0">
                        شیوه ارسال محصول</h4>
                    <div class="panel panel-default" id="panel">
                        <div class="panel-body">
                            @foreach($shippings as $shipping)
                                <div class="col-md-3">
                                    <input type="radio" take_address="{{ $shipping->take_address }}" name="shipping"
                                           value="{{ $shipping->id }}" style="display: none;"
                                           id="shipping-{{ $shipping->id }}">
                                    <label for="shipping-{{ $shipping->id }}" style="width: 100%">
                                        <div style="background:rgba(0,0,0,.1);padding:1rem;margin-top:1rem;border-radius:5px">
                                            <h4 style="display:inline-block;text-align: center;    line-height: 3rem;vertical-align:middle">{{  $shipping->name }}
                                                <br>
                                                <small>
                                                    هزینه : {{ ta_persian_num(number_format($shipping->price)) }} ریال
                                                </small>
                                            </h4>
                                            <img src="{{ asset($shipping->icon) }}" style="width: 35%;    float: left;"
                                                 alt="">

                                        </div>
                                    </label>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12" style="margin-top: 2rem">
                    <h4 style="width: 250px;background: #444;color: #FFF;text-align: center;padding: 1rem 0;border-radius: 10px;border-bottom-left-radius: 0;border-bottom-right-radius: 0">
                        انتخاب آدرس محل دریافت</h4>
                    <div class="panel panel-default" id="panel">
                        <div class="panel-body">
                            <table class=" table-striped table-bordered table-hover" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>دریافت کننده</th>
                                    <th>آدرس محل دریافت</th>
                                    <th>تلفن</th>
                                    <th> همراه</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ ta_persian_num('1') }}</td>
                                    <td>{{ auth()->guard('customer')->user()->name }}</td>
                                    <td><textarea name="address" class="form-control" id="" cols="30"
                                                  rows="3">{{ auth()->guard('customer')->user()->address }}</textarea>
                                    </td>
                                    <td>{{ auth()->guard('customer')->user()->telephone }}</td>
                                    <td>{{ auth()->guard('customer')->user()->phone }}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 2rem">
                    <div class="panel panel-default" id="panel">
                        <div class="panel-body">
                            <div class="col-md-9">
                                <h5 style="font-weight: bold;">آیا تمایلی به استفاده از اعتبار کیف پول خود دارید؟</h5>
                                <p style="margin-top: 1.5rem;">اعتبار فعلی
                                    : {{ ta_persian_num(number_format(auth()->guard('customer')->user()->credit)) }}
                                    ریال</p>
                            </div>
                            <div class="col-md-3">

                                <a href="{{ route('customer.moneybag') }}" target="_blank" style="color: #111;">

                                    <div class="profileBox" style="float: left;">
                                        <h5 style="width: 84%;float: right;margin-top: 0.8rem">شارژ کیف پول</h5>
                                        <img src="{{ asset('clientAssets/img/moneybag.png') }}" style="width: 15%"
                                             alt="">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12" style="margin-top: 2rem">
                    <div class="panel panel-default" id="panel">
                        <div class="panel-body"
                             style="min-height: 160px;background: url({{ asset('clientAssets/img/l1.png') }});-webkit-background-size: 100% 100%;background-size: 100% 100%;">
                            <div class="col-md-5" style="float: left;margin-top: 2rem">
                                <div class="col-md-6">
                                    <input type="radio" name="payment_method" value="money_bag" style="display: none"
                                           id="money_bag">
                                    <label style="width: 100%" for="money_bag">
                                        <div class="profileBox" style="background: #FFF">
                                            <h5 style="width: 75%;float: right;margin-top: 0.8rem"> کیف پول</h5>
                                            <img src="{{ asset('clientAssets/img/moneybag.png') }}" style="width:24%"
                                                 alt="">
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-6">

                                    <input type="radio" name="payment_method" value="online" style="display: none"
                                           id="online">
                                    <label for="online" style="width: 100%">
                                        <div class="profileBox" style="background: #FFF">
                                            <h5 style="width: 75%;float: right;margin-top: 0.8rem">درگاه بانکی</h5>
                                            <img src="{{ asset('clientAssets/img/onlinePayment.png') }}"
                                                 style="width: 22%"
                                                 alt="">
                                        </div>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="clearfix"></div>
                    <center>
                        <button class="btn btn-danger btn-md"
                                style="width: 25%;margin-top:1rem;font-size:1.2rem;font-weight:bold;background: #d60000;">
                            تایید نهایی و پرداخت
                        </button>
                    </center>
            </form>
        </div>
    </div>
@endsection
@section('extraScripts')
    <script>
        $("input[name=shipping]").change(function () {
            if ($(this).attr('take_address') === "1") {
                $("#address").show();
            } else {
                $("#address").hide();
            }
        })
    </script>

    <script>
        function checkDiscount() {
            $.ajax({
                type: 'POST',
                url: '{{route('customer.checkDiscount')}}',
                data: {
                    _token: "{{ csrf_token() }}",
                    code: document.getElementById('discount').value,
                    carts: [@foreach($carts as $cart)
                    {
                        'product': {{$cart['product']}}, 'price': {{$cart['price']}}},
                        @endforeach]
                }, success: function (result) {
                    var message = document.getElementById('discountMessage');
                    if (result['status'] === '0') {
                        message.style = 'float:right;color:#e52531;font-size:13px;';
                    } else if (result['status'] === '1') {
                        message.style = 'float:right;color:green;font-size:13px;';
                    }
                    message.textContent = result['message'];
                    $("#discountField").text(result['discount'] + " ریال");
                    $("#sumPrice").text(result['price'] + " ریال");
                }
            });
        }
    </script>

@endsection