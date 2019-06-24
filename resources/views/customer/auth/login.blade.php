@extends('client.layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="loginWrapper">
                <div class="col-md-6">
                    <form action="/customer/login?previous={{ url()->previous() }}" id="loginForm" method="post">
                        @csrf
                        <h3><i class="fa fa-sign-in" style="font-size: 20px;margin-left: 6px;"></i>ورود</h3>
                        <h5 style="margin-top: 20px">مشخصات را با دقت پر کنید</h5>
                        <div style="margin-top:10px;width: 60%">
                            <label for="">شماره همراه</label>
                            <input type="text" class="form-control" name="phone">
                            <label for="">رمز عبور</label>
                            <input type="password" class="form-control" name="password">
                            <input type="checkbox" name="rules" id="rules">
                            <label for="rules"> قوانین را مطالعه نموده و موافق هستم</label>
                            <button class="btn btn-danger btn-sm" style="width:25%; margin-top: 3px;float: left;">ورود
                            </button>
                            <div class="clearfix"></div>
                            <a href="">رمز عبور خود را فراموش کرده اید؟</a>
                        </div>
                    </form>
                </div>
                <div class="col-md-6" style="border-right: 1px solid rgba(0,0,0,.08);">
                    <form action="/customer/register" method="post">
                        @csrf
                        <h3><img src="/clientAssets/img/ic-signup.png" alt="">عضویت</h3>
                        <h5 style="margin-top: 20px">مشخصات را با دقت پر کنید</h5>
                        <div style="margin-top:10px;width: 60%">
                            <label for="">نام و نام خانوادگی</label>
                            <input type="text" class="form-control" name="name">
                            <label for="">شماره همراه</label>
                            <input type="text" class="form-control" name="phone">
                            <label for="">شماره تلفن</label>
                            <input type="text" class="form-control" name="telephone">
                            <label for="">پست الکترونیکی</label>
                            <input type="email" class="form-control" name="email">
                            <label for="">رمز عبور</label>
                            <input type="password" class="form-control" name="password">
                            <label for="">تکرار رمز عبور</label>
                            <input type="password" class="form-control" name="password_confirmation">
                            <label for="" style="margin-top: 10px;">جنسیت</label>
                            <br>
                            <input type="radio" name="gender" value="male" id="male">
                            <label for="male">آقا</label>
                            <input type="radio" name="gender" value="female" id="female">
                            <label for="female">خانم</label>
                            <button class="btn btn-danger btn-sm" style="float:left;width:25%; ">ثبت
                                نام
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extraScripts')
    <script>
        $("#loginForm").submit(function (e) {
            if ($("input[name=rules]").prop('checked') == false) {
                e.preventDefault();
                swal({
                    title: 'خطا!',
                    text: "پذیرفتن قوانین جهت ورود به سامانه الزامیست",
                    type: 'error',
                    confirmButtonText: 'متوجه شدم'
                })
            }

        });
    </script>

@endsection