<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = array('title', 'in_stock', 'price', 'slug', 'weight');
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
