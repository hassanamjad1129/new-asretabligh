@extends('admin.layout.master')
@section('extraScripts')
    <script src="/js/jQuery.min.js"></script>
    <script>
        var i = 2;

        function removeElement(x) {
            $("#front_label_" + x).remove();
            $("#back_label_" + x).remove();
            $("#button_" + x).remove();
        }

        function addFile() {
            $("#File").append("<div class=\"clearfix\"></div> \n" +
                " <div class=\"col-md-4\" id=\"front_label_" + i + "\">\n" +
                "                    <div class=\"card\">\n" +
                "                        <div class=\"card-header\">\n" +
                "                            <label for=\"\">برچسب رو</label>\n" +
                "                        </div>\n" +
                "                        <div class=\"card-body\">\n" +
                "                            <input type=\"text\" name=\"front_label[]\" class=\"form-control\"/>\n" +
                "                        </div>\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"col-md-4\" id=\"back_label_" + i + "\">\n" +
                "                    <div class=\"card\">\n" +
                "                        <div class=\"card-header\">\n" +
                "                            <label for=\"\">برچسب پشت</label>\n" +
                "                        </div>\n" +
                "                        <div class=\"card-body\">\n" +
                "                            <input type=\"text\" name=\"back_label[]\" class=\"form-control\"/>\n" +
                "                        </div>\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"col-md-4\" id=\"button_" + i + "\">\n" +
                "                    <button type=\"button\" class=\"btn btn-sm btn-danger\"\n" +
                "                            style=\"margin: 0.5rem  0.0rem!important;\"\n" +
                "                            onclick=\"removeElement(" + i + ")\"><span\n" +
                "                                class=\"icon-trash\"></span></button>\n" +
                "                </div>");
            i = i + 1;
        }
    </script>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            ایجاد فایل محصول
        </div>
        <div class="card-block">
            <form action="{{ route('admin.productFile.store',[$category,$subcategory,$product]) }}"
                  enctype="multipart/form-data"
                  method="post">
                @csrf
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <label for="">عنوان محصول</label>
                        </div>
                        <div class="card-block">
                            <h5>{{$product->title}}</h5>
                        </div>
                    </div>
                </div>
                <div id="File">
                    <div class="col-md-4" id="front_label_1">
                        <div class="card">
                            <div class="card-header">
                                <label for="">برچسب رو</label>
                            </div>
                            <div class="card-body">
                                <input type="text" name="front_label[]" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="back_label_1">
                        <div class="card">
                            <div class="card-header">
                                <label for="">برچسب پشت</label>
                            </div>
                            <div class="card-body">
                                <input type="text" name="back_label[]" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="button_1">
                        <button type="button" class="btn btn-sm btn-danger"
                                style="margin: 0.5rem  0.0rem!important;"
                                onclick="removeElement(1)"><span
                                    class="icon-trash"></span></button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div style="margin-top: 0.5rem !important;">
                    <button type="button" class="btn btn-info" onclick="addFile()">افزودن فایل
                    </button>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top: 0.5rem">
                    <button type="submit" class="btn btn-success"> فایل محصول</button>
                </div>
            </form>
        </div>
    </div>
@endsection