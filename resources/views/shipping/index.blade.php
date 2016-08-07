@extends('master_page')
@section('content')

<div class="col-md-12">
    <div class="wrapper">
        @foreach($shipping_options as $shipping_option)
            <div class="col-md-2">
                <span class="pull-right">
                    {{ Form::open(['method' => 'DELETE', 'route' => ['shipping.destroy', $shipping_option->id]]) }}
                        {{ Form::submit('Delete', ['class' => 'glyphicon glyphicon-remove danger confirm_delete']) }}
                    {{ Form::close() }}

                    <a class="glyphicon glyphicon-pencil success" href="{{route('shipping.edit', $shipping_option->id)}}"></a>
                </span>

                <h1>Country: {{$shipping_option->country}}</h1>
                
                <p>Weight: {{$shipping_option->weight}}</p>
                <p>Price: {{$shipping_option->price}}</p>
            </div>
        @endforeach
    </div>
</div>

@stop
