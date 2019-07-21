@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <p>تراکنش های کیف پول</p>
        </div>
        <div class="card-block">
            <a href="{{ route('admin.moneybag.create',[$customer]) }}" class="btn btn-success">افزودن تراکنش</a>
            <h3>موجودی فعلی : {{ number_format($customer->credit) }} ریال</h3>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عملیات</th>
                    <th>مبلغ</th>
                    <th>توضیحات</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
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