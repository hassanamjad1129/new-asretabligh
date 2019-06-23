@extends('client.layout.master')
@section('content')

    <style>
        .file {
            margin-bottom: 20px;
            text-align: center;
            direction: ltr;
        }

        .file p {
            padding-bottom: 4px;
        }

        .file i {
            text-align: center;
        }

        li {
            list-style: none;
        }

        #dataTables-example tr.info, #dataTables-example td.info {
            background-color: #d9edf7 !important;
        }

        .table-striped > tbody > tr.danger > td, .table-striped > tbody > tr.danger > th, .table-striped > tbody > tr > td.danger, .table-striped > tbody > tr > th.danger, .table-striped > tfoot > tr.danger > td, .table-striped > tfoot > tr.danger > th, .table-striped > tfoot > tr > td.danger, .table-striped > tfoot > tr > th.danger, .table-striped > thead > tr.danger > td, .table-striped > thead > tr.danger > th, .table-striped > thead > tr > td.danger, .table-striped > thead > tr > th.danger {
            background-color: #f2dede !important;
        }</style>
    <h3>لیست فایل های ارسالی</h3>
    <hr>
    @if(count($errors->feild)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->feild->all() as $error)
                    <li><i class="fa fa-warning"></i> {!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(count($errors->success)>0)
        <div class="alert alert-success">
            <ul>
                @foreach($errors->success->all() as $error)
                    <li><i class="fa fa-check"></i> {!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <ul>
        @foreach($files as $file)
            <li class="col-lg-2 col-md-3 col-sm-4 col-xs-6 file">
                <a href="{{ url('/orderFiles/'.$file) }}" style="color: #000" target="_blank">
                    <i class="fa fa-file fa-5x"></i>
                    <h5>{{ $file }}</h5></a>
            </li>
        @endforeach
    </ul>
@endsection