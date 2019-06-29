@extends('client.layout.master')
@section('content')
    <style>
        input[type="radio"] + label > div {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        input[type="radio"]:checked + label > div {
            background-color: #e52531 !important;
        }

        input[type="radio"]:checked + label > div > p {
            color: #FFF !important;
        }

        button.close, button.close:hover {
            -webkit-appearance: none;
            padding: 0;
            cursor: pointer;
            color: #000;
            border: 0;
            background: transparent;
            font-size: 18px;
            border-radius: 100%;
            width: 20px;
            height: 20px;
            position: relative;
            top: -5px;
            right: 0;
            opacity: 1;
            float: right;
        }

        .orderSpecification li {
            list-style-type: disc;
            margin-bottom: 10px;
        }
    </style>
    <div class="container">
        <div class="col-md-3">
            <div style="padding: 1rem;background: #FFF;box-shadow: 0 0 10px #BBB">
                <img src="{{ url('getProductPicture/'.$product->id) }}" style="width: 100%;padding: 2rem" alt="">
                <h4 style="text-align: center;color:#d60000;font-weight: bold">{{ $product->title }}</h4>
                <div style="margin-top: 1rem">
                    <p style="    line-height: 25px;">{!! nl2br($product->description) !!}</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <form action="{{ route('storeCart') }}" id="orderForm" method="post">
                @csrf
                <input type="hidden" name="product" value="{{$product->id}}">
                <div style="padding: 1rem;background: #FFF;box-shadow: 0 0 10px #BBB;overflow: hidden;">
                    <div class="col-md-8">
                        <h3 style="margin-bottom: 2rem;font-weight: bold;"><i class="fa fa-shopping-bag"></i> ثبت سفارش
                        </h3>
                        @foreach($properties as $index=>$property)
                            <div class="col-md-12">
                                <label v="p-{{ $property->id }}" for=""
                                       style="font-weight: bold;font-size:15px;margin-top:10px">{{ $property->name }}
                                    <i
                                            class="fa fa-info-circle" data-toggle="modal"
                                            data-target="#pro-{{$property->id}}" style="cursor: pointer;"></i></label>
                                <div class="clearfix"></div>
                                @foreach($property->ProductValues as $value)
                                    <div>
                                        <input type="radio" style="display: none" val="p-{{ $property->id }}"
                                               id="p-{{ $value->id }}"
                                               name="property-{{ $property->id }}"
                                               value="{{ $value->id }}">
                                        <label for="p-{{ $value->id }}" class="col-md-3" style="padding: 0 5px">
                                            <div style="padding: 0.5rem;background: #EEE;border-radius: 10px">
                                                @if($value->picture)
                                                    <img src="{{ route('getValuePicture',[$value]) }}"
                                                         style="width: 100%"
                                                         alt="">
                                                @endif
                                                <p style="text-align: center">{{ $value->name }}</p>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                            <div class="clearfix"></div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <label for="" v="typeOrder" style="font-weight: bold;font-size:15px;margin-top:10px">نوع
                                کار</label>
                            <div class="clearfix"></div>
                            @if($product->type=='all' or $product->type=='single')
                                <div>
                                    <input name="type" style="display: none" id="type-1"
                                           {{ $product->type=='single'?"checked":"" }} type="radio" val="typeOrder"
                                           value="single"/>
                                    <label for="type-1" class="col-md-6" style="padding: 0 5px">
                                        <div style="padding: 0.5rem;background: #EEE;border-radius: 10px">
                                            <p style="text-align: center">یک رو</p>
                                        </div>
                                    </label>
                                </div>
                            @endif
                            @if($product->type=='all' or $product->type=='double')
                                <div>
                                    <input name="type" style="display: none" id="type-2" type="radio" val="typeOrder"
                                           {{ $product->type=='double'?"checked":"" }}
                                           value="double"/>
                                    <label for="type-2" class="col-md-6" style="padding: 0 5px">
                                        <div style="padding: 0.5rem;background: #EEE;border-radius: 10px">
                                            <p style="text-align: center">دو رو</p>
                                        </div>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="" style="font-weight: bold;font-size:15px;margin-top:10px">تعداد سری:</label>
                            <input type="number" name="qty" id="qty" min="1" value="1" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                        <div class="files" style="margin-top: 1rem;">
                            @if(!$product->typeRelatedFile)
                                <div class='col-md-6'><label for="front-file"
                                                             style="font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%;    cursor: pointer;">آپلود
                                        فایل
                                        ارسالی</label><input type='file' id="front-file"
                                                             style="display: none;"
                                                             name='front-file'/></div>

                            @endif
                        </div>
                        <div class="col-md-12">
                            <label for="" v="service" style="font-weight: bold;font-size:15px;margin-top:10px">خدمات
                                اضافی</label>
                            <div>
                                <input type="radio" style="display: none" val="service"
                                       id="service-0"
                                       name="service"
                                       value="">
                                <label for="service-0" class="col-md-3" style="padding: 0 5px">
                                    <div style="padding: 0.5rem;background: #EEE;border-radius: 10px">
                                        <p style="text-align: center">ندارد</p>
                                    </div>
                                </label>
                            </div>
                            @foreach($product->services as $service)
                                <div>
                                    <input type="radio" style="display: none" val="service"
                                           id="service-{{ $service->id }}"
                                           name="service"
                                           value="{{ $service->id }}">
                                    <label for="service-{{ $service->id }}" class="col-md-3" style="padding: 0 5px">
                                        <div style="padding: 0.5rem;background: #EEE;border-radius: 10px">
                                            <p style="text-align: center">{{ $service->name }}</p>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="col-md-4">
                        <h4 style="margin-bottom: 10px;font-weight: bold;font-size:15px">قیمت : </h4>
                        <div style="background: #111;padding: 10px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">

                            <h5 style="color:#FFF;text-align: center"><span
                                        id="finalPrice">{{ ta_persian_num("0") }} ریال</span></h5>
                        </div>
                        <h4 style="margin-bottom: 10px;margin-top: 10px;font-weight: bold;font-size:15px">
                            مشخصات سفارش :</h4>
                        <div class="orderSpecification"
                             style="border:1px solid #CCC;border-radius: 5px; padding: 10px 2rem;">
                            <ul>

                            </ul>
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="" style="width: 100%;" alt="" id="frontPic">
                                </div>
                                <div class="col-md-6">
                                    <img src="" style="width: 100%;" alt="" id="backPic">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                    <div class="col-xs-4" style="margin-top: 1rem;float:left">
                        @if($product->typeRelatedFile)
                            <button id="sendOrder" class="btn btn-danger"
                                    style="display: none;    width: 100% !important;
    position: relative;
    bottom: 60px;
    padding: 0.8rem 0;
    font-weight: bold;
    border-radius: 10px;">ثبت سفارش
                            </button>
                        @elseif(!$product->typeRelatedFile or  $product->type=='double' or  $product->type=='single')
                            <button id="sendOrder" class="btn btn-danger" style="    width: 100% !important;
    position: relative;
    bottom: 60px;
    padding: 0.8rem 0;
    font-weight: bold;
    border-radius: 10px;">ثبت
                                سفارش
                            </button>
                        @endif
                    </div>
                </div>
            </form>

        </div>
    </div>
    @foreach($properties as $property)
        <div id="pro-{{ $property->id }}" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p style="text-align: justify">{!! nl2br($property->description) !!}</p>
                    </div>

                </div>

            </div>
        </div>
    @endforeach
@endsection

@section('extraScripts')
    <script>
        var pageCount = 0;
        const product ={{ $product->id }};
        var data = {};
        var type = "";
        $("input[type=radio]").change(function (e) {
            const id = $(this).attr('val');
            if ($(this).attr('name') !== 'type')
                data[$(this).attr('name')] = $(this).val();
            else
                type = $(this).val()
            if ($(`li[v=${id}]`).length) {
                $(`li[v=${id}]`).text($(`label[v=${id}]`).text() + " : " + $(this).parent().children('label').text())
            } else {
                $(".orderSpecification ul").append(`<li v='${id}'>` + $(`label[v=${id}]`).text() + " : " + $(this).parent().children('label').text() + `</li>`)
            }
            if (pageCount)
                $.ajax({
                    type: "post",
                    url: "{{ route("fetchOrderPrice") }}",
                    data: {
                        pageCount: pageCount,
                        qty: $("input[name=qty]").val(),
                        product: product,
                        data: data,
                        type: type
                    },
                    success: function (response) {
                        $("#finalPrice").text(response);
                    }
                })
        });

        $("select").change(function (e) {
            const id = $(this).attr('val');
            if ($(`li[v=${id}]`).length) {
                $(`li[v=${id}]`).text($(`label[v=${id}]`).text() + " : " + $(this).parent().children('label').text())
            } else {
                $(".orderSpecification ul").append(`<li v='${id}'>` + $(`label[v=${id}]`).text() + " : " + $(this).find("option:selected").text() + `</li>`)
            }
        });
        $("input[name=qty]").change(function () {
            type =
            if (pageCount)
                $.ajax({
                    type: "post",
                    url: "{{ route("fetchOrderPrice") }}",
                    data: {
                        pageCount: pageCount,
                        qty: $("input[name=qty]").val(),
                        product: product,
                        data: data,
                        type: type
                    },
                    success: function (response) {
                        $("#finalPrice").text(response);
                    }
                })
        });
        $("input[name=type]").change(function () {
            if ($(this).val() == "single") {
                type = "single";
            } else if ($(this).val() == 'double') {
                type = "double";
            }
        })
        @if($product->typeRelatedFile)
        $("input[name=type]").change(function () {
            $("#frontPic").attr('src', '');
            $("#backPic").attr('src', '');
            if ($(this).val() == "single") {
                type = "single";
                $("#sendOrder").show();
                $(".files").html("<div class='col-md-6'><label for='front-file' style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل رو</label><input type='file' name='front-file' id='front-file'  style='display: none'/></div><div class='clearfix' />");
            } else if ($(this).val() == 'double') {
                type = "double";
                $("#sendOrder").show();
                $(".files").html("<div class='col-md-6'><label for='front-file' style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل رو</label><input type='file' name='front-file' id='front-file'  style='display: none' /></div><div class='col-md-6'><label for='back-file'  style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل پشت</label><input type='file' name='back-file' id='back-file' style='display: none' /></div><div class='clearfix' />");
            } else {
                $("#sendOrder").hide();
            }
        });
        @endif
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("body").on('change', "input[name='front-file']", function () {
            readFrontURL(this);
        });
        $("body").on('change', "input[name='back-file']", function () {
            readBackURL(this);
        });
        $("body").on('change', "input[name='front-file'],input[name='back-file']", function (e) {
            var formData = new FormData();

            formData.append('product', product);
            formData.append('front-file', $("input[name='front-file']")[0].files[0]);
            if ($("input[name='back-file']").length)
                formData.append('back-file', $("input[name='back-file']")[0].files[0]);
            swal({
                title: '',
                html: "<center><img src='/images/loading.gif' /><p>در حال اپلود فایل لطفا شکیبا باشید ...</p><br /><div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:0%'>0%</div></div></center>",
                confirmButtonText: "باشه",
                allowOutsideClick: false
            });
            swal.disableButtons();
            $.ajax({
                url: '{{ route('checkFiles') }}',
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', progress, false);
                    }
                    return myXhr;
                },
                success: function (response) {
                    swal.close();
                    pageCount = response;
                    if ($("li[v=file]").length) {
                        $("li[v=file]").text("تعداد صفحات :" + response)
                    } else {
                        $(".orderSpecification ul").append(`<li v='file'>تعداد صفحات : ${response}</li>`)
                    }
                    $.ajax({
                        type: "post",
                        url: "{{ route("fetchOrderPrice") }}",
                        data: {
                            pageCount: pageCount,
                            qty: $("input[name=qty]").val(),
                            product: product,
                            data: data,
                            type: type
                        },
                        success: function (response) {
                            $("#finalPrice").text(response);
                        }
                    })

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.close();

                }
            })
        });

        function readFrontURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    const splitedFile = input.files[0].name.split('.');
                    if (splitedFile[(splitedFile.length) - 1] === 'jpeg' || splitedFile[splitedFile.length - 1] === 'jpg') {
                        $('#frontPic').attr('src', e.target.result).addClass('img-thumbnail');
                    } else {
                        $('#frontPic').attr('src', '/clientAssets/img/icons8-pdf-128.png').addClass('img-thumbnail');
                    }

                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        function readBackURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    const splitedFile = input.files[0].name.split('.');
                    if (splitedFile[(splitedFile.length) - 1] === 'jpeg' || splitedFile[splitedFile.length - 1] === 'jpg') {
                        $('#backPic').attr('src', e.target.result).addClass('img-thumbnail');
                    } else {
                        $('#backPic').attr('src', '/clientAssets/img/icons8-pdf-128.png').addClass('img-thumbnail');
                    }

                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        function progress(e) {

            if (e.lengthComputable) {
                var max = e.total;
                var current = e.loaded;

                var Percentage = (current * 100) / max;
                console.log(Percentage);
                var percentVal = Percentage + '%';
                $(".progress-bar-striped").attr('aria-valuenow', Percentage);
                $(".progress-bar-striped").text(percentVal);
                $(".progress-bar-striped").css('width', percentVal);


                if (Percentage >= 100) {
                    // process completed
                }
            }
        }
    </script>
@endsection