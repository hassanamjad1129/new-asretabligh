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
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <input id="prd-{{ $product->id }}" type="checkbox" name="products[]"
                                   value="{{ $product->id }}" {{ $service->products->contains($product->id)?"checked":"" }} />
                            <label for="prd-{{ $product->id }}">{{ $product->title }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">بروزرسانی</button>
                </div>
            </form>

        </div>
    </div>
@endsection