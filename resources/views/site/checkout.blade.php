<!DOCTYPE html>
<html class="no-js" lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Printalia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="shortcut icon" type="image/x-icon" href="{{ $settings::get('icon') ? asset('storage/' . $settings::get('icon')) : asset('assets/media/icon.png') }}" />
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

        * {
            direction: rtl;
            text-align: right;
        }

        *:not(i):not(.fa):not([class*="fa-"]) {
            font-family: "Cairo", sans-serif !important;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            /* Prevent horizontal scrolling on the body */
        }

        /* Ensure images scale down responsibly */
        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* Main content wrapper to handle overall page scrolling if content exceeds height */
        .main-wrapper {
            min-height: 100vh;
            /* Ensure it takes at least full viewport height */
            overflow-y: auto;
            /* Allow vertical scrolling */
            overflow-x: hidden;
            /* Prevent horizontal scrolling within the main wrapper */
            -webkit-overflow-scrolling: touch;
            /* Smoother scrolling on iOS */
        }

        /* Specific adjustments for the error-page content */
        .error-page .content,
        .error-page .thumbnail {
            padding: 10px;
            /* Add some padding on all sides for content */
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

            .py-lg-5 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
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
            .row.py-3 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
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


    <div id="main-wrapper" class="main-wrapper m-0">
        <section class="error-page onepage-screen-area">
            <div class="container">
                <div class="row align-items-center py-lg-5 py-3 px-2">
                    <div class="col-lg-6 ">
                        <div class="content" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                            <h4 class="fw-bold"> الاشتراك في باقة {{ $plan->name }} </h4>
                            <div class="monthly-pricing d-flex align-items-start gap-1 justify-content-start">
                                <h6 class="fw-bold text-dark"> حول مبلغ {{ $plan->price }} </h6>
                                <img class="duration" src="{{ asset('assets/media/Saudi_Riyal_Symbol.svg') }}" alt="ريال سعودي" style="width: 20px; height: auto;" />
                            </div>

                            <form method="POST" action="{{ route('designer.subscribe') }}" enctype="multipart/form-data" class="mt-3">
                                @csrf
                                <div class="form-group mt-2">
                                    <label for="bankSelector" class="fw-bold">اختر الحساب البنكي:</label>
                                    <select id="bankSelector" class="form-select" name="account_code">
                                        <option value=""> اختر</option>
                                        @foreach ($bankAccounts as $account)
                                        <option value="{{ $account->code }}" data-name="{{ $account->name }}">
                                            {{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <h6 class="fw-bold text-dark mt-2">على حساب <span id="selectedBankName" class="text-primary"></span> بكود <span id="selectedBankCode" class="text-success"></span></h6>

                                <div class="form-group mb-3"> <label for="receiptInput" class="form-label">صورة
                                        الوصل</label> <input type="file" class="form-control" name="receipt" id="receiptInput" accept="image/*" required>
                                </div>
                                <p class="text-danger small">تأكد من وضوح الايصال</p> <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button type="submit" class="btn axil-btn btn-fill-primary b-3">ارسال</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center align-items-center">
                        <div class="thumbnail text-center" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="400">
                            <img src="{{ asset('assets') }}/media/others/money.png" id="receiptPreview" alt="إيصال الدفع" style="max-width: 100%; padding: 5px;">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const receiptInput = document.getElementById('receiptInput');
            const receiptPreview = document.getElementById('receiptPreview');
            const defaultImageSrc = "{{ asset('assets') }}/media/others/money.png";
            const bankSelector = document.getElementById('bankSelector');
            const selectedBankName = document.getElementById('selectedBankName');
            const selectedBankCode = document.getElementById('selectedBankCode');

            receiptInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        receiptPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    receiptPreview.src = defaultImageSrc; // Reset to default if no file or invalid file
                }
            });

            bankSelector.addEventListener('change', function(event) {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const bankCode = selectedOption.value;
                const bankName = selectedOption.dataset.name || selectedOption.text;

                selectedBankCode.textContent = bankCode ? bankCode : '...';
                selectedBankName.textContent = (bankCode && bankName !== ' اختر') ? bankName : '...';
            });

            // Initialize bank code and name display on page load if an option is pre-selected
            if (bankSelector.value) {
                bankSelector.dispatchEvent(new Event('change'));
            } else {
                // Set initial placeholder if no option is selected
                selectedBankCode.textContent = '...';
                selectedBankName.textContent = '...';
            }
        });

    </script>

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
