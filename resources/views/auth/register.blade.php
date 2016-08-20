@extends('master_page')

@section('register')
<div class="col-md-12">
    <div class="wrapper">
        <h1 class="capital center">{{trans('text.sign_up')}}</h1>

        <div class="col-md-4"></div>

        <div class="col-md-4">

            @if( $errors->all() )
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                      <span class="sr-only">Error:</span>
                        {{ $error }}
                    </div>
                @endforeach
            @endif

            <form class="generic_form" method="POST" action="{!! route('auth.register') !!}">
                {!! csrf_field() !!}

                <p>
                    <input type="text" class="generic_input" placeholder="{{trans('text.name')}}" name="name" value="{{ old('name') }}"/>
                </p>

                <p>
                    <input type="email" class="generic_input" placeholder="{{trans('text.email_address')}}" name="email" value="{{ old('email') }}">
                </p>

                <p>
                    <input type="password" class="generic_input" placeholder="{{trans('text.password')}}" name="password">
                </p>

                <p>
                    <input type="password" class="generic_input" placeholder="{{trans('text.confirm_password')}}" name="password_confirmation">
                </p>

                <p>
                    <input class="generic_submit" type="submit" value="{{trans('text.sign_up')}}" id="user_register_button"/>
                </p>
            </form>

        </div>

        <div class="col-md-4"></div>
    </div>
</div>
@endsection
