<?php

namespace App\Providers;

use App\Models\Tp_option;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $generalSettings = Cache::rememberForever('generalSettings', function () {
            return json_decode(Tp_option::where('option_name', 'general_settings')->value('option_value'), true);
        });
        View::composer('frontend.partials.header', function ($view) use ($generalSettings) {
            $view->with('generalSettings', $generalSettings);
        });
		
		Paginator::useBootstrap();
    }
}
