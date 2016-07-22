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
        <div class="col-md-10 nopadding">
            <form method="POST" action="{{ route('cart') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="width_100">

                    <tr>
                        <th>{{trans('text.product')}}</th>
                        <th>{{trans('text.title')}}</th>
                        <th>{{trans('text.quantity')}}</th>
                        <th>{{trans('text.price')}}</th>
                    </tr>
                    <div class="col-md-12"><span class="gray_line"></span></div>

                    @foreach($cart as $index=>$row)
                        <tr>
                            <td>
                                <img class="checkout_image" src="{{route('image', $row->options->thumbnail)}}?w=150&h=150&fit=crop" />
                            </td>
                            
                            <td>{{$row->name}} ({{$row->options->option->title}})</td>
                            
                            <td>
                                <input name="{{$row->rowid}}" class="checkout_input" type="number" value="{{$row->qty}}"/>x
                                {{$row->options->weight}} {{trans('text.grams')}}
                            </td>

                            <td>
                                {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}
                                {{ number_format(($row->price * $rate), 2, '.', ',') }}
                            </td>

                            <td>
                                <a href="{{ route('remove_cart_item', $row->rowid) }}" > <img src="/images/x.svg"/> </a>    
                            </td>
                        </tr>
                    @endforeach
                </table>
                <input class="generic_submit" type="submit" value="{{ trans('text.update') }}" />
                <a class="generic_submit checkout_btn" href="{{ route('checkout') }}"> {{ trans('text.checkout') }} </a>
            </form>
        </div>
            
        <div class="col-md-1"></div>
    </div>

</div>

@stop
