<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
class ProductOption extends Model
{
    protected $fillable = array('title', 'price', 'slug', 'weight', 'product_id');
    // protected $fillable = array('price', 'weight');
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
