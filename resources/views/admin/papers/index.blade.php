@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <p>لیست کاغذها</p>
        </div>
        <div class="card-block">
            <a href="{{ route('admin.paper.create') }}" class="btn btn-success">ثبت کاغذ</a>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>

                @foreach($papers as $key=> $paper)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $paper->name }}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.paper.edit',[$paper]) }}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.paper.destroy',[$paper]) }}" method="post">
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