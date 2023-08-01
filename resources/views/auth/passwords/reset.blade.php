@extends('layouts.auth')

@section('page-title',__('main.auth.reset_password.title'))

@section('content')
    <div class="card border-0 box-shadow-01">

        <div class="fs-5 text-muted text-center my-3">
            @lang('main.auth.reset_password.title')
        </div>

        <div class="px-4 text-muted text-center">
            @lang('main.auth.reset_password.reset_instructions')
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">@lang('main.auth.email')</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>@lang('main.auth.reset_password.default_email_error')</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">
                        @lang('main.auth.password')
                    </label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>@lang('main.auth.reset_password.default_password_error')</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">
                        @lang('main.auth.confirm_password')
                    </label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            @lang('main.auth.reset_password_action')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
