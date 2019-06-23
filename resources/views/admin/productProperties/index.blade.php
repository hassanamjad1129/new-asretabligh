@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            مدیریت مشخصات
        </div>
        <div class="card-block">
            <a class="btn btn-success" href="{{route('admin.productProperties.create',[$product])}}">افزودن
                مشخصات</a>
            <a class="btn btn-primary"
               href="{{ route('admin.products.index',[$category]) }}">محصولات</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام مشخصه</th>
                    <th>نوع</th>
                    <th>توضیحات</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($productProperties as $productProperty)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $productProperty->name }}</td>
                        <td>{{($productProperty->type=='selectable')?'انتخابی':'متنی'}}</td>
                        <td>{{str_limit($productProperty->description,20)}}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.productProperties.edit',[$product,$productProperty]) }}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.productProperties.destroy',[$product,$productProperty]) }}"
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