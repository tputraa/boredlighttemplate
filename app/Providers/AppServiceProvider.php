<?php

namespace App\Providers;

use App\Services\MenuService;
use App\View\MenuViewHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with('menus', MenuService::getUserMenus());
        });

        View::creator('layouts.app', function ($view) {
            $view->with('activeParentMenuCode', MenuViewHelper::activeParentMenuCode());
        });
    }
}
