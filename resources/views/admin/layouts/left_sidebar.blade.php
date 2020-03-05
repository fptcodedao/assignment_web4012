<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="{{ route('dashboard.index') }}"><img src="{{asset('assets/images/logo.svg')}}" width="25" alt="{{ config('app.name') }}"><span class="m-l-10">{{ config('app.name') }}</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="#"><img src="{{asset('assets/images/profile_av.jpg')}}" alt="User"></a>
                    <div class="detail">
                        <h4>{{ auth()->guard('admin')->user()->full_name }}</h4>
                        <small>{{ auth()->guard('admin')->user()->roles[0]->name }}</small>
                    </div>
                </div>
            </li>
            <li class="{{ request()->routeIs('dashboard.index*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ request()->routeIs('dashboard.posts*') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-apps"></i><span>Bài Đăng</span></a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('dashboard.posts.index') }}">Danh sách</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.posts.create') }}">Thêm bài đăng</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('dashboard.category*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.category.index') }}" class=""><i class="zmdi zmdi-assignment"></i><span>Quản lý danh mục</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('dashboard.comments*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.comments.index') }}" class=""><i class="zmdi zmdi-comments"></i><span>Quản lý phản hồi</span></a>
            </li>
            <li class="{{ request()->routeIs('dashboard.users*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.users.index') }}" class=""><i class="zmdi zmdi-account"></i><span>Quản lý người dùng</span></a>
            </li>
            <li>
                <a href="{{ route('dashboard.logout') }}" class=""><i class="zmdi zmdi-close"></i><span>Đăng xuất</span></a>
            </li>
        </ul>
    </div>
</aside>
