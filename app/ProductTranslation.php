<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = ['title', 'description', 'slug'];
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\Product');
    }

}
