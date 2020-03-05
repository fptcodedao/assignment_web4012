<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="{{ str_replace('_', '-', app()->getLocale()) }}"><!--<![endif]-->
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Library - Google Font Familys -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Kristi|Oleo+Script:400,700" rel="stylesheet">

    <!-- Library -->
    <link href="{{ asset('assets/css/lib.css') }}" rel="stylesheet">

    <!-- Custom - Common CSS -->
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/elements.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/rtl.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <!--[if lt IE 9]>
        <script src="{{ asset('assets/js/html5/respond.min.js') }}"></script>
    <![endif]-->

</head>

<body data-offset="200" data-spy="scroll" data-target=".ownavigation">
<!-- Loader -->
<div id="site-loader" class="load-complete">
    <div class="loader">
        <div class="line-scale">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div><!-- Loader /- -->

@include('layouts.header')

<div class="main-container">

    <main class="site-main">

        <!-- Content Block -->
        <div class="container-fluid no-left-padding no-right-padding content-block {{ request()->routeIs('client.posts.show') ? 'blog-post' : 'blog-parallel' }}">
            <!-- Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <!-- Content Area -->
                    <div class="col-md-8 col-xs-6 content-area">
                        @yield('content')
                    </div><!-- Content Area /- -->
                    <!-- Widget Area -->
                    <div class="col-md-4 col-xs-6 widget-area">
                        <!-- Widget : Search -->
                        <aside class="widget widget_search">
                            <form method="get" class="searchform" action="#">
                                <div class="input-group">
                                    <input placeholder="Search..." class="form-control" required="" type="text"/>
                                    <span class="input-group-btn">
											<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
										</span>
                                </div>
                            </form>
                        </aside><!-- Widget : Search /- -->
                        <!-- Widget : About -->
                        <aside class="widget widget_about">
                            <div class="img-box">
                                <img src="https://graph.facebook.com/v6.0/1753463521/picture?width=500" alt="About" />
                            </div>
                            <h3>KhariDz.Dev</h3>
                            <p>Xin Chào, tôi là Khải là 1 website developer tương lai. Ước mơ trở thành full stack developer giỏi. Tận dụng các kỹ năng và kinh nghiệm cntt để giúp ích cho tương lai.
                            </p>
                            <ul>
                                <li><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#" title="Youtube"><i class="fa fa-youtube"></i></a></li>
                                <li><a href="#" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                            </ul>
                        </aside><!-- Widget : About /- -->
                        <!-- Widget : Post -->
                        <aside class="widget widget_post">
                            <div class="post-tabs">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#popular-post" aria-controls="popular-post" role="tab" data-toggle="tab">Popular Post</a></li>
                                    <li role="presentation"><a href="#recent-post" aria-controls="recent-post" role="tab" data-toggle="tab">recent post</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="popular-post">
                                        @include('client.components.posts.right_post', ['posts' => $post_high])
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="recent-post">
                                        @include('client.components.posts.right_post', ['posts' => $post_high])
                                    </div>
                                </div>
                            </div>
                        </aside><!-- Widget : Post /- -->
                    </div><!-- Widget Area -->
                </div><!-- Row /- -->
            </div><!-- Container /- -->
        </div><!-- Content Block /- -->
    </main>

</div>

<!-- Footer Main -->
<div class="container-fluid no-left-padding no-right-padding footer-main">
    <!-- Bottom Footer -->
    <div class="container-fluid no-left-padding no-right-padding bottom-footer">
        <!-- Container -->
        <div class="container">
            <div class="logo-block">
                <a href="#"><img src="{{asset('assets/images/logo.png')}}" width="230px" alt="Logo" /></a>
            </div>
            <div class="copyright">
                <p>Copyright © 2019 KhariDz.Dev</p>
            </div>
            <div class="ftr-social">
                <ul>
                    <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#" title="Dribbble"><i class="fa fa-dribbble"></i></a></li>
                    <li><a href="#" title="Vimeo"><i class="fa fa-vimeo"></i></a></li>
                    <li><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                </ul>
            </div>
        </div><!-- Container /- -->
    </div><!-- Bottom Footer /- -->
</div><!-- Footer Main /- -->

<!-- JQuery v1.12.4 -->
<script src="{{ asset('assets/js/jquery-1.12.4.min.js') }}"></script>

<!-- Library - Js -->
<script src="{{ asset('assets/js/lib.js') }}"></script>

<!-- Library - Theme JS -->
<script src="{{ asset('assets/js/functions.js') }}"></script>

</body>
</html>
