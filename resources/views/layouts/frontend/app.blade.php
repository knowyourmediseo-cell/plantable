<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <meta name="description" content="@yield('meta_description', 'Eco-friendly plantable products for sustainable living')">
    <meta name="keywords" content="@yield('meta_keywords', 'plantable, eco-friendly, sustainable, green products')">
    <meta name="author" content="{{ config('app.name') }}">

    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Eco-friendly plantable products')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('twitter_description', 'Eco-friendly plantable products')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-image.jpg'))">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- intl-tel-input v19 - has built-in search support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/css/intlTelInput.css">
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
    /* ==============================
       Phone Input - Theme Styling
       ============================== */

    /* The .iti wrapper fills its container */
    .iti {
        display: block !important;
        width: 100% !important;
    }

    /* Inside custom flex wrapper */
    div[style*="display: flex"] .iti {
        flex: 1 !important;
        min-width: 0 !important;
    }

    /* Flag container sits on LEFT of the tel input */
    .iti__flag-container {
        position: absolute !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        right: auto !important;
        z-index: 2 !important;
    }

    /* Selected flag button */
    .iti__selected-country {
        display: flex !important;
        align-items: center !important;
        height: 100% !important;
        padding: 0 10px !important;
        background: transparent !important;
        border: none !important;
        border-right: 1px solid #c8e6c9 !important;
        cursor: pointer !important;
        outline: none !important;
        gap: 6px !important;
    }
    .iti__selected-country:hover {
        background: rgba(46, 125, 50, 0.05) !important;
    }
    .iti__selected-country-primary {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
    }
    .iti__selected-dial-code {
        color: #1B4332 !important;
        font-weight: 500 !important;
        font-size: 14px !important;
    }
    .iti__arrow {
        border-top: 5px solid #2E7D32 !important;
        border-left: 4px solid transparent !important;
        border-right: 4px solid transparent !important;
        margin-left: 4px !important;
    }
    .iti__arrow--up {
        border-top: none !important;
        border-bottom: 5px solid #2E7D32 !important;
    }

    /* Tel input field padding - space for country selector */
    .iti input[type="tel"] {
        padding-left: 90px !important;
        width: 100% !important;
        border-left: none !important;
    }
    .iti input[type="tel"]:focus {
        border-color: #66BB6A !important;
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.2) !important;
        outline: none !important;
    }

    /* Dropdown container */
    .iti__dropdown-content {
        position: absolute !important;
        z-index: 999999 !important;
        background: white !important;
        border: 2px solid #c8e6c9 !important;
        border-radius: 10px !important;
        box-shadow: 0 8px 32px rgba(46, 125, 50, 0.18) !important;
        width: 360px !important;
        overflow: hidden !important;
        margin-top: 4px !important;
    }

    /* Built-in search box (v19) */
    .iti__search-input {
        width: 100% !important;
        padding: 12px 16px !important;
        border: none !important;
        border-bottom: 2px solid #e8f5e9 !important;
        font-size: 14px !important;
        outline: none !important;
        background: #f8fdf8 !important;
        box-sizing: border-box !important;
        border-radius: 8px 8px 0 0 !important;
    }
    .iti__search-input:focus {
        border-bottom-color: #2E7D32 !important;
        background: #fff !important;
    }
    .iti__search-input::placeholder {
        color: #a5b4a5 !important;
    }

    /* Country list scroll area */
    .iti__country-list {
        max-height: 250px !important;
        overflow-y: auto !important;
        list-style: none !important;
        padding: 4px 0 !important;
        margin: 0 !important;
    }

    /* Each country row */
    .iti__country {
        display: flex !important;
        align-items: center !important;
        padding: 10px 16px !important;
        cursor: pointer !important;
        transition: background 0.15s !important;
    }
    .iti__country.iti__highlight,
    .iti__country:hover {
        background: #e8f5e9 !important;
    }
    .iti__flag-box {
        flex-shrink: 0 !important;
    }
    .iti__country-name {
        margin-left: 10px !important;
        flex: 1 !important;
        color: #1B4332 !important;
        font-size: 14px !important;
    }
    .iti__dial-code {
        color: #2E7D32 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        margin-left: 8px !important;
    }
    .iti__divider {
        border-bottom: 1px solid #e8f5e9 !important;
        margin: 4px 0 !important;
        padding: 0 !important;
    }
    </style>

    @stack('styles')
</head>
<body class="font-inter antialiased">
    @include('layouts.frontend.partials.header')
    <main>
        @yield('content')
    </main>
    @include('layouts.frontend.partials.footer')

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 text-white p-3 rounded-full shadow-lg transition-all hidden z-50"
        style="background-color:#2E7D32; border:none; width:46px; height:46px; display:flex; align-items:center; justify-content:center;"
        onmouseover="this.style.background='#1B5E20'" onmouseout="this.style.background='#2E7D32'">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <!-- intl-tel-input v19 JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/js/intlTelInput.min.js"></script>
    @vite(['resources/js/app.js'])

    @stack('scripts')

    @if(session('success'))
        <script>
            if (typeof $ !== 'undefined') {
                $(document).ready(function() { showToast('{{ session('success') }}', 'success'); });
            }
        </script>
    @endif
    @if(session('error'))
        <script>
            if (typeof $ !== 'undefined') {
                $(document).ready(function() { showToast('{{ session('error') }}', 'error'); });
            }
        </script>
    @endif

    <script>
    // Toast notification
    function showToast(message, type) {
        type = type || 'success';
        var toast = document.createElement('div');
        toast.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger') + ' position-fixed top-0 end-0 m-3 fade show';
        toast.style.zIndex = '9999';
        toast.innerHTML = '<strong>' + (type === 'success' ? 'Success!' : 'Error!') + '</strong> ' + message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(toast);
        setTimeout(function() { toast.remove(); }, 3000);
    }
    window.Toast = {
        success: function(m) { showToast(m, 'success'); },
        error: function(m) { showToast(m, 'error'); }
    };

    // Phone input initialization with intl-tel-input v19
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.intlTelInput === 'undefined') return;

        document.querySelectorAll('input[type="tel"]').forEach(function(input) {
            // Skip already initialized
            if (input.closest('.iti')) return;

            intlTelInput(input, {
                initialCountry: "in",
                preferredCountries: ["in", "us", "gb", "ae", "ca", "au"],
                separateDialCode: true,
                countrySearch: true,
                formatOnDisplay: true,
                loadUtils: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/js/utils.js"
            });
        });
    });
    </script>
</body>
</html>
