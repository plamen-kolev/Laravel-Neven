@extends('master_page')
@section('content')

<div class="col-md-12">
    <div class="wrapper center">
        <h1>{{$title}}</h1>
    </div>
    
</div>

@if(!empty($categories))

    <div class="item_container col-md-12 row-fluid nopadding">
        @foreach ($categories->chunk(5) as $chunk)
            <div class="row">
                <div class="col-md-1"></div>

                @foreach ($chunk as $index=>$category)

                    <div class="col-md-2 thumbnail_item">
                        @if(Auth::user() && Auth::user()->admin)
                            {!! Form::model($category, ['method' => 'DELETE', 'route' => array('category.destroy', $category->slug) ] ) !!}
                                {!! Form::submit('delete', array('class' => 'generic_submit') )!!}
                            {{ Form::close() }}

                            {!! Form::model($category, ['method' => 'GET', 'route' => array('category.edit', $category->slug)] ) !!}
                                {!! Form::submit('edit', array('class' => 'generic_submit') )!!}
                            {{ Form::close() }}
                        @endif


                        <div class="thumbnail_item_inner category_item">
                            <h2 class="thumbnail_title">
                                <a class="" href="{!! route('category.show', [ $category->slug ]) !!}"> {{$category->title()}} </a>
                            </h2>
                            <span class="underliner"></span>

                            <a class="" href="{!! route('category.show', [ $category->slug ]) !!}">
                                <img src="{{ route('image',$category->thumbnail) }}?w=150&h=150&fit=crop">
                            </a>

                           
                        </div>
                    </div>
                @endforeach

                <div class="col-md-1"></div>
            </div>
        @endforeach

    </div>
@endif

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
