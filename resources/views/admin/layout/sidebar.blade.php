<style>
    #myInput:focus {
        border: none;
        border-bottom: 1px solid #FFF;
    }
</style>
<div class="sidebar">
    <nav class="sidebar-nav">
        <label for="" style="color: #fff;">جستجو</label>
        <input type="text" style="color:#fff;width: 97%;background: rgba(255,255,255,.1)" id="myInput"
               onkeyup="myFunction()" class="form-control">
        <ul class="nav" id="sidebarNav">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="icon-speedometer"></i> داشبورد </a>
            </li>
            @can('categories')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.categories.index')}}"><i class="icon-camrecorder"></i>دسته
                        ها و
                        محصولات
                    </a>
                </li>
            @endcan
            @can('papers')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.paper.index')}}">
                        <i class="icon-camrecorder"></i>مدیریت کاغذ ها
                    </a>
                </li>
            @endcan
            @can('customers')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.customer.index')}}"><i class="icon-user"></i> مدیریت
                        کاربران</a>
                </li>
            @endcan
            @canany(['orders','orderArchives'])

                <li class="nav-title">
                    مدیریت سفارشات
                </li>
                @can('orders')
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.orders.index')}}"><i class="icon-user"></i>  در
                            حال
                            انجام</a>
                    </li>
                @endcan
                @can('orderArchives')
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.orders.finished')}}"><i class="icon-user"></i>
                            تحویل
                            داده شده</a>
                    </li>
                @endcan
            @endcanany
            @can('discounts')
                <li class="nav-title">
                    تخفیف
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.discount.index')}}"><i class="icon-tag"></i>لیست تخفیف
                        ها</a>
                </li>
            @endcan

            @can('مدیریت دسترسی ها')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.roles.index')}}"><i class="icon-user-follow"></i>گروه
                        های
                        مدیریتی</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.permissions.index')}}"><i
                                class="icon-user-following"></i>
                        مدیریت دسترسی ها</a>
                </li>
            @endcan
            @can('posts')
                <li class="nav-title">
                    مدیریت پست ها
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.posts.index') }}"><i class="icon-folder-alt"></i> لیست پست
                        ها</a>
                </li>
            @endcan
            @can('bestCustomers')
                <li class="nav-title">
                    مدیریت برترین مشتریان
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.bestCustomers.index') }}"><i class="icon-folder-alt"></i>لیست
                        برترین مشتریان</a>
                </li>
            @endcan
            @can('admins')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.admins.index')}}"><i class="icon-user-unfollow"></i> مدیران</a>
                </li>
            @endcan
            @can('slideshows')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.slideshow.index')}}"><i class="icon-user-unfollow"></i>
                        اسلایدشو</a>
                </li>
            @endcan
            @can('settings')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.getOptions') }}"><i class="icon-camera"></i> تنظیمات</a>
                </li>
            @endcan

            @can('shippings')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.shipping.index') }}"><i class="icon-truck"></i> روش های
                        ارسال</a>
                </li>
            @endcan
            @can('services')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.service.index') }}"><i class="icon-truck"></i> خدمات اضافی</a>
                </li>
            @endcan
        </ul>
    </nav>
</div>