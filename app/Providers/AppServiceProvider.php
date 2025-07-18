<?php

namespace App\Providers;

use App\Models\Farm;
use Illuminate\Support\Facades\Auth;
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
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();
            $farms = $user->farms()->get(); // ajuste conforme seu relacionamento
            $view->with('farms', $farms);
        }
    });
    }
}
