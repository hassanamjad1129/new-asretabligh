@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ویرایش دسته بندی
        </div>
        <div class="card-block">
            <form action="{{ route('admin.categories.update',[$category]) }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                @method('patch')
                <div class="col-md-8">
                    <div class="col-md-12">
                        <label for="">عنوان دسته بندی</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="form-control"/>
                    </div>

                    <div class="col-md-12">
                        <label for=""> توضیحات دسته بندی</label>
                        <input type="text" name="description" class="form-control" value="{{$category->description}}"/>
                    </div>
                    <div class="col-md-12">
                        <label for=""> فعال بودن دسته بندی</label>
                        <input type="checkbox" @if($category->status==1) checked @endif name="status"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12">
                        <label for="">حساس به تعداد صفحات</label>
                        <select name="count_paper" class="form-control" id="">
                            <option value="1" {{ $category->count_paper==1?"selected":"" }}>بلی</option>
                            <option value="0" {{ $category->count_paper==0?"selected":"" }}>خیر</option>
                        </select>
                    </div>

                </div>
                <div class="col-md-4">
                    <label for="">تصویر دسته بندی</label>
                    <img src="{{ route('admin.categoryPicture',[$category]) }}" style="width: 100%" alt=""/>
                    <input type="file" name="picture" id="" class="form-control" accept="image/*">
                </div>

                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top:1.7rem;">
                    <button type="submit" class="btn btn-warning">ثبت ویرایش</button>
                </div>
            </form>
        </div>
    </div>
@endsection