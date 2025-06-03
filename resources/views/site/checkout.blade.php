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
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/media/icon.png" />
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
        * {
            direction: rtl;
            text-align: right;
            box-sizing: border-box;
            /* Recommended for easier layout management */
        }

        *:not(i):not(.fa):not([class*="fa-"]) {
            font-family: "Cairo", sans-serif !important;
        }

        html {
            height: 100%;
        }

        body {
            min-height: 100vh;
            /* Changed from height: 100% to allow growth */
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            display: flex;
            /* Added to make body a flex container if #main-wrapper is its only child */
            flex-direction: column;
            /* Added */
        }

        #main-wrapper {
            flex-grow: 1;
            /* Allow main-wrapper to take available space if body is flex */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .onepage-screen-area {
            flex-grow: 1;
            display: flex;
            align-items: flex-start;
            /* Changed from center to flex-start for normal scroll */
            justify-content: center;
            padding: 20px 0;
            /* Keep vertical padding */
            width: 100%;
        }

        .error-page .container {
            /* flex-grow: 0; */
            /* This might not be necessary */
            padding-left: 15px;
            /* Restore default container padding or adjust as needed */
            padding-right: 15px;
            width: 100%;
            /* Ensure container takes full width */
        }

        .error-page .row {
            align-items: center;
            /* Keep for vertical alignment of columns if they are same height */
            /* margin: 0; */
            /* Bootstrap rows have negative margins, usually handled by container padding */
            width: 100%;
            justify-content: center;
        }

        .error-page .content,
        .error-page .thumbnail {
            padding: 15px;
            /* Adjusted padding */
            width: 100%;
            /* Ensure content and thumbnail take full width of their columns */
        }

        .error-page .thumbnail img#receiptPreview {
            max-width: 100%;
            height: auto;
            /* Ensures proportional scaling */
            max-height: 500px;
            /* Adjusted max-height, can be further tuned with media queries */
            display: block;
            margin: 0 auto;
        }


        /* Responsive adjustments */
        @media (max-width: 991.98px) {

            /* Medium devices (tablets, less than 992px) */
            .error-page .row {
                flex-direction: column-reverse;
                /* Stack thumbnail below content on tablets and mobiles */
            }

            .error-page .content,
            .error-page .thumbnail {
                text-align: center;
                /* Center content for stacked layout */
            }

            .monthly-pricing {
                justify-content: center !important;
                /* Center price */
            }
        }

        @media (max-width: 767.98px) {

            /* Small devices (landscape phones, less than 768px) */
            .error-page .content h4 {
                font-size: 1.5rem;
                /* Adjust font size for smaller screens */
            }

            .error-page .content h6 {
                font-size: 1rem;
            }

            .error-page .row {
                padding-top: 1rem;
                /* Reduced padding for small screens */
                padding-bottom: 1rem;
            }
        }

        @media (max-width: 575.98px) {

            /* Extra small devices (portrait phones, less than 576px) */
            .error-page .content h4 {
                font-size: 1.3rem;
            }

            .error-page .content h6 {
                font-size: 0.9rem;
            }

            .btn.axil-btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }

            .error-page .thumbnail img#receiptPreview {
                max-height: 350px;
                /* Further reduce image height for very small screens */
            }
        }

    </style>
</head>

<body class="h-100">
    <div id="main-wrapper" class="main-wrapper m-0">
        <section class="error-page onepage-screen-area">
            <div class="container">
                <div class="row align-items-center py-lg-5 py-3 px-2">
                    <div class="col-lg-6">
                        <div class="content" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                            <h4 class="fw-bold"> الاشتراك في باقة {{ $plan->name }} </h4>
                            <div class="monthly-pricing d-flex align-items-start gap-1 justify-content-start">
                                <h6 class="fw-bold text-dark"> حول مبلغ {{ $plan->price }} </h6>
                                <img class="duration" src="{{ asset('assets/media/Saudi_Riyal_Symbol.svg') }}" alt="ريال سعودي" style="width: 20px; height: auto;" />
                            </div>
                            <div class="form-group mt-2">
                                <label for="bankSelector" class="fw-bold">اختر الحساب البنكي:</label>
                                <select id="bankSelector" class="form-select">
                                    <option value=""> اختر</option>
                                    @foreach ($bankAccounts as $account)
                                    <option value="{{ $account->code }}" data-name="{{ $account->name }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <h6 class="fw-bold text-dark mt-2">على حساب <span id="selectedBankName" class="text-primary"></span> بكود <span id="selectedBankCode" class="text-success"></span></h6>

                            <form method="POST" action="{{ route('designer.subscribe') }}" enctype="multipart/form-data" class="mt-3">
                                @csrf
                                <div class="form-group mb-3"> <label for="receiptInput" class="form-label">صورة الوصل</label> <input type="file" class="form-control" name="receipt" id="receiptInput" accept="image/*" required>
                                </div>
                                <p class="text-danger small">تأكد من وضوح الايصال</p> <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button type="submit" class="btn axil-btn btn-fill-primary b-3">ارسال</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center align-items-center">
                        <div class="thumbnail text-center" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="400">
                            <img src="{{ asset('assets') }}/media/others/money.png" id="receiptPreview" alt="إيصال الدفع" style="max-width: 100%; padding: 5px;"> </div>
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
        document.getElementById('receiptInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewImage = document.getElementById('receiptPreview');
            const defaultImageSrc = "{{ asset('assets') }}/media/others/money.png"; // Store default image src

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.src = defaultImageSrc; // Reset to default if no file or invalid file
            }
        });

        document.getElementById('bankSelector').addEventListener('change', function(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            const bankCode = selectedOption.value;
            const bankName = selectedOption.dataset.name || selectedOption.text; // Get name from data-attribute or text

            document.getElementById('selectedBankCode').textContent = bankCode ? bankCode : '...';
            document.getElementById('selectedBankName').textContent = (bankCode && bankName !== ' اختر') ? bankName : '...';
        });
        // Initialize bank code display on page load if a bank is already selected (e.g. from old input)
        // document.getElementById('bankSelector').dispatchEvent(new Event('change')); // Uncomment if needed

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
