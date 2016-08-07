@extends('master_page')
@section('content')
    <div class="col-md-12">
        <div class="wrapper">
            <h1 class="capital"><a href="{{route('blog.index')}}">Articles</a> <a href="{{route('blog.create')}}">+</a></h1>
            <hr/>
            <h1 class="capital"><a href="{{route('stockist.index')}}">Stockists</a><a href="{{route('stockist.create')}}">+</a></h1>
            <hr/>
            <h1 class="capital"><a href="{{route('product.index')}}">products</a><a href="{{route('product.create')}}">+</a></h1>
            <hr/>
            <h1 class="capital"><a href="{{route('product.index')}}">categories</a><a href="{{route('category.create')}}">+</a></h1>
            <hr/>
            <h1 class="capital"><a href="{{route('ingredient.index')}}">ingredients</a><a href="{{route('ingredient.create')}}">+</a></h1>

            <hr/>
            <h1 class="capital"><a href="{{route('shipping.index')}}">shipping options</a><a href="{{route('shipping.create')}}">+</a></h1>

            <hr/>
            <h1 class="capital"><a href="{{route('slide.index')}}/?#slides">slides</a><a href="{{route('slide.create')}}">+</a></h1>
        </div>
    </div>
    

@stop
