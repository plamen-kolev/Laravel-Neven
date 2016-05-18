<?php

namespace App\Providers;
use App\Category as Category;
use Illuminate\Support\ServiceProvider;
use Cache;
use Config;
use DB;
use App\CategoryTranslation as CategoryTranslation;

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

        $categories = DB::table('category_translations')
            ->join('categories', 'category_translations.category_id', '=', 'categories.id')
            ->where('category_translations.locale', '=', Config::get('app.locale')  )
            ->get();

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
        //
    }
}
