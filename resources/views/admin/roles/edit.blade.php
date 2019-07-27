@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ویرایش گروه مدیریتی
        </div>
        <div class="card-block">
            <form action="{{ route('admin.roles.update',[$role]) }}" method="post">
                @csrf
                @method('patch')
                <div class="col-md-12">
                    <label for="name">نام گروه</label>
                    <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control">
                    <button class="btn btn-sm btn-success" style="margin-top: 10px">بروزرسانی گروه</button>
                </div>
            </form>
        </div>
    </div>
@endsection