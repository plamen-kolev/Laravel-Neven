description_nb<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Initial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('slides', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('image', 255)->unique();
            $table->string('url', 255);
            $table->text('description');
            $table->timestamps();

        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('slug',255)->unique();
            $table->string('thumbnail_full',255);
            $table->string('thumbnail_medium',255);
            $table->string('thumbnail_small',255);

            $table->string('title_en',255);
            $table->string('title_nb',255);

            $table->text('description_en')->default('');
            $table->text('description_nb')->default('');

            $table->timestamps();
        });

        Schema::create('ingredients', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('thumbnail_full',255);
            $table->string('thumbnail_medium',255);
            $table->string('thumbnail_small',255);

            $table->string('title_en',255);
            $table->string('title_nb',255);

            $table->text('description_en');
            $table->text('description_nb');

            $table->string('slug', 255)->unique();
            $table->timestamps();

        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('thumbnail_full', 255);
            $table->string('thumbnail_medium', 255);
            $table->string('thumbnail_small', 255);
            $table->string('tags', 255)->default('');
            $table->string('hidden_tags', 255)->default('');

            $table->string('title_en',255);
            $table->string('title_nb',255);

            $table->text('description_en', 255);
            $table->text('description_nb', 255);

            $table->text('tips_en', 255);
            $table->text('tips_nb', 255);


            $table->text('benefits_en', 255);
            $table->text('benefits_nb', 255);


            $table->boolean('featured')->default(0);
            $table->string('slug',255)->unique();
            $table->timestamps();
            $table->boolean('in_stock')->default(1);
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });

        Schema::create('product_options', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->integer('weight');
            // $table->boolean('in_stock');
            $table->decimal('price', 10, 2)->unsigned();

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });


        Schema::create('images', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('thumbnail_full',255);
            $table->string('thumbnail_medium',255);
            $table->string('thumbnail_small',255);
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });

        // Blog schema
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title',600);
            $table->string('tags', 255);
            $table->string('slug')->unique();
            $table->text('body');

            $table->timestamps();

        });

        // many to many
        Schema::create('ingredient_product', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('ingredient_id');
            $table->integer('product_id');
        });

        Schema::create('product_related', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('related_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('related_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('order_number', 8);
            $table->string('email',255);
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('address_1',255);
            $table->string('address_2',255)->default('');

            $table->string('city',50);
            $table->string('post_code',50);

            $table->string('country',5);
            $table->string('phone',255);
            $table->integer('last4');
            $table->float('total');
            $table->float('shipping');

            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('option_id')->unsigned();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
        });

        Schema::create('shipping_options', function (Blueprint $table){
            $table->increments('id');
            $table->string('country', 100);
            $table->string('country_code', 3);
            $table->integer('weight')->unsigned();
            $table->float('price')->unsigned();

            $table->timestamps();

        });

        Schema::create('reviews', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->text('body');
            $table->tinyInteger('rating')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->on('products')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->on('products')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('subscribers', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('email', 300)->unique();
            $table->boolean('send')->default(1);

            $table->timestamps();
        });

        Schema::create('stockists', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('slug', 500)->unique();
            $table->string('title', 500);
            $table->string('address', 500);
            $table->string('lat', 500);
            $table->string('lng', 500);

            $table->string('thumbnail_full',255);

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stockists');
        Schema::drop('subscribers');
        Schema::drop('reviews');
        Schema::drop('order_product');
        Schema::drop('orders');
        Schema::drop('shipping_options');
        Schema::drop('articles');
        Schema::drop('ingredients');
        Schema::drop('images');
        Schema::drop('product_options');
        Schema::drop('slides');
        Schema::drop('product_related');
        Schema::drop('products');
        Schema::drop('ingredient_product');
        Schema::drop('categories');
        
        
        // many to many



    }
}
