<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Menu;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load helpers
        require_once app_path('Helpers/helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap for pagination
        Paginator::useBootstrapFive();

        // Share data with all views
        View::composer('*', function ($view) {
            // Share header menu
            $headerMenu = Menu::active()
                ->where('location', 'header')
                ->with(['items' => function ($query) {
                    $query->active()->whereNull('parent_id')->orderBy('sort_order')->with('children');
                }])
                ->first();

            // Share footer menu
            $footerMenu = Menu::active()
                ->where('location', 'footer')
                ->with(['items' => function ($query) {
                    $query->active()->whereNull('parent_id')->orderBy('sort_order')->with('children');
                }])
                ->first();

            $view->with([
                'headerMenu' => $headerMenu,
                'footerMenu' => $footerMenu,
            ]);
        });
    }
}
