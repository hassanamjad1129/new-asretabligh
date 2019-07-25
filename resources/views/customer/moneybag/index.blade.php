@extends('customer.layout.dashboardMaster')
@section('dashboardContent')
    <style>
        .table-striped td, .table-striped th {
            padding: 20px 10px;
            font-size: 1.0rem;
            text-align: center;
        }
    </style>

    <div class="col-xs-12" style="margin-top: 2rem">
        <h4 style="width: 250px;background: #444;color: #FFF;text-align: center;padding: 1rem 0;border-radius: 10px;border-bottom-left-radius: 0;border-bottom-right-radius: 0">
            سوابق شارژ کیف پول</h4>
        <div class="panel panel-default" id="panel">
            <div class="panel-body">
                <div style="display: flex;justify-content: center;margin: 2rem 0;">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form action="" method="post">
                                    @csrf
                                    <h4 style="text-align: center;font-weight: bold;">افزایش موجودی کیف پول</h4>
                                    <div style="display: flex;justify-content: space-around;    align-items: center;">
                                        <input type="text" style="margin-top: 1rem;width: 90%" name="price" id=""
                                               class="form-control">
                                        <h4>ریال</h4>
                                    </div>
                                    <hr>
                                    <button class="btn btn-danger" style="float: left;">پرداخت</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table-striped table-hovered table-bordered" style="width: 100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>مبلغ</th>
                        <th>عملیات</th>
                        <th>توضیحات</th>
                        <th>تاریخ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    ?>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ ta_persian_num(number_format($report->price)) }} ریال</td>
                            <td>{{ $report->getOperation() }}</td>
                            <td>{{ $report->description }}</td>
                            <td>{{ jdate(strtotime($report->created_at))->format('H:i | Y/m/d') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection