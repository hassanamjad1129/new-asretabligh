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
    </style>
    <div class="card">
        <div class="card-header">
            <h4>افزودن دسته بندی</h4>
        </div>
        <div class="card-block">
            <form action="{{ route('admin.pCategories.store') }}" method="post" style="display: inline;">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">نام دسته</label>
                        <input type="text" class="form-control" name="name"/>
                    </div>

                    <button class="btn btn-success" style="margin-top: 10px">ثبت دسته</button>

                </div>
            </form>
        </div>
    </div>
@endsection