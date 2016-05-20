<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $fillable = ['title', 'slug', 'description'];
    public $timestamps = false;

    public function category(){
        return $this->belongsTo('App\Category');
    }
}


