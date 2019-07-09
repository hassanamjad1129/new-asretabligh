@extends('admin.layout.master')
@section('extraStyle')
    <link rel="stylesheet" href="/adminAsset/datatables/dataTables.bootstrap.css">
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h5>روش ارسال سفارشات</h5>
            </div><!-- /.box-header -->
            <div class="card-block">
                <a href="{{ route('admin.shipping.create') }}" class="btn btn-success">ایجاد روش جدید</a>
                <table class="table table-bordered table-hover dataTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان روش</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($shippings as $shipping)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $shipping->name }}</td>
                            <td>{{ $shipping->status?"غیرفعال":"فعال" }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.shipping.edit',[$shipping->id]) }}"
                                       class="btn btn-primary">ویرایش
                                        اطلاعات</a>
                                    @if(!$shipping->status)
                                        <form action="{{ route('admin.shipping.destroy',[$shipping->id]) }}"
                                              method="post"
                                              style="display: inline">
                                            @csrf
                                            @method('delete')

                                            <button class="btn btn-danger"
                                                    style="border-bottom-right-radius: 0;border-top-right-radius: 0;">
                                                حذف
                                                روش
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.shipping.restore',[$shipping->id]) }}"
                                           class="btn btn-danger">بازگردانی روش</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@section('extraScripts')
    <script src="/adminAsset/datatables/jquery.dataTables.min.js"></script>
    <script src="/adminAsset/datatables/dataTables.bootstrap.min.js"></script>

    <script>
        $("table").dataTable();
    </script>
@endsection
