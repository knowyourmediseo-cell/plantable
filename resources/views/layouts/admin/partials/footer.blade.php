<footer class="mt-auto py-3 bg-white border-top">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-muted small">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-muted small">Version 1.0.0 | Powered by Laravel {{ app()->version() }}</p>
            </div>
        </div>
    </div>
</footer>
