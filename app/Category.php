<?php

namespace App;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = array('title', 'slug','description', 'thumbnail');

    public function products() {
        return $this->hasMany('App\Product');
    }
}
