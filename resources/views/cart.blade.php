@extends('master_page')
@section('content')

@if (Auth::user())
    @if (!Auth::user()->active)
        <div class="col-md-12 " role="alert">
            <div class="wrapper alert alert-danger">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                {!! trans('text.send_activation_email_message', ['url' => route('send_activation_email', Auth::user()->email) ] ) !!}
            </div>
            
        </div>
    @endif


@endif

<div class="col-md-12">
    <div class="wrapper">
        <div class="col-md-1"></div>

        <div class="col-md-2 green">{{trans('text.product')}}</div>
        <div class="col-md-3 green">{{trans('text.title')}}</div>
        <div class="col-md-2 green">{{trans('text.grams')}}</div>
        <div class="col-md-2 green">{{trans('text.quantity')}}</div>
        <div class="col-md-1 green">{{trans('text.price')}}</div>

        <div class="col-md-1"></div>
        <div class="col-md-12"><span class="gray_line"></span></div>
        <form method="POST" action="{{ route('show_cart') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @foreach($cart as $index=>$row)
                <div class="col-md-12 shopping_item_row ">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <img src="{{$row->options->thumbnail_small}}" />
                    </div>
                    
                    <div class="col-md-3">
                        <h2>{{$row->name}} ({{$row->options->option->title}})</h2>
                    </div>
                    
                    <div class="col-md-2">
                        <h2>{{$row->options->weight}}</h2>
                    </div>
                    
                    <div class="col-md-2">
                        <h2><input style="width:100%;" name="{{$row->rowid}}" class="checkout_input" type="number" value="{{$row->qty}}"/></h2>
                    </div>

                    <div class="col-md-1">
                        
                        <h2 class="green">{{\App\Http\Controllers\HelperController::getCurrencySymbol()}}
                        {{ number_format($row->price * $rate, 2, '.', ',') }}</h2>
                    </div>
                    <div class="col-md-1 x">
                        <a href="{{ route('remove_cart_item', $row->rowid) }}" > <img src="/images/x.svg"> </a>
                    </div>
                </div>

            @endforeach

            <div class="col-md-12 check_btns">
                <input class="generic_submit" type="submit" value="{{ trans('text.update') }}" />    
                <a class="generic_submit checkout_btn" href="{{ route('checkout') }}"> {{ trans('text.checkout') }} </a>
            </div>
            
        </form>
    </div>
    
</div>

@stop
