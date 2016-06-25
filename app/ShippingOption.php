<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingOption extends Model
{
    protected $fillable = ['country', 'country_code', 'weight', 'price'];
}
