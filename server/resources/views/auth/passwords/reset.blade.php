@extends('layouts.main')

@section('content')
<div class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form method="POST" action="{{ route('password.request') }}" class="card">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="card-body p-6">
                        <div class="card-title">
                            <img src="{{ asset('brand/logo.svg') }}" alt="{{ config('app.name') }}" class="img-fluid">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
                            <div role="group" class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fe fe-mail"></i></div>
                                </div>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="{{ __('E-Mail Address') }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">{{ __('Password') }}</label>
                            <div role="group" class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fe fe-lock"></i></div>
                                </div>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('Password') }}">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                            <div role="group" class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fe fe-lock"></i></div>
                                </div>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="{{ __('Confirm Password') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-6">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
