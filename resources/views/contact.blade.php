@extends('master_page')
@section('content')

<div class="col-md-12 nopadding nomargin">
    <div id="hero">
         <div class='layer' data-depth='0.10' data-type='parallax'>
             <div class=" layer-contact-back-left pull-left"></div>
             <div class=" layer-contact-back-right pull-right"></div>
         </div>
         <div class='layer' data-depth='0.40' data-type='parallax'>
             <div class=" layer-contact-front-left pull-left"></div>
             <div class=" layer-contact-front-right pull-right"></div>
         </div>
    </div>

    <div class="wrapper">
        <div class="col-md-4"></div>
        <div class="col-md-4" id="stockist_container">
            @if( $errors->all() )
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                      <span class="sr-only">Error:</span>
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            <div class="col-md-12">
                <h1 class="capital center">{{trans('text.contact_us_title')}}</h1>
                {!! Form::open(array('url' => route('contact'), 'class' => 'generic_form' ) ) !!}
                    {{-- {{ Form::label('first_name', trans('text.first_name') ) }} --}}
                    <p>{!! Form::text('first_name', Input::old('first_name'), array('placeholder' => trans("text.first_name"), 'class' => 'generic_input' )); !!}</p>

                    {{-- {{ Form::label('last_name', trans('text.last_name') ) }} --}}
                    <p>{!! Form::text('last_name', Input::old('last_name'), array('placeholder' => trans("text.last_name"), 'class' => 'generic_input' )); !!}</p>

                    {{-- {{ Form::label('email', trans('text.email') ) }} --}}
                    <p>{!! Form::text('email', Input::old('email'), array('placeholder' => trans("text.email") , 'class' => 'generic_input')); !!}</p>

                    {{-- {{ Form::label('telephone', trans('text.telephone') ) }} --}}
                    <p>{!! Form::text('telephone', Input::old('telephone'), array('placeholder' => trans("text.phone"), 'class' => 'generic_input' )); !!}</p>

                    <p>
                        {{-- {{ Form::label('about', trans('text.about') ) }} --}}
                        {!! Form::textarea('about', Input::old('about'),
                                array(
                                    'placeholder' => trans("text.about"),
                                    'maxlength'=>'5000',
                                    'class' => 'generic_input'
                                )
                            );
                        !!}
                    </p>
                    <div>
                    <p>{!! Form::submit(trans('text.submit'), array('class' => 'generic_submit width_65') )!!}</p>
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>

</div>

@stop
