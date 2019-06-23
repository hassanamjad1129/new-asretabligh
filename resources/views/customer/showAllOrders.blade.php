@extends('client.layout.master')
@section('content')
    <h3>سفارشات شما</h3>
    <hr>
    @if(count($errors->feild)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->feild->all() as $error)
                    <li><i class="fa fa-warning"></i> {!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(count($errors->success)>0)
        <div class="alert alert-success">
            <ul>
                @foreach($errors->success->all() as $error)
                    <li><i class="fa fa-check"></i> {!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-xs-12">
        <div class="panel panel-body">
            <table class="table table-striped table-bordered table-hover datatable" id="dataTables-example">
                <thead>
                <tr>
                    <th>#</th>
                    <th>شماره سفارش</th>
                    <th> عنوان سفارش</th>
                    <th>وضعیت سفارش</th>
                    <th>مبلغ کل</th>
                    <th>کد پیگیری</th>
                    <th>تاریخ ثبت سفارش</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>AT-{{ $order->id }}</td>
                        <td>{{ $order->cart->category->catName }}</td>
                        <td>@if($order->status==0) تایید نشده@elseif($order->status==1) تایید اولیه @elseif($order->status==2) در دست چاپ @else آماده تحویل@endif</td>
                        <td>{{ number_format((str_replace(",","",$order->cart->total_price))*(1+(0.01*\App\option::where('option_name','tax')->first()->option_value))) }} ریال</td>
                        <td>{{ $order->tracking_code }}</td>
                        <td>{{ jdate(strtotime($order->created_at))->format('date') }}</td>
                        <td><a href="{{ url('/customer/orders/'.$order->id.'/detail') }}" class="btn btn-info"><i class="fa fa-eye"></i> مشاهده جزییات ...</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection