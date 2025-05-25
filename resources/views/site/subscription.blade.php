<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Printalia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <meta name="description" content="Printalia هي منصة يمنية تتيح للمصممين تحويل تصاميمهم إلى منتجات مثل التيشيرتات والأكواب وبيعها بسهولة دون الحاجة لرأس مال، مع ربط مباشر بالمصانع." />
    <meta name="keywords" content="Printalia, منصة تصميم, طباعة عند الطلب, بيع تصاميم, موكابس, اليمن, مصممين مبتدئين, تصميم منتجات, تجارة إلكترونية, POD اليمن" />
    <meta name="author" content="Printalia Team" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="ar" />
    <meta name="theme-color" content="#FF5722" />

    <meta property="og:title" content="Printalia" />
    <meta property="og:description" content="حوّل تصاميمك إلى منتجات قابلة للبيع بسهولة، وابدأ مشروعك دون رأس مال عبر منصة Printalia اليمنية." />
    <meta property="og:image" content="https://example.com/assets/media/og-image.jpg" />
    <meta property="og:url" content="https://example.com" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="ar_YE" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Printalia" />
    <meta name="twitter:description" content="منصة يمنية لتحويل التصاميم إلى منتجات قابلة للبيع مع ربط بالمصانع ونظام موكابس سهل للمصممين المبتدئين." />
    <meta name="twitter:image" content="https://example.com/assets/media/og-image.jpg" />
    <meta name="twitter:site" content="@Printalia" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/media/icon.png" />
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.rtl.min.css" />
    <link rel="stylesheet" href="assets/css/vendor/font-awesome.css" />
    <link rel="stylesheet" href="assets/css/vendor/slick.css" />
    <link rel="stylesheet" href="assets/css/vendor/slick-theme.css" />
    <link rel="stylesheet" href="assets/css/vendor/sal.css" />
    <link rel="stylesheet" href="assets/css/vendor/magnific-popup.css" />
    <link rel="stylesheet" href="assets/css/vendor/green-audio-player.min.css" />
    <link rel="stylesheet" href="assets/css/vendor/odometer-theme-default.css" />

    <link rel="stylesheet" href="assets/css/app.css" />
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

        /* Adjustments for content fitting */
        html,
        body {
            height: 100%;
            /* Ensure html and body take full height */
            margin: 0;
            /* Remove default body margin */
            padding: 0;
            /* Remove default body padding */
            overflow-x: hidden;
            /* Prevent horizontal scroll */
        }

        #main-wrapper {
            min-height: 100vh;
            /* Ensure main-wrapper takes at least the full viewport height */
            display: flex;
            flex-direction: column;
        }

        .onepage-screen-area {
            flex-grow: 1;
            /* Allow the content area to grow and fill available space */
            display: flex;
            align-items: center;
            /* Center content vertically */
            justify-content: center;
            /* Center content horizontally */
            padding: 20px 0;
            /* Add some vertical padding instead of large fixed margins */
        }

        .error-page .container {
            flex-grow: 0;
            /* Prevent the container from growing excessively */
            padding: 0;
            /* Remove default container padding if any is causing issues */
        }

        .error-page .row {
            align-items: center;
            /* Ensure vertical alignment of columns */
            margin: 0;
            /* Remove row margins */
            width: 100%;
            /* Ensure row takes full width */
            justify-content: center;
            /* Center content horizontally in the row */
        }

        .error-page .content,
        .error-page .thumbnail {
            padding: 20px;
            /* Add some padding to the content and thumbnail for spacing */
        }

        /* Override the .m-0 class on #main-wrapper as it might interfere */
        .main-wrapper.m-0 {
            margin: 0 !important;
        }

    </style>
</head>

<body class="h-100">
    <div id="main-wrapper" class="main-wrapper m-0">


        <section class="error-page onepage-screen-area">
            <div class="container">
                <div class="row align-items-center py-5 px-2">
                    <div class="col-lg-6">
                        <div class="content" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                            <h2 class="title">مرحبا {{ explode(' ', auth('designer')->user()->name)[0] }}</h2>
                            <h4 class="title"> انت غير مشترك الان! </h4>
                            <h5> فعليك الاشتراك من جديد او تجديد اشتراكك </h5>
                            <a href="{{ route('home') }}" class="axil-btn btn-fill-primary">الرئيسية</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="thumbnail" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="400">
                            <img src="{{ asset('assets') }}/media/others/subscription.png" alt="404">
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



    </div>

    <script src="{{ asset('assets') }}/js/vendor/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/isotope.pkgd.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/odometer.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/jquery-appear.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/slick.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/sal.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/js.cookie.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/jquery.style.switcher.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/jquery.countdown.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/tilt.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/green-audio-player.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/jquery.nav.js"></script>

    <script src="{{ asset('assets') }}/js/app.js"></script>
</body>

</html>
