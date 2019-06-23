@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            لیست مدیران وبسایت
        </div>
        <div class="card-block">
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-sm">ایجاد مدیر</a>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>ایمیل</th>
                    <th>
                        عملیات
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1 ?>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li>
                                        <a href="{{ route('admin.admins.edit',[$admin]) }}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.admins.destroy',[$admin]) }}" method="post">
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