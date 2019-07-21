<!DOCTYPE html>
<html dir="rtl" lang="fa-IR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>چاپ عصر تبلیغ|پرینت آنلاین|پرینت سیاه و سفید|پرینت رنگی|پلات|لمینت|چاپ پوستر|چاپ نقشه</title>

    <meta name="description" content="مجری کلیه امور چاپی و تبلیغاتی
چاپ دیجیتال-چاپ افست-خدمات دانشجویی
چاپ آنلاین دیجیتال: پرینت رنگی-پرینت سیاه و سفید-چاپ کتاب-چاپ پوستر-پلات-لمینت-صحافی پایان نامه فوری-صحافی گالینگور-صحافی سیمی-صحافی چسب گرم-سلفون حرارتی
خدمات IT: طراحی سایت-اپلیکیشن-سئو
خدمات افست: چاپ فرم عمومی-چاپ فرم اختصاصی-کارت ویزیت-سربرگ-کاتالوگ-بروشور-پوستر-مجله-کتاب
طراحی-لیتوگرافی">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="چاپ عصر تبلیغ @yield('title')">
    <meta property="og:image" content="{{ asset('/logo.jpg') }}"/>
    <link rel="icon" type="image/png"
          href="{{ asset('/clientAssets/img/favicon_1b54d71dbf76e5d7bfef02009f15c179.png') }}">
    <meta property="og:url" content="{{ url('/') }}"/>

    <meta property="og:description" content="مجری کلیه امور چاپی و تبلیغاتی
چاپ دیجیتال-چاپ افست-خدمات دانشجویی
چاپ آنلاین دیجیتال: پرینت رنگی-پرینت سیاه و سفید-چاپ کتاب-چاپ پوستر-پلات-لمینت-صحافی پایان نامه فوری-صحافی گالینگور-صحافی سیمی-صحافی چسب گرم-سلفون حرارتی
خدمات IT: طراحی سایت-اپلیکیشن-سئو
خدمات افست: چاپ فرم عمومی-چاپ فرم اختصاصی-کارت ویزیت-سربرگ-کاتالوگ-بروشور-پوستر-مجله-کتاب
طراحی-لیتوگرافی"/>
    <link rel="stylesheet" href="{{ asset('clientAssets/css/all.css') }}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('sweetalert2.min.css') }}">
    <style>.propertyParent {
            height: 130px;
        }

        .properties p {
            margin-bottom: 0 !important;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: pre-wrap;
        }

        .badge {
            background-color: #000;
        }

        #navigation {
            background-color: rgb(229, 37, 49) !important;
        }

        .alertify-logs {
            position: fixed;
            z-index: 1;
            z-index: 999999999 !important;
        }</style>
    <script src="{{ asset('/clientAssets/js/jquery-3.1.1.min.js')  }}"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!------------------    Fixed Navigation    -------------------->
