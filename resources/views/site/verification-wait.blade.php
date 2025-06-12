<!DOCTYPE html>
<html class="no-js" lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
    <link rel="shortcut icon" type="image/x-icon" href="{{ $settings::get('icon') ? asset('storage/app/public/' . $settings::get('icon')) : asset('assets/media/icon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/bootstrap.rtl.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/font-awesome.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/slick.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/slick-theme.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/sal.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/magnific-popup.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/green-audio-player.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/odometer-theme-default.css" />

    <link rel="stylesheet" href="{{ asset('assets') }}/css/app.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet" />
    <style>
        /* Apply border-box to all elements for consistent sizing */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        /* RTL direction and text alignment */
        * {
            direction: rtl;
            text-align: right;
        }

        /* Apply Cairo font to all non-icon elements */
        *:not(i):not(.fa):not([class*="fa-"]) {
            font-family: "Cairo", sans-serif !important;
        }

        /* Ensure html and body take full height and prevent horizontal overflow */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Main wrapper to ensure full height and contain content */
        #main-wrapper {
            min-height: 100vh;
            /* Takes at least the full viewport height */
            display: flex;
            /* Use flexbox for layout */
            flex-direction: column;
            /* Stack children vertically */
            overflow-y: auto;
            /* Allow vertical scrolling if content exceeds height */
            overflow-x: hidden;
            /* Prevent horizontal scrolling within main wrapper */
            -webkit-overflow-scrolling: touch;
            /* Smoother scrolling on iOS */
        }

        /* Section containing the main content, uses flex to center its content */
        .onepage-screen-area {
            flex-grow: 1;
            /* Allows this section to grow and fill available space */
            display: flex;
            /* Use flexbox for content centering */
            align-items: center;
            /* Center content vertically */
            justify-content: center;
            /* Center content horizontally */
            padding: 20px 0;
            /* Add vertical padding around the content */
        }

        /* Adjustments for the container within the error page */
        .error-page .container {
            flex-grow: 0;
            /* Prevent the container from expanding unnecessarily */
            padding: 0;
            /* Remove default padding from container */
            width: 100%;
            /* Ensure container takes full width */
        }

        /* Adjustments for the row within the error page */
        .error-page .row {
            align-items: center;
            /* Vertically align items in the row */
            margin: 0;
            /* Remove default row margins */
            width: 100%;
            /* Ensure row takes full width */
            justify-content: center;
            /* Center content horizontally in the row */
        }

        /* Padding for content and thumbnail sections */
        .error-page .content,
        .error-page .thumbnail {
            padding: 15px;
            /* Add some padding for internal spacing */
        }

        /* Ensure images scale down responsibly */
        img {
            max-width: 100%;
            height: auto;
            display: block;
            /* Removes extra space below images */
        }

        /* Override specific Bootstrap .m-0 on #main-wrapper to ensure no margins */
        .main-wrapper.m-0 {
            margin: 0 !important;
        }

        /* Media queries for fine-tuning on smaller devices */
        @media (max-width: 768px) {
            .error-page .title {
                font-size: 1.8rem;
                /* Adjust title size for tablets */
            }

            .error-page h4 {
                font-size: 1.3rem;
            }

            .error-page h5 {
                font-size: 1.1rem;
            }

            /* Adjust padding on the row for medium screens */
            .row.p-sm-5 {
                padding: 2rem !important;
                /* Reduce overall padding for tablets */
            }
        }

        @media (max-width: 576px) {
            .error-page .title {
                font-size: 1.5rem;
                /* Further adjust title size for phones */
            }

            .error-page h4 {
                font-size: 1.1rem;
            }

            .error-page h5 {
                font-size: 0.9rem;
            }

            /* Adjust padding on the row for very small screens */
            .row.p-3 {
                padding: 1rem !important;
                /* Minimum padding for mobile */
            }

            /* Stack columns on extra small devices */
            .error-page .col-lg-6 {
                margin-bottom: 20px;
                /* Add space between stacked columns */
            }

            .error-page .col-lg-6:last-child {
                margin-bottom: 0;
                /* No margin after the last stacked column */
            }
        }

    </style>
</head>

<body class="onepage-template">
    <a href="#main-wrapper" id="backto-top" class="back-to-top">
        <i class="far fa-angle-double-up"></i>
    </a>

    <div id="preloader"></div>
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

    <div class="op-case-modal op-modal-wrap">
        <div class="op-modal-inner">
            <button class="close"><i class="far fa-times"></i></button>
            <div class="op-modal-content">
                <div class="case-content"></div>
            </div>
        </div>
    </div>
    <div class="op-portfolio-modal op-modal-wrap">
        <div class="op-modal-inner">
            <button class="close"><i class="far fa-times"></i></button>
            <div class="op-modal-content">
                <div class="portfolio-thumbnail"></div>
                <div class="portfolio-content"></div>
            </div>
        </div>
    </div>
    <div class="op-blog-modal op-modal-wrap">
        <div class="op-modal-inner">
            <button class="close"><i class="far fa-times"></i></button>
            <div class="op-modal-content">
                <div class="post-thumbnail"></div>
                <div class="post-content"></div>
            </div>
        </div>
    </div>
    <div id="main-wrapper" class="main-wrapper m-0">


        <section class="error-page onepage-screen-area">
            <div class="container">
                <div class="row align-items-center p-sm-5 p-3">
                    <div class="col-lg-6">
                        <div class="content" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                            <h2 class="title">مرحبا {{ explode(' ', auth('designer')->user()->name)[0] }}</h2>
                            <h4>جاري التحقق من اشتراكك</h4>
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
