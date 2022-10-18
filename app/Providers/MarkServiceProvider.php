<?php

namespace App\Providers;
use App\Models\Mark;
use App\Observers\MarkObserver;

use Illuminate\Support\ServiceProvider;

class MarkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Mark::observe(MarkObserver::class);
    }
}
