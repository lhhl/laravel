<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('generate', 'components.form.formcontrols', [ 'formRender', 'alias', 'page' ]);
        Form::component('feature', 'components.form.featureform', [ 'textControl', 'alias', 'showable'  ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
