@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <p>کاغذهای مجاز</p>
        </div>
        <div class="card-block">
            <form action="" method="post">
                @csrf
                @foreach($papers as $paper)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <input type="checkbox" name="papers[]"
                               {{ $product->Papers->contains($paper->id)?"checked":"" }} value="{{ $paper->id }}" id="">
                        <label for="{{ $paper->id }}">{{ $paper->name }}</label>
                    </div>
                @endforeach
                <div class="clearfix"></div>
                <button class="btn btn-primary">بروزرسانی</button>
            </form>
        </div>
    </div>
@endsection