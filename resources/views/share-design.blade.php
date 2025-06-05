<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $design->title }} - تصميم</title>
    <meta property="og:title" content="{{ $design->title }}" />
    <meta property="og:description" content="{{ $design->description ?: 'تصميم فريد من نوعه.' }}" />
    <meta property="og:image" content="{{ $design->front_image_url }}" />
    <meta property="og:url" content="{{ request()->fullUrl() }}" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $design->title }}">
    <meta name="twitter:description" content="{{ $design->description ?: 'تصميم فريد من نوعه.' }}">
    <meta name="twitter:image" content="{{ $design->front_image_url }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
        }

        .design-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
        }

        .design-image {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .social-share-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-share-buttons a {
            font-size: 24px;
            color: #555;
            transition: color 0.3s ease;
        }

        .social-share-buttons a:hover {
            color: #007bff;
        }

        .social-share-buttons .facebook:hover {
            color: #3b5998;
        }

        .social-share-buttons .twitter:hover {
            color: #00acee;
        }

        .social-share-buttons .whatsapp:hover {
            color: #25D366;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="design-container">
        <h1>{{ $design->title }}</h1>
        @if ($design->description)
        <p>{{ $design->description }}</p>
        @endif

        @if ($design->front_image_url)
        <h3>الوجه الأمامي</h3>
        <img src="{{ $design->front_image_url }}" alt="Design Front" class="design-image">
        @endif

        @if ($design->back_image_url)
        <h3>الوجه الخلفي</h3>
        <img src="{{ $design->back_image_url }}" alt="Design Back" class="design-image">
        @endif

        <p><strong>سعر البيع:</strong> {{ number_format($design->sale_price, 2) }} جنيه</p>
        <p><strong>المصمم:</strong> {{ $design->designer->name ?? 'غير معروف' }}</p>

        <div class="social-share-buttons">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="facebook" title="مشاركة على فيسبوك">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($design->title . ' - تصميم رائع!') }}" target="_blank" class="twitter" title="مشاركة على تويتر">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://api.whatsapp.com/send?text={{ urlencode($design->title . ' - تصميم رائع! ' . request()->fullUrl()) }}" target="_blank" class="whatsapp" title="مشاركة عبر واتساب">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>
</body>
</html>
