<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            // Verificar si el valor es una cadena base64 válida y representa una imagen
            if (preg_match('/^data:image\/(\w+);base64,/', $value)) {
                return true;
            }
            return false;
        });
    }
}
