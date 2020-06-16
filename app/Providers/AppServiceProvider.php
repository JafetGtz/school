<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\Database\Eloquent\Relations\Relation;

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

        ViewFactory::macro('component', function (
            $name,
            $viewData = [],
            $componentData = []
        ) {
            $viewData['layout'] = $viewData['layout'] ?? 'default';

            return view()->make(
                'app',
                [
                    'name' => $name,
                    'data' => $componentData,
                ] + $viewData
            );
        });

        Relation::morphMap([
            'student' => 'App\Student',
            'teacher' => 'App\Teacher',
        ]);
    }
}
