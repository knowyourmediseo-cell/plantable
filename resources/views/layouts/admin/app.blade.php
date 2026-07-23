<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/css/intlTelInput.css">
    @vite(['resources/css/admin.css'])
    @stack('styles')
    <style>
    /* Phone input - admin theme */
    .iti { display: block !important; width: 100% !important; }
    .iti__selected-country { display: flex !important; align-items: center !important; height: 100% !important; padding: 0 10px !important; background: #fff !important; border: none !important; border-right: 1px solid #dee2e6 !important; cursor: pointer !important; outline: none !important; gap: 6px !important; }
    .iti__selected-country:hover { background: #f8f9fa !important; }
    .iti__selected-dial-code { color: #495057 !important; font-weight: 500 !important; font-size: 14px !important; }
    .iti__arrow { border-top: 5px solid #6c757d !important; border-left: 4px solid transparent !important; border-right: 4px solid transparent !important; }
    .iti__arrow--up { border-top: none !important; border-bottom: 5px solid #6c757d !important; }
    .iti input[type="tel"] { padding-left: 90px !important; width: 100% !important; }
    .iti__dropdown-content { z-index: 999999 !important; background: white !important; border: 1px solid #dee2e6 !important; border-radius: 8px !important; box-shadow: 0 4px 20px rgba(0,0,0,.15) !important; width: 340px !important; overflow: hidden !important; }
    .iti__search-input { width: 100% !important; padding: 12px 16px !important; border: none !important; border-bottom: 1px solid #dee2e6 !important; font-size: 14px !important; outline: none !important; background: #f8f9fa !important; box-sizing: border-box !important; }
    .iti__search-input:focus { border-bottom-color: #0d6efd !important; background: #fff !important; }
    .iti__country-list { max-height: 260px !important; overflow-y: auto !important; list-style: none !important; padding: 4px 0 !important; margin: 0 !important; }
    .iti__country { display: flex !important; align-items: center !important; padding: 10px 16px !important; cursor: pointer !important; }
    .iti__country.iti__highlight, .iti__country:hover { background: #e7f3ff !important; }
    .iti__country-name { margin-left: 10px !important; flex: 1 !important; font-size: 14px !important; }
    .iti__dial-code { color: #0d6efd !important; font-weight: 600 !important; font-size: 13px !important; margin-left: 8px !important; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1">
        @include('layouts.admin.partials.sidebar')
        <div class="flex-grow-1 d-flex flex-column" style="margin-left: 260px;">
            @include('layouts.admin.partials.navbar')
            <main class="p-4 flex-grow-1">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </main>
            @include('layouts.admin.partials.footer')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/js/intlTelInput.min.js"></script>
    @vite(['resources/js/admin.js'])
    @stack('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof intlTelInput === 'undefined') return;
        document.querySelectorAll('input[type="tel"]').forEach(function(input) {
            if (input.closest('.iti')) return;
            intlTelInput(input, {
                initialCountry: 'in',
                preferredCountries: ['in', 'us', 'gb', 'ae', 'ca', 'au'],
                separateDialCode: true,
                countrySearch: true,
                formatOnDisplay: true,
                loadUtils: 'https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/js/utils.js'
            });
        });
    });
    </script>
</body>
</html>
