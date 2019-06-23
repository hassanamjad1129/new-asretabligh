@extends('admin.layout.master')
@section('content')
    <h3>ثبت مشتری جدید</h3>
    <hr>
    <div class="card">
        <div class="card-block">
            <form action="{{ url('/admin/bestCustomers') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <label for="">عنوان</label>
                <input type="text" class="form-control" name="title">
                <label for="">تصویر شاخص</label>
                <div class="input-group">
   <span class="input-group-btn">
     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-success">
       <i class="fa fa-picture-o"></i> انتخاب تصویر
     </a>
   </span>
                    <input id="thumbnail" class="form-control" type="text" value="{{ old('picture') }}"
                           name="picture">
                </div>
                <img id="holder" src="{{ old('picture') }}" style="margin-top:15px;max-height:100px;">
                <br>
                <button type="submit" class="btn btn-primary">ذخیره</button>
            </form>
        </div>
    </div>
@endsection
@section('extraScripts')
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
    <script src="/adminAssets/tinymce/tinymce.min.js"></script>
    <script> var editor_config = {
            selector: 'textarea',
            theme: 'modern',
            plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            directionality: 'rtl',
            height: "250",
            language: 'fa_IR',
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ],
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = '/laravel-filemanager?lang=' + tinymce.settings.language + '&field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };
        tinymce.init(editor_config);
    </script>

@endsection