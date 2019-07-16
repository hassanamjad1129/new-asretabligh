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
@section('extraScripts')
    <script>
        $(function () {

            var url = window.location.pathname,
                urlRegExp = new RegExp(url + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
            // now grab every link from the navigation
            $('.customerSideBar a').each(function () {
                // and test its normalized href against the url pathname regexp
                if (urlRegExp.test(this.href)) {
                    $(this).parent('li').addClass('active');
                }
            });

        });
    </script>
@endsection
