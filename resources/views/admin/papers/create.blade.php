@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <p>افزودن کاغذ</p>
        </div>
        <div class="card-block">
            <form action="{{ route('admin.paper.store') }}" method="post">
                @csrf
                <div class="col-md-12">
                    <label for="">نام کاغذ</label>
                    <input type="text" name="name" id="" class="form-control">
                </div>
                <div class="col-md-12" style="margin-top: 10px;">
                    <button class="btn btn-primary">ثبت نهایی</button>
                </div>
            </form>
        </div>
    </div>
@endsection