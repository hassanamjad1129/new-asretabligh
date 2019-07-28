@extends('admin.layout.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="card">
                    <div class="card-header">داشبورد</div>
                    <div class="card-block">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">نام نام خانوادگی</label>
                                        <input type="text" name="name" id="name"
                                               value="{{ Auth::guard('admin')->user()->name }}"
                                               class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">پست الکترونیکی</label>
                                        <input name="email" class="form-control" id="email"
                                               value="{{ Auth::guard('admin')->user()->email }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">رمز عبور جدید</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">تکرار رمز عبور</label>
                                        <input name="password_confirmation" class="form-control"
                                               id="password_confirmation" type="password">
                                    </div>

                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <br>
                            <button type="submit" class="btn btn-danger" style="float:left">بروزرسانی</button>
                            <div class="clearfix"></div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
