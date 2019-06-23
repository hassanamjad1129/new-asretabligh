<!DOCTYPE html>
<html lang="IR-fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->
    <title> پنل مدیریت @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/all.css') }}"/>
    <link rel="stylesheet" href="{{ asset('adminAssets/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/datatables/jquery.dataTables_themeroller.css') }}">
    @yield('extraStyles')
    <style>
        select.form-control{
            padding: 0 10px;
        }
        .mce-btn-group {
            float: right !important;
        }
    </style>
</head>
<body class="navbar-fixed sidebar-nav fixed-nav">
<header class="navbar">
    <div class="container-fluid">
        <button class="navbar-toggler mobile-toggler hidden-lg-up" type="button">&#9776;</button>
        <a class="navbar-brand" href="#">{{ env('APP_NAME') }}
        </a>
        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler layout-toggler" href="#">&#9776;</a>
            </li>
        </ul>
        <ul class="nav navbar-nav pull-left hidden-md-down">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="true" aria-expanded="false">
                    {{--<img src="{{ route('admin.get_avatar') }}" class="img-avatar"--}}
                    {{--alt="{{ auth()->guard('admin')->user()->email }}">--}}
                    <span class="hidden-md-down">{{ auth()->guard('admin')->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-xs-center">
                        <strong>تنظیمات</strong>
                    </div>
                    <a class="dropdown-item" href="#"><i class="fa fa-user"></i> پروفایل</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-wrench"></i> تنظیمات</a>
                    <div class="divider"></div>
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <button class="dropdown-item"><i class="fa fa-lock"></i> خروج</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</header>
<!-- Sidebar -->
@include('admin.layout.sidebar')
<!-- Main content -->
<main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">خانه</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
        <li class="breadcrumb-item active">داشبورد</li>

        <!-- Breadcrumb Menu-->
        <li class="breadcrumb-menu">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn btn-secondary" href="#"><i class="icon-speech"></i></a>
                <a class="btn btn-secondary" href="./"><i class="icon-graph"></i> &nbsp;داشبورد</a>
                <a class="btn btn-secondary" href="#"><i class="icon-settings"></i> &nbsp;تنظیمات</a>
            </div>
        </li>
    </ol>

    <div class="container-fluid">
        @if(count($errors->failed)>0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->failed->all() as $error)
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
        @yield('content')
    </div>
    <!--/.container-fluid-->
</main>
<footer class="footer">
        <span class="pull-left">
            <a href="http://coreui.io">تمامی حقوق برای چاپ محفوظ است.</a> &copy; 1398.
        </span>
    <span class="pull-right">
            طراحی و توسعه توسط <a href="http://hugenet.ir">ایده پردازان تدبیر بنیان</a>
        </span>
</footer>
<script src="{{ asset('adminAssets') }}/js/all.js"></script>
<script>
    function myFunction() {
        // Declare variables
        var input, filter, ul, li, i, a;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("sidebarNav");
        li = ul.getElementsByTagName("li");
        console.log(li);
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            var founded = false;
            a = li[i].getElementsByTagName("a")[0];

            if (a) {
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                    founded = true;
                }
            }
            if (!founded) {
                li[i].style.display = "none";
            }
        }
    }
</script>
<script src="/adminAssets/js/sweet.js"></script>
@yield('extraScripts')
<script src="{{ asset('adminAssets/js/app.js') }}"></script>
<script src="{{ asset('adminAssets/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminAssets/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
    $("table").dataTable();
    $("body").on("keydown", ".price", function (event) {

        if (event.keyCode == 46 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 8 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39)) {
            return;
        } else {
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
    });
    $("body").on("keyup", ".price", function (event) {
        var $this = $(this);
        var strInput = $this.val();
        strInput = strInput.replace(/ /g, '');
        strInput = strInput.replace(/,/g, '');
        $this.val(strInput.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    });
</script>
</body>
</html>