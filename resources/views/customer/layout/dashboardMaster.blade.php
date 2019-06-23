@extends('client.layout.master')
@section('content')
    <div class="container">
        <div class="col-md-2">
            @include('customer.layout.sidebar')
        </div>
        <div class="col-md-10">
            @yield('dashboardContent')
        </div>
    </div>
@endsection