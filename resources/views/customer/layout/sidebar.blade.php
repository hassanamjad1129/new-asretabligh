<ul class="customerSideBar">
    @if(auth()->guard('customer')->user()->avatar)
        <img src="{{ asset(auth()->guard('customer')->user()->avatar) }}" style="width: 100%;"
             alt="{{ auth()->guard('customer')->user()->name }}">
    @else
        <img src="/clientAssets/img/Neutral-placeholder-profile.jpg" style="width: 100%;"
             alt="{{ auth()->guard('customer')->user()->name }}">
    @endif
    <p style="padding: 1rem;background: #EDEDED;text-align: center">{{ auth()->guard('customer')->user()->name }}</p>
    <li><a href="/customer/home" style="width: 100%;display: block;">داشبورد </a></li>
    <li><a href="{{ route('customer.orders') }}" style="width: 100%;display: block;">سفارشات</a></li>
    <li><a href="/customer/setting" style="width: 100%;display: block;">تنظیمات</a></li>
</ul>