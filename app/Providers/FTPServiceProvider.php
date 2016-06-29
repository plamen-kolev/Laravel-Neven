<?php

namespace App\Providers;
use League\Flysystem\Adapter\Ftp as Adapter;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Storage;

class FTPServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('ftp', function($app, $config) {
            return new Filesystem(new Adapter([
                'host'      => env('FTP_HOSTNAME'),
                'username'  => env('FTP_USERNAME'),
                'password'  => env('FTP_PASSWORD'),

                // * optional config settings 
                'port' => env('FTP_PORT', 21),
                'root' => env('FTP_PATH', '/home/www/'),
                'timeout' => 10,
            ])); 
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
