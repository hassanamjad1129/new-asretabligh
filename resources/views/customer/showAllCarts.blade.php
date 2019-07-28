@extends('client.layout.master')
@section('content')
    <style>
        .table-striped td, .table-striped th {
            padding: 20px 10px;
            font-size: 1.2rem;
            text-align: center;
        }
    </style>
    <div class="container">
        <div style="background: #FFF;box-shadow: 0 0 10px rgba(0,0,0,.2);overflow: hidden;padding:1rem 0">
            <h3 style="padding:0 1rem;text-align: center">سبدخرید </h3>
            <hr>
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

            <div class="col-xs-12 ">
                <form action="{{ route('customer.finalStep') }}" method="post">
                    @csrf
                    <table class="table-striped table-bordered table-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>انتخاب</th>
                            <th> عنوان سفارش</th>
                            <th>جزییات سفارش</th>
                            <th>فایل های ارسالی</th>
                            <th>سری</th>
                            <th>وضعیت سبد</th>
                            <th>مبلغ کل</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        $sum = 0;?>
                        @if($carts)
                            @foreach($carts as $key=>$cart)
                                <tr>
                                    <td style="font-weight: bold">{{ ta_persian_num($i++) }}</td>
                                    <td><input type="checkbox" name="carts[]" style="width: 20px;height:20px"
                                               value="{{ $key }}"
                                               id=""></td>
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
                                    <td>{{ $cart['qty'] }}</td>
                                    <td>
                                        <?php
                                        echo "در انتظار پرداخت";
                                        ?></td>
                                    <?php
                                    $sum += $cart['price'];
                                    $servicePrice = 0;
                                    foreach ($cart['services'] as $service) {
                                        $servicePrice += ($service['price'] * $cart['qty']);
                                    }
                                    $sum += $servicePrice;
                                    ?>
                                    <td>{{ ta_persian_num(number_format($cart['price']+($servicePrice))) }}
                                        ریال
                                    </td>
                                    <td><a href="{{ url('/cart/'.$key.'/remove') }}" class="deleteBTN"><i
                                                    class="fa fa-trash-o"
                                                    style="font-size: 23px;color:#d60000"
                                                    aria-hidden="true"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" style="text-align: center;font-size: 1.7rem">آیتمی در سبد خرید شما وجود
                                    ندارد
                                </td>
                            </tr>
                        @endif
                        </tbody>
                        <tfoot>
                        <td colspan="7">جمع کل :</td>
                        <td colspan="2">{{ ta_persian_num(number_format($sum)) }} ریال</td>
                        </tfoot>
                    </table>
                    <center>
                        <button class="btn btn-danger btn-md"
                                style="width: 25%;margin-top:1rem;font-size:1.2rem;font-weight:bold;background: #d60000;">
                            تایید نهایی و پرداخت
                        </button>
                    </center>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extraScripts')
    <script>
        $(".deleteBTN").click(function (e) {
            e.preventDefault();
            swal({
                title: 'آیا از انجام این کار اطمینان دارید؟',
                text: "این عمل قابل بازگشت نیست",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d60000',
                confirmButtonText: 'بله',
                cancelButtonText: "خیر"
            }).then((result) => {
                if (!result.value) {
                    window.location.href = $(this).attr('href');
                }
            })
        })
    </script>
@endsection