@extends('master_page')
@section('content')
    <div class="col-md-12">
        <div class="wrapper">
            <h1 class="capital">Articles <a href="{{route('blog.create')}}">+</a></h1>
            <hr/>
            <h1 class="capital">Stockists<a href="{{route('stockist.create')}}">+</a></h1>
            <hr/>
            <h1 class="capital">products<a href="{{route('product.create')}}">+</a></h1>
            <hr/>
            <h1 class="capital">categories<a href="{{route('category.create')}}">+</a></h1>
            <hr/>
            <h1 class="capital">ingredients<a href="{{route('ingredient.create')}}">+</a></h1>

            <hr/>
            <h1 class="capital">shipping options<a href="{{route('shipping.create')}}">+</a></h1>

            <hr/>
            <h1 class="capital">slides<a href="{{route('slide.create')}}">+</a></h1>
        </div>
    </div>
    

@stop
