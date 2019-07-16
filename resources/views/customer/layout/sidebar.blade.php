<ul class="customerSideBar">
    <img src="/clientAssets/img/Neutral-placeholder-profile.jpg" style="width: 100%;" alt="">
    <p style="padding: 1rem;background: #EDEDED;text-align: center">{{ auth()->guard('customer')->user()->name }}</p>
    <li class="active"><a href="">داشبورد </a></li>
    <li><a href="{{ route('customer.orders') }}">سفارشات</a></li>
    <li><a href="">تنظیمات</a></li>
</ul>