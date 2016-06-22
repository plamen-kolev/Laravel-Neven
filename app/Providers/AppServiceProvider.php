<?php

namespace App\Providers;
use App\Category as Category;
use Illuminate\Support\ServiceProvider;
use Cache;
use Config;
use Storage;
use League\Flysystem\Filesystem;
// use League\Flysystem\Adapter\Ftp as Adapter;

use League\Flysystem\Dropbox\DropboxAdapter;
use Dropbox\Client;

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
    public function register(){
        
        $this->app->singleton('League\Glide\Server', function($app) {
            $storageDriver = Storage::disk(env('FILESYSTEM'))->getDriver();
            
            $factory = ServerFactory::create([
                'source' => $storageDriver,
                'cache'  => Storage::disk('local')->getDriver(),
                // 'cache'  => '/tmp/',
                // 'cache'  => $storageDriver,
                'source_path_prefix'    => 'images',
                'cache_path_prefix'     =>  'images/.cache',
                'base_url' => '/images/'
            ]);
            return $factory;
        });
    }
    
}




