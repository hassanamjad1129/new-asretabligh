@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            لیست دسترسی ها
        </div>
        <div class="card-block">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان دسترسی</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1 ?>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $permission->label }}</td>
                        <td>
                            <a href="{{ route('admin.permissions.edit',[$permission]) }}" class="btn btn-warning btn-sm">ویرایش</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection