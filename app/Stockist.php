<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Stockist extends Model
{

    protected $fillable = ['title', 'slug', 'x', 'y', 'thumbnail_full'];
    public $errors = '';
    private $rules = array(
        'title'      => 'unique:stockists,title|required|String|min:1',
        'thumbnail'  => 'required|max:10000|mimes:jpeg,jpg,png',
        'longitude'  => 'required|Numeric',
        'latitude'   => 'required|Numeric',
    );

    public function validate($data){
        $validator = Validator::make($data, $this->rules);
        if($validator->fails()){
            $this->errors = $validator->errors();
            return false;
        } 
        return true;
    }
}
