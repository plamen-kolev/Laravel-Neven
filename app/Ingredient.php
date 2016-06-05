<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    
    protected $fillable = array('thumbnail_full','thumbnail_medium', 'thumbnail_small', 'slug', 'title_en', 'title_nb', 'description_en', 'description_nb');

    public function products(){
        return $this->belongsToMany('App\Product', 'order_product');
    }
        
}
