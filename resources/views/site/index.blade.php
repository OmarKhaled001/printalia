<!DOCTYPE html>
<html class="no-js" lang="ar">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Printalia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- SEO Meta Tags -->
    <meta name="description" content="Printalia هي منصة يمنية تتيح للمصممين تحويل تصاميمهم إلى منتجات مثل التيشيرتات والأكواب وبيعها بسهولة دون الحاجة لرأس مال، مع ربط مباشر بالمصانع." />
    <meta name="keywords" content="Printalia, منصة تصميم, طباعة عند الطلب, بيع تصاميم, موكابس, اليمن, مصممين مبتدئين, تصميم منتجات, تجارة إلكترونية, POD اليمن" />
    <meta name="author" content="Printalia Team" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="ar" />
    <meta name="theme-color" content="#FF5722" />

    <!-- Open Graph Meta (Facebook & LinkedIn) -->
    <meta property="og:title" content="Printalia" />
    <meta property="og:description" content="حوّل تصاميمك إلى منتجات قابلة للبيع بسهولة، وابدأ مشروعك دون رأس مال عبر منصة Printalia اليمنية." />
    <meta property="og:image" content="https://example.com/assets/media/og-image.jpg" />
    <meta property="og:url" content="https://example.com" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="ar_YE" />

    <!-- Twitter Meta -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Printalia" />
    <meta name="twitter:description" content="منصة يمنية لتحويل التصاميم إلى منتجات قابلة للبيع مع ربط بالمصانع ونظام موكابس سهل للمصممين المبتدئين." />
    <meta name="twitter:image" content="https://example.com/assets/media/og-image.jpg" />
    <meta name="twitter:site" content="@Printalia" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/media/icon.png" />
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
        @include('site.sections.plans')



        @include('site.sections.footer')
    </div>
    @include('site.sections.script')
</body>
</html>
