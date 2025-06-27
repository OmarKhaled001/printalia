<?php

// File: app/Http/Controllers/DynamicCssController.php
// --- Updated to include font size ---

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Setting;

class DynamicCssController extends Controller
{
    public function __invoke()
    {
        $primaryColor   = Setting::where('key', 'primary_color')->value('value') ?: 'rgb(63, 162, 46)';
        $secondaryColor = Setting::where('key', 'secondary_color')->value('value') ?: '#1E3A1F';
        $accentColor    = Setting::where('key', 'accent_color')->value('value') ?: '#D7F4C2';
        $linkColor      = Setting::where('key', 'link_color')->value('value') ?: $primaryColor;
        $bodyColor      = Setting::where('key', 'body_color')->value('value') ?: '#43594A';

        $fontPrimary    = Setting::where('key', 'font_family')->value('value') ?: 'Cairo';
        $fontSecondary  = Setting::where('key', 'font_secondary')->value('value') ?: 'Poppins';
        // --- NEW: Added font size setting ---
        $fontSize       = Setting::where('key', 'font_size')->value('value') ?: '16';


        // تجهيز Google Fonts import
        $googleImport = "@import url('https://fonts.googleapis.com/css2?family=" . urlencode($fontPrimary) . "&display=swap');\n";
        if ($fontPrimary !== $fontSecondary) {
            $googleImport .= "@import url('https://fonts.googleapis.com/css2?family=" . urlencode($fontSecondary) . "&display=swap');";
        }

        $css = <<<CSS
{$googleImport}

:root {
    --color-primary: {$primaryColor};
    --color-secondary: {$secondaryColor};
    --color-accent: {$accentColor};
    --color-link: {$linkColor};
    --color-body: {$bodyColor};
    --color-dark: {$primaryColor};
    --font-primary: '{$fontPrimary}', sans-serif;
    --font-secondary: '{$fontSecondary}', sans-serif;
    /* --- NEW: CSS variable for font size --- */
    --font-size-base: {$fontSize}px;
}

body {
    font-family: var(--font-primary);
    color: var(--color-body);
    background-color: var(--color-accent);
    /* --- NEW: Applying the font size --- */
    font-size: var(--font-size-base);
}

a {
    color: var(--color-link);
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.bg-primary {
    background-color: var(--color-primary) !important;
}

.btn {
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    background-color: var(--color-primary);
    color: white;
    padding: 0.5rem 1rem;
    transition: var(--transition);
}

.btn:hover {
    background-color: var(--color-secondary);
}
CSS;

        return new Response($css, 200, ['Content-Type' => 'text/css']);
    }
}
