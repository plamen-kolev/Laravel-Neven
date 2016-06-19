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
// use App\Category as Category;
// use App\Product as Product;

    Route::group(['middleware' => ['web', 'admin'] ], function () {
        Route::get('admin', array('as' => 'admin', 'uses' => 'PageController@admin'));

        Route::resource('category', 'CategoryController', ['only' => ['create', 'store', 'destroy', 'edit', 'update']] );
        Route::resource('product', 'ProductController', ['only' => ['create', 'store', 'destroy', 'edit', 'update' ]] );

        Route::resource('ingredient', 'IngredientController', ['only' => ['create','store'] ]);
        
        Route::get('stockist_create/', array('as' => 'stockist.create', 'uses' => 'StockistController@create'));
        Route::post('stockist_store/', array('as' => 'stockist.store', 'uses' => 'StockistController@store'));
        

        Route::resource('stockist', 'StockistController', ['only' => ['edit', 'update'] ]);
        Route::resource('blog', 'ArticleController', ['only' => ['create', 'store' ,'destroy', 'edit']] );

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
        Route::get('about/',                     array('as' => 'about', 'uses' => 'PageController@about'));
        
        Route::match( array('GET', 'POST'),'contact',
                      array('before' => 'csrf', 'as' => 'contact', 'uses' => 'PageController@contact'));

        Route::get('category/', array('as' => 'category.index', 'uses' => 'CategoryController@index'));
        Route::get('category/{category}', array('as' => 'category.show', 'uses' => 'CategoryController@show')) ; 
        // Route::resource('category', 'CategoryController', ['only' => ['show']] );

        // Route::get('admin')
        Route::get('search',                array('as' => 'search', 'uses' => 'ProductController@search'));
        
        // Route::resource('product', 'ProductController', ['only' => ['index', 'show', ]] );
        Route::get('product/', array('as' => 'product.index', 'uses' => 'ProductController@index'));
        Route::get('product/{product}', array('as' => 'product.show', 'uses' => 'ProductController@show')) ; 
        Route::post('product/{product}', array('as' => 'product.show', 'uses' => 'ProductController@show')) ;

        # 'ProductController', ['only' => ['index', 'show', ]] );

        Route::post('review/add',           array('before' => 'csrf', 'as' => 'add_review', 'uses' => 'ReviewController@store'));
        Route::post('review/delete',        array('before' => 'csrf', 'as' => 'delete_review', 'uses' => 'ReviewController@destroy'));

        Route::get('blog', ['as' => 'blog.index', 'uses' => 'ArticleController@index']);
        Route::get('blog/{slug}', ['as' => 'blog.show', 'uses' => 'ArticleController@show']);

        Route::match( array('GET', 'POST'),'stockist',
                      array('as' => 'stockist', 'uses' => 'PageController@stockist'));

        Route::post('subscribe', ['before' => 'csrf','as' => 'subscribe', 'uses' => 'PageController@subscribe']);

        // CartController
        Route::post('cart/add_to_cart/',    array('before' => 'csrf', 'as' => 'add_to_cart', 'uses' => 'CartController@add_to_cart'));
        Route::match(                       array('GET', 'POST'),'cart/',
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

        Route::match(array('GET', 'POST'), 'password/change', ['before' => 'csrf', 'as' => 'change_password', 'uses' => 'UserController@change_password']);


        // Mail activation routes
        Route::get('register/verify/{confirmationCode}/', [
            'as' => 'account_activation',
            'uses' => 'Auth\AuthController@account_activation'
        ]);

        // Registration Routes...
        Route::get('register/', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
        Route::post('register/', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);

        // Password reset link request routes...
        Route::get('password/email', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@getEmail']);
        Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@postEmail']);

        // Password reset routes...
        Route::get('password/reset/{token}', ['as' => 'auth.password.getRest', 'uses' => 'Auth\PasswordController@getReset']);
        Route::post('password/reset', [ 'as' => 'auth.password.postReset', 'uses' => 'Auth\PasswordController@postReset']);

        // // // Password Reset Routes...
        // Route::get('password/reset/{token?}/', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
        // Route::post('password/email/', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);

        // Route::post('password/reset/', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);

        # ingredients
        Route::get('ingredient/{slug}/', ['as' => 'ingredient.show', 'uses' => 'IngredientController@show']
        );

        Route::get('stockists/', ['as' => 'stockists', 
            'uses' => 'ProductController@stockists']
        );

        Route::get('stockists/become', ['as' => 'become_stockist', 
            'uses' => 'ProductController@become_stockist']
        );

        Route::get('stockist_all/', array('as' => 'stockist.index', 'uses' => 'StockistController@index'));
        


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
