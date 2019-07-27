@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            مدیریت تخفیف ها
        </div>
        <div class="card-block">
            <a class="btn btn-success" href="{{route('admin.discount.create')}}">افزودن
                تخفیف</a>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان</th>
                    <th>نوع کسر مبلغ</th>
                    <th>مقدار</th>
                    <th>تعداد استفاده</th>
                    <th>کد تخفیف</th>
                    <th>تاریخ شروع</th>
                    <th>تاریخ پایان</th>
                    <th>حداقل قیمت</th>
                    <th>حداکثر قیمت</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                @foreach($discounts as $discount)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$discount->title?$discount->title:'عنوانی ثبت نشده است'}}</td>
                        <td>{{$discount->type_doing == 'percentage'?'درصدی(%)':'نقدی(ریال)'}}</td>
                        <td>{{$discount->value}}</td>
                        <td>{{$discount->count_discount==0?'نامحدود':$discount->count_discount}}</td>
                        <td>{{$discount->code}}</td>
                        <td>{{$discount->started_at?$discount->changeDate($discount->started_at):'چیزی ثبت نشده'}}</td>
                        <td>{{$discount->finished_at?$discount->changeDate($discount->finished_at):'چیزی ثبت نشده'}}</td>
                        <td>{{$discount->minimum_price?$discount->minimum_price:'چیزی ثبت نشده'}}</td>
                        <td>{{$discount->maximum_price?$discount->maximum_price:'چیزی ثبت نشده'}}</td>
                        <td>
                            <a href="{{route('admin.discount.changeStatus',$discount)}}"><button class="btn {{$discount->status == 1?'btn-success':'btn-danger'}}">{{$discount->status == 1?'فعال':'غیرفعال'}}</button></a>
                        </td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-block dropdown-toggle"
                                        data-toggle="dropdown" style="width: 60%;"
                                        aria-expanded="false">عملیات
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="btn btn-sm" href="{{route('admin.discount.edit',$discount->id)}}">ویرایش</a>
                                    </li>
                                    <li>
                                        <form action="{{route('admin.discount.delete',$discount)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="deleteForm btn btn-sm"
                                                    style="background: none;color: #20a8d8;">حذف
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
@endsection