<?php

namespace App\Providers;
use App\Category as Category;
use Illuminate\Support\ServiceProvider;
use Cache;
use Config;
use Storage;

use League\Glide\ServerFactory;

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
        
        $this->app->singleton('League\Glide\Server', function($app) {
                $storageDriver = Storage::getDriver();
                return ServerFactory::create([
                    'source' => $storageDriver,
                    'cache' => $storageDriver,
                    'source_path_prefix'    => 'images',
                    'cache_path_prefix'     =>  'images/.cache',
                    'base_url' => '/images/'
                ]);
            });
    }
    
}