<header id="navigation" class="navbar-fixed-top navbar">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <a class="navbar-brand" href="#body">
                        <div class="logo1">
                            <img src="/clientAssets/img/xlm6bndh4dygw6xtug3t.png" style="height:50px">
                        </div>
                    </a>
                </div>

                <div class="col-md-10">
                    <nav class="navbar navbar-inverse pull-right">

                        <ul class="nav navbar-nav pull-right" style="margin-top: 0.4rem;">
                            <li class="active-menu"><a href="{{ url('/') }}">صفحه اصلی</a></li>
                            <li style="width: 80px" class="dropdown"><a href="#" class="dropdown-toggle"
                                                                        data-toggle="dropdown" data-hover="dropdown">محصولات</a>
                                <ul class="dropdown-menu">
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('categoryProductPrice',[str_replace(" ","-",$category->name)]) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="{{ url('shop') }}">فروشگاه</a>
                            </li>

                            <li><a href="{{ route('rules') }}">قوانین و مقرارت</a></li>
                            <li><a href="{{ url('/aboutUs') }}">درباره ما</a></li>
                            <li><a href="{{ url('/contactUs') }}">تماس با ما</a></li>

                        </ul>
                        <ul class="nav navbar-nav pull-left">
                            @if(!Auth::guard('customer')->user())
                                <li>
                                    <a href="{{ url('/customer/login') }}"
                                       onclick="window.location = '{{ url('customer/login') }}'">
                                        <i class="flaticon-black"></i> ورود / ثبت نام</a>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                       style="padding:6px;margin-top: 0.4rem;">@if(Auth::guard('customer')->user()->image)
                                            <img
                                                    src="{{ asset('/uploads/usersPicture/'. Auth::guard('customer')->user()->image) }}"
                                                    class="img-circle" style="height:30px;margin-left:5px"> @else<i
                                                    class="flaticon-black"></i>@endif سلام
                                        ، {{ Auth::guard('customer')->user()->name }}</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/customer/orders') }}"
                                               onclick="window.location = '{{ url('customer/orders') }}'"><i
                                                        class="fa fa-sign-in"></i> مشاهده پروفایل</a></li>
                                        <li><a href="{{ url('/customer/logout') }}"
                                               onclick="window.location = '{{ url('customer/logout') }}'"><i
                                                        class="fa fa-sign-out"></i> خروج از حساب کاربری</a></li>
                                    </ul>
                                    @endif
                                </li>

                                <li style="margin-right: 14px;">
                                    <a href="{{ route('cart') }}" style="padding:6px"><span class="badge"
                                                                                            style="position: relative;right: 5px;bottom: 15px;">{{ ta_persian_num($cart) }}</span><i
                                                class="fa fa-shopping-cart fa-2x"></i>
                                        <p style="position: relative;display: inline;bottom: 4px;">سبد خرید</p></a>
                                </li>

                        </ul>
                    </nav>

                    <div class="menu2 shadow">
                        <input type="checkbox" id="menuTrigger"/>
                        <div class="menuResize">
                            <h3>منو</h3>
                            <label for="menuTrigger" class="trigger">
                                <div class="line"></div>
                                <div class="line"></div>
                                <div class="line"></div>
                            </label>
                            <ul class="links">
                                <li class="link active"><a href="">صفحه اول </a></li>
                                <li class="link have-sub">
                                    <a href=''>محصولات</a>
                                    <ul>
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{ url('/') }}"
                                                   onclick="window.location = '/'">{{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="link"><a href="{{ url('/rules') }}">قوانین و مقرارت</a></li>
                                <li class="link"><a href="{{ url('/aboutUs') }}">درباره ما</a></li>
                                <li class="link"><a href="{{ url('/contactUs') }}">تماس با ما</a></li>
                                <li class="link"><a href="{{ url('/customer/login') }}"><i
                                                class="flaticon-black"></i></a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@if(request()->url()!=env('APP_URL'))
    <div style="margin-top: 8rem;">
        @yield('content')
    </div>
@else
    @yield('content')
@endif
<div class="clearfix"></div>
<!------------------    contact    -------------------->
<div class="container">
    <div class="row">
        <div class="contact wow fadeInUp animated">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <span style="float: right"> <i class="flaticon-location"></i>{{ $address }}</span>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
                <span class="span-phone" id="phoneFooter"> <i class="flaticon-technology"></i>{{ ta_persian_num($phone) }}</span>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
                <span class="span-phone"> <i class="flaticon-multimedia"></i>{{ $email }}</span>
            </div>

        </div>
    </div>
</div>

<!------------------    Footer    -------------------->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-6 div">
                <h3 class="title">راهنمای سفارش</h3>
                <ul>
                    <li>
                        <a href="{{ url('/ordering') }}" target="_blank">ثبت سفارش</a>
                    </li>
                    <li>
                        <a href="{{ url('/page/8') }}" target="_blank">رویه های ارسال سفارش</a>
                    </li>
                    <li>
                        <a href="{{ url('/paymentWays') }}" target="_blank">شیوه های پرداخت</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6 div">
                <h3 class="title">خدمات مشتریان</h3>
                <ul>
                    <li><a href="{{ url('/contactUs') }}">تماس با ما</a></li>
                    <li><a href="{{ url('/refund') }}">استرداد کالا</a></li>
                    <li><a href="{{ asset('/sitemap.xml') }}">نقشه سایت</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6 div">
                <h3 class="title">حساب کاربری من</h3>
                <ul>
                    <li>
                        <a href="@if(Auth::guard('customer')->user()) {{ url('/customer/home') }}@else {{ url('/customer/login') }}@endif">حساب
                            کاربری من</a></li>
                    <li>
                        <a href="@if(Auth::guard('customer')->user()) {{ url('/customer/orders') }}@else {{ url('/customer/login') }}@endif">تاریخچه
                            سفارش ها</a></li>
                    <li><a href="#" class="newsletter">خبرنامه</a></li>
                    <li><a href="/Inquiry" class="newsletter">استعلام</a></li>

                </ul>
            </div>

            <div class="col-md-5 col-sm-12 col-xs-12 logo-footer">

                <img id="drftnbpelbrhrgvllbrh" style="cursor:pointer;height: 130px;display: inline;float: left"
                     class="img-responsive"
                     onclick="window.open(&quot;https://trustseal.enamad.ir/Verify.aspx?id=12757&amp;p=nbpdwkynqgwlyncrqgwl&quot;, &quot;Popup&quot;,&quot;toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30&quot;)"
                     alt="" src="{{ asset('/clientAssets/img/enamad.png') }}"/>
                <img id='fukznbqesizpwlaorgvj' style='cursor:pointer;height: 130px;float: left'
                     onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=62943&p=gvkauiwkpfvlaodsxlao", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'
                     alt='logo-samandehi'
                     src='{{ asset('/clientAssets/img/samandehi.png') }}'/>
                <img src="{{ url('/clientAssets/img/logo-footer3_c14102fd323f0cd11b1241a2b32dcf00.png') }}" alt="درگاه"
                     style="width: 26%;display: inline;float: left"
                     class="img-responsive"/>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="row">
            <p class="copyright">تمام حقوق مادی و معنوی این وب سایت برای چاپ
                <span style="color: #e52531">
                عصر تبلیغ
            </span>
                محفوظ می باشد.
            </p>
            <ul class="social">
                <li>
                    <a href="https://plus.google.com/asretabligh" target="_blank"
                       class="glyph-icon flaticon-social"></a>
                </li>
                <li>
                    <a href="https://t.me/asretabligh" class="glyph-icon flaticon-social-media-1"
                       target="_blank"></a>
                </li>
                <li>
                    <a href="https://instagram.com/asretabligh" class="glyph-icon flaticon-social-media"
                       target="_blank"></a>
                </li>
                <li>
                    <a href="https://facebook.com/asretabligh" class="glyph-icon flaticon-facebook-logo"
                       target="_blank"></a>
                </li>
                <li>
                    <a href="https://www.aparat.com/asretabligh" class="fa fa-film" style="color:#000"
                       target="_blank"></a>
                </li>
            </ul>
        </div>
    </div>

</footer>
<!-- Material button -->
<button class="material-scrolltop " type="button "></button>
<script src="{{ asset('clientAssets/js/all.js') }}"></script>
<script src="{{ asset('clientAssets/js/vertical.news.slider.js') }}"></script>

<script src="{{ asset('js/jquery.mixitup.min.js') }}"></script>
<script src="{{ asset('/clientAssets') }}/js/carousel.js "></script>
<script src="{{ asset('sweetalert2.min.js') }}"></script>
@if(count($errors->failed)>0)
    <script>
        $(document).ready(function (e) {
            var text = "";
            @foreach($errors->failed->all() as $error)
                text = text + "{{ $error }}\n";
            @endforeach
            swal({
                title: 'خطا!',
                text: text,
                type: 'error',
                confirmButtonText: 'باشه'
            })
        });

    </script>
@endif
@if(count($errors->success)>0)
    <script>
        var text = "";
        $(document).ready(function (e) {
            @foreach($errors->success->all() as $error)
                text = text + "{{ $error }}";
            @endforeach

            swal({
                title: 'سپاس',
                text: text,
                type: 'success',
                confirmButtonText: 'باشه'
            })
        });

    </script>
@endif
<!--script>window.$crisp=[];window.CRISP_WEBSITE_ID="6ab90e88-fe2e-48b1-89a2-8fe7fd9523c8";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script-->
@yield('extraScripts')
<style>.crisp-client .crisp-6k5puw .crisp-1hzjrty, .crisp-client .crisp-6k5puw .crisp-1hzjrty *, .crisp-client .crisp-6k5puw .crisp-561mbi, .crisp-client .crisp-6k5puw .crisp-561mbi * {
        font-family: Sans !important;
    }</style>
</body>

</html>
