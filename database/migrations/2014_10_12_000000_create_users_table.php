<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 200);
            $table->string('last_name', 200)->default('');
            $table->boolean('admin', 0);
            $table->string('email')->unique();
            // payment
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            // activation
            $table->boolean('active')->default(0);
            $table->string('activation_code',60) ;

            $table->string('password', 120);

            // personal details
            $table->string('address_1', 255)->default('');
            $table->string('address_2', 255)->default('');
            $table->string('city', 255)->default('');
            $table->string('post_code', 255)->default('');
            $table->string('country', 255)->default('');
            $table->string('phone', 100)->default('');


            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('subscriptions', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->string('name');
            $table->string('stripe_id');
            $table->string('stripe_plan');
            $table->integer('quantity');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
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
        Schema::drop('users');
        Schema::drop('subscriptions');
    }
}
