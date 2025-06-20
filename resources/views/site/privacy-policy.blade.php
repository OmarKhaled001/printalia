<!DOCTYPE html>
<html class="no-js" lang="ar">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $settings::get('site_title', 'Printalia - منصة التصميم والطباعة حسب الطلب') }}</title>
    <meta name="description"
        content="{{ $settings::get('site_description', 'منصة يمنية متخصصة في تصميم وبيع المنتجات المطبوعة حسب الطلب') }}">
    <meta name="keywords"
        content="{{ $settings::get('site_keywords', 'Printalia, برنتاليا, تصميم منتجات, طباعة حسب الطلب, يمن') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Open Graph / Facebook Meta Tags (لتحسين المشاركة على السوشيال ميديا) -->
    <meta property="og:title" content="{{ $settings::get('site_title', 'Printalia') }}">
    <meta property="og:description"
        content="{{ $settings::get('site_description', 'منصة التصميم والطباعة حسب الطلب في اليمن') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo-social-share.png') }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $settings::get('site_title', 'Printalia') }}">
    <meta name="twitter:description"
        content="{{ $settings::get('site_description', 'منصة التصميم والطباعة حسب الطلب في اليمن') }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ $settings::get('icon') ? asset('storage/app/public/' . $settings::get('icon')) : asset('assets/media/icon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/bootstrap.rtl.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/font-awesome.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/slick.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/slick-theme.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/sal.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/magnific-popup.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/green-audio-player.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/odometer-theme-default.css" />

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/app.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet" />
    <style>
        * {
            direction: rtl;
            /* text-align: right; */
        }
    </style>
    <!-- in resources/views/vendor/filament/layouts/app.blade.php -->

    <link rel="stylesheet" href="{{ url('dynamic-styles.css') }}">
</head>

