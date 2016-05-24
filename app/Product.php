<?php

namespace App;

use App\Http\Controllers\HelperController;
use Illuminate\Database\Eloquent\Model;
use Cache;
use App\ProductOption as ProductOption;
use Carbon\Carbon;

class Product extends Model
{   
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['title', 'description', 'tips', 'benefits'];
    protected $fillable = array('featured', 'title', 'in_stock', 'slug', 'description', 'thumbnail_full', 'thumbnail_small', 'thumbnail_medium', 'tips', 'benefits', 'tags', 'hidden_tags');

    public function price(){
        return $this->options()->first()->price * HelperController::getRate();
    }
    
    // public function getCachedTranslation($language){
    //     $key = 'translation' + $this->id;
    //     if(Cache::has($key)){
    //         return Cache::get($key);
    //     }
    //     print "not cached";
    //     $translation = $this->translations()->where('locale', $language)->first();
    //     Cache::put($key, $translation, env('CACHE_TIMEOUT', 60));
    //     return $translation;
    // }

    public function orders(){
        return $this->belongsToMany('App\Order', 'order_product')->withPivot('quantity');;
    }

    public function getOption($slug){
        return ProductOption::where('product_id', $this->id)
                            ->where('slug',$slug)
                            ->first();
    }

    // relatinshop helpers
    public function ingredients(){
        return $this->belongsToMany('App\Ingredient', 'ingredient_product');
    }

    public function options(){
        return $this->hasMany('App\ProductOption');
    }

    public function related()
    {
        return $this->belongsToMany('App\Product', 'product_related', 'product_id', 'related_id');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function images(){
        return $this->hasMany('App\Image');
    }

    public function translations(){
        return $this->hasMany('App\ProductTranslation');
    }

}
