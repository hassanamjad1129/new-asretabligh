@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            مدیریت فایل محصول
        </div>
        <div class="card-block">
            <a class="btn btn-success" href="{{route('admin.productFile.create',[$category,$subcategory,$product])}}">افزودن
                فایل محصول</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان محصول</th>
                    <th>برچسب رو</th>
                    <th>برچسب پشت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($productFiles as $productFile)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$product->title}}</td>
                        <td>
                            {{$productFile->front_label}}
                        </td>
                        <td>{{$productFile->back_label}}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.productFile.edit',[$category,$subcategory,$product,$productFile]) }}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.productFile.destroy',[$category,$subcategory,$product,$productFile]) }}"
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