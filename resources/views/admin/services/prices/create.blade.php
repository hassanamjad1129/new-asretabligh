@extends('admin.layout.master')
@section('extraStyles')
    <link href="/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css" rel="stylesheet">
    <style>
        .card-header {
            padding: 0.5rem 5px
        }
    </style>
@endsection
@section('extraScripts')
    <script src="/js/jQuery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
            $('.alert-danger').hide();
            $('.alert-success').hide();
        });
    </script>
    <script>
        var i = 2;
        var paper = "";
        var service = {{ $service->id }}
        $("select[name=paper]").change(function () {
            $("#Prices").html("");
            var values = [];
            $(".js-example-basic-single option:selected").each(function () {
                values.push(this.value);
            });
            paper = $(this).val();
            $.post('/admin/ajaxServicePrices', {
                values_id: values.length ? values.sort().join('-') : null,
                _token: '{{csrf_token()}}',
                paper: paper,
                service: "{{ $service->id }}"
            }, function (data, status) {
                data.forEach(function (item, index) {
                    @if($service->allow_type)
                    addProductPrice(data[index].id, data[index].min, data[index].max, data[index].single_price, data[index].double_price, data[index].coworker_single_price, data[index].coworker_double_price);
                    @else
                    addProductPrice(data[index].id, data[index].min, data[index].max, data[index].price, data[index].coworker_price);
                    @endif
                })
            });

        });

        function submitForm() {
            var myForm = ($("#myForm").serialize());
            Swal.fire({
                title: 'لطفا صبر کنید',
                timer: 3000,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
                // },
                // onClose: () => {
                //     Swal.close();
                // }
            });

            $.post('/admin/ajaxServiceSubmitForm', myForm, function (data, status) {
                if (data.errors) {
                    $('.alert-danger').show();
                    data.errors.forEach(function (item, index) {
                        $("#Error").append("<li><i class=\"fa fa-warning\"></i>" + data.errors[index] + "</li>")
                    });
                }
                // sweetAlert.onClose;

                if (data.success) {
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'عملیات با موفقیت انجام شد',
                        showConfirmButton: true,
                        confirmButtonText: 'باشه'
                    })
                    var values = [];
                    $(".js-example-basic-single option:selected").each(function () {
                        values.push(this.value);
                    });
                    $("#Prices").html("");
                    $.post('/admin/ajaxServicePrices', {
                        paper: paper,
                        service: service,
                        values_id: values.sort().join('-'),
                        _token: '{{csrf_token()}}'
                    }, function (data, status) {
                        data.forEach(function (item, index) {
                            @if($service->allow_type)
                            addProductPrice(data[index].id, data[index].min, data[index].max, data[index].single_price, data[index].double_price, data[index].coworker_single_price, data[index].coworker_double_price);
                            @else
                            addProductPrice(data[index].id, data[index].min, data[index].max, data[index].price, data[index].coworker_price);
                            @endif
                        })
                    });
                }
            });
        }

        function removeAddOrderPrice(i) {
            $("#addOrderPrice_" + i).remove();
        }

        function addOrderPrice(id) {
            $("#Prices").append("<div id=\"addOrderPrice_" + i + "\">\n" +
                "<div class=\"col-md-12\">\n" +
                "                        <div class=\"col-md-1\">\n" +
                "                            <div class=\"card\">\n" +
                "                                <div class=\"card-header\"> حداقل</div>\n" +
                "                                <input type=\"number\" name=\"min[]\" class=\"form-control\"/>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-1\">\n" +
                "                            <div class=\"card\">\n" +
                "                                <div class=\"card-header\"> حداکثر</div>\n" +
                "                                <input type=\"number\" name=\"max[]\" class=\"form-control\"/>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                    @if($service->allow_type)

                        "                        <div class=\"col-md-2\">\n" +
                "                            <div class=\"card\">\n" +
                "                                <div class=\"card-header\">قیمت یک رو<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                                <input type=\"text\" name=\"single_price[]\" class=\"price form-control\"\n" +
                "                                       value=\"\"/>\n" +
                "                               <input type=\"hidden\" name=\"product_id[]\" value=\"" + id + "\"/>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-2\">\n" +
                "                            <div class=\"card\">\n" +
                "                                <div class=\"card-header\">قیمت دو رو<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                                <input type=\"text\" name=\"double_price[]\" class=\"price form-control\"\n" +
                "                                       value=\"\"/>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-2\">\n" +
                "                            <div class=\"card\">\n" +
                "                                <div class=\"card-header\">قیمت یک رو همکار<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                                <input type=\"text\" name=\"coworker_single_price[]\" class=\"price form-control\"\n" +
                "                                       value=\"\"/>\n" +
                "                               <input type=\"hidden\" name=\"product_id[]\" value=\"" + id + "\"/>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-2\">\n" +
                "                            <div class=\"card\">\n" +
                "                                <div class=\"card-header\">قیمت دو رو همکار<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                                <input type=\"text\" name=\"coworker_double_price[]\" class=\"price form-control\"\n" +
                "                                       value=\"\"/>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                    @else
                        "                        <div class=\"col-md-2\">\n" +
                "                            <div class=\"card\">\n" +
                "                                <div class=\"card-header\">قیمت <span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                                <input type=\"text\" name=\"price[]\" class=\"price form-control\"\n" +
                "                                       value=\"\"/>\n" +
                "                               <input type=\"hidden\" name=\"product_id[]\" value=\"" + id + "\"/>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                        <div class=\"col-md-2\">\n" +
                "                            <div class=\"card\">\n" +
                "                                <div class=\"card-header\">قیمت همکار<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                                <input type=\"text\" name=\"coworker_price[]\" class=\"price form-control\"\n" +
                "                                       value=\"\"/>\n" +
                "                            </div>\n" +
                "                        </div>\n" +

                    @endif
                        "                        <div class=\"col-md-1\">\n" +
                "                            <button type=\"button\" class=\"btn btn-sm btn-danger\" id=\"button\"\n" +
                "                                    style=\"margin-top: 1.7rem !important;\" onclick=\"removeAddOrderPrice(" + i + ")\"><span\n" +
                "                                        class=\"icon-trash\"></span></button>\n" +
                "                        </div>\n" +
                "                    </div>");
            i = i + 1;
        }

        function addElement(id, type, name, i) {
            if (type == "input") {
                /* $("#moreProperty").append("<div class=\"card-body\">\n" +
                     "                                        <input type=\"text\" name=\"input[]\" id=\"input_" + id + "\" class=\"form-control\"/>\n" +
                     "                                    </div>");*/
            }
            // first clear content of previous price
            $("#moreProperty").html("");
            $("#moreProperty").append("<div id=\"rootProperty_" + i + "\">      \n" +
                "               <div class=\"col-md-6\">\n" +
                "                    <div class=\"card\">\n" +
                "                        <div class=\"card-header\">" + name + "</div>\n" +
                "                    <div class=\"card-body\">\n" +
                "                        <select class=\"js-example-basic-single form-control\" parent=\"" + i + "-" + "\"  name=\"value[]\"\n" +
                "                                id=\"property_" + id + "\" \n" +
                "                                onchange=\"addProperty(" + id + ")\">\n" +
                "                            <option value=\"\" selected>انتخاب کنید</option>\n" +
                "                        </select>\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "             </div>",
            );
            var options = [];
            $.post('/admin/ajaxServiceAnswers', {property_id: id, _token: '{{csrf_token()}}'}, function (data, status) {
                data.forEach(function (item, index) {
                    options [index] = data[index].name;
                });
                options.forEach(function (element, key) {
                    $("#property_" + id).append(new Option(element, data[key].id, false, false));
                })
            });
            $(document).ready(function () {
                $('.js-example-basic-single').select2();
            });

        }

        function removeCreatedPrice(id) {
            swal({
                title: 'آیا از انجام این عمل اطمینان دارید؟',
                text: "انجام این عمل قابل بازگشت نیست",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله اطمینان دارم',
                cancelButtonText: 'خیر'
            }).then(function (result) {
                if (result.value) {
                    $.post('/admin/ajaxRemoveServicePrice', {
                        id: id,
                        _token: '{{csrf_token()}}'
                    }, function (data, status) {
                        $("#createdPrice_" + id).remove();
                    });
                }
            });
        }

        @if($service->allow_type)
        function addProductPrice(id, min, max, single_price, double_price, coworker_single_price, coworker_double_price) {

            $("#Prices").append("<div class=\"created_price\">\n" +
                "     <div id=\"createdPrice_" + id + "\">\n" +
                "    <div class=\"col-md-12\">\n" +
                "        <div class=\"col-md-1\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\"> حداقل</div>\n" +
                "                <input type=\"number\" name=\"min_" + id + "\" class=\"form-control\" value=\"" + min + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-1\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\"> حداکثر</div>\n" +
                "                <input type=\"number\" name=\"max_" + id + "\" class=\"form-control\" value=\"" + max + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-2\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\">قیمت یک رو<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                <input type=\"text\" name=\"single_price_" + id + "\" class=\"price form-control\" value=\"" + single_price + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-2\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\">قیمت دو رو<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                <input type=\"text\" name=\"double_price_" + id + "\" class=\"price form-control\" value=\"" + double_price + "\"/>\n" +
                "                <input type=\"hidden\" name=\"price_id[]\" value=\"" + id + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-2\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\">قیمت یک رو همکار<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                <input type=\"text\" name=\"coworker_single_price_" + id + "\" class=\"price form-control\" value=\"" + coworker_single_price + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-2\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\">قیمت دو رو همکار<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                <input type=\"text\" name=\"coworker_double_price_" + id + "\" class=\"price form-control\" value=\"" + coworker_double_price + "\"/>\n" +
                "                <input type=\"hidden\" name=\"price_id[]\" value=\"" + id + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-1\">\n" +
                "            <button type=\"button\" class=\"btn btn-sm btn-danger\" id=\"button\"\n" +
                "                    style=\"margin-top: 1.7rem !important;\"\n" +
                "                    onclick=\"removeCreatedPrice(" + id + ")\"><span\n" +
                "                        class=\"icon-trash\"></span></button>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "     </div>\n" +
                "</div>"
            )
        }

        @else
        function addProductPrice(id, min, max, price, coworker_price) {

            $("#Prices").append("<div class=\"created_price\">\n" +
                "     <div id=\"createdPrice_" + id + "\">\n" +
                "    <div class=\"col-md-12\">\n" +
                "        <div class=\"col-md-1\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\"> حداقل</div>\n" +
                "                <input type=\"number\" name=\"min_" + id + "\" class=\"form-control\" value=\"" + min + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-1\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\"> حداکثر</div>\n" +
                "                <input type=\"number\" name=\"max_" + id + "\" class=\"form-control\" value=\"" + max + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-2\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\">قیمت<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                <input type=\"text\" name=\"price_" + id + "\" class=\"price form-control\" value=\"" + price + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-2\">\n" +
                "            <div class=\"card\">\n" +
                "                <div class=\"card-header\">قیمت همکار<span class=\"tag tag-primary\">ریال</span></div>\n" +
                "                <input type=\"text\" name=\"coworker_price_" + id + "\" class=\"price form-control\" value=\"" + coworker_price + "\"/>\n" +
                "                <input type=\"hidden\" name=\"price_id[]\" value=\"" + id + "\"/>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-1\">\n" +
                "            <button type=\"button\" class=\"btn btn-sm btn-danger\" id=\"button\"\n" +
                "                    style=\"margin-top: 1.7rem !important;\"\n" +
                "                    onclick=\"removeCreatedPrice(" + id + ")\"><span\n" +
                "                        class=\"icon-trash\"></span></button>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "     </div>\n" +
                "</div>"
            )
        }

        @endif
        function removeElementHtml(x) {
            var child = $("select[parent^=" + x + "]").attr("id");
            if (child != undefined) {
                var property_number = child.split("_");
                removeElementHtml(property_number[1])
            }
            $("select[parent^=" + x + "-" + "]").parent().parent().parent().remove();
            // removeElementHtml(parent);
        }

        function removeProductPriceElements() {
            $(".created_price").remove();
        }

        function addProperty(i) {
            var id = document.getElementById("property_" + i);
            if (id)
                id = id.value;
            //if (data == "")
            removeElementHtml(i);
            removeProductPriceElements();
            var values = [];
            $(".js-example-basic-single option:selected").each(function () {
                values.push(this.value);
            });
            $("#Prices").html("");
            $.post('/admin/ajaxServicePrices', {
                paper: paper,
                service: service,
                values_id: values.sort().join('-'),
                _token: '{{csrf_token()}}'
            }, function (data, status) {
                data.forEach(function (item, index) {
                    @if($service->allow_type)
                    addProductPrice(data[index].id, data[index].min, data[index].max, data[index].single_price, data[index].double_price, data[index].coworker_single_price, data[index].coworker_double_price);
                    @else
                    addProductPrice(data[index].id, data[index].min, data[index].max, data[index].price, data[index].coworker_price);
                    @endif
                })
            });
            $.post('/admin/ajaxServiceProperties', {value_id: id, _token: '{{csrf_token()}}'}, function (data, status) {
                data.forEach(function (item, index) {
                    addElement(data[index].id, data[index].type, data[index].name, i);
                })
            });
        }
    </script>
