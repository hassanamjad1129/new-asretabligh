@extends('admin.layout.master')
@section('extraStyles')
    <link href="https://unpkg.com/persian-datepicker@1.1.3/dist/css/persian-datepicker.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
          بروزرسانی تخفیف
        </div>
        <div class="card-block">
            <a class="btn btn-success" href="{{route('admin.discount.index')}}">مدیریت تخفیف ها</a>

            <div class="col-md-12" style="margin-top: 30px;">
                <form action="{{route('admin.discount.update',$discount->id)}}" method="post">
                    @csrf
                    @method('patch')
                    <div class="col-md-6">
                        <label for="title">عنوان تخفیف </label>
                        <input type="text" name="title" placeholder="عنوان تخفیف" id="title" class="form-control" value="{{$discount->title}}">
                    </div>
                    <div class="col-md-6">
                        <label for="count_discount">تعداد استفاده تخفیف (اگر محدودیت ندارد این فیلد را خالی
                            بگذارید)</label>
                        <input type="text" name="count_discount" id="count_discount" class="form-control" value="{{$discount->count_discount}}">
                    </div>

                    <div class="col-md-6">
                        <label for="type_doing">نوع کسر قیمت</label>
                        <select name="type_doing" id="type_doing" class="form-control">
                            <option value="percentage" {{$discount->type_doing=='percentage'?'selected':''}}>درصدی</option>
                            <option value="cash" {{$discount->type_doing=='cash'?'selected':''}}>نقدی</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="discount_value">مقدار تخفیف</label>
                        <input type="text" name="discount_value" id="discount_value" class="form-control" required value="{{$discount->value}}">
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <label for="started_at">تاریخ آغاز تخفیف</label>
                        <input type="text" onfocus="datePiker('start')" name="started_at" id="started_at"
                               class="form-control datePiker started" value="{{$discount->started_at?$discount->changeDate($discount->started_at):''}}">
                    </div>
                    <div class="col-md-6">
                        <label for="finished_at">تاریخ پایان تخفیف</label>
                        <input type="text" onfocus="datePiker('finished')" name="finished_at" id="finished_at"
                               class="form-control datePiker finished" value="{{$discount->finished_at?$discount->changeDate($discount->finished_at):''}}">
                    </div>

                    <div class="col-md-6">
                        <label for="minimum_price">حداقل قیمت</label>
                        <input type="text" name="minimum_price" id="minimum_price" class="form-control" value="{{$discount->minimum_price}}">
                    </div>
                    <div class="col-md-6">
                        <label for="maximum_price">حداکثر قیمت</label>
                        <input type="text" name="maximum_price" id="maximum_price" class="form-control" value="{{$discount->maximum_price}}">
                    </div>

                    <div class="col-md-2" style="margin-top: 50px">
                        <label for="all_users">تمام کاربران</label>
                        <input type="radio" id="all_users" name="all_users" value="true" required {{$discount->all_users==1?'checked':''}}>
                    </div>
                    <div class="col-md-10" style="margin-top: 50px">
                        <label for="user">بعضی از کاربران</label>
                        <input type="radio" id="user" name="all_users" value="false" required {{$discount->all_users==0?'checked':''}}>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>شماره همراه</th>
                                <th>ایمیل</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="customers[]" value="{{$customer->id}}" {{$discount->all_users==0?$discount->hasCustomer($customer):''}}>
                                    </td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{$customer->email}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-2" style="margin-top: 50px">
                        <label for="all_products">تمام محصولات</label>
                        <input type="radio" id="all_products" name="all_products" value="true" required {{$discount->all_products == 1?'checked':''}}>
                    </div>
                    <div class="col-md-10" style="margin-top: 50px">
                        <label for="product">بعضی از محصولات</label>
                        <input type="radio" id="product" name="all_products" value="false" required {{$discount->all_products == 0?'checked':''}}>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>عکس</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($products as $product)
                                <tr>
                                    <td><input type="checkbox" name="products[]" value="{{$product->id}}" {{$discount->all_products==0?$discount->hasProducts($product):''}}></td>
                                    <td>{{$product->title}}</td>
                                    <td><img src="{{ route('admin.productPicture',[$product]) }}" style="width: 80px"
                                             alt="{{ $product->name }}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 10px">
                        <label for="code">کد تخفیف</label>
                        <input type="text" required class="form-control" id="code" name="code" placeholder="code"
                               style="font-size: 20px;letter-spacing: 5px" value="{{$discount->code}}">
                        <a class="btn btn-info" onclick="generateCode()">ساخت کد تخفیف</a>
                    </div>

                    <label for="first_order">تخفیف برای اولین سفارش</label>
                    <input type="checkbox" name="first_order" value="1" id="first_order" {{$discount->first_order==1?'checked':''}}>
                    <br>
                    <input type="submit" class="btn btn-success" value="بروزرسانی" style="margin-top: 20px">
                </form>
            </div>

        </div>
    </div>
@endsection
@section('extraScripts')
    <script>
        function generateCode() {
            $.ajax({
                type: 'POST',
                url: '{{route('admin.discount.generate.code')}}',
                data: {
                    _token: "{{ csrf_token() }}"
                }, success: function (result) {
                    document.getElementById('code').value = result;
                }
            });
        }
    </script>

    <script type=text/javascript src="https://unpkg.com/persian-date@1.0.5/dist/persian-date.min.js"></script>
    <script type=text/javascript
            src="https://unpkg.com/persian-datepicker@1.1.3/dist/js/persian-datepicker.min.js"></script>
    <script type="text/javascript">
        function datePiker(input) {
            if (input === 'start') {
                $(".started").persianDatepicker({
                    format: 'YYYY/MM/DD H:m:s',
                });
            } else {
                $(".finished").persianDatepicker({
                    format: 'YYYY/MM/DD H:m:s',
                });
            }
        }
    </script>
@endsection