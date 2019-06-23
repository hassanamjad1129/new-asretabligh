@extends('admin.layout.master')
@section('extraStyles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('extraScripts')
    <script src="/js/jQuery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script>
        var i = 2;

        function getInformation() {
            var selectedOption = $("#info").val();
            if (selectedOption == 1) {
                $("#selectAble").hide();
            } else {
                $("#selectAble").show();
            }
        }

        function removeElement(x) {
            $("#answer_" + x).remove();
            $("#picture_" + x).remove();
            $("#button_" + x).remove();
            $("#neverMind_" + x).remove();
        }


        function addAnswer() {
            $("#answer").append("<div class=\"clearfix\"></div>\n" +
                "                                <div class=\"col-md-6\">\n" +
                "                                    <input type=\"text\" name=\"answer[]\" id=\"answer_" + i + "\" class=\"form-control\"\n" +
                "                                           style=\"margin-top: 1.7rem !important;\"/>\n" +
                "                                </div>\n" +
                "                                <div class=\"col-md-3\">\n" +
                "                                    <button type=\"button\" class=\"btn btn-sm tag tag-primary\" id=\"neverMind_" + i + "\">تصویر اختیاری</button>\n" +
                "                                    <input type=\"file\" name=\"picture[]\" id=\"picture_" + i + "\" class=\"form-control\" accept=\"image/*\"/>\n" +
                "                                </div>\n" +
                "                                <div class=\"col-md-3\">\n" +
                "                                    <button type=\"button\" class=\"btn btn-sm btn-danger\" id=\"button_" + i + "\" style=\"margin-top: 1.7rem !important;\" onclick=\"+removeElement(" + i + ")\"><span class=\"icon-trash\"></span></button>\n" +
                "                               </div>");
            i = i + 1;
        }
    </script>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            ایجاد مشخصات محصول
        </div>
        <div class="card-block">
            <form action="{{ route('admin.productProperties.store',[$product]) }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                <div class="col-md-6">
                    <label for="">عنوان مشخصه</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')?old('name'):''}}"/>
                </div>
                <div class="col-md-6">
                    <label for="">نوع مشخصه</label>
                    <select class="form-control" name="type" style="padding: 0.1rem"
                            id="info" onchange="getInformation()">
                        <option value="1">توضیح</option>
                        <option value="2" selected>تک انتخابی</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for=""> توضیحات مشخصه</label>
                    <input type="text" name="description" class="form-control"
                           value="{{old('description')?old('description'):''}}"/>
                </div>
                <div id="selectAble">
                    <div class="col-md-12">
                        <label for="">پاسخ های مشخصه</label>
                        <div id="answer">
                            <?php $i = 1;?>
                            @if(old('answer'))
                                @foreach(old('answer') as $key=>$item)
                                    <div class="clearfix"></div>
                                    <div class="col-md-6">
                                        <input type="text" name="answer[]" id="answer_{{$key}}" class="form-control"
                                               value="{{$item}}" style="margin-top: 1.7rem !important;"/>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-sm tag tag-primary"
                                                id="neverMind_{{$key}}">تصویر اختیاری
                                        </button>
                                        <input type="file" name="picture[]" id="picture_{{$key}}" class="form-control"
                                               accept="image/*"/>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-sm btn-danger" id="button_{{$key}}"
                                                style="margin-top: 1.7rem !important;"
                                                onclick="removeElement({{$key}})"><span
                                                    class="icon-trash"></span></button>
                                    </div>
                                @endforeach

                            @else
                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <input type="text" name="answer[]" id="answer_{{$i}}" class="form-control"
                                           style="margin-top: 1.7rem !important;"/>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-sm tag tag-primary" id="neverMind_{{$i}}">تصویر
                                        اختیاری
                                    </button>
                                    <input type="file" name="picture[]" id="picture_{{$i}}" class="form-control"
                                           accept="image/*"/>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-sm btn-danger" id="button_{{$i}}"
                                            style="margin-top: 1.7rem !important;" onclick="removeElement({{$i}})"><span
                                                class="icon-trash"></span></button>

                                </div>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        <div style="margin-top: 1.5rem !important;">
                            <button type="button" class="btn btn-info" onclick="addAnswer()">افزودن پاسخ مشخصه
                            </button>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6" style="margin-top: 1.5rem">
                        <label for="">وابستگی</label>
                        <button type="button" class="btn btn-sm tag tag-primary">اختیاری</button>
                        <select class="js-example-basic-single form-control" name="dependency">
                            <option value="0" selected>مشخصات وابستگی را وارد کنید</option>
                            @foreach($productProperties as  $productProperty)
                                @foreach($productProperty->ProductValues()->get() as $productAnswer)
                                    <option value="{{$productAnswer->id}}">{{$productProperty->name}}
                                        - {{$productAnswer->name}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top: 1.5rem">
                    <button type="submit" class="btn btn-success">ثبت مشخصات</button>
                </div>
            </form>
        </div>
    </div>
@endsection