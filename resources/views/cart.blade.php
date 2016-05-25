@extends('master_page')
@section('content')
{{ Auth::user() }}
@if (Auth::user())
    @if (!Auth::user()->active)
        <div class="col-md-12 alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>

            {!! trans('text.send_activation_email_message', ['url' => Auth::user()->confirmation_code ] ) !!}
<!--             Your account is not activated, click <a href="{{ route('account_activation', [Auth::user()->confirmation_code])  }}">here</a> to receive another email.
            You must activate your account before a purchace can be placed -->
        </div>
    @endif

{{--@else--}}
    {{--<div class="col-md-12 alert alert-danger" role="alert">--}}
        {{--<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>--}}
        {{--<span class="sr-only">{{trans('text.error')}}:</span>--}}

        {{--{{trans('text.create_account_to_checkout')}}--}}

    {{--</div>--}}
@endif

<div class="col-md-12">
    <form method="POST" action="{{ route('show_cart') }}">
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Weight</th>
                <th>Item Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $row)
            <tr>
                <td>
                    <p><strong>{{$row->name}} ({{$row->options->option->title}})</strong></p>
                </td>
                <td><input name="{{$row->rowid}}" type="number" value="{{$row->qty}}"></td>
                <td>{{$row->options->option->weight}}</td>
                <td>
                    {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}
                    {{ number_format($row->price * $rate, 2, '.', ',') }}
                </td>
                <td>
                    {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}

                    {{ number_format($row->subtotal * $rate, 2, '.', ',') }}
                </td>

                <td><a href="{{ route('remove_cart_item', $row->rowid) }}" class="btn btn-danger">Remove item</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" value="{{ trans('text.submit') }}" />
    </form>

    <a href="{{ route('destroy_cart') }}"> {{trans('text.delete_cart_items') }} </a>
    <a id="checkout_button" href="{{ route('checkout') }}">{{  trans('text.checkout_form') }}</a>
</div>
<div><p>fresh code here</p></div>

<div class="col-md-12">
    <div class="wrapper">
        <div class="col-md-1"></div>

        <div class="col-md-2">{{trans('text.product')}}</div>
        <div class="col-md-3">{{trans('text.title')}}</div>
        <div class="col-md-2">{{trans('text.grams')}}</div>
        <div class="col-md-2">{{trans('text.quantity')}}</div>
        <div class="col-md-1">{{trans('text.price')}}</div>

        <div class="col-md-1"></div>
        <div class="col-md-12"><span class="gray_line"></span></div>

        @foreach($cart as $row)
            <div class="col-md-12 shopping_item_row">
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <img src="{{$row->options->thumbnail_small}}" />
                </div>
                
                <div class="col-md-3">
                    <h2>{{$row->name}}</h2>
                </div>
                
                <div class="col-md-2">
                    <h2>{{$row->options->weight}}</h2>
                </div>
                
                <div class="col-md-2">
                    <h2>{{$row->qty}}</h2>
                </div>

                <div class="col-md-1">
                    
                    <h2>{{\App\Http\Controllers\HelperController::getCurrencySymbol()}}
                    {{ number_format($row->price * $rate, 2, '.', ',') }}</h2>
                </div>
                <div class="col-md-1"></div>
            </div>

        @endforeach
    </div>
    
</div>

@stop
