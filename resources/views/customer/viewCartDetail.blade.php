@extends("client.layout.master")
@section('content')
    <style>
        li {
            list-style: none;
        }

        .table tr:first-child td {
            border: none;
        }

    </style>
    <div class="col-xs-11">
        <h3>جزییات سبد خرید شماره {{ $cart->id }}</h3>
        <hr>
    </div>
    <div class="col-xs-1">
        <a href="#" onClick="history.back();" class="btn btn-primary">بازگشت <i class="fa fa-arrow-left"></i></a>
    </div>
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

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-info-circle" aria-hidden="true"></i> مشخصات سفارش</h4>
            </div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>عنوان سفارش</td>
                        <td>{{ $cart->category->catName }}</td>
                    </tr>
                    <tr>
                        <td>مشخصات سفارش</td>
                        <td>
                            <?php
                            $values = unserialize($cart->attr_values);
                            foreach ($values as $item) {
                                $value = \App\attr_value::find($item);
                                echo $value->attr->attr_name . " : " . $value->value . "<br /><br />";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>تعداد</td>
                        <td>{{ $cart->qty }} عدد</td>
                    </tr>
                    <tr>
                        <td>مبلغ کل سفارش(بدون مالیات)</td>
                        <td>{{ number_format((str_replace(",","",$cart->total_price))) }} ریال</td>
                    </tr>
                    <tr>
                        <td>مبلغ کل سفارش(با مالیات)</td>
                        <td>{{ number_format((str_replace(",","",$cart->total_price))*(1+(0.01*\App\option::where('option_name','tax')->first()->option_value))) }}
                            ریال
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-file-image-o" aria-hidden="true"></i> فایل های ارسالی</h4>
            </div>
            <div class="panel-body">
                <table class="table">
                    <?php
                    $files = $cart->uploads;
                    ?>
                    @if($files->count())
                        @foreach($files as $file)
                            <tr>
                                <td><?php echo $file->filesID->upload_name; ?></td>
                              <td><a class="btn btn-sm btn-success" href="{{ url('/customer/download/'.$file->fileName) }}"><i class="fa fa-download"></i>  نمایش </a></td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>

    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-truck" aria-hidden="true"></i> وضعیت سفارش</h4>
            </div>
          @if($cart->isFinalized())  
          <div class="panel-body">
            <p>وضعیت سفارش : <?php
              switch($cart->order->status){
                case 0:echo 'تایید نشده';break;
                case 1:echo 'تایید اولیه';break;
                case 2:echo 'در حال چاپ';break;
                case 3:echo 'آماده تحویل';break;
              
              }
              
              ?></p>
          </div>
          @else
          <div class="panel-body">
                <form action="{{ url('/customer/cart/createPayment') }}" method="post">
                    {{ csrf_field() }}
                    <p>در انتظار پرداخت</p>
                    <input type="hidden" name="order" value="{{ $cart->id }}">
                    <button class="btn btn-info">پرداخت</button>
                </form>
          </div>
          
          @endif
        </div>

    </div>
@endsection