language middleware in app/http/middleware/language

 $products = DB::table('products')
                    ->select('products.thumbnail', 
                             'products.id',
                            'category_translations.title as category', 
                            'product_translations.title', 
                            'product_options.in_stock',
                            'product_translations.slug', 
                            'product_translations.description as description', 
                            'product_options.price'
                            )
                    ->leftJoin("product_translations", "product_translations.product_id", "=" , "products.id")
                    ->leftJoin("categories", "categories.id", "=", "products.category_id")
                    ->leftJoin("product_options", "products.id", "=", "product_options.product_id")
                    ->leftJoin("category_translations", "categories.id", "=", "category_translations.category_id")

                    ->where('product_translations.locale', Config::get('app.locale'))
                    ->where("category_translations.locale", Config::get('app.locale'))
                    ->groupBy('product_options.slug')
                    ->get();

$categories = DB::table('categories')
                                ->select('category_translations.title', 'category_translations.title', 'category_translations.slug')
                                ->leftJoin("category_translations", "category_translations.category_id", "=", "categories.id")
                                ->leftJoin("product_options", "products.id", "product_options.product_id")
                                ->where('locale', Config::get('app.locale'))
                                ->orderBy('product_options.title')
                                ->get();