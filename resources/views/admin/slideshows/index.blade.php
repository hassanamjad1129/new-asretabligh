@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>اسلایدشو</h3>
        </div>
        <div class="card-block">
            <form action="{{ url('/admin/slideshow/setPriority/') }}" method="post">
                {{ csrf_field() }}

                <div class="panel panel-default table-responsive" style="padding: 15px">
                    <div class="alert alert-info"><i class="fa fa-info-circle" aria-hidden="true"></i> توجه : اولویت
                        محصولات به
                        صورت پیش فرض صفر می باشد . (صفر پایین ترین اولویت می باشد )
                    </div>
                    <button class="btn btn-primary" type="submit">ویرایش اولویت محصولات</button>
                    <a href="{{ route('admin.slideshow.create') }}" class="btn btn-primary">ایجاد اسلایدشو جدید</a>
                    <br>
                    <table class="table table table-striped table-bordered table-hover datatable"
                           id="dataTables-example">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>تصویر</th>
                            <th>اولویت تصویر</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($slideshows as $slideshow)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td><img src="{{ asset($slideshow->image) }}"
                                         class="img-responsive img-thumbnail" style="width: 100px"/></td>
                                <td><input type="number" name="priority<?= $slideshow->id ?>" class="form-control"
                                           min="0"
                                           value="{{ $slideshow->priority }}"></td>
                                <td>
                                    <a class="btn btn-danger btn-sm deleteLink"
                                       href="{{ url('/admin/slideshow/delete/'.$slideshow->id) }}"><i
                                                class="fa fa-trash"
                                                aria-hidden="true"></i></a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </form>
        </div>
    </div>

@endsection