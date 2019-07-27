@extends('client.layout.master')
@section('title')بازنشانی رمز عبور@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="loginWrapper">
                <form action="" style="display: flex;justify-content: center;justify-items: center" method="post">
                    @csrf
                    <div class="col-md-5">
                        <h3 style="text-align: center">
                            <i class="fa fa-key" style="font-size: 20px;margin-left: 6px;"></i>
                            بازنشانی رمز عبور
                        </h3>
                        <h5 style="text-align: center;margin-top: 20px">مشخصات را با دقت پر کنید</h5>
                        <div style="margin-top:10px;width: 100%">
                            <label for="">شماره همراه</label>
                            <input type="text" class="form-control" name="phone"/>
                            <label for="">کد امنیتی</label>
                            <input type="text" class="form-control" name="token"/>
                            <label for="">رمز عبور جدید</label>
                            <input type="password" class="form-control" name="password"/>
                            <label for="">تکرار رمز عبور</label>
                            <input type="password" class="form-control" name="password_confirmation"/>
                            <button class="btn btn-danger btn-sm" style="width:25%; margin-top: 3px;float: left;">
                                بازنشانی رمز عبور
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection