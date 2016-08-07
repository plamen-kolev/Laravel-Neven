@extends('master_page')
@section('content')

<div class="col-md-12">
    <div class="wrapper">
    @foreach($slides as $slide)
        <div class="item">
            <img src="{{route('image', $slide->image)}}?w=720&fit=crop"/>
            {{ Form::open(['method' => 'DELETE', 'route' => ['slide.destroy', $slide->id]]) }}
                {{ Form::submit('Delete', ['class' => 'glyphicon glyphicon-remove danger confirm_delete']) }}
            {{ Form::close() }}
            <p>
                {{$slide->description_en}}
            </p>
            <a class="glyphicon glyphicon-pencil success" href="{{route('slide.edit', $slide->id)}}"></a>
        </div>
    @endforeach

    </div>
</div>

@stop
