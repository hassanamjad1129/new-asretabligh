@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ایجاد دسترسی جدید
        </div>
        <div class="card-block">
            <form action="{{ route('admin.permissions.store') }}" method="post">
                @csrf
                <div class="col-md-6">
                    <label for="name">نام دسترسی</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="name">عنوان دسترسی</label>
                    <input type="text" name="label" id="label" class="form-control">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-success" style="margin-top: 10px">ثبت دسترسی</button>
                </div>
            </form>
        </div>
    </div>
@endsection