<?php

namespace App\Providers;
use App\Category as Category;
use Illuminate\Support\ServiceProvider;
use Cache;
use Config;
use Storage;
use League\Flysystem\Filesystem;

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
            if (Cache::has('menu_categories')){
                $view->with('categories', Cache::get('menu_categories'));                
            } else {
                $categories = Category::all();
                Cache::add('menu_categories', $categories, env('CACHE_TIMEOUT') );
                $view->with('categories', $categories);    
            }
            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){


        $this->app->singleton('League\Glide\Server', function($app) {
            if(Cache::has('glide_factory')){
                return Cache::get('glide_factory');
            }

            $storageDriver = Storage::disk(env('FILESYSTEM'))->getDriver();
            
            $factory = ServerFactory::create([
                'source' => $storageDriver,
                'cache'  => Storage::disk('local')->getDriver(),

                'source_path_prefix'    => 'images',
                'cache_path_prefix'     =>  'images/.cache',
                'base_url' => '/images/'
            ]);
            Cache::add('glide_factory', $factory, env('CACHE_TIMEOUT'));
            return $factory;
        });
    }
    
}




