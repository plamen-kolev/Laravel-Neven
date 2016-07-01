@extends('master_page')
@section('content')
    <div class="col-md-12">

        <h1 id="order_successful_message">{{trans('text.successful_order')}}</h1>
        <h2> {{ trans('text.shipping_details') }}  </h2>

        <p> {{ trans('text.order_number') }} : {{$order->order_number}}</p>
        <p> {{ trans('text.email') }} : {{$order->email}}</p>
        <p> {{ trans('text.first_name') }} : {{$order->first_name}}</p>
        <p> {{ trans('text.last_name') }} : {{$order->last_name}}</p>
        <p> {{ trans('text.address') }} : {{$order->address_1}}</p>

        @if($order->address_2)
            <p> {{ trans('text.address_2') }} : {{$order->address_2}}</p>
        @endif
        <p> {{ trans('text.city') }} : {{$order->city}}</p>

        <p> {{ trans('text.post_code') }} : {{$order->post_code}}</p>
        <p> {{ trans('text.country') }} : {{$order->country}}</p>
        <p> {{ trans('text.phone') }} : {{$order->phone}}</p>

        <h1>{{ trans('text.payment')  }}</h1>

        <p> {{ trans('text.total') }} : {{$order->total}}</p>
        <p> {{ trans('text.last4') }} : {{$order->last4}}</p>

        <h1>{{ trans("products")  }}</h1>
        @foreach($cart as $row)

            <p><strong>{{$row->name}} ({{$row->options->option->title}})</strong></p>

            <p> <img width=200 src="{{$row->thumbnail}}"/> {{ trans('text.quantity')  }} {{$row->qty}}    {{ trans('text.price')  }} ${{$row->price}}   {{ trans('text.subtotal')  }} ${{$row->subtotal}}  </p>



        @endforeach
    </div>


@stop