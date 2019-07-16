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
            background-color: #e52531 !important;
        }

        input[type="radio"]:checked + label > div > h4, input[type="checkbox"]:checked + label > div > h4 {
            color: #FFF !important;
        }
    </style>
    <div class="container">
        <div class="col-xs-12">
            <h3 style="text-align: center;font-weight: bold;margin-bottom: 2rem">تایید نهایی سبد خرید</h3>
            <form action="{{ route('customer.storeOrder') }}" method="post">
                @csrf
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
                                foreach ($cart['services'] as $service) {
                                    $servicePrice += $service['price'];
                                }
                                $sum += $servicePrice;
                                ?>
                                <td>{{ ta_persian_num(number_format($cart['price']+$servicePrice)) }} ریال</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" style="text-align: center;font-size: 1.7rem">آیتمی در سبد خرید شما وجود
                                ندارد
                            </td>
                        </tr>
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: left">جمع کل :</td>
                        <td colspan="1">{{ ta_persian_num(number_format($sum)) }} ریال</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left">کد تخفیف دارید؟</td>
                        <td colspan="1">
                            <div style="display: inline-block" class="form-inline">
                                <input name="discount" class="form-control"/>
                                <button type="button" class="btn btn-danger">اعمال</button>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                @if($indexes)
                    @foreach($indexes as $cart)
                        <input type="hidden" name="cart[]" value="{{ $cart }}">
                    @endforeach
                @endif
                <h3 style="margin-top: 2rem;margin-bottom: 2rem">روش های ارسال سفارش</h3>
                @foreach($shippings as $shipping)
                    <div class="col-md-3">
                        <input type="radio" take_address="{{ $shipping->take_address }}" name="shipping"
                               value="{{ $shipping->id }}" style="display: none;"
                               id="shipping-{{ $shipping->id }}">
                        <label for="shipping-{{ $shipping->id }}" style="width: 100%">
                            <div style="background:rgba(0,0,0,.1);padding:1rem;margin-top:1rem;border-radius:5px">
                                <img src="{{ asset($shipping->icon) }}" style="width: 35%" alt="">
                                <h4 style="display:inline-block;text-align: center;margin-top: 1rem;vertical-align:middle">{{  $shipping->name }}
                                    <br>
                                    <small>
                                        هزینه : {{ ta_persian_num(number_format($shipping->price)) }} ریال
                                    </small>
                                </h4>
                            </div>
                        </label>

                    </div>
                @endforeach
                <div class="clearfix"></div>
                <div id="address" style="display: none;margin-top:1rem">
                    <label for="" style="font-size: 1.4rem;">آدرس تحویل سفارش</label>
                    <textarea name="address" class="form-control" id="" cols="30" rows="4"></textarea>
                </div>
                <div class="clearfix"></div>
                <div style="width: 100%;">
                    <h3 style="margin-top:1rem;">روش پرداخت : </h3>
                    <div class="clearfix"></div>
                    <div style="display: flex;justify-items: center;justify-content: center;align-items: center;align-content: center">
                        <div class="col-md-3">
                            <input type="radio" name="payment_method" value="money_bag" style="display: none"
                                   id="money_bag">
                            <label style="width: 100%" for="money_bag">
                                <div style="background:rgba(0,0,0,.1);border-radius: 5px;padding: 1rem ">
                                    <img src="" alt="">
                                    <h4 style="text-align: center">کیف پول</h4>
                                    <h4 style="text-align: center;font-size: 1.1rem;margin-top:1rem">اعتبار فعلی
                                        :{{ ta_persian_num(number_format(auth()->guard('customer')->user()->credit)) }}
                                        ریال</h4>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input type="radio" name="payment_method" value="online" style="display: none" id="online">
                            <label for="online" style="width: 100%">
                                <div style="background:rgba(0,0,0,.1);border-radius: 5px;padding: 1rem ">
                                    <img src="" alt="">
                                    <h4 style="text-align: center">درگاه بانک ملت</h4>
                                    <h4 style="text-align: center;font-size: 1.1rem;margin-top:1rem">پرداخت آنلاین</h4>
                                </div>
                            </label>
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

@endsection