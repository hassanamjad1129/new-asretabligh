@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <p>ویرایش کاغذ</p>
        </div>
        <div class="card-block">
            <form action="{{ route('admin.paper.update',[$paper]) }}" method="post">
                @csrf
                @method('patch')
                <div class="col-md-12">
                    <label for="">نام کاغذ</label>
                    <input type="text" value="{{ $paper->name }}" name="name" id="" class="form-control">
                </div>
                <div class="col-md-12" style="margin-top: 10px;">
                    <button class="btn btn-primary">بروزرسانی</button>
                </div>
            </form>
        </div>
    </div>
@endsection