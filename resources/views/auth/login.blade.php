@extends('layouts.login-theme')

@section('content')
                    <div class="header">
                        <div class="logo text-center"><img src="{{asset('public/images/'.$settings->logo)}}" alt="Logo" height="30" width="auto"></div>
                        <p class="lead">Login to your account</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="form-auth-small">
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

                        <div class="form-group clearfix">
                            <label for="password" class="control-label sr-only">{{ __('Password') }}</label>


                                <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>

                        <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left" for="remember">
                                        <input class="fancy-checkbox element-left" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span>{{ __('Remember Me') }}</span>
                                    </label>
                        </div>




                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))


                            <div class="bottom">
                                <span class="helper-text"><i class="fa fa-lock"></i> <a href="{{ route('password.request') }}">Forgot password?</a> 
                                <!-- OR <a href="{{ route('register') }}">Register</a></span> -->
                            </div>

                        @endif

                    </form>

@endsection
