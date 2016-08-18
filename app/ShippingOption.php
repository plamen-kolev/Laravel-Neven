<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
class ShippingOption extends Model
{
    protected $fillable = ['country', 'country_code', 'weight', 'price'];

    public function save(array $options = []){
       Cache::flush();
       parent::save();
       // after save code
    }
}
