@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>افزودن خدمات</h5>
        </div>
        <div class="card-block">
            <form action="{{ route('admin.service.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="">عنوان خدمت</label>
                        <input type="text" name="name" id="" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="">آیا آپلود فایل مجاز است؟</label>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <input type="radio" value="1" name="allow_type" id="yes">
                            <label for="yes">بله</label>
                        </div>
                        <div class="col-md-4">
                            <input type="radio" value="0" checked name="allow_type" id="no">
                            <label for="no">خیر</label>
                        </div>
                    </div>
                </div>
                <div class="col-12" style="margin-top: 1rem">
                    <button class="btn btn-primary">ثبت نهایی</button>
                </div>
            </form>
        </div>
    </div>
@endsection