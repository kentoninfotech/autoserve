@extends('layouts.login-theme')

@section('content')
     <div class="panel panel-default">
        <div class="header">
            <h3 class="heading">{{ __('Reset Password') }}</h3>
        </div>
        
     <div class="panel-body"> 
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}" class="form-auth-small">
            @csrf

            <div class="form-group clearfix">
                <label for="email" class="control-label sr-only">{{ __('E-Mail Address') }}</label>


                    <input placeholder="E-mail" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">
                {{ __('Send Password Reset Link') }}
            </button>
        </form>
     </div>
     </div>

@endsection
