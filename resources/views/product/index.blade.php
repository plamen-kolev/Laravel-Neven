@extends('master_page')
@section('content')

<div class="col-md-12">
    <div class="wrapper center">
        <h1 class="capital">{{$title}}</h1>
    </div>

</div>

@if(!empty($categories))

    <div class="item_container col-md-12 row-fluid" id='category_listing'>
        @foreach ($categories->chunk(5) as $chunk)
            <div class="row">
                <div class="col-md-1"></div>

                @foreach ($chunk as $index=>$category)

                    <div class="col-md-2 thumbnail_item">

                        <div class="thumbnail_item_inner category_item">
                            <h2 class="thumbnail_title">
                                <a class="" href="{!! route('category.show', [ $category->slug ]) !!}"> {{$category->title()}} </a>
                            </h2>
                            <span class="underliner"></span>

                            <a class="" href="{!! route('category.show', [ $category->slug ]) !!}">
                                <img class="b-lazy" alt="{{$category->title()}}" data-src="{{ route('image',$category->thumbnail) }}?w=150&h=150&fit=crop" src="{{ asset('images/loading.gif') }}">
                            </a>

                            @if(Auth::user() && Auth::user()->admin)
                                <span class="pull-right">
                                    {{ Form::open(['method' => 'DELETE', 'route' => ['category.destroy', $category->slug]]) }}
                                        {{ Form::submit('Delete', ['class' => 'glyphicon glyphicon-remove danger confirm_delete']) }}
                                    {{ Form::close() }}

                                    <a class="glyphicon glyphicon-pencil success" href="{{route('category.edit', $category->slug)}}"></a>
                                </span>
                            @endif

                        </div>
                    </div>
                @endforeach

                <div class="col-md-1"></div>
            </div>
        @endforeach

    </div>
@endif

@include('partials.products')


<div class="col-md-12">
    <div class="wrapper center">
        {{$products->render()}}
    </div>
</div>




@stop
