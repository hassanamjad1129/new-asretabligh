@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            ویرایش کاربر
        </div>
        <div class="card-block">
            <form action="{{ route('admin.customer.update',$customer) }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                @method('patch')
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">نام</label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="name" class="form-control"
                                   value="{{old('name')?old('name'):$customer->name}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">شماره همراه </label>
                        </div>
                        <div class="card-body">
                            <input type="text" name="phone" class="form-control"
                                   value="{{old('phone')?old('phone'):$customer->phone}}"/>
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
                            <input type="text" name="telephone" class="form-control"
                                   value="{{old('telephone')?old('telephone'):$customer->telephone}}"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">جنسیت</label>
                        </div>
                        <div class="card-body">
                            <select class="form-control" name="gender">
                                <option value="">انتخاب کنید ...</option>
                                <option value="male" {{ $customer->gender=='male'?"selected":"" }}>مرد</option>
                                <option value="female" {{ $customer->gender=='female'?"selected":"" }}>زن</option>
                            </select>
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
                            <input type="password" name="password" class="form-control"
                                   value="{{old('password')?old('password'):''}}"/>
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
                            <input type="password" name="confirmPassword" class="form-control"
                                   value="{{old('confirmPassword')?old('confirmPassword'):''}}"/>
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
                                <option value="0" {{($customer->type=='credit')?'selected':''}}>اعتباری</option>
                                <option value="1" {{($customer->type=='cash')?'selected':''}}>نقدی</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <label for="">تصویر</label>
                        </div>
                        <div class="card-body">
                            <input type="file" name="avatar" id="avatar" class="form-control">
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