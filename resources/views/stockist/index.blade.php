@extends('master_page')

@section('content')

<div class="col-md-12">
    <div class="wrapper ">
       <div class="col-md-12">
            <h1 class=" capital center">{{trans('text.buy_local')}}</h1>
            <p class="capital center green margin_bottom_100">{{trans('text.shops_distributing_our_products')}}</p>
            @foreach ($stockists->chunk(4) as $chunk)
                <div class="col-md-12 stockist_chunk_wrapper">
                    @foreach($chunk as $stockist)
                        <div class="col-md-3 stock_hover">
                            <div class="stockist_item" id="{{$stockist->slug}}">

                                <div class="stockist_tumbnail col-md-5">
                                    <img width=100% src="{{ route('image', $stockist->thumbnail) }}?w=150&h=150&fit=crop" />
                                </div>
                                <div class="col-md-7">
                                    <h2 >{{$stockist->title}}</h2>
                                    <p>{!! $stockist->address !!}</p>

                                    @if(Auth::user() && Auth::user()->admin)
                                        <span class="pull-right">
                                            {{ Form::open(['method' => 'DELETE', 'route' => ['stockist.destroy', $stockist->slug]]) }}
                                                {{ Form::submit('Delete', ['class' => 'glyphicon glyphicon-remove danger confirm_delete']) }}
                                            {{ Form::close() }}

                                            <a class="glyphicon glyphicon-pencil success" href="{{route('stockist.edit', $stockist->slug)}}"></a>
                                        </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endforeach
        </div>
        
        <div class="col-md-12 extra_padding_50">
            <div class="google_map" id="map"></div>
       </div>
       <div class="col-md-12 center">
            <a class="green_link" href="{{route('stockist')}}">{{trans('text.become_stockist')}}</a>    
       </div>
       
    </div> 
</div>




@stop

@section('scripts')
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBcXrf03SUBrXH55xMQr46NKAUavfqxSE&callback=initMap"></script>
    <script>
        function initMap() {
            var myLatlng = {lat: 59.914095, lng: 10.746957};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: myLatlng
            });

            @foreach($stockists as $stockist)
                var myLatlng = {lat: {{$stockist->lat}}, lng: {{$stockist->lng}} };
                var marker = new google.maps.Marker({
                  position: myLatlng,
                  map: map,
                  title: 'Click to zoom'
                });

                $('#{{$stockist->slug}}').bind('click', { lat: '{{$stockist->lat}}', lng: '{{$stockist->lng}}' }, function(event) {
                    var data = event.data;

                    map.panTo(new google.maps.LatLng('{{$stockist->lat}}', '{{$stockist->lng}}'));
                   
                });
            @endforeach

            marker.addListener('click', function() {
                map.setZoom(8);
                map.setCenter(marker.getPosition());
            });

        }
    </script>
@stop
