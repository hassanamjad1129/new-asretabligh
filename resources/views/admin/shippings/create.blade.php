@extends('admin.layout.master')
@section('content')
    <div class="card">
        <section class="card-header">
            <h2>ایجاد روش ارسال جدید</h2>
        </section>
        <!-- Main content -->
        <section class="card-block">

            <form action="{{ route('admin.shipping.store') }}" method="post">
                @csrf
                <div class="col-md-6">
                    <label for="name">عنوان روش</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control"/>
                </div>
                <div class="col-md-6">
                    <label for="name">آیکن</label>
                    <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> انتخاب تصویر
                        </a>
                    </span>
                        <input id="thumbnail" class="form-control" value="{{ old('filepath') }}" type="text"
                               name="filepath">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="description">توضیحات</label>
                    <input type="text" name="description" value="{{ old('description') }}" id="description"
                           class="form-control"/>
                </div>

                <div class="col-md-6">
                    <label for="description">قیمت</label>
                    <input type="text" name="price" id="price" value="{{old('price')}}" class="form-control"/>
                </div>
                <div class="col-md-6">
                    <input type="checkbox" id="take_address" name="take_address" value="1">
                    <label for="take_address">نیاز به گرفتن آدرس از مشتری است</label>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-success" style="margin-top: 5px">ثبت روش</button>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('extraScripts')
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endsection