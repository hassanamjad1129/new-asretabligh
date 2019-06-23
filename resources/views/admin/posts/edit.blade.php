@extends('admin.layout.master')
@section('content')
    <style>
        .treeview, .treeview ul {
            margin: 0;
            padding: 0;
            list-style: none;

            color: #369;
        }

        .treeview ul {
            margin-left: 1em;
            position: relative
        }

        .treeview ul ul {
            margin-left: .5em
        }

        .treeview ul:before {
            content: "";
            display: block;
            width: 0;
            position: absolute;
            top: 0;
            right: 0;
            border-right: 1px solid;

            /* creates a more theme-ready standard for the bootstrap themes */
            bottom: 15px;
        }

        .treeview li {
            margin: 0;
            padding: 0 1em;
            line-height: 2em;
            font-weight: 700;
            position: relative
        }

        .treeview ul li:before {
            content: "";
            display: block;
            width: 10px;
            height: 0;
            border-top: 1px solid;
            margin-top: -1px;
            position: absolute;
            top: 1em;
            right: 0
        }

        .tree-indicator {
            margin-right: 5px;

            cursor: pointer;
        }

        .treeview li a {
            text-decoration: none;
            color: inherit;

            cursor: pointer;
        }

        .treeview li button, .treeview li button:active, .treeview li button:focus {
            text-decoration: none;
            color: inherit;
            border: none;
            background: transparent;
            margin: 0px 0px 0px 0px;
            padding: 0px 0px 0px 0px;
            outline: 0;
        }

        .treeview label {
            margin: 0;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <h5>ویرایش پست</h5>
        </div>
        <div class="card-block">
            <form action="{{ route('admin.posts.update',[$post]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>توضیحات پست</h5>
                        </div>
                        <div class="card-block">
                            <label for="">عنوان</label>
                            <input type="text" value="{{ old('title')?old('title'):$post->title }}" name="title"
                                   class="form-control"/>
                            <label for="">محتوا</label>
                            <textarea name="description"
                                      class="form-control">{{ old('description')?old('description'):$post->description }}</textarea>
                            <button class="btn btn-success" style="margin-top: 10px">بروزرسانی</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>مشخصات پست</h5>
                        </div>
                        <div class="card-block">
                            <div class="input-group">
                                <span class="input-group-btn">
                                   <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-success">
                                       <i class="fa fa-picture-o"></i> انتخاب تصویر
                                   </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text"
                                       value="{{ old('picture')?old('picture'):$post->picture }}"
                                       name="picture">
                            </div>
                            <img id="holder" src="{{ old('picture')?old('picture'):$post->picture }}"
                                 style="margin-top:15px;max-height:100px;">
                            <hr>
                            <label for="">دسته بندی پست</label>
                            <ul class="treeview">
                                @foreach($categories as $category)
                                    <li>
                                        <input type="checkbox" name="categories[]"
                                               {{ in_array($category->id,$post->categories()->pluck('id')->toArray())?"checked":"" }} value="{{ $category->id }}"
                                               id="item-{{ $category->id }}"/>
                                        <label for="item-{{ $category->id }}">{{ $category->name }}</label>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
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