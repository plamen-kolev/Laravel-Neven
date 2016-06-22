<?php

namespace App\Providers;
use App\Category as Category;
use Illuminate\Support\ServiceProvider;
use Cache;
use Config;
use Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Ftp as Adapter;

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
    public function register()
    {
        
        $this->app->singleton('League\Glide\Server', function($app) {
                $storageDriver = '';
                if(env('FILESYSTEM') == 'ftp'){
                    $storageDriver = $this->ftp_storage();
                } else if(env('FILESYSTEM') == 'dropbox'){
                    $storageDriver = $this->dropbox_storage();
                } else {
                    $storageDriver = Storage::getDriver();
                }
                
                $factory = ServerFactory::create([
                    'source' => $storageDriver,
                    // 'cache'  => Storage::disk('local')->getDriver(),
                    'cache'  => $storageDriver,
                    'source_path_prefix'    => 'images',
                    'cache_path_prefix'     =>  'images/.cache',
                    'base_url' => '/images/'
                ]);
                return $factory;
            });
    }

    public function ftp_storage(){
        return new Filesystem(new Adapter([
            'host'      => env('FTP_HOSTNAME'),
            'username'  => env('FTP_USERNAME'),
            'password'  => env('FTP_PASSWORD'),

            // * optional config settings 
            'port' => env('FTP_PORT', 21),
            'root' => env('FTP_PATH', '/home/www/'),
            'timeout' => 10,
        ]));  
    }



    public function dropbox_storage(){

        // $client = new Client('y8q0dxtg0pk98lz', 'g7l1872ctpemj1s');
        $client = new Client(env('DROPBOX_TOKEN'), env('DROPBOX_SECRET'));
        $adapter = new DropboxAdapter($client);

        return new Filesystem($adapter);

       
    }
    
    
}




