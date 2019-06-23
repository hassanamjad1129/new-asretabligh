@extends('admin.layout.master')
@section('extraStyles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('extraScripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            ایجاد محصول
        </div>
        <div class="card-block">
            <form action="{{ route('admin.products.store',[$category]) }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                <div class="col-md-6">
                    <label for="">عنوان محصول</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control"/>
                </div>
                <div class="col-md-6">
                    <label for="">تصویر محصول</label>
                    <input type="file" name="picture" id="" class="form-control" accept="image/*"/>
                </div>
                <div class="col-md-6">
                    <label for=""> دسته</label>
                    <select class="js-example-basic-single form-control" name="category">
                        @foreach($allCategories as  $thisCategory)
                            <option value="{{$thisCategory->id}}" {{ $category->id==$thisCategory->id?"selected":"" }}>{{$thisCategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="">محاسبه فایل مجاز است؟</label>
                    <select name="calculateFile" id="calculateFile" class="form-control">
                        <option value="0">خیر</option>
                        <option value="1">بله</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="">نوع کار مجاز برای سفارش :</label>
                    <select name="type" id="type" class="form-control">
                        <option value="all">هم یک رو و هم دو رو</option>
                        <option value="single">فقط یک رو</option>
                        <option value="double">فقط دو رو</option>
                    </select>

                </div>
                <div class="col-md-6">
                    <label for="">فایل های ارسالی ربطی به دو رو یا یک رو بودن دارد ؟</label>
                    <select name="typeRelatedFile" id="typeRelatedFile" class="form-control">
                        <option value="1">بله</option>
                        <option value="0">خیر</option>
                    </select>

                </div>

                <div class="col-md-12">
                    <label for=""> توضیحات محصول</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top: 1.5rem">
                    <button type="submit" class="btn btn-success">ثبت محصول</button>
                </div>
            </form>
        </div>
    </div>
@endsection