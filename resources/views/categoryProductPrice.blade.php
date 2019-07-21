@extends('client.layout.master')
@section('title')
    لیست قیمت {{ $category->name }}
@endsection
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
        <?php use App\Models\ProductValue as ProductValueAlias;$i = 1; ?>
        @foreach($products as $product)
            <h2 style="text-align: center;">لیست قیمت <a
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
                                if ($value->property_id == $property) {
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
        @endforeach
    </div>
@endsection