<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{$settings::get('site_title', 'Printalia - منصة التصميم والطباعة حسب الطلب') }}</title>
    <meta name="description" content="{{$settings::get('site_description', 'منصة يمنية متخصصة في تصميم وبيع المنتجات المطبوعة حسب الطلب') }}">
    <meta name="keywords" content="{{$settings::get('site_keywords', 'Printalia, برنتاليا, تصميم منتجات, طباعة حسب الطلب, يمن') }}">

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
    <link rel="shortcut icon" type="image/x-icon" href="{{$settings::get('icon') ? asset('storage/app/public/' .$settings::get('icon')) : asset('assets/media/icon.png') }}" />
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
                <div class="row align-items-center p-5">
                    <div class="col-lg-6">
                        <div class="content" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                            <h2 class="title">جاري التحقق من حسابك</h2>
                            <a href="{{ route('home') }}" class="axil-btn btn-fill-primary">الرئيسية</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="thumbnail" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="400">
                            <img src="{{ asset('assets') }}/media/others/verification.png" alt="404">
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
