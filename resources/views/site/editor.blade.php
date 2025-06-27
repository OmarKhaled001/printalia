<!DOCTYPE html>
<html lang="ar" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>المصمم</title>
    <meta name="description"
        content="{{ $settings::get('site_description', 'منصة يمنية متخصصة في تصميم وبيع المنتجات المطبوعة حسب الطلب') }}">
    <meta name="keywords"
        content="{{ $settings::get('site_keywords', 'Printalia, برنتاليا, تصميم منتجات, طباعة حسب الطلب, يمن') }}">

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ $settings::get('icon') ? asset('storage/app/public/' . $settings::get('icon')) : asset('assets/media/icon.png') }}" />

    <style>
        :root {
            --color-primary: rgb(63, 162, 46);
            --color-white: #ffffff;
            --color-black: #000000;
            --color-light: #F0F8F2;
            --color-dark: #1E3A1F;
            --color-text-dark: #264D29;
            --color-accent1: #1E3A1F;
            --color-accent2: #D7F4C2;
            --color-blue-shade: #feffc0;
            --color-link: #3A9230;
            --color-mabel: #E0F4E9;
            --color-fog: #DDF3E0;
            --color-pink-shade: #E9FBEA;
            --color-peach: #EAF8DD;
            --color-rose: #7A9F74;
            --color-chart1: #75C16D;
            --color-chart2: #C4F0B7;
            --color-body: #43594A;
            --color-gray-1: #6B7C6E;
            --color-gray-2: #99AFA1;
            --color-gray-3: #A5C0AA;
            --color-gray-4: #BBD3C3;
            --color-ship-gray: #3D4F42;
            --color-ghost: #D3E8D8;
            --color-mercury: #E7F4E8;

            --gradient-primary: linear-gradient(90deg, #F0F8F2 0%, rgba(240, 248, 242, 0) 70.31%);
            --gradient-blue: linear-gradient(145.92deg, rgb(63, 162, 46) 20.18%, #A4E8A0 76.9%);
            --gradient-accent: linear-gradient(180deg, #D7F4C2 0%, #F3FDF1 100%);
            --gradient-white: linear-gradient(266.3deg, rgba(240, 248, 242, 0) 7.84%, #F0F8F2 29.1%, rgba(240, 248, 242, 0) 64.32%);
            --gradient-dark: linear-gradient(180deg, #1E3A1F 0%, #2B4F2D 100%);

            --border-light: 1px solid #DCEDE2;
            --border-lighter: 1px solid #F0F8F2;
            --border-dark: 1px solid var(--color-ship-gray);
            --border-gray: 1px solid var(--color-gray-4);

            --transition: all 0.3s ease-in-out;
        }

        [data-theme="dark"] {
            --color-primary: #75C16D;
            --color-white: #1E3A1F;
            --color-black: #E7F4E8;
            --color-light: #2B4F2D;
            --color-dark: #D7F4C2;
            --color-text-dark: #D3E8D8;
            --color-accent1: #C4F0B7;
            --color-accent2: #1E3A1F;
            --color-body: #D3E8D8;
            --color-gray-1: #99AFA1;
            --color-gray-2: #6B7C6E;
            --color-gray-3: #3D4F42;
            --color-gray-4: #43594A;
        }

        * {
            box-sizing: border-box;
            transition: var(--transition);
        }

        body {
            direction: rtl;
            background-color: var(--color-light);
            color: var(--color-body);
            overflow: hidden;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
            height: 100%;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .toolbar {
            background-color: var(--color-white);
            border-bottom: var(--border-light);
            padding: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 10;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .toolbar button {
            flex-shrink: 0;
            height: 36px;
            width: 36px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--color-white);
            border: var(--border-light);
            color: var(--color-body);
        }

        .toolbar button:hover {
            background-color: var(--color-mabel);
        }

        .btn-outline-primary {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .btn-outline-success {
            border-color: var(--color-chart1);
            color: var(--color-chart1);
        }

        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-success {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .main-content-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            background-color: var(--color-white);
        }

        .canvas-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background-color: var(--color-light);
            position: relative;
            overflow: auto;
        }

        #canvas-wrapper {
            position: relative;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            transform-origin: center;
            transition: transform 0.2s ease;
        }

        .aspect-ratio-container {
            position: relative;
            width: 800px;
            height: 600px;
            background-color: var(--color-white);
            border: var(--border-light);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background-color: var(--color-white); */
        }

        .products-panel {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--color-white);
            border-top: var(--border-light);
            padding: 10px;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
            height: 45vh;
            /* تعديل: استخدام ارتفاع نسبي بدلاً من 400px الثابتة */
            z-index: 20;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            overflow: hidden;
            /* تعديل: إخفاء التمرير للسماح للعنصر الداخلي بالتحكم به */

            /* إضافة: تحويل اللوحة إلى حاوية Flex */
            display: flex;
            flex-direction: column;
        }

        .products-panel.show {
            transform: translateY(0);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: var(--border-light);
        }

        .panel-header h5 {
            margin: 0;
            font-weight: bold;
            font-size: 16px;
            color: var(--color-text-dark);
        }

        .panel-tabs {
            display: flex;
            border-bottom: var(--border-light);
            margin-bottom: 10px;
        }

        .panel-tab {
            padding: 6px 12px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            font-size: 14px;
            color: var(--color-gray-1);
        }

        .panel-tab.active {
            border-bottom: 2px solid var(--color-primary);
            color: var(--color-primary);
            font-weight: bold;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            gap: 8px;
            overflow-y: auto;
            /* تعديل: الشبكة هي التي ستقوم بالتمرير */
            height: 100%;
            /* تعديل: إزالة الارتفاع الثابت والسماح لها بملء المساحة */
        }

        .product-item {
            border: var(--border-light);
            border-radius: 5px;
            overflow: hidden;
            cursor: pointer;
            transition: var(--transition);
            background-color: var(--color-white);
        }

        .product-item:hover {
            border-color: var(--color-primary);
            box-shadow: 0 0 5px rgba(99, 199, 76, 0.3);
        }

        .product-item.selected {
            border: 2px solid var(--color-primary);
            background-color: var(--color-mabel);
        }

        .product-image {
            width: 100%;
            height: 50px;
            object-fit: contain;
            background-color: var(--color-light);
            border-bottom: var(--border-light);
        }

        .product-name {
            padding: 4px;
            font-size: 10px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--color-body);
        }

        .mobile-controls {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            gap: 5px;
            z-index: 30;
        }

        .mobile-controls .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .zoom-controls {
            position: absolute;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 30;
        }

        .zoom-controls button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: var(--border-light);
            color: var(--color-body);
        }

        .theme-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 30;
            width: 36px;
            height: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-white);
            border: var(--border-light);
            border-radius: 50%;
            cursor: pointer;
        }

        /* Desktop styles */
        @media (min-width: 992px) {
            .main-content-area {
                flex-direction: row;
            }

            .products-panel {
                position: relative;
                width: 280px;
                height: auto;
                /* يتم إعادة التعيين للشاشات الكبيرة */
                border-top: none;
                border-left: var(--border-light);
                box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);
                transform: none;
                padding: 15px;
                overflow: visible;
                /* إعادة التعيين للشاشات الكبيرة */
                display: block;
                /* إعادة التعيين للشاشات الكبيرة */
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                height: auto;
                /* يتم إعادة التعيين للشاشات الكبيرة */
                max-height: calc(100vh - 200px);
            }

            .mobile-controls {
                display: none;
            }

            .toolbar button {
                width: auto;
                height: 38px;
                padding: 0 10px;
            }

            .toolbar button i {
                margin-left: 5px;
            }

            .toolbar button span {
                display: inline;
                font-size: 14px;
            }

            .product-image {
                height: 70px;
            }

            .product-name {
                font-size: 12px;
            }

            .aspect-ratio-container {
                max-width: 90%;
                max-height: 90%;
            }
        }

        @media (max-width: 991px) {
            .aspect-ratio-container {
                width: 100%;
                height: 0;
                padding-bottom: 75%;
                /* 4:3 aspect ratio */
            }
        }

        .product-item {
            border: var(--border-light);
            border-radius: 5px;
            overflow: hidden;
            cursor: pointer;
            transition: var(--transition);
            background-color: var(--color-white);
        }

        .product-item:hover {
            border-color: var(--color-primary);
            box-shadow: 0 0 5px rgba(99, 199, 76, 0.3);
        }

        .product-item.selected {
            border: 2px solid var(--color-primary);
            background-color: var(--color-mabel);
        }

        .product-image {
            width: 100%;
            height: 50px;
            object-fit: contain;
            background-color: var(--color-light);
            border-bottom: var(--border-light);
        }

        .product-name {
            padding: 4px;
            font-size: 10px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--color-body);
        }

        .product-price {
            font-size: 9px;
            text-align: center;
            color: var(--color-primary);
            font-weight: bold;
        }

        .mobile-controls {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            gap: 5px;
            z-index: 30;
        }

        .mobile-controls .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .zoom-controls {
            position: absolute;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 30;
        }

        .zoom-controls button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: var(--border-light);
            color: var(--color-body);
        }

        .theme-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 30;
            width: 36px;
            height: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-white);
            border: var(--border-light);
            border-radius: 50%;
            cursor: pointer;
        }

        .profit-calculator {
            background-color: var(--color-mabel);
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            border: var(--border-light);
        }

        .profit-calculator p {
            margin: 5px 0;
            font-size: 12px;
        }

        /* Desktop styles */
        @media (min-width: 992px) {
            .main-content-area {
                flex-direction: row;
            }

            .products-panel {
                position: relative;
                width: 280px;
                height: auto;
                border-top: none;
                border-left: var(--border-light);
                box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);
                transform: none;
                padding: 15px;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                height: auto;
                max-height: calc(100vh - 200px);
            }

            .mobile-controls {
                display: none;
            }

            .toolbar button {
                width: auto;
                height: 38px;
                padding: 0 10px;
            }

            .toolbar button i {
                margin-left: 5px;
            }

            .toolbar button span {
                display: inline;
                font-size: 14px;
            }

            .product-image {
                height: 70px;
            }

            .product-name {
                font-size: 12px;
            }

            .product-price {
                font-size: 11px;
            }

            .aspect-ratio-container {
                max-width: 90%;
                max-height: 90%;
            }
        }

        @media (max-width: 991px) {
            .aspect-ratio-container {
                width: 100%;
                height: 0;
                padding-bottom: 75%;
                /* 4:3 aspect ratio */
            }
        }
    </style>

    <link rel="stylesheet" href="{{ url('dynamic-styles.css') }}">
