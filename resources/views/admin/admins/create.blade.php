@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ایجاد کاربر
        </div>
        <div class="card-block">
            <form action="{{ route('admin.admins.store') }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">نام و نام خانوادگی</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="name" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">پست الکترونیکی</label>
                        </div>
                        <div class="card-body">
                            <input type="email" name="email" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">رمز عبور</label>
                        </div>
                        <div class="card-body">
                            <input type="password" name="password" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">تکرار رمز عبور</label>
                        </div>
                        <div class="card-body">
                            <input type="password" name="password_confirmation" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">ثبت اپراتور</button>
                </div>
            </form>
        </div>
    </div>
@endsection
