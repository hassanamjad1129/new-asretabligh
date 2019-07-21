@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <p>ایجاد تراکنش روی کیف پول</p>
        </div>
        <div class="card-block">
            <form action="/admin/customer/{{ $customer->id }}/moneybag" method="post">
                @csrf
                <div class="col-md-6">
                    <label for="">مبلغ (ریال)</label>
                    <input type="text" name="price" class="form-control price"/>
                </div>
                <div class="col-md-6">
                    <label for="">عملیات</label>
                    <select name="operation" id="" class="form-control">
                        <option value="increase">افزایش</option>
                        <option value="decrease">کاهش</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="">توضیحات</label>
                    <textarea name="description" id="" cols="30" rows="4" class="form-control"></textarea>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-success" style="margin-top: 10px;margin-bottom: 10px;">ثبت نهایی</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('extraScripts')
    <script>
        $('.price').keydown(function (event) {
            if (event.keyCode == 46 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 8 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39)) {
                return;
            } else {
                if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                    event.preventDefault();
                }
            }
        });
        $('.price').keyup(function (event) {
            var $this = $(this);
            var strInput = $this.val();
            strInput = strInput.replace(/ /g, '')
            strInput = strInput.replace(/,/g, '');
            $this.val(strInput.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
    </script>
@endsection