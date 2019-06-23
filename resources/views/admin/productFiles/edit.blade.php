@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ویرایش فایل محصول
        </div>
        <div class="card-block">
            <form action="{{ route('admin.productFile.update',[$category,$subcategory,$product,$productFile]) }}"
                  enctype="multipart/form-data"
                  method="post">
                @csrf
                @method('patch')
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <label for="">عنوان محصول</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="title" class="form-control" value="{{$product->title}}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">برچسب رو</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="front_label[]" class="form-control" value="{{($productFile->front_label)?$productFile->front_label:''}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">برچسب پشت</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="back_label[]" class="form-control" value="{{($productFile->back_label)?$productFile->back_label:''}}"/>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top: 0.5rem">
                    <button type="submit" class="btn btn-primary"> ویرایش فایل محصول</button>
                </div>
            </form>
        </div>
    </div>
@endsection