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
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.categories.index')}}"><i class="icon-camrecorder"></i>دسته ها و
                    محصولات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.user.index')}}"><i class="icon-user"></i> مدیریت کاربران</a>
            </li>
            @can('مدیریت دسترسی ها')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.roles.index')}}"><i class="icon-user-follow"></i>گروه های
                        مدیریتی</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.permissions.index')}}"><i class="icon-user-following"></i>
                        مدیریت دسترسی ها</a>
                </li>
            @endcan

            <li class="nav-title">
                مدیریت پست ها
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.posts.index') }}"><i class="icon-folder-alt"></i> لیست پست
                    ها</a>
            </li>

            <li class="nav-title">
                مدیریت برترین مشتریان
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.bestCustomers.index') }}"><i class="icon-folder-alt"></i>لیست
                    برترین مشتریان</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.admins.index')}}"><i class="icon-user-unfollow"></i> مدیران</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.slideshow.index')}}"><i class="icon-user-unfollow"></i>
                    اسلایدشو</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="icon-camera"></i> تنظیمات</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.shipping.index') }}"><i class="icon-truck"></i> روش های ارسال</a>
            </li>
        </ul>
    </nav>
</div>