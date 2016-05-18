<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientTranslation extends Model
{
    protected $fillable = ['title', 'description', 'slug'];
    public $timestamps = false;

    public function ingredient(){
        return $this->belongsTo('App\Ingredient');
    }
}
