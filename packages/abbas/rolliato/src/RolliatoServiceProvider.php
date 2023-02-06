<?php

namespace Abbas\Rolliato;

use Illuminate\Support\ServiceProvider;

class RolliatoServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