</head>

<body>
    <div class="container-fluid">


        <div class="toolbar">
            <a class="btn btn-success btn-sm" href="{{ route('filament.designer.pages.dashboard') }}"
                title="لوحة التحكم">
                <i class="fas fa-tachometer-alt"></i>
                <span class="d-none d-lg-inline">لوحة التحكم</span>
            </a>
            <button class="btn btn-outline-primary btn-sm" onclick="triggerFileInput('imgUploader')" title="رفع صورة">
                <i class="fas fa-upload"></i>
                <span class="d-none d-lg-inline">صورة</span>
            </button>
            <button class="btn btn-outline-primary btn-sm" onclick="undo()" title="تراجع">
                <i class="fas fa-undo"></i>
                <span class="d-none d-lg-inline">تراجع</span>
            </button>
            <button class="btn btn-outline-primary btn-sm" onclick="redo()" title="إعادة">
                <i class="fas fa-redo"></i>
                <span class="d-none d-lg-inline">إعادة</span>
            </button>
            <button class="btn btn-outline-danger btn-sm" onclick="removeSelected()" title="حذف العنصر المحدد">
                <i class="fas fa-trash"></i>
                <span class="d-none d-lg-inline">حذف</span>
            </button>
            <button class="btn btn-primary btn-sm" onclick="openSaveModal()" title="حفظ التصميم">
                <i class="fas fa-save"></i>
                <span class="d-none d-lg-inline">حفظ</span>
            </button>
        </div>

        <div class="main-content-area flex-grow-1">
            <div class="canvas-container">
                <div id="canvas-wrapper">
                    <div class="aspect-ratio-container">
                        <canvas id="canvas"></canvas>
                    </div>
                </div>
                <div class="mobile-controls">
                    <button class="btn btn-sm btn-outline-primary" onclick="toggleProductsPanel()">
                        <i class="fas fa-box"></i>
                    </button>
                </div>
                <div class="zoom-controls">
                    <button onclick="zoomIn()">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button onclick="zoomOut()">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button onclick="resetZoom()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>

            <div class="products-panel" id="productsPanel">
                <div class="panel-header">
                    <h5>المنتجات</h5>
                    <button class="btn btn-sm btn-outline-secondary d-lg-none" onclick="toggleProductsPanel()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="panel-tabs">
                    <div class="panel-tab active" onclick="switchProductView('front')">الواجهة الأمامية</div>
                    <div class="panel-tab" onclick="switchProductView('back')">الواجهة الخلفية</div>
                </div>
                <div class="product-grid" id="frontProductsGrid">
                    @foreach ($products as $product)
                        <div class="product-item" data-product-id="{{ $product->id }}" data-side="front"
                            data-price="{{ $product->price }}"
                            onclick="loadProductMockup({{ $product->id }}, 'front')">
                            <img src="{{ asset('storage/app/public/' . $product->image_front) }}"
                                class="product-image" alt="{{ $product->name }}">
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-price">{{ number_format($product->price, 2) }} ر.س</div>
                        </div>
                    @endforeach
                </div>
                <div class="product-grid d-none" id="backProductsGrid">
                    @foreach ($products as $product)
                        @if ($product->is_double_sided && $product->image_back)
                            <div class="product-item" data-product-id="{{ $product->id }}" data-side="back"
                                data-price="{{ $product->price }}"
                                onclick="loadProductMockup({{ $product->id }}, 'back')">
                                <img src="{{ asset('storage/app/public/' . $product->image_back) }}"
                                    class="product-image" alt="{{ $product->name }}">
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-price">{{ number_format($product->price, 2) }} ر.س</div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>

        <input type="file" id="imgUploader" accept="image/*" style="display: none" />
    </div>

    <!-- Save Design Modal -->
    <!-- Save Design Modal -->
    <div class="modal fade" id="saveDesignModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حفظ التصميم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saveDesignForm" method="POST" action="{{ route('designs.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="designTitle" class="form-label">عنوان التصميم</label>
                            <input type="text" class="form-control" id="designTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="designDescription" class="form-label">وصف التصميم</label>
                            <textarea class="form-control" id="designDescription" name="description" rows="3"></textarea>
                        </div>

                        <div class="profit-calculator">
                            <p>سعر المنتج: <span id="productPriceSpan">0.00</span> ر.س</p>
                            <div class="mb-3">
                                <label class="form-label">سعر البيع</label>
                                <input type="number" class="form-control" id="salePriceInput" name="sale_price"
                                    step="0.01" min="0" required>
                            </div>
                            <p>هامش الربح: <span id="profitSpan">0.00</span> ر.س</p>
                        </div>


                        <input type="hidden" id="designProductId" name="product_id">
                        <input type="hidden" id="designSide" name="side">

                        <!-- ملفات الصور -->
                        <input type="file" id="imageFrontFile" name="image_front" style="display: none;">
                        <input type="file" id="imageBackFile" name="image_back" style="display: none;">
                        <input type="file" id="logoFrontFile" name="logo_front" style="display: none;">
                        <input type="file" id="logoBackFile" name="logo_back" style="display: none;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-success">حفظ التصميم</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Fabric.js Canvas
        const canvas = new fabric.Canvas("canvas", {
            preserveObjectStacking: true,
            width: 800,
            height: 600
        });

        // Zoom level management
        let zoomLevel = 1;
        const minZoom = 0.2;
        const maxZoom = 3;
        const zoomStep = 0.1;
        const canvasWrapper = document.getElementById('canvas-wrapper');
        const aspectContainer = document.querySelector('.aspect-ratio-container');

        // Undo/Redo functionality
        let history = [];
        let historyIndex = -1;

        // قائمة المنتجات من Blade
        const products = @json($products);

        // تحميل المنتجات عند بدء التشغيل
        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
            setupCanvasResizeObserver();
            saveState(); // Save initial state

            // إضافة حدث لتغيير حجم الشاشة
            window.addEventListener('resize', centerCanvas);

            // Center canvas initially
            centerCanvas();
        });

        // Save canvas state to history
        function saveState() {
            // If we're not at the end of history, remove future states
            if (historyIndex < history.length - 1) {
                history = history.slice(0, historyIndex + 1);
            }

            const json = JSON.stringify(canvas.toJSON());
            history.push(json);
            historyIndex = history.length - 1;
        }

        // Undo last action
        function undo() {
            if (historyIndex > 0) {
                historyIndex--;
                loadState(history[historyIndex]);
            }
        }

        // Redo last undone action
        function redo() {
            if (historyIndex < history.length - 1) {
                historyIndex++;
                loadState(history[historyIndex]);
            }
        }

        // Load canvas state from history
        function loadState(jsonState) {
            canvas.loadFromJSON(jsonState, function() {
                canvas.renderAll();
            });
        }

        // Setup canvas event listeners for undo/redo
        function setupCanvasEvents() {
            canvas.on({
                'object:added': saveState,
                'object:modified': saveState,
                'object:removed': saveState
            });
        }

        // مراقبة تغيير حجم الحاوية
        function setupCanvasResizeObserver() {
            const resizeObserver = new ResizeObserver(entries => {
                centerCanvas();
            });

            resizeObserver.observe(document.querySelector('.canvas-container'));
        }

        // توسيط الكانفس في الحاوية
        function centerCanvas() {
            const container = document.querySelector('.canvas-container');
            const wrapper = document.getElementById('canvas-wrapper');

            const containerWidth = container.clientWidth;
            const containerHeight = container.clientHeight;

            // حساب الحجم المتاح مع مراعاة مستوى التكبير
            const availableWidth = containerWidth * zoomLevel;
            const availableHeight = containerHeight * zoomLevel;

            // توسيط العنصر
            wrapper.style.transform = `scale(${zoomLevel})`;
            wrapper.style.marginLeft = 'auto';
            wrapper.style.marginRight = 'auto';
        }

        // التكبير
        function zoomIn() {
            if (zoomLevel < maxZoom) {
                zoomLevel += zoomStep;
                applyZoom();
            }
        }

        // التصغير
        function zoomOut() {
            if (zoomLevel > minZoom) {
                zoomLevel -= zoomStep;
                applyZoom();
            }
        }

        // إعادة ضبط التكبير
        function resetZoom() {
            zoomLevel = 1;
            applyZoom();
        }

        // تطبيق مستوى التكبير
        function applyZoom() {
            canvasWrapper.style.transform = `scale(${zoomLevel})`;
            canvasWrapper.style.transformOrigin = 'center';
            centerCanvas();
        }



        // تبديل عرض الواجهة الأمامية/الخلفية
        function switchProductView(side) {
            const frontTab = document.querySelector('.panel-tab[onclick="switchProductView(\'front\')"]');
            const backTab = document.querySelector('.panel-tab[onclick="switchProductView(\'back\')"]');
            const frontGrid = document.getElementById('frontProductsGrid');
            const backGrid = document.getElementById('backProductsGrid');

            if (side === 'front') {
                frontTab.classList.add('active');
                backTab.classList.remove('active');
                frontGrid.classList.remove('d-none');
                backGrid.classList.add('d-none');
            } else {
                frontTab.classList.remove('active');
                backTab.classList.add('active');
                frontGrid.classList.add('d-none');
                backGrid.classList.remove('d-none');
            }
        }

        // تحميل صورة المنتج كخلفية للتصميم
        function loadProductMockup(productId, side) {
            // إزالة التحديد من جميع العناصر
            document.querySelectorAll('.product-item').forEach(item => {
                item.classList.remove('selected');
            });

            // تحديد العنصر المحدد
            document.querySelectorAll(`.product-item[data-product-id="${productId}"][data-side="${side}"]`).forEach(
                item => {
                    item.classList.add('selected');
                });

            // العثور على المنتج في المصفوفة
            const product = products.find(p => p.id == productId);
            if (!product) return;

            const imageUrl = side === 'front' ?
                "{{ asset('storage/app/public/') }}/" + product.image_front :
                "{{ asset('storage/app/public/') }}/" + product.image_back;

            fabric.Image.fromURL(imageUrl, function(img) {
                // قياس الصورة لتناسب الكانفس مع الحفاظ على النسبة
                const scaleFactor = Math.min(
                    canvas.width / img.width, canvas.height / img.height
                );

                img.set({
                    scaleX: scaleFactor,
                    scaleY: scaleFactor,
                    left: canvas.width / 2,
                    top: canvas.height / 2,
                    originX: 'center',
                    originY: 'center'
                });

                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                    scaleX: img.scaleX,
                    scaleY: img.scaleY,
                });

                saveState(); // Save state after background change

                // إغلاق لوحة المنتجات على الهاتف بعد الاختيار
                if (window.innerWidth < 992) {
                    toggleProductsPanel();
                }
            });
        }

        // تبديل عرض لوحة المنتجات على الهاتف
        function toggleProductsPanel() {
            const productsPanel = document.getElementById("productsPanel");
            productsPanel.classList.toggle("show");
        }

        // فتح نموذج الحفظ
        function openSaveModal() {
            const selectedProductItem = document.querySelector('.product-item.selected');
            if (!selectedProductItem) {
                alert('الرجاء اختيار منتج أولاً');
                return;
            }

            const productId = selectedProductItem.dataset.productId;
            const side = selectedProductItem.dataset.side;
            const productPrice = parseFloat(selectedProductItem.dataset.price);

            // تعبئة بيانات المنتج في النموذج
            document.getElementById('designProductId').value = productId;
            document.getElementById('designSide').value = side;
            document.getElementById('productPriceSpan').textContent = productPrice.toFixed(2);

            // إعداد مستمع لسعر البيع لحساب الربح
            document.getElementById('salePriceInput').addEventListener('input', function() {
                const salePrice = parseFloat(this.value) || 0;
                const profit = salePrice - productPrice;
                document.getElementById('profitSpan').textContent = profit.toFixed(2);
            });

            // إنشاء الصور للتصميم
            generateDesignImages(side);

            // فتح النموذج
            const modal = new bootstrap.Modal(document.getElementById('saveDesignModal'));
            modal.show();
        }

        // إنشاء صور التصميم للحفظ
        function generateDesignImages(side) {
            // 1. حفظ صورة الموكب فقط (الخلفية بدون التصميم)
            const currentBg = canvas.backgroundImage;
            const objects = canvas.getObjects();

            // إخفاء جميع العناصر مؤقتاً لالتقاط صورة الخلفية فقط
            canvas.forEachObject(obj => obj.visible = false);
            canvas.renderAll();

            // الحصول على صورة الخلفية فقط
            const mockupDataURL = canvas.toDataURL({
                format: "png",
                multiplier: 1
            });

            // 2. حفظ صورة التصميم فقط (الشعارات بدون الخلفية)
            canvas.setBackgroundImage(null, () => {
                canvas.forEachObject(obj => obj.visible = true);
                canvas.renderAll();

                const designDataURL = canvas.toDataURL({
                    format: "png",
                    multiplier: 1
                });

                // 3. حفظ الصورة المدمجة (الخلفية + التصميم)
                canvas.setBackgroundImage(currentBg, () => {
                    canvas.forEachObject(obj => obj.visible = true);
                    canvas.renderAll();

                    const mergedDataURL = canvas.toDataURL({
                        format: "png",
                        multiplier: 1
                    });

                    // تحويل البيانات إلى ملفات
                    function dataURLtoFile(dataurl, filename) {
                        const arr = dataurl.split(',');
                        const mime = arr[0].match(/:(.*?);/)[1];
                        const bstr = atob(arr[1]);
                        let n = bstr.length;
                        const u8arr = new Uint8Array(n);
                        while (n--) {
                            u8arr[n] = bstr.charCodeAt(n);
                        }
                        return new File([u8arr], filename, {
                            type: mime
                        });
                    }

                    if (side === 'front') {
                        // صورة الموكب فقط -> image_front
                        const mockupFile = dataURLtoFile(mockupDataURL, 'mockup_front.png');
                        // صورة التصميم فقط -> logo_front
                        const designFile = dataURLtoFile(designDataURL, 'design_front.png');
                        // الصورة المدمجة -> image_front (تستبدل صورة الموكب)
                        const mergedFile = dataURLtoFile(mergedDataURL, 'merged_front.png');

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(mergedFile);
                        document.getElementById('imageFrontFile').files = dataTransfer.files;

                        const logoTransfer = new DataTransfer();
                        logoTransfer.items.add(designFile);
                        document.getElementById('logoFrontFile').files = logoTransfer.files;
                    } else {
                        // نفس الخطوات للواجهة الخلفية
                        const mockupFile = dataURLtoFile(mockupDataURL, 'mockup_back.png');
                        const designFile = dataURLtoFile(designDataURL, 'design_back.png');
                        const mergedFile = dataURLtoFile(mergedDataURL, 'merged_back.png');

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(mergedFile);
                        document.getElementById('imageBackFile').files = dataTransfer.files;

                        const logoTransfer = new DataTransfer();
                        logoTransfer.items.add(designFile);
                        document.getElementById('logoBackFile').files = logoTransfer.files;
                    }
                });
            });
        }

        // إعداد مستمعي الأحداث
        function setupEventListeners() {
            // مستمعي حدث تحميل الصور
            document.getElementById("imgUploader").addEventListener("change", handleImageUpload);

            // تفاعل التمرير للتكبير/التصغير
            document.querySelector('.canvas-container').addEventListener('wheel', function(e) {
                if (e.ctrlKey) {
                    e.preventDefault();
                    if (e.deltaY < 0) {
                        zoomIn();
                    } else {
                        zoomOut();
                    }
                }
            });

            // Setup canvas events for undo/redo
            setupCanvasEvents();
        }

        // معالجة تحميل الصور
        function handleImageUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(f) {
                fabric.Image.fromURL(f.target.result, function(img) {
                    // حساب مقياس مناسب بناءً على حجم الكانفس
                    const scale = 0.2;

                    img.set({
                        left: canvas.width / 2,
                        top: canvas.height / 2,
                        scaleX: scale,
                        scaleY: scale,
                        originX: 'center',
                        originY: 'center'
                    });
                    canvas.add(img);
                    canvas.setActiveObject(img);
                    canvas.renderAll();

                    saveState(); // Save state after adding image
                });
            };
            reader.readAsDataURL(file);
        }

        // إزالة العنصر المحدد
        function removeSelected() {
            const active = canvas.getActiveObject();
            if (active) {
                canvas.remove(active);
                saveState(); // Save state after removal
            }
        }

        // تشغيل مدخل الملف
        function triggerFileInput(id) {
            document.getElementById(id).click();
        }
    </script>
</body>

</html>
