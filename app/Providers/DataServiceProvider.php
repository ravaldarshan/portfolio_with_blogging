<?php

namespace App\Providers;

use App\Models\admin\Setting;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
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
        view()->composer([
            'frontpage.layouts.main',
            'frontpage.layouts.header',
            'frontpage.layouts.footer',
            'frontpage.about.index',
            'frontpage.service.index',
            'frontpage.blog.index',
            'frontpage.blog.detail',
            'frontpage.project.index',
            'frontpage.contact.index',
            'frontpage.home.index',
            'administrator.layouts.main',
            'administrator.authentication.main',
            'administrator.authentication.login',
            'administrator.logs.export'
        ], function ($view) {
            $settings = Setting::get()->toArray();
        
            $settings = array_column($settings, 'value', 'name');
            $view->with('settings', $settings);
        });
    }
}
