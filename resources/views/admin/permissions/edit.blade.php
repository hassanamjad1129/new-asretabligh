@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ویرایش دسترسی
        </div>
        <div class="card-block">
            <form action="{{ route('admin.permissions.update',[$permission]) }}" method="post">
                @csrf
                @method('patch')
                <div class="col-md-6">
                    <label for="name">نام دسترسی</label>
                    <input type="text" name="name" value="{{ $permission->name }}" id="name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="name">عنوان دسترسی</label>
                    <input type="text" name="label" value="{{ $permission->label }}" id="label" class="form-control">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-success" style="margin-top: 10px">بروزرسانی دسترسی</button>
                </div>
            </form>
        </div>
    </div>
@endsection