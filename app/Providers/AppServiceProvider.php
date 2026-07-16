<?php

namespace App\Providers;

use App\Models\SettingsModel;
use App\Models\SosyalMedyaModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();

        View::composer(["*"], function ($view) {
            $bitis = now()->addMinute(3);
            $datalar = Cache::remember("ayarlar", $bitis, function () {
                return [
                    "ayarlar" => SettingsModel::first(),
                    "sm" => SosyalMedyaModel::all()
                ];
            });

            $view->with('datalar', $datalar);
        });
    }
}

