@extends('master_page')
@section('content')

<div class="col-md-12">
    <div class="wrapper center">
        <h1>{{$title}}</h1>
    </div>
    
</div>

<div class="col-md-12 gallery_second">
    <div class="wrapper">
        @if(Auth::user() && Auth::user()->admin)
            <a class="generic_submit" href="{{route('product.create')}}">Create a product</a>
        @endif

        @include('index_products')
    </div>

    <div class="col-md-12">
        <div class="wrapper center">
            {{$products->render()}}        
        </div>
    
        
    </div>

</div>


@stop