<body class="sticky-header onepage-template">
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->
    <a href="#main-wrapper" id="backto-top" class="back-to-top">
        <i class="far fa-angle-double-up"></i>
    </a>

    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

    <div class="my_switcher d-none d-lg-block">
        <ul>
            <li title="Light Mode">
                <a href="javascript:void(0)" class="setColor light" data-theme="light">
                    <i class="fal fa-lightbulb-on"></i>
                </a>
            </li>
            <li title="Dark Mode">
                <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                    <i class="fas fa-moon"></i>
                </a>
            </li>
        </ul>
    </div>

    <!-- Case Study Modal Box -->
    <div class="op-case-modal op-modal-wrap">
        <div class="op-modal-inner">
            <button class="close"><i class="far fa-times"></i></button>
            <div class="op-modal-content">
                <div class="case-content"></div>
            </div>
        </div>
    </div>
    <!-- Case Study Modal Box -->

    <!-- Portfolio Modal Box -->
    <div class="op-portfolio-modal op-modal-wrap">
        <div class="op-modal-inner">
            <button class="close"><i class="far fa-times"></i></button>
            <div class="op-modal-content">
                <div class="portfolio-thumbnail"></div>
                <div class="portfolio-content"></div>
            </div>
        </div>
    </div>
    <!-- Portfolio Modal Box -->

    <!-- Blog Modal Box -->
    <div class="op-blog-modal op-modal-wrap">
        <div class="op-modal-inner">
            <button class="close"><i class="far fa-times"></i></button>
            <div class="op-modal-content">
                <div class="post-thumbnail"></div>
                <div class="post-content"></div>
            </div>
        </div>
    </div>
    <!-- Blog Modal Box -->

    <div id="main-wrapper" class="main-wrapper">

        <!--=====================================-->
        <!--=        Header Area Start       	=-->
        <!--=====================================-->
        <header class="header axil-header header-style-1">
            <div id="axil-sticky-placeholder"></div>
            <div class="axil-mainmenu">
                <div class="container">
                    <div class="header-navbar">
                        <div class="header-logo">
                            <a href="{{ route('home') }}"><img class="light-version-logo"
                                    src="{{ $settings::get('icon') ? asset('storage/app/public/' . $settings::get('logo')) : asset('assets/media/logo.png') }}"
                                    width="160px" alt="logo" /></a>
                            <a href="{{ route('home') }}"><img class="dark-version-logo"
                                    src="{{ $settings::get('icon') ? asset('storage/app/public/' . $settings::get('logo')) : asset('assets/media/logo.png') }}"
                                    width="160px" alt="logo" /></a>
                            <a href="{{ route('home') }}"><img class="sticky-logo"
                                    src="{{ $settings::get('icon') ? asset('storage/app/public/' . $settings::get('logo')) : asset('assets/media/logo.png') }}"
                                    width="160px" alt="logo" /></a>
                        </div>
                        <div class="header-main-nav">
                            <!-- Start Mainmanu Nav -->
                            <nav class="mainmenu-nav" id="mobilemenu-popup">
                                <div class="d-block d-lg-none">
                                    <div class="mobile-nav-header">
                                        <div class="mobile-nav-logo">
                                            <a href="{{ route('home') }}">
                                                <img class="light-mode"
                                                    src="{{ $settings::get('icon') ? asset('storage/app/public/' . $settings::get('logo')) : asset('assets/media/logo.png') }}"
                                                    width="160px" alt="Site Logo" />
                                                <img class="dark-mode"
                                                    src="{{ $settings::get('icon') ? asset('storage/app/public/' . $settings::get('logo')) : asset('assets/media/logo.png') }}"
                                                    width="160px" alt="Site Logo" />
                                            </a>
                                        </div>
                                        <button class="mobile-menu-close" data-bs-dismiss="offcanvas">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <ul class="mainmenu" id="onepagenav">
                                    <li>
                                        <a href="{{ route('home') }}#op-home">الرئيسية</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('home') }}#op-about">من نحن</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('home') }}#op-vision">رؤيتنا</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('home') }}#op-pricing">الاشتركات</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('privacy-policy') }}">سياستنا</a>
                                    </li>
                                    @if (Auth::guard('designer')->check())
                                        <li class="header-btn">
                                            <a href="{{ route('filament.designer.auth.login') }}"
                                                class="axil-btn btn-fill-primary">لوحة التحكم</a>
                                        </li>
                                    @else
                                        <li class="header-btn">
                                            <a href="{{ route('filament.designer.auth.login') }}"
                                                class="axil-btn btn-fill-primary">سجل الآن</a>
                                        </li>
                                    @endif

                            </nav>
                            <!-- End Mainmanu Nav -->
                        </div>
                        <div class="header-action">
                            <ul class="list-unstyled">
                                <li class="mobile-menu-btn sidemenu-btn d-lg-none d-block">
                                    <button class="btn-wrap" data-bs-toggle="offcanvas"
                                        data-bs-target="#mobilemenu-popup">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                </li>
                                <li class="my_switcher d-block d-lg-none mx-2">
                                    <ul>
                                        <li title="Light Mode">
                                            <a href="javascript:void(0)" class="setColor light" data-theme="light">
                                                <i class="fal fa-lightbulb-on"></i>
                                            </a>
                                        </li>
                                        <li title="Dark Mode">
                                            <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                                                <i class="fas fa-moon"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <!--=====================================-->
        <!--=       Breadcrumb Area Start       =-->
        <!--=====================================-->
        <div class="breadcrum-area">
            <div class="container">
                <div class="breadcrumb">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="active">سياستنا</li>
                    </ul>
                    <h1 class="title h2">سياستنا</h1>
                </div>
            </div>
            <ul class="shape-group-8 list-unstyled">
                <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
                    <img src="assets/media/others/bubble-9.png" alt="Bubble">
                </li>
                <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
                    <img src="assets/media/others/bubble-11.png" alt="Bubble">
                </li>
                <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                    <img src="assets/media/others/line-4.png" alt="Line">
                </li>
            </ul>
        </div>
        <!--=====================================-->
        <!--=    Privacy Policy Area Start      =-->
        <!--=====================================-->
        <section class="section-padding privacy-policy-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="privacy-policy-content">

                            <h4>
                                {{ $settings::get('platform_policy_title', 'سياسة المنصة') }}
                            </h4>
                            <p>
                                {{ $settings::get('platform_policy_description', 'نحن نلتزم بتقديم تجربة تسوق آمنة وموثوقة، ونحافظ على خصوصية المستخدمين وبياناتهم وفقًا لأعلى المعايير.') }}
                            </p>

                            <h4>
                                {{ $settings::get('shipping_policy_title', 'سياسة الشحن') }}
                            </h4>
                            <p>
                                {{ $settings::get('shipping_policy_description', 'نقوم بشحن الطلبات خلال 2-5 أيام عمل. تتوفر خدمة التوصيل إلى جميع المناطق، مع إمكانية تتبع الشحنة بعد الشحن.') }}
                            </p>

                            <h4>
                                {{ $settings::get('return_policy_title', 'سياسة الإرجاع') }}
                            </h4>
                            <p>
                                {{ $settings::get('return_policy_description', 'يحق للعملاء إرجاع المنتجات خلال 14 يومًا من تاريخ الاستلام بشرط أن تكون بحالتها الأصلية ومرفقة بالفاتورة.') }}
                            </p>



                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!--=====================================-->
        <!--=        Footer Area Start       	=-->
        <!--=====================================-->
        @include('site.sections.footer')



        <!--=====================================-->
        <!--=       Offcanvas Menu Area       	=-->

    </div>
    @include('site.sections.script')
</body>

</html>
