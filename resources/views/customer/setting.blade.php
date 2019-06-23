@extends('client.layout.master')
@section('content')
    <h3>تنظیمات کاربری</h3>
    <hr>
    @if(count($errors->feild)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->feild->all() as $error)
                    <li><i class="fa fa-warning"></i> {!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(count($errors->success)>0)
        <div class="alert alert-success">
            <ul>
                @foreach($errors->success->all() as $error)
                    <li><i class="fa fa-check"></i> {!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-md-6 col-xs-12">
        <div class="form-group">
            <form action="" method="post">
                {{ csrf_field() }}
                <label for="">رمز عبور فعلی :</label>
                <input type="password" name="password" class="form-control" id="password">
                <label for="">رمز عبور جدید :</label>
                <input type="password" name="newPassword" class="form-control" id="password">
                <label for="">تکرار رمز عبور جدید :</label>
                <input type="password" name="renewPassword" class="form-control" id="password">
                <br>
                <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> تغییر رمز عبور</button>
            </form>
        </div>
    </div>
@endsection