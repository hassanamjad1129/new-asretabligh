@extends('admin.layout.master')
@section('content')
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
    <div class="card">
        <div class="card-header">
            <p>سفارشات مشتری</p>
        </div>
        <div class="card-block">
            <form action="" method="post">
                @csrf
                <div style="display: flex;justify-content: center;margin-bottom: 2rem">
                    <div class="col-md-4">
                        <label for="">شروع :</label>
                        <input type="text" class="form-control date"
                               value="{{ request()->has('start_date')?request()->start_date:"" }}" name="start_date">
                    </div>
                    <div class="col-md-4">
                        <label for="">پایان :</label>
                        <input type="text" class="form-control date"
                               value="{{ request()->has('finish_date')?request()->finish_date:"" }}" name="finish_date">
                    </div>
                    <div class="col-md-2">
                        <label for="" style="color: #FFF;">HI</label>
                        <button class="btn btn-success" style="margin-right: 10px;    margin-top: 1.8rem;">فیلتر
                        </button>
                    </div>
                </div>
            </form>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>محصول</th>
                    <th>تاریخ</th>
                    <th>وضعیت</th>
                    <th>قیمت</th>
                    <th>جزییات</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $sum = 0;
                ?>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $order->category->name."|".$order->product->title }}</td>
                        <td>{{ $order->getOrderDate() }}</td>
                        <td>{{ $order->getStatus() }}</td>
                        <td>{{ ta_persian_num(number_format($order->getTotalPrice())) }} ریال</td>
                        <td><a href="{{ route('admin.orders.orderDetail',[$order]) }}" class="btn btn-danger">جزییات</a>
                        </td>
                        <?php
                        $sum += $order->getTotalPrice();
                        ?>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="4">مجموع مبلغ سفارشات:</th>
                    <th colspan="2">{{ number_format($sum) }} ریال</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@section('extraScripts')
    <script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
    <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".date").pDatepicker({
                format: 'YYYY/MM/DD',
                initialValueType: 'persian',
                initialValue: false
            });
        });
    </script>

@endsection