@extends('admin.layout.master')
@section('content')
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">

    <div class="card">
        <div class="card-header">
            <p>گزارش سفارشات</p>
        </div>
        <div class="card-block">
            <form action="" method="post">
                @csrf
                <div style="display: flex;justify-content: center;margin-bottom: 2rem">
                    <div class="col-md-3">
                        <label for="">شروع :</label>
                        <input type="text" class="form-control date"
                               value="{{ request()->has('start_date')?request()->start_date:"" }}" name="start_date">
                    </div>
                    <div class="col-md-3">
                        <label for="">پایان :</label>
                        <input type="text" class="form-control date"
                               value="{{ request()->has('finish_date')?request()->finish_date:"" }}" name="finish_date">
                    </div>
                    <div class="col-md-3">
                        <label for="">وضعیت</label>
                        <select name="status" id="" class="form-control">
                            <option value="" {{ request()->has('status')?"":"selected" }}>همه</option>
                            <option value="1" {{ request()->has('status') and  request()->status==1?"selected":"" }}>
                                تایید مالی
                            </option>
                            <option value="2" {{ request()->has('status') and  request()->status==2?"selected":"" }}>در
                                حال انجام
                            </option>
                            <option value="3" {{ request()->has('status') and  request()->status==3?"selected":"" }}>
                                آماده تحویل
                            </option>
                            <option value="4" {{ request()->has('status') and  request()->status==4?"selected":"" }}>
                                تحویل داده شده
                            </option>
                        </select>
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
                    <th>قیمت</th>
                    <th>تاریخ</th>
                    <th>وضعیت</th>
                    <th>جزییات</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $sum = 0;
                ?>
                @if(request()->has('start_date') or request()->has('finish_date'))
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $order->category->name."|".$order->product->title }}</td>
                            <td>{{ ta_persian_num(number_format($order->getTotalPrice())) }} ریال</td>
                            <td>{{ $order->getOrderDate() }}</td>
                            <td>{{ $order->getStatus() }}</td>
                            <td><a href="{{ route('admin.orders.orderDetail',[$order]) }}"
                                   class="btn btn-danger">جزییات</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
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