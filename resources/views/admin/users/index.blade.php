@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            مدیریت کاربران
        </div>
        <div class="card-block">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام و نام خانوادگی</th>
                    <th>تصویر</th>
                    <th>موبایل</th>
                    <th>تلفن</th>
                    <th>نوع کاربر</th>
                    <th>تاریخ عضویت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $user->name}}</td>
                        <td><img src="{{ asset($user->avatar) }}" style="width:200px" class="img-circle" alt=""></td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->telephone}}</td>
                        <td>{{($user->type)=='credit'?'اعتباری':'نقدی'}}</td>
                        <td>{{ jdate(strtotime($user->created_at))->format('H:i|Y/m/d') }}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm" href="{{ route('admin.customer.edit',[$user]) }}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.customer.destroy',[$user]) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="deleteForm btn btn-sm"
                                                    style="background: none;color: #20a8d8;">حذف
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection