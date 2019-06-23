@extends('client.layout.master')
@section('content')
    <h3>سبدخرید شما</h3>
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
                    <th> عنوان سفارش</th>
                    <th>وضعیت سبد</th>
                    <th>مبلغ کل</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($carts as $cart)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $cart->category->catName }}</td>
                        <td>
                          <?php 
                          if($cart->isFinalized()){
                            echo "تکمیل شده";
                          }else{
                            echo "در انتظار پرداخت";
                          }
                          ?></td>
                        <td>{{ number_format($cart->total_price) }} ریال</td>
                        <td><a href="{{ url('/customer/carts/'.$cart->id.'/detail') }}" class="btn btn-info"><i
                                        class="fa fa-eye"></i> مشاهده جزییات ...</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection