<?php
namespace App\Providers\Setting;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Defer-load the provider when usage.
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('setting', function () {
            return new SettingManager();
        });
    }

    /**
     * Get provides
     */
    public function provides()
    {
        return ['setting', SettingManager::class];
    }
}
