<!-- Header Section -->
<header class="header_s">
    <!-- SidePanel -->
    <div id="slidepanel-1" class="slidepanel">
        <!-- Top Header -->
        <div class="container-fluid no-right-padding no-left-padding top-header">
            <!-- Container -->
            <div class="container">
                <div class="top-left">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" title="Dribbble"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#" title="Vimeo"><i class="fa fa-vimeo"></i></a></li>
                        <li><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
                <div class="logo-block">
                    <a href="{{ route('client.index') }}" title="Logo"><img src="{{ asset('assets/images/logo.png') }}" width="230px" alt="Logo"/></a>
                </div>
                <div class="top-right">
                    <span><a href="javascript:void(0);" id="search" title="Search"><i class="pe-7s-search"></i></a></span>
                    <span>
                        @guest
                            <a href="{{ route('login') }}" title="Search"><i class="pe-7s-user"></i></a>
                        @endguest
                        @auth
                            <a href="#" title="Account"><i class="pe-7s-user"></i></a>
                            <a href="{{ route('logout') }}" title="Logout"><i class="pe-7s-close"></i></a>
                        @endauth
                    </span>
                </div>
                <!-- Search Box -->
                <div class="search-box search-block1">
                    <span><i class="icon_close"></i></span>
                    <form><input type="text" class="form-control" placeholder="Enter a keyword and press enter..." /></form>
                </div><!-- Search Box /- -->
            </div><!-- Container /- -->
        </div><!-- Top Header /- -->
    </div><!-- SidePanel /- -->

    <!-- Menu Block -->
    <div class="menu-block">
        <!-- Container -->
        <div class="container">
            <!-- Ownavigation -->
            <nav class="navbar ownavigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('client.index') }}"><img src="{{ asset('assets/images/logo.png') }}" width="230px" alt="Logo"/></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="{{ request()->routeIs('client.index*') ? 'active' : '' }}">
                            <a href="{{ route('client.index') }}" title="Home" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">Home</a>
                            <i class="ddl-switch fa fa-angle-down"></i>
                        </li>
                        @foreach($list_category as $category)
                            <li class="{{ request()->is("*/$category->slug") ? 'active' : '' }}">
                                <a href="{{ route('client.category.show', $category->slug) }}" title="{{ $category->name }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                        <li><a href="#" title="Contact Us">Contact</a></li>
                    </ul>
                </div>
                <div id="loginpanel-1" class="desktop-hide">
                    <div class="right toggle" id="toggle-1">
                        <a id="slideit-1" class="slideit" href="#slidepanel"><i class="fo-icons fa fa-inbox"></i></a>
                        <a id="closeit-1" class="closeit" href="#slidepanel"><i class="fo-icons fa fa-close"></i></a>
                    </div>
                </div>
            </nav><!-- Ownavigation /- -->
        </div><!-- Container /- -->
    </div><!-- Menu Block /- -->
</header><!-- Header Section /- -->
