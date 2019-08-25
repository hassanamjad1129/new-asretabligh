@extends('client.layout.master')
@section('title') لیست قیمت {{ $category->name }}@endsection
@section('description')لیست قیمت@foreach($products as $product) {{ $product->title }} ارزان، @endforeach @endsection
@section('content')
    <style>
        .table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
            border-bottom-width: 2px;
            background: #d60000;
            color: #FFF;
            padding: 1rem !important;

        }

        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 1px solid #ddd;
            padding: 0.5rem 1rem;
            text-align: center;
        }

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
            color: #fff;
            cursor: default;
            background-color: #D60000;
            border: 1px solid #ddd;
            border-radius: 2rem;
        }

        .nav-tabs > li > a:hover {
            border-color: #eee #eee #ddd;
        }
        .nav > li > a:hover, .nav > li > a:focus {
            text-decoration: none;
            background-color: #d60000;
            color: #FFF;
            border-radius: 2rem;
        }

        .nav-tabs > li > a {
            margin-left: auto;
            margin-right: -2px;
            border-radius: 4px 4px 0 0;
            margin: 0 0.4rem;
        }

        h2{
            font-size: 1.7rem;
        }

        .table-bordered > tbody > tr:hover {
            transform: scale(1.02);
            transition: all 0.3s ease 0s;
        }
    </style>
    <div class="container">
        <h1 style="text-align: center">لیست قیمت {{ $category->name }}</h1>
        <br>
        <ul class="nav nav-tabs" style="display: flex;
    justify-content: center;
    border: none;">
            <?php $i = 0;?>
            @foreach($products as $product)
                <?php $i++;?>
                <li class="{{$i==1?'active':''}}"><a data-toggle="tab" href="#c{{$product->id}}">{{$product->title}}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            <?php use App\Models\ProductValue as ProductValueAlias;$i = 1; ?>
            @foreach($products as $product)
                <div id="c{{$product->id}}" class="tab-pane fade{{$i==1?' in active':''}}">
                    <h2 style="text-align: center;margin-top: 20px;">لیست قیمت <a
                                href="{{ route('showProduct',$product) }}">{{ $product->title }}</a></h2>
                    <br>
                    <table class="table-striped table-bordered" style="width: 100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نوع کاغذ</th>
                            <?php $properties = []; ?>
                            @foreach($product->ProductProperties as $property)
                                <?php $properties[] = $property->id; ?>
                                <th>{{ $property->name }}</th>
                            @endforeach
                            <th>نوع کار</th>
                            <th>از تعداد</th>
                            <th>تا تعداد</th>
                            <th>قیمت (ریال)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product->Papers as $paper)
                            <?php
                            $prices = \App\Models\ProductPrice::where('product_id', $product->id)->where('paper_id', $paper->id)->orderBy('values')->get();
                            foreach ($prices as $price):
                            ?>
                            @if($price->single_price)
                                <tr>
                                    <td>{{ ta_persian_num($i++) }}</td>
                                    <td style="">{{ $product->title." ".ta_persian_num($paper->name) }}</td>
                                    <?php
                                    $data = explode('-', $price->values);
                                    foreach ($properties as $key => $property) {
                                        foreach ($data as $d) {
                                            $value = ProductValueAlias::find($d);
                                            if ($value->property_id == $property) {
                                                echo "<td>" . ta_persian_num($value->name) . "</td>";

                                            }
                                        }


                                    }
                                    ?>
                                    <td>یک رو</td>
                                    <td>{{ ta_persian_num($price->min) }}</td>
                                    <td>{{ ta_persian_num($price->max) }}</td>
                                    <td>{{ ta_persian_num(number_format($price->single_price)) }} ریال</td>
                                </tr>
                            @endif

                            @if($price->double_price)
                                <tr>
                                    <td>{{ ta_persian_num($i++) }}</td>
                                    <td>{{ $product->title." ".ta_persian_num($paper->name) }}</td>
                                    <?php
                                    $data = explode('-', $price->values);
                                    foreach ($properties as $key => $property) {
                                        foreach ($data as $d) {
                                            $value = ProductValueAlias::find($d);
                                            if ($value->property_id == $property) {
                                                echo "<td>" . ta_persian_num($value->name) . "</td>";

                                            }
                                        }
                                    }
                                    ?>
                                    <td>دو رو</td>
                                    <td>{{ ta_persian_num($price->min) }}</td>
                                    <td>{{ ta_persian_num($price->max) }}</td>

                                    <td>{{ ta_persian_num(number_format($price->double_price)) }} ریال</td>
                                </tr>
                            @endif

                            <?php
                            endforeach;
                            ?>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('extraScripts')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
@endsection