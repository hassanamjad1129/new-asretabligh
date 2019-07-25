@extends('client.layout.master')
@section('content')
    <div class="container">
        <div class="col-md-2">
            <img src="{{ auth()->guard('customer')->user()->avatar?asset(auth()->guard('customer')->user()->avatar):"/clientAssets/img/Neutral-placeholder-profile.jpg" }}"
                 style="width: 100%" alt=""
                 class="img-thumbnail">
        </div>
        <div class="col-md-10">
            <h3 style="margin-bottom: 1rem">{{ auth()->guard('customer')->user()->name }}</h3>
            <p style="margin-bottom: 1rem">سطح کاربری
                : {{ auth()->guard('customer')->user()->type=='credit'?'حساب دفتری':'عادی' }}</p>
            <p style="margin-bottom: 1rem">موجودی کیف پول
                : {{ ta_persian_num(number_format(auth()->guard('customer')->user()->credit)) }} ریال</p>
            <p style="margin-bottom: 1rem">تعداد سفارشات
                : {{ ta_persian_num(auth()->guard('customer')->user()->totalOrderItems()) }}</p>
        </div>

        <div class="col-md-12" style="margin-top: 2rem">
            <div class="col-md-3">
                <a href="/" style="color: #111;">
                    <div class="profileBox">
                        <h4 style="width: 84%;float: right;margin-top: 0.8rem">خانه</h4>
                        <img src="{{ asset('clientAssets/img/home.png') }}" style="width: 15%" alt="">
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('customer.orders') }}" style="color: #111;">
                    <div class="profileBox">
                        <h4 style="width: 84%;float: right;margin-top: 0.8rem">سفارشات</h4>
                        <img src="{{ asset('clientAssets/img/orders.png') }}" style="width: 15%" alt="">
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('customer.customerHome') }}" style="color: #111;">
                    <div class="profileBox">
                        <h4 style="width: 84%;float: right;margin-top: 0.8rem">پروفایل کاربری</h4>
                        <img src="{{ asset('clientAssets/img/profile.png') }}" style="width: 15%" alt="">
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('customer.moneybag') }}" style="color: #111;">
                    <div class="profileBox">
                        <h4 style="width: 84%;float: right;margin-top: 0.8rem">کیف پول</h4>
                        <img src="{{ asset('clientAssets/img/moneybag.png') }}" style="width: 15%" alt="">
                    </div>
                </a>
            </div>
            <div class="clearfix"></div>
            @yield('dashboardContent')
        </div>
    </div>
@endsection
@section('extraScripts')
    <script>
        $(function () {

            var url = window.location.pathname,
                urlRegExp = new RegExp(url + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
            // now grab every link from the navigation
            $('.customerSideBar a').each(function () {
                // and test its normalized href against the url pathname regexp
                if (urlRegExp.test(this.href)) {
                    $(this).parent('li').addClass('active');
                }
            });

        });
    </script>
@endsection
