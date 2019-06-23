@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ایجاد کاربر
        </div>
        <div class="card-block">
            <form action="{{ route('admin.admins.update') }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">نام</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="first_name" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">نام خانوادگی</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="last_name" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">موبایل </label>
                        </div>
                        <div class="card-body">
                            <input type="number" name="mobile" class="form-control" min="0"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">تلفن</label>
                        </div>
                        <div class="card-body">
                            <input type="number" name="telephone" class="form-control" min="0"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">رمز عبور</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="password" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">تکرار رمز عبور</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="confirmPassword" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">نوع</label>
                        </div>
                        <div class="card-body">
                            <select class="form-control" style="height: 2.5rem !important;" name="type">
                                <option value="0" selected>اعتباری</option>
                                <option value="1">نقدی</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">ثبت کاربر</button>
                </div>
            </form>
        </div>
    </div>
@endsection
