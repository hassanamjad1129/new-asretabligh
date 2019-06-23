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
            <div style="padding: 1rem;background: #FFF;box-shadow: 0 0 10px #BBB;overflow: hidden;">
                <div class="col-md-8">
                    <h3 style="margin-bottom: 2rem;font-weight: bold;"><i class="fa fa-shopping-bag"></i> ثبت سفارش</h3>
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
                                                <img src="{{ route('getValuePicture',[$value]) }}" style="width: 100%"
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
                                    ارسالی</label><input type='file' id="front-file" style="display: none;"
                                                         name='front-file'/></div>

                        @endif
                    </div>

                </div>
                <div class="col-md-4">
                    <h4 style="margin-bottom: 10px;font-weight: bold;font-size:15px">قیمت : </h4>
                    <div style="background: #111;padding: 10px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">

                        <h5 style="color:#FFF;text-align: center"><span>{{ ta_persian_num("0") }} ریال</span></h5>
                    </div>
                    <h4 style="margin-bottom: 10px;margin-top: 10px;font-weight: bold;font-size:15px">
                        مشخصات سفارش :</h4>
                    <div class="orderSpecification"
                         style="border:1px solid #CCC;border-radius: 5px; padding: 10px 2rem;">
                        <ul>

                        </ul>
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
        $("input[type=radio]").change(function (e) {
            const id = $(this).attr('val');
            if ($(`li[v=${id}]`).length) {
                $(`li[v=${id}]`).text($(`label[v=${id}]`).text() + " : " + $(this).parent().children('label').text())
            } else {
                $(".orderSpecification ul").append(`<li v='${id}'>` + $(`label[v=${id}]`).text() + " : " + $(this).parent().children('label').text() + `</li>`)
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
        @if($product->typeRelatedFile)
        $("input[name=type]").change(function () {
            if ($(this).val() == "single") {
                $("#sendOrder").show();
                $(".files").html("<div class='col-md-6'><label for='front-file' style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل رو</label><input type='file' name='front-file' id='front-file'  style='display: none'/></div><div class='clearfix' />");
            } else if ($(this).val() == 'double') {
                $("#sendOrder").show();
                $(".files").html("<div class='col-md-6'><label for='front-file' style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل رو</label><input type='file' name='front-file' id='front-file'  style='display: none' /></div><div class='col-md-6'><label for='back-file'  style=\"    cursor: pointer;font-weight: bold;font-size:15px;margin-top:10px;background:#676767;padding:0.8rem 2rem;text-align: center;color:#FFF;border-radius: 10px;width: 100%\">آپلود فایل پشت</label><input type='file' name='back-file' id='back-file' style='display: none' /></div><div class='clearfix' />");
            } else {
                $("#sendOrder").hide();
            }
        });
        @endif
    </script>
@endsection