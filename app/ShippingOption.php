<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingOption extends Model
{
    protected $fillable = ['country_code', 'weight', 'price', 'country'];
}
