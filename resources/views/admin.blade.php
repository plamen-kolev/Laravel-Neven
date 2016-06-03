@extends('master_page')
@section('content')
    <div class="col-md-12">
        <div class="wrapper">
            <h1 class="capital">Articles <a href="{{route('blog.create')}}">+</a></h1>
            <hr/>
            <h1 class="capital">Stockists<a href="{{route('stockist.create')}}">+</a></h1>
        </div>
    </div>
    

@stop
