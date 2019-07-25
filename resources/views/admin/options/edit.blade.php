@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            مدیریت تنظیمات وبسایت
        </div>
        <div class="card-block">
            <form action="" method="post">
                @csrf
                @foreach($options as $option)
                    <div class="col-md-12">
                        <label for="">{{$option->label}}</label>
                        <input type="text" name="{{ $option->option_name }}" value="{{ $option->option_value }}"
                               class="form-control">
                    </div>
                @endforeach
                <div class="col-md-12" style="margin-top: 1rem">
                    <button class="btn btn-success">ثبت نهایی</button>
                </div>
            </form>

        </div>
    </div>
@endsection