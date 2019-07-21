@extends('client.layout.master')
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
        <?php $i = 1; ?>
        @foreach($products as $product)
            <h2 style="text-align: center;">{{ $product->title }}</h2>
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
                    <th>قیمت (ریال)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($product->Papers as $paper)
                    <?php
                    $prices = \App\Models\ProductPrice::where('product_id', $product->id)->where('paper_id', $paper->id)->get();
                    foreach ($prices as $price):
                    ?>
                    @if($price->single_price)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $paper->name }}</td>
                            <?php
                            $data = explode('-', $price->values);
                            foreach ($properties as $key => $property) {
                                $value = \App\Models\ProductValue::find($data[$key]);
                                if ($value->property_id == $property) {
                                    echo "<td>" . $value->name . "</td>";
                                    break;
                                }
                            }
                            ?>
                            <td>یک رو</td>
                            <td>{{ ta_persian_num(number_format($price->double_price)) }} ریال</td>
                        </tr>
                    @endif

                    @if($price->double_price)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $paper->name }}</td>
                            <?php
                            $data = explode('-', $price->values);
                            foreach ($properties as $key => $property) {
                                $value = \App\Models\ProductValue::find($data[$key]);
                                if ($value->property_id == $property) {
                                    echo "<td>" . $value->name . "</td>";
                                    break;
                                }
                            }
                            ?>
                            <td>دو رو</td>
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