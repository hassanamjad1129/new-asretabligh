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
        }
    </style>
    <div class="container">
        <h1 style="text-align: center">لیست قیمت {{ $category->name }}</h1>
        <br>
        <ul class="nav nav-tabs">
            <?php $i = 0;?>
            @foreach($products as $product)
                <?php $i++;?>
                <li class="{{$i==1?'active':''}}"><a data-toggle="tab" href="#{{$product->id}}"
                                                     onclick="tabActive({{$product->id}})">{{$product->title}}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            <?php use App\Models\ProductValue as ProductValueAlias;$i = 1; ?>
            @foreach($products as $product)
                <div id="{{$product->id}}" class="tab-pane fade{{$i==1?' in active':''}}">
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
                                        $value = ProductValueAlias::find($data[$key]);
                                        if ($value and $value->property_id == $property) {
                                            echo "<td>" . ta_persian_num($value->name) . "</td>";
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
                                        $value = ProductValueAlias::find($data[$key]);
                                        if ($value->property_id == $property) {
                                            echo "<td>" . ta_persian_num($value->name) . "</td>";
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
    <script>
        function tabActive(tagId) {
            $('.tab-content').children().removeClass(' in active');
            $('#' + tagId).addClass("tab-pane fade in active");
        }
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
@endsection