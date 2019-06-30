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

        function removeElement(x) {
            $("#answer_" + x).remove();
            $("#picture_" + x).remove();
            $("#button_" + x).remove();
            $("#neverMind_" + x).remove();
        }

        function addAnswer() {
            $("#answer").append("<div class=\"clearfix\"></div>\n" +
                "                                <div class=\"col-md-6\">\n" +
                "<label>مقدار</label>" +
                "                                    <input type=\"text\" name=\"answer[]\" id=\"answer_" + i + "\" class=\"form-control\"\n" +
                "                                        />\n" +
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
            ویرایش مشخصات محصول
        </div>
        <div class="card-block">
            <form action="{{ route('admin.serviceProperties.update',[$service,$serviceProperty]) }}"
                  enctype="multipart/form-data"
                  method="post">
                @csrf
                @method('patch')
                <div class="col-md-6">
                    <label for="">عنوان مشخصه</label>
                    <input type="text" name="name" class="form-control"
                           value="{{old('name')?old('name'):$serviceProperty->name}}"/>
                </div>
                <div class="col-md-6">
                    <label for="">نوع مشخصه</label>
                    <select class="form-control" name="type" style="padding: 0.1rem"
                            id="info" disabled>
                        <option value="1" {{($serviceProperty->type=='input')?'selected':''}}>توضیح</option>
                        <option value="2" {{($serviceProperty->type=='selectable')?'selected':''}}>تک انتخابی</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for=""> توضیحات مشخصه</label>
                    <input type="text" name="description" class="form-control"
                           value="{{old('description')?old('description'):$serviceProperty->description}}"/>
                </div>
                @if($serviceProperty->type=='selectable')
                    <div id="selectAble">
                        <div class="col-md-12">
                            <label for="">پاسخ های مشخصه</label>
                            <div id="answer">
                                <?php $i = 1;?>
                                @foreach($serviceProperty->ServiceValues as $key=>$serviceAnswer)
                                    <div class="clearfix"></div>
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="col-md-6">
                                                <label for="">مقدار</label>
                                                <input type="text" name="answer_{{$serviceAnswer->id}}"
                                                       class="form-control"
                                                       value="{{$serviceAnswer->name}}"/>
                                                <label for="">آپلود تصویر جدید(در صورتی که میخواهید تغییر دهید)</label>
                                                <input type="file" name="picture[]" id="" class="form-control"
                                                       accept="image/*"/>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-sm btn-primary" id="response"
                                                        style="margin-top: 1rem">{{($serviceAnswer->picture)?"تصویر فعلی":"معین نشده"}}</button>
                                                <div class="clearfix"></div>
                                                <img src="{{ route('admin.ServiceAnswer',[$serviceAnswer]) }}"
                                                     style="width: 50%; margin:0.7rem 0"
                                                     onerror="this.style.display='none';">
                                            </div>
                                            <div class="col-md-3">
                                                <a class="deleteBTN btn btn-danger btn-sm"
                                                   href="{{route('admin.destroyServiceValue',[$service,$serviceProperty,$serviceAnswer])}}"
                                                   style="margin-top: 3.7rem">
                                                    <i class="icon-trash"></i> حذف
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                @if(old('answer'))
                                    @foreach(old('answer') as $key=>$item)
                                        <div class="clearfix"></div>
                                        <div class="col-md-6">
                                            <input type="text" name="answer[]" class="form-control" value="{{$item}}"/>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-sm tag tag-primary">تصویر اختیاری
                                            </button>
                                            <input type="file" name="picture[]" id="" class="form-control"
                                                   accept="image/*"/>
                                        </div>
                                    @endforeach

                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div style="margin-top: 1.5rem">
                                <button type="button" class="btn btn-info" onclick="addAnswer()">افزودن پاسخ
                                    مشخصه
                                </button>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                    </div>
                @endif
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top: 1.5rem">
                    <button type="submit" class="btn btn-primary">ویرایش مشخصات</button>
                </div>
            </form>
        </div>
    </div>
@endsection