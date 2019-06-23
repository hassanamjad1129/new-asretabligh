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
            ویرایش محصول
        </div>
        <div class="card-block">
            <form action="{{ route('admin.products.update',[$category,$subcategory,$product]) }}"
                  enctype="multipart/form-data"
                  method="post">
                @csrf
                @method('patch')
                <div class="col-md-6">
                    <label for="">عنوان محصول</label>
                    <input type="text" name="title" class="form-control"
                           value="{{old('title')?old('title'):$product->title}}"/>
                </div>
                <div class="col-md-6">
                    <label for="">تصویر محصول</label>
                    <img src="{{ route('admin.productPicture',[$product]) }}" style="width: 100%">
                    <input type="file" name="picture" id="" class="form-control" accept="image/*"/>
                </div>
                <div class="col-md-6">
                    <label for=""> توضیحات محصول</label>
                    <textarea name="description" class="form-control" rows="7">{{old('description')?old('description'):$product->description}}
                    </textarea>
                </div>
                <div class="col-md-6" style="margin-top:1.5rem">
                    <label for="">زیر دسته</label>
                    <select class="js-example-basic-single form-control" name="subcategory">
                        <option value="{{$subcategory->id}}" selected>{{$subcategory->name}}</option>
                        @foreach($allSubcategories as  $subcateegory)
                            <option value="{{$subcateegory->id}}">{{$subcateegory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top: 1.5rem">
                    <button type="submit" class="btn btn-warning">ویرایش محصول</button>
                </div>
            </form>
        </div>
    </div>
@endsection