@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            مدیریت دسته بندی
        </div>
        <div class="card-block">
            <a class="btn btn-success" href="{{route('admin.categories.create')}}">افزودن دسته بندی</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان</th>
                    <th>تصویر</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <img src="{{ route('admin.categoryPicture',[$category]) }}" style="width: 80px"
                                 alt="{{ $category->name }}">
                        </td>
                        <td>
                            @if($category->status==1)
                                <span class="badge badge-success">فعال</span>
                            @else
                                <span class="badge badge-danger">غیر فعال</span>
                            @endif
                        </td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm" href="{{ route('admin.categories.edit',[$category]) }}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.categories.destroy',[$category]) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="deleteForm btn btn-sm"
                                                    style="background: none;color: #20a8d8;">حذف
                                            </button>
                                        </form>
                                    </li>
                                    <li><a class="btn btn-sm"
                                            href="{{ route('admin.products.index',[$category]) }}">محصولات</a></li>
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