@extends('admin.layout.master')
@section('content')
    <style>
        .treeview, .treeview ul {
            margin: 0;
            padding: 0;
            list-style: inside;

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
            <h4>دسته بندی پست ها</h4>
        </div>
        <div class="card-block">
            <div class="col-md-12">
                <a href="{{ route('admin.pCategories.create') }}" class="btn btn-primary"
                   style="margin-bottom: 10px">افزودن دسته بندی </a>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام دسته</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                            data-toggle="dropdown" style="width: 60%;"
                                            aria-expanded="false">عملیات
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-left">
                                        <li>
                                            <a href="{{ route('admin.pCategories.edit',[$category]) }}"
                                               class="btn btn-sm btn-block">ویرایش</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.pCategories.destroy',[$category]) }}"
                                                  method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-block deleteForm"
                                                        style="background: transparent;color: #52a9d8;">حذف
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection