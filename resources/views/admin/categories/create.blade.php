@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ایجاد دسته بندی
        </div>
        <div class="card-block">
            <form action="{{ route('admin.categories.store') }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                <div class="col-md-6">
                    <label for="">عنوان دسته بندی</label>
                    <input type="text" name="name" class="form-control"/>
                </div>
                <div class="col-md-6">
                    <label for="">تصویر دسته بندی</label>
                    <input type="file" name="picture" id="" class="form-control" accept="image/*"/>
                </div>
                <div class="col-md-6">
                    <label for=""> توضیحات دسته بندی</label>
                    <input type="text" name="description" class="form-control"/>
                </div>
                <div class="col-md-6" style="margin-top: 1.7rem">
                    <label for=""> فعال بودن دسته بندی</label>
                    <input type="checkbox" name="status"/>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12">
                    <label for="">حساس به تعداد صفحات</label>
                    <select name="count_pages" class="form-control" id="">
                        <option value="yes">بلی</option>
                        <option value="no">خیر</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top: 1.5rem">
                    <button type="submit" class="btn btn-success">ثبت دسته بندی</button>
                </div>
            </form>
        </div>
    </div>
@endsection