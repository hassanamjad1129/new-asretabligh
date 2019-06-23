<!DOCTYPE html>
<html lang="fa-IR" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreUI Bootstrap 4 Admin Template">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->
    <title>چاپ</title>
    <link rel="stylesheet" href="{{ asset('adminAssets/css/all.css') }}">
</head>

<body class="">
<div class="container">
    <div class="row">
        <div class="col-md-8 m-x-auto pull-xs-none vamiddle">
            <div class="card-group ">
                <div class="card p-a-2">
                    <div class="card-block">
                        <h1>ورود</h1>
                        <p class="text-muted">وارد حساب کاربری خود شوید</p>
                        <form action="{{ route('admin.login') }}" method="post">
                            @csrf
                            <div class="input-group m-b-1">
                                <span class="input-group-addon"><i class="icon-user"></i>
                                </span>
                                <input type="text" class="form-control" name="email" placeholder="نام کاربری یا ایمیل">
                            </div>
                            <div class="input-group m-b-2">
                                <span class="input-group-addon"><i class="icon-lock"></i>
                                </span>
                                <input type="password" class="form-control"  name="password" placeholder="رمز ورود">
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <button class="btn btn-primary p-x-2">
                                        <i class="icon-login"></i>
                                        ورود
                                    </button>
                                </div>
                                <div class="col-xs-6 text-xs-right">
                                    <button type="button" class="btn btn-link p-x-0">فراموشی رمز ورود</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="card card-inverse card-primary p-y-3" style="width:44%">
                    <div class="card-block text-xs-center">
                        <div>
                            <img src="{{ asset('adminAssets/img/logo.png') }}" class="img-responsive"
                                 style="height: 250px" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap and necessary plugins -->
<script src="{{ asset('adminAssets/js/all.js') }}"></script>
<script>
    function verticalAlignMiddle() {
        var bodyHeight = $(window).height();
        var formHeight = $('.vamiddle').height();
        var marginTop = (bodyHeight / 2) - (formHeight / 2);
        if (marginTop > 0) {
            $('.vamiddle').css('margin-top', marginTop);
        }
    }

    $(document).ready(function () {
        verticalAlignMiddle();
    });
    $(window).bind('resize', verticalAlignMiddle);
</script>
</body>

</html>