@endsection
@section('content')

    <div class="alert alert-danger" style="display: none">
        <ul id="Error">
        </ul>
    </div>
    <div class="alert alert-success" style="display: none;">
        <ul id="Success">
            <li><i class="fa fa-check"></i>عملیات با موفقیت انجام شد</li>
        </ul>
    </div>
    <div class="card">
        <div class="card-header">
            قیمت محصول
        </div>
        <div class="card-block">
            <form action="{{ route('admin.servicePrice.store',[$service]) }}"
                  enctype="multipart/form-data"
                  method="post" id="myForm">
                @csrf
                <label>مشخصات سفارش</label>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-bottom: 1rem">
                    <label for="">کاغذ</label>
                    <select name="paper" id="" class="form-control">
                        <option value="">انتخاب کنید ...</option>
                        @foreach($papers as $paper)
                            <option value="{{ $paper->id }}">{{ $paper->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="clearfix"></div>

                <div id="properties">
                    @foreach($serviceProperties as $serviceProperty)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">{{$serviceProperty->name}}</div>
                                @if($serviceProperty->type=='input')
                                    <div class="card-body">
                                        <input type="text" name="input[]" class="form-control"/>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <select class="js-example-basic-single form-control" name="value[]"
                                                id="property_{{$serviceProperty->id}}"
                                                onchange="addProperty({{$serviceProperty->id}})">
                                            <option value="" selected>انتخاب کنید</option>
                                            @foreach($serviceProperty->ServiceValues()->get() as $serviceAnswer)
                                                <option value="{{$serviceAnswer->id}}">{{$serviceAnswer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div id="Prices">

                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-info" onclick="addOrderPrice({{$service->id}})">افزودن قیمت
                        سفارش
                    </button>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top: 0.5rem !important;">
                    <input type="hidden" name="service" value="{{ $service->id }}">
                    <button type="button" class="btn btn-success" onclick="submitForm()">ثبت قیمت</button>
                </div>
            </form>
        </div>
    </div>
@endsection
