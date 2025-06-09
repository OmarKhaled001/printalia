<!DOCTYPE html>
<html class="no-js" lang="ar">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{$settings::get('site_title', 'Printalia - منصة التصميم والطباعة حسب الطلب') }}</title>
    <meta name="description" content="{{$settings::get('site_description', 'منصة يمنية متخصصة في تصميم وبيع المنتجات المطبوعة حسب الطلب') }}">
    <meta name="keywords" content="{{$settings::get('site_keywords', 'Printalia, برنتاليا, تصميم منتجات, طباعة حسب الطلب, يمن') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Open Graph / Facebook Meta Tags (لتحسين المشاركة على السوشيال ميديا) -->
    <meta property="og:title" content="{{$settings::get('site_title', 'Printalia') }}">
    <meta property="og:description" content="{{$settings::get('site_description', 'منصة التصميم والطباعة حسب الطلب في اليمن') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo-social-share.png') }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$settings::get('site_title', 'Printalia') }}">
    <meta name="twitter:description" content="{{$settings::get('site_description', 'منصة التصميم والطباعة حسب الطلب في اليمن') }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{$settings::get('icon') ? asset('storage/' .$settings::get('icon')) : asset('assets/media/icon.png') }}" />
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

        *:not(i):not(.fa):not([class*="fa-"]) {
            font-family: "Cairo", sans-serif !important;
        }

    </style>
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


        @include('site.sections.header')
        @include('site.sections.hero')
        @include('site.sections.about-us')
        @include('site.sections.additional')
        @include('site.sections.plans')



        @include('site.sections.footer')
    </div>
    @include('site.sections.script')
</body>
</html>
