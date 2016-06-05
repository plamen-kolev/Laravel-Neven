<?php

namespace App;
use App\Product;
use Config;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = array('title_en', 'title_nb', 'slug','description_en', 'description_en', 'thumbnail_full', 'thumbnail_medium', 'thumbnail_small');

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function title(){
        return ( strcmp(Config::get('app.locale'), 'en') ? $this->title_nb : $this->title_en);
    }
}
