@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-haeder">
            <h5>محصولات مجاز : </h5>
        </div>
        <div class="card-block">
            <form action="" method="post">
                @csrf
                <div class="row">
                    @foreach($products as $product)
                        @foreach($product->Papers as $paper)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                <input id="prd-{{ $product->id }}-{{ $paper->id }}" type="checkbox" name="products[]"
                                       value="{{ $product->id }}-{{ $paper->id }}" {{ $service->haveProductPaper($product->id,$paper->id)?"checked":"" }} />
                                <label for="prd-{{$product->id }}-{{ $paper->id }}">{{ $product->title }}
                                    - {{ $paper->name}}</label>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">بروزرسانی</button>
                </div>
            </form>

        </div>
    </div>
@endsection