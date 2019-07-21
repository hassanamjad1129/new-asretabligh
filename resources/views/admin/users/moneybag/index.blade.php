@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <p>تراکنش های کیف پول</p>
        </div>
        <div class="card-block">
            <a href="{{ route('admin.moneybag.create',[$customer]) }}" class="btn btn-success"></a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>#</tr>
                <tr>عملیات</tr>
                <tr>مبلغ</tr>
                <tr>توضیحات</tr>
                <tr>تاریخ</tr>
                <tr>عملیات</tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                ?>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $report->getOperation() }}</td>
                        <td>{{ number_format($report->price) }} ریال</td>
                        <td>{{ $report->description }}</td>
                        <td>{{ jdate(strtotime($report->created_at))->format('H:i|Y/m/d') }}</td>
                        <td>
                            <form action="{{ route('admin.moneybag.delete',[$customer,$report]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-primary">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection