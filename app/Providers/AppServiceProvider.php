<?php

namespace App\Providers;

use App\Models\AgendaItem;
use App\Models\MenuItem;
use App\Observers\AgendaItemCreatorObserver;
use Illuminate\Support\Facades\Request;
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
    public function boot()
    {
        $menu = MenuItem::getNestedMenuItems();
        View::share('menu', $menu);
        AgendaItem::observe(AgendaItemCreatorObserver::class);
    }
}
