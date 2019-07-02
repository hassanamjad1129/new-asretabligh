@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            مدیریت محصولات
        </div>
        <div class="card-block">
            <a class="btn btn-success" href="{{route('admin.products.create',[$category])}}">افزودن
                محصول</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان</th>
                    <th>تصویر</th>
                    <th>نام زیر دسته</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $product->title }}</td>
                        <td>
                            <img src="{{ route('admin.productPicture',[$product]) }}" style="width: 80px"
                                 alt="{{ $product->name }}">
                        </td>
                        <td>{{$product->category->name}}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.products.edit',[$category,$product]) }}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.products.destroy',[$category,$product]) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="deleteForm btn btn-sm"
                                                    style="background: none;color: #20a8d8;">حذف
                                            </button>
                                        </form>
                                    </li>
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.productPrice.create',[$category,$product]) }}">
                                            قیمت محصول</a>
                                    </li>
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.productProperties.index',[$product]) }}">مشخصات
                                            محصول</a>
                                    </li>
                                    <li><a class="btn btn-sm"
                                           href="{{ route('admin.products.papers',[$category,$product]) }}">کاغذهای
                                            محصول</a>
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