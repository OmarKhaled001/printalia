<!DOCTYPE html>
<html class="no-js" lang="ar">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $settings::get('site_title', 'Printalia - منصة التصميم والطباعة حسب الطلب') }}</title>
    <meta name="description" content="{{ $settings::get('site_description', 'منصة يمنية متخصصة في تصميم وبيع المنتجات المطبوعة حسب الطلب') }}">
    <meta name="keywords" content="{{ $settings::get('site_keywords', 'Printalia, برنتاليا, تصميم منتجات, طباعة حسب الطلب, يمن') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Open Graph / Facebook Meta Tags (لتحسين المشاركة على السوشيال ميديا) -->
    <meta property="og:title" content="{{ $settings::get('site_title', 'Printalia') }}">
    <meta property="og:description" content="{{ $settings::get('site_description', 'منصة التصميم والطباعة حسب الطلب في اليمن') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo-social-share.png') }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $settings::get('site_title', 'Printalia') }}">
    <meta name="twitter:description" content="{{ $settings::get('site_description', 'منصة التصميم والطباعة حسب الطلب في اليمن') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ $settings::get('icon') ? asset('storage/app/public/' . $settings::get('icon')) : asset('assets/media/icon.png') }}" />
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
            text-align: right;
        }

        *:not(i):not(.fa):not([class*="fa-"]) {
            font-family: "Cairo", sans-serif !important;
        }

        /* تحسينات للجوال */
        body {
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .error-page {
            flex: 1;
            padding: 20px 0;
            position: relative;
        }

        .error-page .container {
            height: 100%;
        }

        .error-page .row {
            min-height: calc(100vh - 200px);
            align-items: center;
        }

        .error-page .content {
            padding: 20px 0;
        }

        .error-page .thumbnail img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        @media (max-width: 992px) {
            .error-page .row {
                flex-direction: column-reverse;
                text-align: center;
            }

            .error-page .content {
                padding-top: 30px;
                text-align: center;
            }

            .error-page .thumbnail {
                margin-top: 30px;
                max-width: 80%;
                margin-left: auto;
                margin-right: auto;
            }

            .my_switcher {
                display: none !important;
            }
        }

        @media (max-width: 576px) {
            .error-page .content h2.title {
                font-size: 1.8rem;
            }

            .error-page .content h4.title {
                font-size: 1.4rem;
            }

            .error-page .content h5 {
                font-size: 1.1rem;
            }

            body {
                padding: 15px !important;
            }
        }

    </style>
</head>

<body class="onepage-template">
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

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

    <div id="main-wrapper" class="main-wrapper">
        <!--=====================================-->
        <!--=        Header Area Start       	=-->
        <!--=====================================-->

        <section class="error-page onepage-screen-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 order-lg-2">
                        <div class="content" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                            <h2 class="title">مرحبا {{ explode(' ', auth('designer')->user()->name)[0] }}</h2>
                            <h4 class="title"> انت غير مشترك الان! </h4>
                            <h5> فعليك الاشتراك من جديد او تجديد اشتراكك </h5>
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="thumbnail" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="400">
                            <img src="{{ asset('assets') }}/media/others/subscription.png" alt="404" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            <ul class="shape-group-8 list-unstyled">
                <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
                    <img src="{{ asset('assets') }}/media/others/bubble-9.png" alt="Bubble">
                </li>
                <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
                    <img src="{{ asset('assets') }}/media/others/bubble-27.png" alt="Bubble">
                </li>
                <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                    <img src="{{ asset('assets') }}/media/others/line-4.png" alt="Line">
                </li>
            </ul>
        </section>

        @include('site.sections.plans')
        @include('site.sections.footer')
    </div>

    @include('site.sections.script')
</body>
</html>
