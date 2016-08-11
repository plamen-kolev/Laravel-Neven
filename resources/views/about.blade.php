@extends('master_page')
@section('content')

<div class="col-md-12">
    <div class="wrapper">
        <h1 class="center capital"> {{trans('text.about_us')}} </h1>
        <h2 class="center capital green_text no_top_spacing">{{trans('text.about_page_caption')}}</h2>
        <p class="headline_container margin_top_60 margin_bottom_60">{{trans('text.about_page_intro')}}</p>
    </div>
</div>

@include('partials.proud')
<div class="col-md-12">
    <div class="wrapper">
        <h2 class="center capital">{{trans('text.about_page_caption_2')}}</h2>        
        <p class="headline_container margin_top_35 margin_bottom_60">{{trans('text.about_page_intro_part_2')}}</p>
    </div>
</div>

@include('partials.ingredient_origin')


@stop
