<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Logo;
use Illuminate\Support\Facades\View;

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
        // Get the logos
        // $logo1 = Logo::where('key', 'logo1')->first();
        // $logo2 = Logo::where('key', 'logo2')->first();
    
        // // Share both logo paths to all views
        // view()->share('site_logo1', $logo1->value);
        // view()->share('site_logo2', $logo2->value);
    }
}
