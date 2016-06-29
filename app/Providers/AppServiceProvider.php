<?php

namespace App\Providers;
use App\Category as Category;
use Illuminate\Support\ServiceProvider;
use Cache;
use Config;
use Storage;
use League\Flysystem\Filesystem;
use App\Http\Controllers\HelperController as HelperController;

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
            // $view->with('categories', HelperController::use_cache(Category::orderBy('id', 'asc'), 'menu_categories', 'get') );
            $view->with('categories', Category::orderBy('id', 'asc')->get() );
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




