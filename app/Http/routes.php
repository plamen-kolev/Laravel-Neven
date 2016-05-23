<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Category as Category;
use App\Product as Product;
    Route::get('init', "FakerController@init");

    Route::group(['middleware' => 'admin'], function () {
        Route::resource('category', 'CategoryController', ['only' => ['create', 'store']] );
        Route::resource('product', 'ProductController', ['only' => ['create', 'store' ]] );    
    });
    
    
    Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
//        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'web' ],
        'middleware' => [ 'web' ],
    ],
    function()
    {
        /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/

        Route::get('/',                     array('as' => 'index', 'uses' => 'PageController@index'));

        // Route::get('category/{category}/',  array('language'=> 'en','as' => 'category', 'uses' => 'ProductController@category'));
        Route::resource('category', 'CategoryController', ['only' => ['show']] );

        // Route::get('admin')
        Route::get('search',                array('as' => 'search', 'uses' => 'ProductController@search'));
        
        Route::resource('product', 'ProductController', ['only' => ['index', 'show', ]] );

        Route::post('review/add',           array('before' => 'csrf', 'as' => 'add_review', 'uses' => 'ReviewController@store'));
        Route::post('review/delete',        array('before' => 'csrf', 'as' => 'delete_review', 'uses' => 'ReviewController@destroy'));

        Route::get('blog', ['as' => 'blog', 'uses' => 'PageController@get']);
        Route::get('blog/{slug}', ['as' => 'article', 'uses' => 'PageController@article']);
        Route::match( array('GET', 'POST'),'stockist',
                      array('as' => 'stockist', 'uses' => 'PageController@stockist'));

        // CartController
        Route::post('cart/add_to_cart/',    array('before' => 'csrf', 'as' => 'add_to_cart', 'uses' => 'CartController@add_to_cart'));
        Route::match(                       array('GET', 'POST'),'cart/show_cart/',
                                            array('as' => 'show_cart', 'uses' => 'CartController@show_cart'));
        Route::get('cart/remove_cart/{$cart_instance}',
                                            array('as' => 'remove_cart', 'uses' => 'CartController@remove_cart'));
        Route::get('cart/remove_cart_item/{item_rowid}',array('as'=> 'remove_cart_item', 'uses' => 'CartController@remove_cart_item'));
        Route::get('cart/destroy',          array('as' => 'destroy_cart', 'uses' => 'CartController@destroy_cart'));

        // Checkout stuff
        Route::match(array('GET', 'POST'), 'checkout/',             array('as' => 'checkout', 'uses' => 'PaymentController@checkout'));

        Route::get('cart/calculate_shipping_cost/{country_code}',  array('as' => 'calculate_shipping_cost', 'uses' => 'HelperController@calculate_shipping_cost')  );

        Route::get('login/',  ['as' => 'auth.login', 'uses' => 'Auth\AuthController@showLoginForm']);
        Route::post('login/', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
        Route::get('logout/', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

        // Mail activation routes
        Route::get('register/verify/{confirmationCode}/', [
            'as' => 'account_activation',
            'uses' => 'Auth\AuthController@account_activation'
        ]);

        // Registration Routes...
        Route::get('register/', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
        Route::post('register/', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);

        // Password Reset Routes...
        Route::get('password/reset/{token?}/', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
        Route::post('password/email/', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
        Route::post('password/reset/', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']
        );


        # api and json requests
        Route::get('ingredient/{slug}/', ['as' => 'get_ingredient', 'uses' => 'ApiController@get_ingredient']
        );

        Route::get('stockists/', ['as' => 'stockists', 
            'uses' => 'ProductController@stockists']
        );

        Route::get('stockists/become', ['as' => 'become_stockist', 
            'uses' => 'ProductController@become_stockist']
        );


    });

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'auth'], function () {

    Route::get('register/resend_email', [
        'as' => 'send_activation_email',
        'uses' => 'EmailController@send_confirmation_email'
    ]);
});
