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
            ایجاد زیر دسته
        </div>
        <div class="card-block">
            <form action="{{ route('admin.subcategories.store',['category'=>$category]) }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                <div class="col-md-6">
                    <label for="">عنوان زیر دسته</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')?old('name'):''}}"/>
                </div>
                <div class="col-md-6">
                    <label for="">تصویر زیر دسته</label>
                    <input type="file" name="picture" id="" class="form-control" accept="image/*"/>
                </div>
                <div class="col-md-6">
                    <label for="">دسته پدر</label>
                    <select class="js-example-basic-single form-control" name="parent">
                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                        @foreach($allCategories as  $cateegory)
                            <option value="{{$cateegory->id}}">{{$cateegory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12" style="margin-top:1.5rem">
                    <label for=""> توضیحات زیر دسته</label>
                    <textarea class="form-control" rows="7" name="description">{{old('description')?old('description'):''}}</textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top:1.5rem">
                    <button type="submit" class="btn btn-success">ثبت زیر دسته</button>
                </div>
            </form>
        </div>
    </div>



    </div>
    </div>
@endsection