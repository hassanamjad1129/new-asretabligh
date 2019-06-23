@extends('admin.layout.master')
@section('content')
    <style>
        li .btn-block {
            text-align: right;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h5>لیست پست ها</h5>
        </div>
        <div class="card-block">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">ثبت پست جدید</a>
            <a href="{{ route('admin.pCategories.index') }}" class="btn btn-primary">دسته بندی پست ها</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان پست</th>
                    <th>تصویر پست</th>
                    <th>تاریخ انتشار</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $post->title }}</td>
                        <td><img src="{{ asset($post->picture) }}" style="width: 100px" alt=""
                                 class="img-thumbnail"></td>
                        <td>{{ jdate(strtotime($post->created_at))->format('Y/m/d') }}</td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li>
                                        <a href="{{ route('admin.posts.edit',[$post]) }}"
                                           class="btn btn-sm btn-block">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.posts.destroy',[$post]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-block deleteForm"
                                                    style="background: transparent;color: #52a9d8;">حذف
                                            </button>
                                        </form>
                                    </li>
                                    {{--<li>
                                        <a href="{{route('admin.admin.comment.post.index',[$post])}}" class="btn">مشاهده نظرات</a>
                                    </li>--}}
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