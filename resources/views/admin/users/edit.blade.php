@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ویرایش کاربر
        </div>
        <div class="card-block">
            <form action="{{ route('admin.customer.update',$user) }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                @method('patch')
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">نام</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="first_name" class="form-control"
                                   value="{{old('first_name')?old('first_name'):$user->first_name}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">نام خانوادگی</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="last_name" class="form-control" value="{{old('last_name')?old('last_name'):$user->last_name}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">موبایل </label>
                        </div>
                        <div class="card-body">
                            <input type="number" name="mobile" class="form-control" value="{{old('mobile')?old('mobile'):$user->mobile}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">تلفن</label>
                            <span class="tag tag-primary">اختیاری</span>
                        </div>
                        <div class="card-body">
                            <input type="number" name="telephone" class="form-control" value="{{old('telephone')?old('telephone'):$user->telephone}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for=""> رمز عبور جدید</label>
                            <span class="tag tag-primary">اختیاری</span>
                        </div>
                        <div class="card-body">
                            <input type="password" name="password" class="form-control" value="{{old('password')?old('password'):''}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">تکرار رمز عبور</label>
                            <span class="tag tag-primary">اختیاری</span>
                        </div>
                        <div class="card-body">
                            <input type="password" name="confirmPassword" class="form-control" value="{{old('confirmPassword')?old('confirmPassword'):''}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">نوع</label>
                        </div>
                        <div class="card-body">
                            <select class="form-control" style="height: 2.5rem !important;" name="type">
                                <option value="0" {{($user->type=='credit')?'selected':''}}>اعتباری</option>
                                <option value="1" {{($user->type=='cash')?'selected':''}}>نقدی</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">ویرایش کاربر</button>
                </div>
            </form>
        </div>
    </div>
@endsection