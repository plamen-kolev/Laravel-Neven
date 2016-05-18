<?php

/**
 * Actors model config
 */

return array(

    'title' => 'Product',
    'single' => 'product',
    'model' => 'App\Product',

    'columns' => array(
        'description' => array(
            'title' => 'Description',
            'relationship' => 'product_translations.product_id',
            'select' => "(:table).description",
        ),        
        
    ),


    'edit_fields' => array(
        'description' => array(
            'title' => 'Thumbnail'
        ),

        // 'slug' => array(
        //     'title' => 'Slug',
        // ),

        // 'thumbnail' => array(
        //     'title' => 'Image',
        //     'type' => 'image',
        //     'location' => public_path() . '/',
        //     'naming' => 'random',
        //     'length' => 20,
        // ),
    ),

);