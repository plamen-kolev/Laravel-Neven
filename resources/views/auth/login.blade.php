@extends('master_page')

@section('login')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <h1 class="capital center">{{trans('text.log_in')}}</h1>
            <div class="panel register_container">
                
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{!! route('auth.login') !!}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('text.email_address')}}</label>

                            <div class="col-md-6">
                                <input class="generic_input" type="email" id="login_email_field" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('text.password')}}</label>

                            <div class="col-md-6">
                                <input class="generic_input"  id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">{{trans('text.remember_me')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button class="generic_submit" id="login_button" name="login_button" type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>{{trans('text.log_in')}}
                                </button>
                                <a class="btn btn-link" href="{!! route('auth.password.reset') !!}">{{trans('text.forgotten_password_question')}}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
