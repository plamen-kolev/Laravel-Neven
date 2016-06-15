@extends('master_page')

@section('content')

<div class="col-md-12 nomargin nopadding">
    <div class="wrapper">
        <div class="rslides_container">
            <ul id="slider" class="rslides centered-btns centered-btns1">
                @foreach ($slides as $slide)
                <li>
                    <div class="slide_item" style="background-image:url('{{$slide->image}}');">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <h1>{{$slide->description}}</h1>
                            <a class="action_button" href="{{$slide->url}}">{{ trans('text.view_product')}} <img alt="Right arrow" src="images/right_arrow.png"/> </a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>

<div class="col-md-12 gallery_second">
    <div class="wrapper ">
        <h1 class="index_h1_margin capital center">{{ trans('text.special_offers')}}</h1>
        @include('index_products')
    </div>
</div>

<div class="col-md-12 disclaimers">
    <div class="wrapper ">
        <div class="proud">
            <h1 class="white">{{ trans('text.proud_to_be')}}</h1>
            <div class="col-md-12 row-fluid icons">
                <div class="col-md-1"></div>
                <div class="col-md-2 proud_to">
                    <img src="images/proud_cold_processed.png" alt="Cold processed" />
                </div>

                <div class="col-md-2 proud_to">
                    <img src="images/proud_no_syntetic.png" alt="No syntetic ingredients" />
                </div>

                <div class="col-md-2 proud_to">
                    <img src="images/proud_no_fillers.png" alt="no fillers" />
                </div>

                <div class="col-md-2 proud_to">
                    <img src="images/produd_vegan.png" alt="Vegan" />
                </div>

                <div class="col-md-2 proud_to">
                    <img src="images/proud_cruelty_free.png" alt="cruelty free" />
                </div>
	            <div class="col-md-1"></div>
            </div>
            <a class="green_link white" href="">{{ trans('text.learn_more')}}</a>
        </div>
    </div> 
</div>

<div class="col-md-12 shops">
    <div class="wrapper">
    
        <h1 class="align-center capital stockists">{{ trans('text.find_our_products_in_these_stores_as_well')}}</h1>
        <div class="">
             @foreach ($stockists->chunk(4) as $chunk)
                <div class="col-md-12">
                    <div class="col-md-2"></div>
                    
                    @foreach($chunk as $stockist)
                        <div class="col-md-2 stockist_icon">
                            <img width=150 src="{{$stockist->thumbnail_full}}" alt="{{$stockist->title}}" />
                        </div>
                    @endforeach
                    
                    <div class="col-md-2"></div>
                </div>
             @endforeach
            
        </div>
    </div>
</div> 

<div class="col-md-12 ingredients_map">
    <div class="wrapper ">
        
            <h1 class="white align-center capital">{{ trans('text.origin_of_our_ingredients')}}</h1>
        
        <div class="col-md-12 center_map">
            <img class="full map" src="/images/world-map.svg"/>    
        </div>
        
        <div class="col-md-12 ingredients_world_list">
           <div class="col-md-1 "></div>
           <div class="col-md-2 ">
               <p>1. Shea butter - Ghana</p><p>2. Cacao butter - Ghana</p><p>3. Beeswax - France and Bulgaria</p><p>4. Argan oil - Marocco</p><p>5. Olive oil - Spain</p><p>6. Coconut oil - Sri Lanka</p><p>7. Jojoba oil - Israel</p>
           </div> 
           <div class="col-md-2 ">
                <p>8. Apricot kernel oil - Italy</p><p>9. Avocado oil - South Africa</p><p>10. Rice bran oil - Thailand</p><p>11. Castor oil - India</p><p>12. Sea buckthorn - Belarus</p><p>13. Roship oil - Ukraine</p><p>14. Tamanu oil - Madagascar</p>
           </div> 
           <div class="col-md-2 ">
                <p>15. Lavender - Bulgaria</p><p>16. Rosa Damascena - Bulgaria</p><p>17. Rosemary - Marocco</p><p>18. Frankincense- India</p><p>19. Himalayan cedar oil - India</p><p>20. Lemongrass oil - India</p><p>21. Lemon-scented eucalyptus- India</p>
           </div>
           <div class="col-md-2 ">
               <p>22. Sweet orange oil - USA</p><p>23. Peppermint oil - India</p><p>24. Carrot seed oil- India</p><p>25.  Juniper berry - India</p><p>26. Palmarosa-India</p><p>27. Elemi oil- France</p><p>28. Yang Ylang oil - Madagascar</p>
           </div> 
           <div class="col-md-2 ">
                <p>29. Patchouli oil- Indonesia</p><p>30. Licea Cubeba oil - China</p><p>31. Clary Sage oil - Bulgaria</p><p>32. Myrrh - Keniya</p><p>33. Wild chamomile - Marocco</p><p>34. Geranium - Egypt</p><p>35. Benzoin-Sumatra</p>
           </div> 
           <div class="col-md-1 "></div>  
        </div >

        
    </div>
    
</div>

<script type="text/javascript">

    $('#slider').responsiveSlides({
        pager: true,
        // nav: true,
        namespace: "centered-btns"
    });

</script>

@stop

@section('links')
    <script src="{{ asset('responsiveslides/responsiveslides.min.js') }}" type="text/javascript"></script>
@stop
