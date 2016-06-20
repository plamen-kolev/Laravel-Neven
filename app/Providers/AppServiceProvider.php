<?php

namespace App\Providers;
use App\Category as Category;
use Illuminate\Support\ServiceProvider;
use Cache;
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        view()->composer('master_page', function($view){

        $categories = Category::all();

        $view->with('categories', $categories);
            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('League\Glide\Server', function($app){

            $filesystem = $app->make('Illuminate\Contracts\Filesystem\Filesystem');

            return \League\Glide\ServerFactory::create([
                'source'    => $filesystem->getDriver(),
                'cache'     => $filesystem->getDriver(),
                'source_path_prefix'    => 'images',
                'cache_path_prefix'     =>  'images/.cache',
                // 'base_url'  => 'img'
            ]);

        });
    }
}
