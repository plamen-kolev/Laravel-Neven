<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Stockist extends Model
{

    protected $fillable = ['title', 'slug', 'x', 'y', 'thumbnail_full'];
    public $errors = '';
    private $rules = array(
        'title' => 'required|min:1',
        'size'  => 'required',
        'x'     => 'required',
        'y'     => 'required',

    );

    public function validate($data){
        $validator = Validator::make($data, $this->rules);
        if($validator->fails()){
            dd($validator->errors);
            $this->errors;
            return false;
        } 
        return true;
    }
}
