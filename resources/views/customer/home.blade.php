@extends('customer.layout.dashboardMaster')
@section('dashboardContent')
    <style>
        #panel {
            padding: 10px;
        }

        .table tr:first-child td {
            border: none;
        }
    </style>
    <div class="col-xs-12">
        <h4 style="width: 250px;background: #444;color: #FFF;text-align: center;padding: 1rem 0;border-radius: 10px;border-bottom-left-radius: 0;border-bottom-right-radius: 0">
            پروفایل کاربری</h4>
        <div class="panel panel-default" id="panel">

            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">نام نام خانوادگی</label>
                            <input type="text" name="name" id="name" value="{{ Auth::guard('customer')->user()->name }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">پست الکترونیکی</label>
                            <input name="email" class="form-control" id="email"
                                   value="{{ Auth::guard('customer')->user()->email }}">
                        </div>
                        <div class="col-md-6">
                            <label for="">شماره همراه </label>
                            <input type="text" name="phone" disabled="disabled" class="form-control" id="phone"
                                   value="{{ Auth::guard('customer')->user()->phone }}">
                        </div>
                        <div class="col-md-6">
                            <label for="">شماره تماس ثابت </label>
                            <input type="text" name="telephone" class="form-control" id="tel"
                                   value="{{ Auth::guard('customer')->user()->telephone }}">
                        </div>

                        <div class="col-md-12">
                            <label for="">آدرس</label>
                            <textarea name="address" id="" cols="30" rows="3"
                                      class="form-control">{{ auth()->guard('customer')->user()->address }}</textarea>
                        </div>

                        <div class="col-xs-12">
                            <br>
                            <label for="">جنسیت</label>
                            <div class="clearfix"></div>
                            <input type="radio" name="gender"
                                   {{ auth()->guard('customer')->user()->gender=='male'?"checked":""}} value="male"
                                   id="male">
                            <label for="male">آقا</label>
                            <input type="radio" name="gender"
                                   {{ auth()->guard('customer')->user()->gender=='female'?"checked":""}} value="female"
                                   id="female">
                            <label for="female">خانم</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    @if(auth()->guard('customer')->user()->avatar)
                        <img src="{{ asset(auth()->guard('customer')->user()->avatar) }}" style="width: 100%;"
                             alt="">
                    @else
                        <img src="/clientAssets/img/Neutral-placeholder-profile.jpg" style="width: 100%;" alt="">
                    @endif
                    <input type="file" name="avatar" class="form-control">
                </div>
                <div class="clearfix"></div>
                <br>
                <button type="submit" class="btn btn-danger" style="float:left">بروزرسانی</button>
                <div class="clearfix"></div>

            </form>
        </div>
    </div>
    {{--<div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">آخرین گزارشات</div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>تعداد سفارشات</td>
                        <td>{{ Auth::guard('customer')->user()->totalOrders() }} سفارش</td>
                    </tr>
                    <tr>
                        <td>سفارشات آماده تحویل</td>
                        <td>{{ Auth::guard('customer')->user()->finalOrders() }} سفارش</td>
                    </tr>
                    <tr>
                        <td>سبد خرید</td>
                        <td>{{ Auth::guard('customer')->user()->totalCart() }} مورد</td>
                    </tr>
                    <tr>
                        <td>آخرین ثبت سفارش</td>
                        <td style="direction: ltr;text-align: right">@if(Auth::guard('customer')->user()->lastOrder()) {{ jdate(strtotime(Auth::guard('customer')->user()->lastOrder()))->format('datetime') }}@else
                                ندارد@endif</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">گزارشات مالی</div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>تعداد سفارشات تسویه شده</td>
                        <td>{{ Auth::guard('customer')->user()->ordersCleard() }} سفارش</td>
                    </tr>
                    <tr>
                        <td>مجموع پرداختی ها</td>
                        <td>{{ number_format(Auth::guard('customer')->user()->sumPays()) }} تومان</td>
                    </tr>
                    <tr>
                        <td>تاریخ اخرین پرداخت</td>
                        <td style="direction: ltr;text-align: right">@if(Auth::guard('customer')->user()->lastPay()){{ jdate(strtotime(Auth::guard('customer')->user()->lastPay()))->format('datetime')}}@else
                                ندارد@endif</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>--}}
@endsection