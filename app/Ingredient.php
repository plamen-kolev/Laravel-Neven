<?php

namespace App;
use Config;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{

    protected $fillable = array('thumbnail', 'slug', 'title_en', 'title_nb', 'description_en', 'description_nb');

    public function products(){
        return $this->belongsToMany('App\Product', 'order_product');
    }

    public function title(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->title_nb : $this->title_en);
    }

    public function description(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->description_nb : $this->description_en);
    }

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }

}
