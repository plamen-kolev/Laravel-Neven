@extends('master_page')
@section('content')

<div class="col-md-12">
    <div class="wrapper">
        
        @foreach($ingredients as $ingredient)

            <div class="col-md-2">
                @if(Auth::user() && Auth::user()->admin)
                    <span class="pull-right">
                        {{ Form::open(['method' => 'DELETE', 'route' => ['ingredient.destroy', $ingredient->slug]]) }}
                            {{ Form::submit('Delete', ['class' => 'glyphicon glyphicon-remove danger confirm_delete']) }}
                        {{ Form::close() }}

                        <a class="glyphicon glyphicon-pencil success" href="{{route('blog.edit', $ingredient->slug)}}"></a>
                    </span>
                @endif

                <img class="ingr_pop_img" src="{{route('image', $ingredient->thumbnail)}}?w=150&h=150&fit=crop" alt="{{$ingredient->title()}}" >
                <h1>{{$ingredient->title()}}</h1>
                
                <p>{{$ingredient->description()}}</p>

            </div>

        @endforeach

    </div>
</div>

@stop
