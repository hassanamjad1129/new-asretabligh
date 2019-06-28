@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>خدمات اضافی</h5>
        </div>
        <div class="card-block">
            <a href="{{ route('admin.service.create') }}" class="btn btn-success">افزودن خدمات</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $key=>$service)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $service->name }}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.service.edit',[$service]) }}">ویرایش</a>
                                    </li>
                                    <li><a class="btn btn-sm"
                                           href="#">ویژگی خدمات</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.service.destroy',[$service]) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="deleteForm btn btn-sm"
                                                    style="background: none;color: #20a8d8;">حذف
                                            </button>
                                        </form>
                                    </li>
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.service.products',[$service]) }}">محصولات مجاز</a>
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