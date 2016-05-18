<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['title', 'description'];
    
    protected $fillable = array('thumbnail_full','thumbnail_medium', 'thumbnail_small', 'slug');

    public function products(){
        return $this->belongsToMany('App\Product', 'order_product');
    }
        
}
