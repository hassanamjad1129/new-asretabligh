@extends('client.layout.master')
@section('content')
    <script src='https://api.cedarmaps.com/cedarmaps.js/v1.8.0/cedarmaps.js'></script>
    <link href='https://api.cedarmaps.com/cedarmaps.js/v1.8.0/cedarmaps.css' rel='stylesheet'/>
    <div class="about" style="overflow: hidden;margin: 0">
        <div class="col-xs-12">
            <div class="container">
                <div id="youAreHere">
                    <div class="gps_ring"></div>
                    <p class="youAreHereText" style="margin-right: 5px;">شما اینجا هستید : <a
                                href="{{ url('/') }}">خانه</a> / تماس با ما</p>
                </div>
                <br>
                <h1>تماس با ما</h1>
                <hr>
                <div class="col-md-8">
                    <form action="" method="post">
                        {{ csrf_field() }}
                        <h3>ارسال پیام </h3>

                        <br>
                        @if(count($errors->feild)>0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->feild->all() as $error)
                                        <li style="list-style: none"><i class="fa fa-warning"></i> {!! $error !!}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(count($errors->success)>0)
                            <div class="alert alert-success">
                                <ul>
                                    @foreach($errors->success->all() as $error)
                                        <li style="list-style: none"><i class="fa fa-check"></i> {!! $error !!}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6">
                                <label for="">نام و نام خانوادگی : </label>
                                <input type="text"
                                       style="position: relative;background-color: #FFF;width: 100%;display: block;    height: 35px;border: 1px solid #DDD;"
                                       name="name" class="form-control" id="name"/>
                            </div>
                            <div class="col-md-6">
                                <label for="">پست الکترونیکی : </label>
                                <input type="email" name="email" class="form-control" id="email"/>
                            </div>
                            <div class="col-md-12">
                                <label for="">پیام : </label>
                                <textarea name="message" class="form-control" rows="6" id="address"></textarea>
                                <br>
                                <button class="btn btn-danger" type="submit">ارسال پیام</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <h3>اطلاعات تماس </h3>
                    <br>
                    <h4>چاپ دیجیتال عصر تبلیغ</h4>
                    <br>
                    <h5 style="display: inline-block;    margin-bottom: 1rem;">شماره تماس : </h5><h5
                            style="color:#D60000;direction: ltr;display: inline-block"
                            style="direction: ltr">{{ $phone }}</h5>
                    <br>
                    <h5 style="margin-bottom: 1rem;">ایمیل : {{ $email }}</h5>
                    <h5 style="line-height: 27px">آدرس : {{ $address }}</h5>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="col-md-12" style="margin-top: 10px;padding:0">
        <div id='map' style='width: 100%; height: 320px;'></div>
    </div>
    <script type="text/javascript">
        L.cedarmaps.accessToken = "eebca82823f6c1484f7d3bcec944d9b590bfc979\n"; // See the note below on how to get an access token

        var map = CedarMaps.map(eebca82823f6c1484f7d3bcec944d9b590bfc979, {
            style: 'style://streets-light',
            container: 'map',
            center: [51.3789253, 35.709987],
            zoom: 15,
            scrollWheelZoom: true,
            zoomControl: false,
            minZoom: 7,
            maxZoom: 17,
        })

        /**
         * Adding a Leaflet marker with custom image
         */

        var element = document.createElement('div')
        element.className = 'marker'
        element.style.backgroundImage = 'url(/marker.png)'
        element.style.width = '34px'
        element.style.height = '46px'

        var marker = new CedarMaps.gl.Marker(element).setLngLat([51.3789253, 35.709987]).addTo(map)
        var controles = new CedarMaps.gl.NavigationControl()
        var popup = new CedarMaps.gl.Popup({
            closeButton: true,
            closeOnClick: true,
            offset: [0, -14],
        }).setHTML('Hello World!')
            .setLngLat([51.3789253, 35.709987])
            .addTo(map)
        map.addControl(controles)
    </script>
@endsection