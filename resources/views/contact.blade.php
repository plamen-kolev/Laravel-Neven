@extends('master_page')
@section('content')
<div class="col-md-12 nomargin nopadding">
    <h1 class="capital center">{{trans('text.contact')}}</h1>
    <h2 class="center capital green_text no_top_spacing">{{trans('text.hearing_from_you')}}</h2>


    <div class="parallax">
        <div class="bg__rose_1"></div>
    </div>

    <div class="parallax">
        <div class="bg__rose_blur"></div>
    </div>

    <div class="parallax">
        <div class="bg__rose_2"></div>
    </div>

    <div class="wrapper" id="stockist_form">
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
                
                {!! Form::open(array('url' => route('contact') ) ) !!}
                    <div class="col-md-12">
                        {{ Form::label('first_name', trans('text.first_name') ) }}
                        <p>{!! Form::text('first_name', Input::old('first_name'), array('placeholder' => trans("text.first_name"), 'class' => 'generic_input' )); !!}</p>    
                    </div>
                    
                    <div class="col-md-12">
                        {{ Form::label('last_name', trans('text.last_name') ) }}
                        <p>{!! Form::text('last_name', Input::old('last_name'), array('placeholder' => trans("text.last_name"), 'class' => 'generic_input' )); !!}</p>    
                    </div>
                    
                    <div class="col-md-12">
                        {{ Form::label('email', trans('text.email') ) }}
                        <p>{!! Form::text('email', Input::old('email'), array('placeholder' => trans("text.email") , 'class' => 'generic_input')); !!}</p>    
                    </div>
                    
                    <div class="col-md-12">
                        {{ Form::label('telephone', trans('text.telephone') ) }}
                        <p>{!! Form::text('telephone', Input::old('telephone'), array('placeholder' => trans("text.telephone"), 'class' => 'generic_input' )); !!}</p>    
                    </div>
                    

                    <p>
                        {{ Form::label('about', trans('text.about') ) }}
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