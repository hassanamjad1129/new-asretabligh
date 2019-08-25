@extends('client.layout.master')
@section('content')
    <div class="news-demo" style="margin-top: 2rem">
        <div class="about" style="margin-bottom: 25px;">
            <div class=" title wow fadeInUp animated" id="shoping" style=""><h2 style="text-align: center">ثبت سفارش
                    <span>سریع</span></h2>
            </div>
            <div class="img-title wow fadeInUp animated" style="position:relative;top:5px"></div>
        </div>
        <div class="news-holder cf" style="margin-top: -23px;">
            <center>
                <ul class="news-headlines">
                    <div class="container">
                        <div style="overflow: hidden;" class="categoriesHandler">

                            @foreach($categories as $key=> $category)
                                <li {{ $key?"":"class=active" }} catID="{{ $category->id }}">{{ $category->name }}</li>
                            @endforeach
                        </div>
                    </div>
                </ul>
            </center>
            <!-- .news-preview -->
        </div>
        <div class="categoriesWrapper">
            @foreach($categories as $key=>$category)
                <div class="container categories"
                     categoryContent="{{ $category->id }}" {{ $key?"style=display:none":"" }}>
                    <div class="col-md-3 col-sm-3 col-xs-12" style="padding: 0 1rem">
                        <p style="background: #d60000;color: #FFF;text-align: center;border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
    font-size: 1.5rem;
    padding: 0.7rem 0;">{{ $category->name }}</p>
                        <img src="{{ url('/getCategoryThumbnailPicture/'.$category->id) }}" style="width: 100%;margin-top: 2rem;    border-radius: 10px;
    box-shadow: 0 3px 5px rgba(0,0,0,0.3);"
                             alt="">
                        <p style="margin-top: 1rem">{{ $category->description }}</p>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        @foreach($category->products as $product)
                            <div class=" col-md-3 col-sm-6 col-xs-6">
                                <div class="thumbnail">
                                    <a href="{{ route('showProduct',[$product]) }}">
                                        <img src='{{ url('/getProductThumbnailPicture/'.$product->id) }}'>
                                        <div class="caption">
                                            <h2>{{ $product->title }}</h2>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="clearfix"></div>
            @endforeach
        </div>
    </div>

@endsection
@section('extraScripts')
    <script>
        var currentCategory = 1;
        $(".news-headlines li").click(function (e) {
            const catID = $(this).attr('catID');
            currentCategory = $(`.news-headlines li.active`).index() + 1;
            $(".news-headlines li").removeClass('active')
            $(this).addClass('active');
            $(`.categories`).hide(300);
            $(`.categories[categoryContent=${catID}]`).show(300)
        });
    </script>
@endsection