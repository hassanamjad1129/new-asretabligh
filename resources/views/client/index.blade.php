@extends('client.layout.master')
@section('content')
    <!------------------    Slider   ------------------>
    <div id="slider">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

            <!--  bullet -->
            <ul class="carousel-indicators">
                @for($j=1;$j<=count($slideshows);$j++)
                    <li data-target="#carousel-example-generic" data-slide-to="{{ $j-1 }}"
                        @if($j==1) class="active" @endif></li>
                @endfor
            </ul>
            <!-- slides -->
            <div class="carousel-inner" role="listbox">
                <div class="svg-wrapper bounce">
                    <a data-scroll data-options='{ "easing": "linear" }' href="#servies">
                        <div class="arrow-down"><i class="flaticon-computer"></i></div>
                    </a>
                </div>
                <?php $i = 1; ?>
                @foreach($slideshows as $slideshow)
                    <div class="item @if($i==1) active @endif <?php $i++ ?>"
                         style="background-image: url({{ asset($slideshow->image) }});background-size: 100%;background-repeat: no-repeat">
                        @if(($i-1)%2==1)
                            <div class="bag-red"></div>@else
                            <div class="bag-black"></div>@endif
                        <div class="carousel-caption">
                            <p style="position: relative;bottom: 20px" data-wow-duration="500ms"
                               class="wow slideInRight animated">Digital Print Center</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!------------------    servies    -------------------->
    <div id="servies" style="visibility: visible; animation-duration: 500ms; animation-name: bounceInDown;">
        <div class="container">
            <div class="row servies-div">
                <div class="col-md-3 col-sm-3 wow ofset fadeInUp  animatable animated">
                    <img src="{{ asset('/clientAssets') }}/img/ofset_817e57b12c8d1ea4e51764171bb1667d.png"
                         alt="چاپ افست"
                         title="چاپ افست"/>
                    <div class="title">چاپ افست</div>
                    <p>نوعي چاپ كه در حال حاضر به شکل وسیعی به منظور چاپ مجله، بروشور، کاتالوگ، پوستر، کتاب و ... موررد
                        استفاده قرار می‎گیرد، این چاپ عموما بر روی کاغذ در تیراژهاي بالا استفاده مي‌شود.</p>
                    <a class="btn" href="{{ url('/preorder') }}">مشاهده ادامه</a>
                </div>

                <div class="col-md-3 col-sm-3 wow ofset fadeInUp  animatable animated">
                    <img src="{{ asset('/clientAssets') }}/img/digital_3fd89689e131959c62a04e9a783b43fb.png"
                         alt="چاپ دیجیتال" title="چاپ دیجیتال"/>
                    <div class="title">چاپ دیجیتال</div>
                    <p>این روش معمولاً شامل چاپ حرفه‌ای در تیراژهای کم تعداد توسط نشر رومیزی و دیگر منابع دیجیتال است که
                        بوسیله چاپگرهای لارج‌فرمت و یا چاپگرهای لیزری و جوهرافشان حرفه‌ای انجام می‌شود.
                    </p>
                    <a class="btn" href="{{ url('/preorder')}}">مشاهده ادامه</a>
                </div>

                <div class="col-md-3 col-sm-3 wow ofset fadeInUp  animatable animated">
                    <img src="{{ asset('/clientAssets') }}/img/gifs.png" alt="تخفیف روز" title="تخفیف روز"/>
                    <div class="title">تخفيف روز</div>
                    <p>در چاپ عصر تبليغ هر روز مي‌توانيد از تخفيفات ويژه روز در سايت استفاده كنيد، كاربر گرامي در هر روز
                        با
                        معرفي يك يا چند محصول به صورت تخفيف روز مي‌توانيد از خدمات ما بهرمند گرديد. </p>
                    <a class="btn" href="{{ url('/discount') }}">مشاهده ادامه</a>
                </div>
            </div>
        </div>
    </div>

    <!------------------    About us    -------------------->
    <div class="paper wow pulse animated"></div>


    <div class="news-demo" style="margin-top: 2rem">
        <div class="about" style="margin-bottom: 25px;">
            <div class=" title wow fadeInUp animated" style=""><h2 style="text-align: center">لیست
                    <span>خدمات</span></h2>
            </div>
            <div class="img-title wow fadeInUp animated" style="position:relative;top:5px"></div>
        </div>
        <hr>
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
                    <div class="col-md-3 col-sm-6" style="padding: 0 1rem">
                        <p style="background: #d60000;color: #FFF;text-align: center;border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
    font-size: 1.5rem;
    padding: 0.7rem 0;">{{ $category->name }}</p>
                        <img src="{{ url('/getCategoryPicture/'.$category->id) }}" style="width: 100%;margin-top: 2rem;"
                             alt="">
                        <p>{{ $category->description }}</p>
                    </div>
                    <div class="col-md-9 col-sm-6">
                        @foreach($category->products as $product)
                            <div class=" col-md-3 col-sm-6 col-xs-6">
                                <div class="thumbnail">
                                    <a href="{{ route('showProduct',[$product]) }}">
                                        <img src='{{ url('/getProductPicture/'.$product->id) }}'>
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
    <div class="container">
        <div class="about">
            <div class="title wow fadeInUp animated">
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    <div class="title wow fadeInUp animated"><h2 style="text-align: center">لیست <span>قیمت</span></h2>
                    </div>

                </div>
            </div>
            <div class="col-md-4">

            </div>
            <div class="img-title wow fadeInUp animated" style="position:relative;top:38px"></div>
            <div class="row" id="priceCircles">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="{{ url('/priceList/چاپ افست') }}"><img
                                src="{{ asset('/clientAssets') }}/img/about-img1-h.png" id="offset"
                                class="part-one wow fadeInUp animatable animated img-responsive"
                                alt="عصر تبلیغ"
                                data-toggle="tooltip" title="چاپ افست"></a>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="{{ url('/priceList/چاپ دیجیتال') }}"><img
                                src="{{ asset('/clientAssets') }}/img/about-img2-h_52ba5d14d8e0cb2be8c6c660393e8571.png"
                                id="digital"
                                class="part-two wow fadeInUp animatable animated img-responsive"
                                alt="عصر تبلیغ"
                                data-toggle="tooltip" title="چاپ دیجیتال"></a>

                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="{{ url('/priceList/چاپ دیجیتال') }}"><img
                                src="{{ asset('/clientAssets') }}/img/about-img3-h_cbbb66d9d0650056674ba22fea06e250.png"
                                id="student"
                                class="part-three wow fadeInUp animatable animated img-responsive"
                                alt="عصر تبلیغ"
                                data-toggle="tooltip" title="خدمات دانشجویی"></a>

                </div>

                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="{{ url('/discount') }}">
                        <img src="{{ asset('/clientAssets') }}/img/about-img4-h_f8b61d508eb2c1717418a85be016483f.png"
                             id="gift" class="part-four wow fadeInUp animatable animated img-responsive"
                             alt="عصر تبلیغ" data-toggle="tooltip" title="تخفیف روز">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <!------------------    parallax    -------------------->
    <div class="parallax">
        <div class="parallax-overlay">
            <div class="container">
                <div class="box">
                    <div class="title fadeInUp animated">ویژگی هایی که ما را از دیگران متمایز می کند</div>
                    <div class="slide" data-ride="carousel" id="quote-carousel">
                        <div class="carousel-inner">
                            <?php
                            $property = explode('-', $property);
                            $flag = false;
                            foreach ($property as $item):
                            ?>
                            <div class="item <?php echo $flag ? "" : "active"; $flag = true; ?>">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p>
                                            <i class="flaticon-shapes"></i>{{ $item }} <i class="flaticon-shapes"
                                                                                          id="icon-r"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;  ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="poems">
        <div class="container">
            <div class="row">
                <img src="/clientAssets/img/juzxshnmd2vdkjtsczpc.png" class="img-responsive stripImage" alt="">
            </div>
        </div>
    </div>

    <!------------------    News    -------------------->
    <div class="listnews">
        <div class="container">
            <div class="news">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="col-md-12"
                             style="background: #FDFDFD;padding: 2rem 1rem;box-shadow: 0 0 5px rgba(0,0,0,.2)">
                            @if($discounts->count())
                                <img src="{{ url('/getCategoryPicture/'.$discounts[0]->category->id) }}"
                                     style="width: 100%">
                                <h3 style="text-align: center;font-weight: bold;margin-top: 1rem">تخفیف ویژه</h3>
                            @else
                                <img src="/clientAssets/img/icons8-sale-128.png" style="width: 100%;" alt="">
                                <h3 style="text-align: center;font-weight: bold;margin-top: 1rem;line-height: 2.1rem;">
                                    امروز تخفیفی نداریم</h3>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-6" id="newDIV">
                        <div class="col-md-12"
                             style="background: #FDFDFD;padding: 2rem 1rem;box-shadow: 0 0 5px rgba(0,0,0,.15)">
                            <div class="title wow fadeInUp animated"><h3 style="margin-bottom: 1.5rem;">آخرین <span>مطالب</span>
                                </h3></div>
                            @foreach($news as $key=> $new)
                                <div class="col-md-4 col-sm-12 news-elements" {{ $key?"":"style=display:block" }}>
                                    <div class="card">
                                        <div class="hovereffect">
                                            <img class="img-responsive newsImage"
                                                 src="{{ asset($new->picture)}}"
                                                 alt="عصر تبلیغ"/>
                                            <div class="overlay">
                                                <i class="flaticon-mark"></i>
                                                <a href="{{ url('/news/show/'.$new->id.'/'.mb_substr(strip_tags(trim($new->title)),0,20,'UTF8')) }}">
                                                    <h2>مشاهده جزییات</h2></a>
                                            </div>
                                        </div>
                                        <div class="caption">
                                            <div class="col-md-12">
                                                <a href="{{ url('/news/show/'.$new->id.'/'.mb_substr(strip_tags(trim($new->title)),0,20,'UTF8')) }}"
                                                   style="cursor: pointer"><h4 class="h4">{{ $new->title }}</h4></a>
                                                <h5>
                                                    <img src="{{ asset('/clientAssets') }}/img/user_bb729832533cec2d08d164e8d624643d.png"
                                                         class="user">نویسنده: مدیر
                                                    سایت
                                                </h5>
                                                <p>{!! mb_substr(strip_tags(trim($new->description)),0,150,'UTF8') !!}
                                                    [...]</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="clearfix"></div>
                            <a href="{{ url('/news') }}" class="btn" style="margin-top:1rem">آرشیو خبرها</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>

    <!------------------    customer    -------------------->
    <div id="customers">
        <div class="listnews">
            <div class="container">
                <div class="title wow fadeInUp animated">
                    <h2>مشتریان<span> ما</span></h2>
                </div>
                <div class="img-title wow fadeInUp animated"></div>
            </div>

        </div>
        <div class="container-fluid">

            <div id="owl-demo2">
                @foreach($bestCustomers as $bestCustomer)
                    <div class="item col-md-2 col-sm-4 col-xm-12">
                        <div class="article-item">
                            <a href="#">
                                <img src="{{ asset($bestCustomer->image) }}" alt="عصر تبلیغ"
                                     title=""/></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('extraScripts')
    <script>
        var currentCategory = 1;
        $(document).ready(function () {
            $("#owl-demo2").owlCarousel();
        });
        var currentDate = new Date();
        var pastDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() + 1);
        var diff = pastDate.getTime() / 1000 - currentDate.getTime() / 1000;
        clock = [];
        for (var i ={{ $i }}; i > 1; i--) {
            clock.push($('.clock' + (i - 1)).FlipClock(diff, {
                clockFace: 'HourlyCounter',
                countdown: true,
            }));
        }

        $(".news-headlines li").click(function (e) {
            const catID = $(this).attr('catID');
            currentCategory = $(`.news-headlines li.active`).index() + 1;
            $(".news-headlines li").removeClass('active')
            $(this).addClass('active');
            $(`.categories`).hide(300);
            $(`.categories[categoryContent=${catID}]`).show(300)
        });
        //categoriesHandler
        /*$("#gotToLeft").click(function () {
            var index = $(`.news-headlines li.active`).index() + 1;
            $(".news-headlines li").removeClass('active')
            const width = $(`.news-headlines li:nth-child(${currentCategory})`)[0].offsetWidth;

            if (currentCategory === $(`.news-headlines li`).length) {
                $(`.news-headlines li:nth-child(1)`).addClass('active');
                currentCategory = 0;
                $(".categoriesHandler div").css({
                    left: 0
                });
                $(`.categories`).hide(300);
                $(`.categoriesWrapper .categories:nth-child(1)`).show(300)
            } else {
                $(`.news-headlines li:nth-child(${index + 1}`).addClass('active');
                $(".categoriesHandler div").css({
                    left: (parseInt($(".categoriesHandler div").css('left'))) + width + 12
                });
                $(`.categories`).hide(300);
                const catID = $(".news-headlines li.active").attr('catID')
                $(`.categories[categoryContent=${catID}]`).show(300)
            }
            currentCategory += 1;
        })
        $("#gotToRight").click(function () {
            const width = $(`.news-headlines li:nth-child(${currentCategory})`)[0].offsetWidth;
            var index = $(`.news-headlines li.active`).index() + 1;
            $(".news-headlines li").removeClass('active')
            if (currentCategory === 1) {
                currentCategory = $(`.news-headlines li`).length;
                $(`.news-headlines li:nth-child(${currentCategory})`).addClass('active');
                var sum = 0;
                $(`.news-headlines li`).each(function (index) {
                    sum += ($(this)[0].offsetWidth + 6)
                })
                sum -= ($(`.news-headlines li:last-child`)[0].offsetWidth - 12);
                $(".categoriesHandler div").css({
                    left: sum
                });

                $(`.categories`).hide(300);
                const catID = $(".news-headlines li.active").attr('catID')
                $(`.categories[categoryContent=${catID}]`).show(300)
            } else {
                const width = $(`.news-headlines li:nth-child(${index - 1})`)[0].offsetWidth;
                $(`.news-headlines li:nth-child(${index - 1})`).addClass('active');
                $(".categoriesHandler div").css({
                    left: ((parseInt($(".categoriesHandler div").css('left'))) - width - 10)
                });
                currentCategory -= 1;

                $(`.categories`).hide(300);
                const catID = $(".news-headlines li.active").attr('catID')
                $(`.categories[categoryContent=${catID}]`).show(300)
            }
        })*/
    </script>
@endsection