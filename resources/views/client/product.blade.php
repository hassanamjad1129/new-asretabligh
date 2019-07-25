@extends('client.layout.master')
@section('title') ثبت سفارش {{ $product->title }}@endsection
@section('content')
    <style>
        input[type="radio"] + label > div, input[type="checkbox"] + label > div {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        input[type="radio"]:checked + label > div, input[type="checkbox"]:checked + label > div {
            background-color: #777 !important;
        }

        input[type="radio"]:checked + label > div > p, input[type="checkbox"]:checked + label > div > p {
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
        <form action="{{ route('storeCart') }}" id="orderForm" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product" value="{{$product->id}}">
            <div style="padding: 1rem;background: #FFF;box-shadow: 0 0 10px #BBB;overflow: hidden;">
                <div class="col-md-9">
                    <div class="panel panel-default" style="border-radius: 1rem;">
                        <div class="panel-heading"
                             style="background: #444;border-radius: 1rem;border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                            <h3 style="padding:0.3rem 0;font-size: 1.3rem;color: #FFF;text-align: center"><i
                                        class="fa fa-shopping-bag"></i> ثبت سفارش
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <label for="" style="font-weight: bold;font-size:15px;margin-top:10px">عنوان
                                    سفارش</label>
                                <input type="text" class="form-control" name="title">
                                <label v="paper" for=""
                                       style="font-weight: bold;font-size:15px;margin-top:10px">سایز فایل
                                </label>
                                <div class="clearfix"></div>
                                @foreach($papers as $paper)
                                    <div>
                                        <input type="radio" style="display: none" val="paper"
                                               id="paper-{{ $paper->id }}"
                                               name="paper"
                                               value="{{ $paper->id }}">
                                        <label for="paper-{{ $paper->id }}" class="col-md-3" style="padding: 0 5px">
                                            <div style="padding: 0.5rem;background: #EEE;border-radius: 10px">
                                                <p style="text-align: center">{{ $paper->name }}</p>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach

                            </div>

                            <div class="clearfix"></div>
                            @foreach($properties as $index=>$property)
                                <div class="col-md-12">
                                    <label v="p-{{ $property->id }}" for=""
                                           style="font-weight: bold;font-size:15px;margin-top:10px">{{ $property->name }}
                                        <i
                                                class="fa fa-info-circle" data-toggle="modal"
                                                data-target="#pro-{{$property->id}}"
                                                style="cursor: pointer;"></i></label>
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
                                        <input name="type" style="display: none" id="type-2" type="radio"
                                               val="typeOrder"
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
                                <label for="" style="font-weight: bold;font-size:15px;margin-top:10px">تعداد
                                    سری:</label>
                                <input type="number" name="qty" id="qty" min="1" value="1" class="form-control">
                            </div>
                            <div class="clearfix"></div>
                            <div class="files" style="margin-top: 1rem;display: flex;justify-content: center">
                                @if(!$product->typeRelatedFile)
                                    <div class='col-md-6'><label for="front-file"
                                                                 style="font-weight: bold;font-size:15px;margin-top:10px;background:#e52531;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%;    cursor: pointer;
    border-top-left-radius: 0;
    border-top-right-radius: 0;">آپلود
                                            فایل
                                            ارسالی</label><input type='file' id="front-file"
                                                                 style="display: none;"
                                                                 name='front-file'/></div>

                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default" style="border-radius: 1rem;">
                        <div class="panel-heading"
                             style="background: #444;border-radius: 1rem;border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                            <h3 style="padding:0.3rem 0;font-size: 1.3rem;color: #FFF;text-align: center"> خدمات
                                پس از چاپ</h3>

                        </div>
                        <div class="panel-body">
                            <div>
                                <input type="checkbox" style="display: none" val="service"
                                       id="service-0"
                                       name="service[]"
                                       value="none">
                                <label for="service-0" class="col-md-3" style="padding: 0 5px">
                                    <div style="padding: 0.5rem;background: #EEE;border-radius: 10px">
                                        <p style="text-align: center">ندارد</p>
                                    </div>
                                </label>
                            </div>
                            <div id="mainServices">

                            </div>
                            <div id="services"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default"
                         style="border-radius: 1rem;    background-image: linear-gradient(#BFBFBF, #FFF);">
                        <div class="panel-heading"
                             style="background: #444;border-radius: 1rem;border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                            <h3 style="padding:0.3rem 0;font-size: 1.3rem;color: #FFF;text-align: center">مشخصات سفارش
                                شما
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div style="display: flex;
    -webkit-box-flex: a;
    align-items: center;
    align-content: center;
    justify-content: center;">
                                <h4 style="    margin-bottom: 10px;
    font-weight: bold;
    font-size: 15px;
    border-bottom: 1px solid #222;
    padding-bottom: 5px;
    text-align: center;">{{ $product->title }}</h4>
                            </div>
                            <div class="orderSpecification"
                                 style="border-radius: 5px; padding: 10px 1rem;">
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
                            <div style="display: flex;justify-content: space-between">
                                <h4 style="margin-bottom: 10px;font-weight: bold;font-size:15px;display: inline">جمع
                                    سفارش
                                    : </h4>
                                <span id="finalPrice">{{ ta_persian_num("0") }} ریال</span>
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
    bottom: 0px;
    padding: 0.8rem 0;
    font-weight: bold;
    border-radius: 10px;">ثبت سفارش
                        </button>
                    @elseif(!$product->typeRelatedFile or  $product->type=='double' or  $product->type=='single')
                        <button id="sendOrder" class="btn btn-danger" style="    width: 100% !important;
    position: relative;
    bottom: 0px;
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
        function countProperties(obj) {
            var count = 0;

            for (var property in obj) {
                if (Object.prototype.hasOwnProperty.call(obj, property)) {
                    count++;
                }
            }

            return count;
        }

        var pageCount = 0;
        const product ={{ $product->id }};
        var data = {};
        var service = {};
        var serviceFiles = {};

                @if($product->type=='single')
        var type = "single";
                @elseif($product->type=='double')
        var type = "double";
                @else
        var type = "";
                @endif
        var paper = "";
        var services = [];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#orderForm").submit(function (e) {
            $("#orderForm input[type=file]").each(function () {
                if ($(this).get(0).files.length === 0) {
                    console.log($(this));
                    e.preventDefault();
                    swal({
                        title: 'خطا!',
                        text: "تمامی فایل های خواسته شده را آپلود کنید",
                        type: 'error',
                        confirmButtonText: 'متوجه شدم'
                    })
                }
            })
        });

        $("body").on("change", "input[type=radio]", function (e) {
            const id = $(this).attr('val');

            if ($(this).attr('name') !== 'type' && $(this).attr('name') !== 'service' && $(this).attr('name') !== 'paper' && !$(this).hasClass('service-type') && !$(this).hasClass("service"))
                data[$(this).attr('name')] = $(this).val();
            else if ($(this).attr('name') === 'type')
                type = $(this).val();
            else if ($(this).hasClass("service"))
                service[$(this).attr('name')] = $(this).val();
            else if ($(this).attr('name') === 'paper')
                paper = $(this).val();

            if ($(`li[v=${id}]`).length) {
                $(`li[v=${id}]`).text($(`label[v=${id}]`).text() + " : " + $(this).parent().children('label').text())
            } else {
                if ($(this).hasClass("service") || $(this).hasClass('service-type')) {
                    const service = $(this).attr('service');
                    $(".orderSpecification ul").append(`<li class='serviceList' service='${service}'  v='${id}'>` + $(`label[v=${id}]`).text() + " : " + $(this).parent().children('label').text() + `</li>`)
                } else
                    $(".orderSpecification ul").append(`<li v='${id}'>` + $(`label[v=${id}]`).text() + " : " + $(this).parent().children('label').text() + `</li>`)

            }
            services = []
            $.each($("input[name='service[]']:checked"), function () {
                services.push($(this).val());
            });
            if (pageCount && !countProperties(service))
                $.ajax({
                    type: "post",
                    url: "{{ route("fetchOrderPrice") }}",
                    data: {
                        pageCount: pageCount,
                        qty: $("input[name=qty]").val(),
                        product: product,
                        data: data,
                        paper: paper,
                        type: type,
                    },
                    success: function (response) {
                        $("#finalPrice").text(response);
                    }
                })
            else if (pageCount && countProperties(service) && !$(this).hasClass('service-type')) {
                services = []
                $.each($("input[name='service[]']:checked"), function () {
                    services.push($(this).val());
                });
                $.ajax({
                    type: "post",
                    url: "{{ route("fetchServicePrice") }}",
                    data: {
                        pageCount: pageCount,
                        qty: $("input[name=qty]").val(),
                        product: product,
                        data: data,
                        paper: paper,
                        type: type,
                        service: service,
                        services: services,
                        serviceFiles: serviceFiles

                    },
                    success: function (response) {
                        $("#finalPrice").text(response);
                    }
                })
            }
        });

        $("select").change(function (e) {
            const id = $(this).attr('val');
            if ($(`li[v=${id}]`).length) {
                $(`li[v=${id}]`).text($(`label[v=${id}]`).text() + " : " + $(this).parent().children('label').text())
            } else {
                $(".orderSpecification ul").append(`<li v='${id}'>` + $(`label[v=${id}]`).text() + " : " + $(this).find("option:selected").text() + `</li>`)
            }
        });

        $("input[name=paper]").change(function () {

            $.ajax({
                type: "post",
                url: "{{ route('fetchPaperServices') }}",
                data: {
                    paper: $(this).val(),
                    product:{{ $product->id }}
                },
                success: function (response) {
                    $("#services").html("");
                    if (pageCount)
                        $.ajax({
                            type: "post",
                            url: "{{ route("fetchOrderPrice") }}",
                            data: {
                                pageCount: pageCount,
                                qty: $("input[name=qty]").val(),
                                product: product,
                                data: data,
                                paper: paper,
                                type: type,
                            },
                            success: function (response) {
                                $("#finalPrice").text(response);
                            }
                        })

                    $("#serviceWrapper").show();
                    $("#mainServices").html("");
                    response = JSON.parse(response);
                    for (var item in response) {
                        $("#mainServices").append("    <div>\n" +
                            "<input type=\"checkbox\" allow_type='" + response[item]['allow_type'] + "' style=\"display: none\" val=\"service\"\n" +
                            "id=\"service-" + response[item].id + "\"\n" +
                            "name=\"service[]\"\n" +
                            "value=\"" + response[item].id + "\">\n" +
                            "<label for=\"service-" + response[item].id + "\" class=\"col-md-3\" style=\"padding: 0 5px\">\n" +
                            "<div style=\"padding: 0.5rem;background: #EEE;border-radius: 10px\">\n" +
                            "<p style=\"text-align: center\">" + response[item].name + "</p>\n" +
                            "</div>\n" +
                            "</label>\n" +
                            "</div>\n")
                    }
                }
            });
        });

        $("body").on('click', "input[name='service[]']", function (el) {
            if ($(el.target).is(":not(:checked)")) {
                console.log($("li[service=" + $(el.target).val() + "]"));
                $("li[service=" + $(el.target).val() + "]").remove();
                $(".service-" + $(el.target).val()).remove();
            } else {
                if ($(el.target).val() === 'none') {
                    services = [];
                    service = {};
                    $("li[class='serviceList']").remove();
                    $("div[class^='service-']").remove();
                    $("input[name='service[]']").prop('checked', false);
                    if (pageCount)
                        $.ajax({
                            type: "post",
                            url: "{{ route("fetchOrderPrice") }}",
                            data: {
                                pageCount: pageCount,
                                qty: $("input[name=qty]").val(),
                                product: product,
                                data: data,
                                paper: paper,
                                type: type,
                            },
                            success: function (response) {
                                $("#finalPrice").text(response);
                            }
                        })

                } else {
                    $.ajax({
                        type: "post",
                        url: "{{ route('fetchServiceProperties') }}",
                        data: {
                            service: $(el.target).val()
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            var str = "<div class='service-" + $(el.target).val() + "'>";
                            var thisService = "";
                            for (var service in response) {
                                service = response[service];
                                thisService = $(el.target).val();
                                str += "<div class=\"col-md-12\">\n" +
                                    "<label v=\"s-" + service['id'] + "\" for=\"\"\n" +
                                    "style=\"font-weight: bold;font-size:15px;margin-top:10px\">" + service['name'] + "\n" +
                                    "</label>\n" +
                                    "<div class=\"clearfix\"></div>\n";
                                for (var value in service['values']) {
                                    value = service['values'][value];
                                    str += ("" +
                                        "<div>\n" +
                                        "<input type=\"radio\" style=\"display: none\" service='" + thisService + "' val=\"s-" + service['id'] + "\"\n" +
                                        "id=\"s-" + value['id'] + "\"\n" +
                                        "name=\"service-" + service['id'] + "\" class='service' \n" +
                                        "value=\"" + value['id'] + "\">\n" +
                                        "<label for=\"s-" + value['id'] + "\" class=\"col-md-3\" style=\"padding: 0 5px\">\n" +
                                        "<div style=\"padding: 0.5rem;background: #EEE;border-radius: 10px\">\n" +
                                        (value['picture'] ?
                                            "<img src=\"/getServicePicture/" + value['id'] + "\" style=\"width: 100%\"\n" +
                                            "alt=\"\">\n" + "\n" : "") +
                                        "<p style=\"text-align: center\">" + value['name'] + "</p>\n" +
                                        "</div>\n" +
                                        "</label>\n" +
                                        "</div>\n"
                                    );

                                }
                                str += "</div>\n" + "<div class=\"clearfix\"></div>\n";


                            }
                            if ($(el.target).attr('allow_type') == 1) {
                                str += "<div class=\"col-md-6\">\n" +
                                    "<label v=\"typeService" + "\" for=\"\"\n" +
                                    "style=\"font-weight: bold;font-size:15px;margin-top:10px\"> نوع کار خدمات \n" +
                                    "</label>\n" +
                                    "<div class=\"clearfix\"></div>\n"
                                str += "    <div>\n" +
                                    "<input class='service-type' name=\"service-type-" + thisService + "\" serviceID='" + thisService + "'  style=\"display: none\" id=\"service-type-1\"\n" +
                                    "type=\"radio\" service='" + thisService + "' val=\"typeService\"\n" +
                                    "value=\"single\"/>\n" +
                                    "<label for=\"service-type-1\" class=\"col-md-6\" style=\"padding: 0 5px\">\n" +
                                    "<div style=\"padding: 0.5rem;background: #EEE;border-radius: 10px\">\n" +
                                    "<p style=\"text-align: center\">یک رو</p>\n" +
                                    "</div>\n" +
                                    "</label>\n" +
                                    "</div>";
                                str += "<div>\n" +
                                    "<input class='service-type' service='" + thisService + "' name=\"service-type-" + thisService + "\" serviceID='" + thisService + "'  style=\"display: none\" id=\"service-type-2\" type=\"radio\" val=\"typeService\"\n" +
                                    "\n" +
                                    "value=\"double\"/>\n" +
                                    "<label for=\"service-type-2\" class=\"col-md-6\" style=\"padding: 0 5px\">\n" +
                                    "<div style=\"padding: 0.5rem;background: #EEE;border-radius: 10px\">\n" +
                                    "<p style=\"text-align: center\">دو رو</p>\n" +
                                    "</div>\n" +
                                    "</label>\n" +
                                    "</div></div><div class='clearfix'></div><div class='row' id='service-file-" + thisService + "'></div>";

                                /*
                                str += "<div class=\"col-md-12\">\n" +
                                    "<label v=\"sf-" + 1 + "\" for=\"\"\n" +
                                    "style=\"font-weight: bold;font-size:15px;margin-top:10px\"> آپلود فایل \n" +
                                    "</label>\n" +
                                    "<div class=\"clearfix\"></div>\n";
                                str += "<div class='col-md-6' style='padding-right:0'><label for='front-file' style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل رو</label><input type='file' name='front-file' id='front-file'  style='display: none' /></div><div class='col-md-6'><label for='back-file'  style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل پشت</label><input type='file' name='back-file' id='back-file' style='display: none' /></div><div class='clearfix' />";
                                */

                            }
                            $("#services").append(str + "<hr></div>");
                        }
                    });
                }
            }

        })
        ;
        $("input[name=qty]").change(function () {
            if (pageCount && countProperties(service) == 0)
                $.ajax({
                    type: "post",
                    url: "{{ route("fetchOrderPrice") }}",
                    data: {
                        pageCount: pageCount,
                        qty: $("input[name=qty]").val(),
                        product: product,
                        data: data,
                        paper: paper,

                        type: type
                    },
                    success: function (response) {
                        $("#finalPrice").text(response);
                    }
                })
            else if (pageCount && countProperties(service)) {
                services = []
                $.each($("input[name='service[]']:checked"), function () {
                    services.push($(this).val());
                });
                $.ajax({
                    type: "post",
                    url: "{{ route("fetchServicePrice") }}",
                    data: {
                        pageCount: pageCount,
                        qty: $("input[name=qty]").val(),
                        product: product,
                        data: data,
                        paper: paper,
                        type: type,
                        service: service,
                        services: services,
                        serviceFiles: serviceFiles
                    },
                    success: function (response) {
                        $("#finalPrice").text(response);
                    }
                })
            }
        });
        $("input[name=type]").change(function () {
            if ($(this).val() == "single") {
                type = "single";
            } else {
                type = "double";
            }
        });
        @if($product->typeRelatedFile)
        $("input[name=type]").change(function () {
            $("#frontPic").attr('src', '');
            $("#backPic").attr('src', '');
            if ($(this).val() == "single") {
                type = "single";
                $("#sendOrder").show();
                $(".files").html("<div class='col-md-4'><label for='front-file' style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#e52531;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%;\n" +
                    "    border-top-left-radius: 0;\n" +
                    "    border-top-right-radius: 0;\">آپلود فایل رو</label><input type='file' name='front-file' id='front-file'  style='display: none'/></div><div class='clearfix' />");
            } else if ($(this).val() == 'double') {
                type = "double";
                $("#sendOrder").show();
                $(".files").html("<div class='col-md-4'><label for='front-file' style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#e52531;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%;\n" +
                    "    border-top-left-radius: 0;\n" +
                    "    border-top-right-radius: 0;\">آپلود فایل رو</label><input type='file' name='front-file' id='front-file'  style='display: none' /></div><div class='col-md-4'><label for='back-file'  style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#e52531;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%;\n" +
                    "    border-top-left-radius: 0;\n" +
                    "    border-top-right-radius: 0;\">آپلود فایل پشت</label><input type='file' name='back-file' id='back-file' style='display: none' /></div><div class='clearfix' />");
            } else {
                $("#sendOrder").hide();
            }
        });
        @endif

        $("body").on('change', ".service-type", function () {
            $("#serviceFrontPic").attr('src', '');
            $("#serviceBackPic").attr('src', '');
            const serviceID = $(this).attr('serviceID');
            if ($(this).val() === "single") {
                serviceFiles[serviceID] = "single";
                serviceType = "single";
                $("#service-file-" + serviceID).html("<div class='col-md-6'><label for='service-front-file-" + serviceID + "' style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل رو</label><input type='file' name='service-front-file-" + serviceID + "' id='service-front-file-" + serviceID + "'  style='display: none'/></div><div class='clearfix' />");
            } else if ($(this).val() === 'double') {
                serviceFiles[serviceID] = "double";
                serviceType = "double";
                $("#service-file-" + serviceID).html("<div class='col-md-6'><label for='service-front-file-" + serviceID + "' style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل رو</label><input type='file' name='service-front-file-" + serviceID + "' id='service-front-file-" + serviceID + "'  style='display: none' /></div><div class='col-md-6'><label for='service-back-file-" + serviceID + "'  style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل پشت</label><input type='file' name='service-back-file-" + serviceID + "' id='service-back-file-" + serviceID + "' style='display: none' /></div><div class='clearfix' />");

            }

            services = []
            $.each($("input[name='service[]']:checked"), function () {
                services.push($(this).val());
            });
            $.ajax({
                type: "post",
                url: "{{ route("fetchServicePrice") }}",
                data: {
                    pageCount: pageCount,
                    qty: $("input[name=qty]").val(),
                    product: product,
                    data: data,
                    paper: paper,
                    type: type,
                    service: service,
                    services: services,
                    serviceFiles: serviceFiles

                },
                success: function (response) {
                    $("#finalPrice").text(response);
                }
            })
        });

        $("body").on('change', "input[name='front-file']", function () {
            readFrontURL(this);
        });
        $("body").on('change', "input[name='back-file']", function () {
            readBackURL(this);
        });
        $("body").on('change', "input[name='service-front-file']", function () {
            readFront2URL(this);
        });
        $("body").on('change', "input[name='service-back-file']", function () {
            readBack2URL(this);
        });
        $("body").on('change', "input[name='service-front-file'],input[name='service-back-file']", function (e) {
            var formData = new FormData();

            formData.append('product', product);
            formData.append('service-front-file', $("input[name='service-front-file']")[0].files[0]);
            if ($("input[name='service-back-file']").length)
                formData.append('service-back-file', $("input[name='service-back-file']")[0].files[0]);

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
                    if (pageCount && countProperties(service) == 0)
                        $.ajax({
                            type: "post",
                            url: "{{ route("fetchOrderPrice") }}",
                            data: {
                                pageCount: pageCount,
                                qty: $("input[name=qty]").val(),
                                product: product,
                                paper: paper,
                                data: data,
                                type: type
                            },
                            success: function (response) {
                                $("#finalPrice").text(response);
                            }
                        })
                    else if (pageCount && countProperties(service)) {
                        services = []
                        $.each($("input[name='service[]']:checked"), function () {
                            services.push($(this).val());
                        });
                        $.ajax({
                            type: "post",
                            url: "{{ route("fetchServicePrice") }}",
                            data: {
                                pageCount: pageCount,
                                qty: $("input[name=qty]").val(),
                                product: product,
                                data: data,
                                paper: paper,
                                type: type,
                                service: service,
                                services: services,
                                serviceFiles: serviceFiles

                            },
                            success: function (response) {
                                $("#finalPrice").text(response);
                            }
                        })
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.close();
                }

            });
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


        function readFront2URL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    const splitedFile = input.files[0].name.split('.');
                    if (splitedFile[(splitedFile.length) - 1] === 'jpeg' || splitedFile[splitedFile.length - 1] === 'jpg') {
                        $('#serviceFrontPic').attr('src', e.target.result).addClass('img-thumbnail');
                    } else {
                        $('#serviceFrontPic').attr('src', '/clientAssets/img/icons8-pdf-128.png').addClass('img-thumbnail');
                    }

                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        function readBack2URL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    const splitedFile = input.files[0].name.split('.');
                    if (splitedFile[(splitedFile.length) - 1] === 'jpeg' || splitedFile[splitedFile.length - 1] === 'jpg') {
                        $('#serviceBackPic').attr('src', e.target.result).addClass('img-thumbnail');
                    } else {
                        $('#serviceBackPic').attr('src', '/clientAssets/img/icons8-pdf-128.png').addClass('img-thumbnail');
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
                var percentVal = parseInt(Percentage) + '%';
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