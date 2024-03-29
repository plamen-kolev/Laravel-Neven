<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

// require_once base_path('vendor/fzaninotto/faker/src/autoload.php');
use Faker\Factory as Faker;

use Illuminate\Http\Request;
use App\Product as Product;
use App\Category as Category;
use App\Ingredient as Ingredient;
use App\Slide as Slide;
use App\Image as Image;
use App\Review as Review;
use App\Article as Article;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaravelLocalization;
use Illuminate\Support\Str as Str;
use App\ProductOption as ProductOption;
use App\ShippingOption as ShippingOption;
use App\Stockist as Stockist;
use App\Console\Commands\InitCommand as InitCommand;
use Storage;
use File;
use DB;

class FakerCommand extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $category_num = 2;
    protected $ingredient_num = 2;
    protected $product_num = 2;
    protected $ingredients_per_product = 2;
    protected $related_images = 2;
    protected $tags = 1;
    protected $slide_images = 5;
    protected $articles = 2;
    protected $options = 2;
    protected $reviews = 1;
    protected $stockists = 2;

    protected $signature = 'faker:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->storage_path = '/tmp/';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function deploy_image($w, $h, $faker){

        $filename = $this::local_image($faker->image($dir = $this->storage_path, $width = $w, $height = $h));
        Storage::disk(env('FILESYSTEM'))->put('images/' . $filename, File::get($this->storage_path . $filename) );
        return $filename;
    }

    public function handle()
    {
        $faker = Faker::create();

        InitCommand::generate_heros();

        InitCommand::get_or_create_admin();
        $this->product_num = $this->product_num;
        $this->category_num = $this->category_num;


        $languages = array_keys(LaravelLocalization::getSupportedLocales());

        # create stockists
        $this->line("Generating $this->stockists stockists");
        foreach(range(1,$this->stockists) as $index){

            $filename = $this::deploy_image(1560,480, $faker);

            $title = "$faker->word " . str_random(10);
            Stockist::create([
                'title' => $title,
                'address'   => $faker->address,
                'slug'  => Str::slug($title),
                'thumbnail' => $filename,
                'lat' => $faker->randomFloat($nbMaxDecimals = 6, $min = 40, $max = 41) ,
                'lng'  => $faker->randomFloat($nbMaxDecimals = 6, $min = 0, $max = 1),
                'body'  => $faker->text,
            ]);
        }


        # create articles
        $this->line("Generating $this->articles articles");
        foreach(range(1,$this->articles) as $index){

            $filename = $this::deploy_image(720,580, $faker);

            $title = "$faker->word " . str_random(10);
            Article::create([
                'title' => $title,
                'thumbnail' => $filename,
                'slug'  => Str::slug($title),
                'tags'  => "$faker->word, $faker->word, $faker->word, $faker->word",
                'body'  => $faker->text,
            ]);
        }

        $this->line("Generating $this->slide_images slides");
        foreach(range(1,$this->slide_images) as $index){

            $filename = $this::deploy_image(1560,480, $faker);

            Slide::create([
                'image' => $filename,
                'url'   => "google.com",
                'description_en' => $faker->text,
                'description_nb' => 'nb ' . $faker->text
            ]);
        }

        $this->line("Generating $this->category_num categories");
        foreach(range(1,$this->category_num) as $index){
            // CATEGORY
            $title = 'Category' . $index . " " . str_random(10);
            $filename = $this::deploy_image(1280,720, $faker);
            $category = new Category ([
                'thumbnail'    => $filename,
                'slug'      =>  Str::slug($title),

                'title_en'  => $title,
                'title_nb'  => 'Norwegian ' . $title,

                'description_en' => 'Desc ' . $faker->text,
                'description_nb' => 'Norwegian Desc ' . $faker->text,

            ]);
            $category->save();

        }



        // INGREDIENT
        $this->line("Generating $this->ingredient_num ingredients");
        foreach(range(1,$this->ingredient_num) as $index){
            $title = 'Ingredient' . ' ' . $index . ' '  . str_random(6);

            $filename = $this::deploy_image(1280,720, $faker);

            $ingredient = Ingredient::create([
                'thumbnail'    => $filename,
                'slug'              =>  Str::slug($title),
                'title_en'          => "{$title}",
                'title_nb'          => "Norwegian {$title}",

                'description_en'    => "{$faker->text}",
                'description_nb'    => "Norwegian {$faker->text}"
            ]);

            $ingredient->save();
        }

        // Create product
        $this->line("Generating $this->product_num products");
        foreach(range(1,$this->product_num) as $index){

            $filename = $this::deploy_image(720,580, $faker);
            // Add products
            $title = "Title{$faker->word} en " . str_random(10);
            $product = new Product([
                'thumbnail'    => $filename,
                'hover_thumbnail' => $this::deploy_image(720,580, $faker),
                'in_stock'  => $faker->boolean(50),
                'featured'  => $faker->boolean(40),
                'slug'      => Str::slug($title),
                'title_en'          => $title,
                'description_en'    => "descr {$faker->text}",
                'tips_en'           => "tip {$faker->text}",
                'benefits_en'       => "benefit {$faker->text}",

                'title_nb'          => "Norwegian {$title}",
                'description_nb'    => "Norwegian descr {$faker->text}",
                'tips_nb'           => "Norwegian tip {$faker->text}",
                'benefits_nb'       => "Norwegian benefit {$faker->text}",
                'category_id'       => Category::find($faker->numberBetween($min = 1, $max = $this->category_num))->id
            ]);

            // ADD Category
            $product->save();

            // reviews
            foreach(range(1,$this->reviews) as $index){
                $review = new Review([
                    'body'      => $faker->text,
                    'rating'    => rand (1, 5)
                ]);

                $review->user()->associate(User::find(1));
                $review->product()->associate($product);
                $review->save();
            }


            // Options
            foreach(range(1,$this->options) as $index){
                $option = new ProductOption([
                    'title'  => $faker->word . str_random(10),
                    'price'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 100),
                    'weight' => 50
                ]);
                $option->slug = Str::slug($option->title);
                $option->product_id = $product->id;
                $option->save();

            }
            // add product language texsts

            $product->save();

            // ADD related images
            foreach(range(1, $this->related_images) as $index){
                $filename = $this::deploy_image(1280,720, $faker);
                $image = new Image([
                    'thumbnail'    => $filename,
                ]);

                $image->product()->associate($product);
                $image->save();
            }
            // Add tags
            $tag = '';
            foreach(range(1, $this->tags) as $index){
                $tag .= 'Tag ' . $index . str_random(10) . ',';

            }
            $product->tags = $tag;
            $product->save();

            // Add ingredients
            foreach(range(0, $this->ingredients_per_product) as $index){
                $product->ingredients()
                    ->attach(Ingredient::find($index)
                );
            }
        }

        // associate products
        foreach(Product::all() as $product){
            $product->related()->attach(Product::find(1)->first());
            $product->related()->attach($product);
            $product->save();
        }

        // fake articles for the blog
        foreach(range(1, $this->articles) as $index){
            new Article([
                'tag' => $faker->word  . str_random(10),
                'body'=> $faker->text  . str_random(10),
                'tags'=> $faker->word . str_random(10),
            ]);
        }


        $this->line("Generating shipping options");

        // create shipping options
        ShippingOption::create([
            'country_code' => 'NO',
            'country'       => 'Norway',
            'weight'       => 300,
            'price'        => 10
        ]);

        ShippingOption::create([
            'country_code' => 'NO',
            'country'       => 'Norway',
            'weight'       => 500,
            'price'        => 30
        ]);

        ShippingOption::create([
            'country_code' => 'GB',
            'country'       => 'Great Britain',
            'weight'       => 300,
            'price'        => 30
        ]);


        ShippingOption::create([
            'country_code' => 'ALL',
            'country'       => 'Other',
            'weight'       => 300,
            'price'        => 300
        ]);
    }


    public static function local_image($image){
        preg_match('~([a-zA-Z0-9])+.jpg~', $image, $m );
        return $m[0];
    }
}
