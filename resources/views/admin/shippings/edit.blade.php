@extends('admin.layout.master')
@section('content')
    <section class="content-header">
        <h2>ویرایش روش ارسال</h2>
    </section>
    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.shippings.update',[$shipping->id]) }}" method="post">
            @csrf
            @method('patch')
            <div class="col-md-6">
                <label for="name">عنوان روش</label>
                <input type="text" value="{{ $shipping->name }}" name="name" id="name" class="form-control"/>
            </div>
            <div class="col-md-6">
                <label for="name">آیکن</label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> انتخاب تصویر
                        </a>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" value="{{ $shipping->icon }}"
                           name="filepath">
                </div>
            </div>
            <div class="col-md-6">
                <label for="description">توضیحات</label>
                <input type="text" name="description" id="description" value="{{ $shipping->description }}"
                       class="form-control"/>
            </div>
            <div class="col-md-6">
                <label for="description">قیمت</label>
                <input type="text" name="price" id="price" value="{{ $shipping->price }}"
                       class="form-control"/>
            </div>

            <div class="col-md-6">
                <input type="checkbox" id="take_address" name="take_address" value="1">
                <label for="take_address">نیاز به گرفتن آدرس از مشتری است</label>
            </div>
            <div class="col-md-12">
                <button class="btn btn-success" style="margin-top: 5px">بروزرسانی روش</button>
            </div>
        </form>
    </section>
@endsection
@section('extraScripts')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
            language: 'fa'
        };
        $('#lfm').filemanager('image');
    </script>
@endsection