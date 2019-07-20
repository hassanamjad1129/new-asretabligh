@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            مدیریت کاربران
        </div>
        <div class="card-block">
            <a class="btn btn-success" href="{{route('admin.user.create')}}">افزودن کاربر</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام و نام خانوادگی</th>
                    <th>موبایل</th>
                    <th>تلفن</th>
                    <th>نوع کاربر</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $user->name}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->telephone}}</td>
                        <td>{{($user->type)=='credit'?'اعتباری':'نقدی'}}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm" href="{{ route('admin.user.edit',[$user]) }}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.user.destroy',[$user]) }}"
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