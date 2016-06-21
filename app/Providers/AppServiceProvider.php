<?php

namespace App\Providers;
use App\Category as Category;
use Illuminate\Support\ServiceProvider;
use Cache;
use Config;
use Storage;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Ftp as Adapter;

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
                $storageDriver = '';
                if(env('FILESYSTEM') == 'ftp'){
                    $storageDriver = new Filesystem(new Adapter([
                        'host' => env('FTP_HOSTNAME'),
                        'username' => env('FTP_USERNAME'),
                        'password' => env('FTP_PASSWORD'),

                        // * optional config settings 
                        'port' => env('FTP_PORT', 21),
                        'root' => env('FTP_PATH', '/home/pi/FTP'),
                        'timeout' => 10,
                    ]));    
                } else {
                    $storageDriver = Storage::getDriver();
                }
                

                $factory = ServerFactory::create([
                    'source' => $storageDriver,
                    'cache' => $storageDriver,
                    'source_path_prefix'    => 'images',
                    'cache_path_prefix'     =>  'images/.cache',
                    'base_url' => '/images/'
                ]);
                return $factory;
            });
    }
    
}




