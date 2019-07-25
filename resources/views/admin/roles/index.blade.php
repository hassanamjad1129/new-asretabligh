@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            لیست گروه های مدیریتی
        </div>
        <div class="card-block">
            <a class="btn btn-success" href="{{route('admin.roles.create')}}">ایجاد گروه مدیریتی</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان گروه</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1 ?>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $role->label }}</td>
                        <td>
                            <form action="{{ route('admin.roles.destroy',[$role]) }}" method="post"
                                  style="display: inline">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm deleteForm">حذف</button>
                            </form>
                            <a href="{{ route('admin.roles.edit',[$role]) }}" class="btn btn-warning btn-sm">ویرایش</a>
                            <a href="{{ route('admin.rolePermissions',[$role]) }}" class="btn btn-primary btn-sm">لیست
                                دسترسی ها</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection