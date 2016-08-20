@foreach($cart as $index=>$row)
<div class="col-md-12">
    <div class="col-md-3">
        <img class="checkout_image" src="{{route('image', $row->options->thumbnail)}}?w=150&fit=crop" />
    </div>

    <div class="col-md-3">{{$row->name}} ({{$row->options->option->title}})</div>

    <div class="col-md-3">
        <p>{{$row->qty}}x{{$row->options->weight}} {{trans('text.grams')}}</p>
    </div>

    <div class="col-md-3">
        {{\App\Http\Controllers\HelperController::getCurrencySymbol()}}
        {{ number_format(($row->price * $rate), 2, '.', ',') }} {{trans("text.each")}}
    </div>
</div>
@endforeach
