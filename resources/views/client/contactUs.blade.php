@extends('client.layout.master')
@section('content')
    <div id="youAreHere">
        <div class="gps_ring"></div>
        <p class="youAreHereText">شما اینجا هستید : <a href="{{ url('/') }}">خانه</a> / تماس با ما</p>
    </div>
    <div class="about" style="overflow: hidden;margin: 0">
        <div class="col-xs-12">
            <div class="container">
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
                    <h4>چاپ عصر تبلیغ</h4>
                    <br>
                    <h5 style="display: inline-block">شماره تماس : </h5><span
                            style="direction: ltr">{{ $phone }}</span>
                    <br>
                    <h5>ایمیل : {{ $email }}</h5>
                    <br>
                    <h5>آدرس : {{ $address }}</h5>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="col-md-12" style="margin-top: 10px;padding:0">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1619.979450092633!2d51.392374658259484!3d35.70262899504738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzXCsDQyJzA5LjUiTiA1McKwMjMnMzYuNSJF!5e0!3m2!1sen!2sir!4v1480962140937"
                height="320" frameborder="0" style="border:0;width: 100%" allowfullscreen></iframe>
    </div>
@endsection