<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{

    protected $fillable = array('order_number','email', 'first_name', 'last_name', 'address_1', 'city', 'post_code', 'country', 'phone', 'total', 'last4');

    public function products(){
        return $this->belongsToMany('App\Product', 'order_product');
    }
}
