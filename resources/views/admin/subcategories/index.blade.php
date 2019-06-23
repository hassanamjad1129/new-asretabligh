@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            مدیریت زیر دسته
        </div>
        <div class="card-block">
            <a class="btn btn-success" href="{{route('admin.subcategories.create',[$category])}}">افزودن زیر دسته</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان</th>
                    <th>تصویر</th>
                    <th>دسته پدر</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($subcategories as $subcategory)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $subcategory->name}}</td>
                        <td><img src="{{ route('admin.subcategoryPicture',[$subcategory]) }}" style="width:80px" --}}
                                 alt="{{ $subcategory->name }}">
                        </td>
                        <td>{{$subcategory->category->name}}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.subcategories.edit',[$category,$subcategory]) }}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.subcategories.destroy',[$category,$subcategory]) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="deleteForm btn btn-sm"
                                                    style="background: none;color: #20a8d8;">حذف
                                            </button>
                                        </form>
                                    </li>
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.products.index',[$category,$subcategory]) }}">محصولات</a>
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