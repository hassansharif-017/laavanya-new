<?php

namespace App\Providers;

use App\Models\Tp_option;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
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

        $excludeUrls = [
            url('login'),
            url('password/reset'),
            url('user/login'),
            url('user/customer-login'),
            url('user/register'),
            url('user/customer-register'),
            url('user/reset'),
            url('user/resetPassword'),
            url('user/resetPasswordUpdate'),
            url('seller/register'),
            url('seller/seller-register'),
            url('frontend/hasShopSlug'),
            url('checkout'),
            url('frontend/make_order'),
            url('frontend/checkemail'),
            url('checkout'),
            url('order-tracking'),
        ];


        view()->composer('*', function ($view) {
            if (!Auth::check() && !defined('NITROPACK_HOME_URL')) {
                define("NITROPACK_HOME_URL", "https://laavanya-gracefullyyou.in");
                define("NITROPACK_SITE_ID", "nYvKbEMcmuYtVHodiTTTtnnUfzoLTZdZ");
                define("NITROPACK_SITE_SECRET", "6T24TC2qRWNLJkyjQlADTF4PP0Y8MywgFZjaQpxV97aI6IxSfjqY7M8Bm8sEO6a6");
                include_once 'libs/nitropack-sdk/bootstrap.php';
            }
        });

        $generalSettings = Cache::rememberForever('generalSettings', function () {
            return json_decode(Tp_option::where('option_name', 'general_settings')->value('option_value'), true);
        });
        View::composer('frontend.partials.header', function ($view) use ($generalSettings) {
            $view->with('generalSettings', $generalSettings);
        });

        Paginator::useBootstrap();
    }
}
