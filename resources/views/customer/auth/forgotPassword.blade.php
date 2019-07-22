@extends('client.layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="loginWrapper">
                <form action="" style="display: flex;justify-content: center;justify-items: center">
                    <div class="col-md-6">
                        <h3><i class="fa fa-key" style="font-size: 20px;margin-left: 6px;"></i>فراموشی رمز عبور
                        </h3>
                        <h5 style="margin-top: 20px">مشخصات را با دقت پر کنید</h5>
                        <div style="margin-top:10px;width: 60%">
                            <label for="">شماره همراه</label>
                            <input type="text" class="form-control" name="phone"/>
                            <button class="btn btn-danger btn-sm" style="width:25%; margin-top: 3px;float: left;">
                                ارسال کد فراموشی
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection