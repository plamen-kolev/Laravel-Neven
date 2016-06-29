@extends('master_page')
@section('content')

<div class="col-md-12">
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          <span class="sr-only">Error:</span>
            {{ $error }}
        </div>
    @endforeach
</div>

<div class="col-md-12">
    <div class="wrapper">
        <h1 class="capital center"> {{ trans('text.change_password') }} </h1>

        <div class="col-md-4"></div>
        <div class="col-md-4 form_border">
            {!! Form::open(array('url' => route('change_password'), 'method' => 'POST')) !!}
                
                {{-- {{ Form::label('current_password', trans('text.current_password')) }} --}}
                {!! Form::password('current_password', array('class'=>'generic_input', 'placeholder' => trans('text.current_password'))) !!}

                {{-- {{ Form::label('password', trans('text.password')) }} --}}
                {!! Form::password('password', array('class'=>'generic_input', 'placeholder' => trans('text.password'))) !!}

                {{-- {{ Form::label('password_confirmation', trans('text.confirm_password')) }} --}}
                {!! Form::password('password_confirmation', array('class'=>'generic_input', 'placeholder' => trans('text.confirm_password'))) !!}
                
                {!! Form::submit(trans('text.change_password'), array('class'=>'generic_submit capital', 'id' => 'change_password_button')) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
    

@stop
