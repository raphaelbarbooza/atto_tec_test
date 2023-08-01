@extends('layouts.auth')

@section('page-title',__('main.auth.reset_password.title'))

@section('content')
    <div class="card border-0 box-shadow-01">

        <div class="fs-5 text-muted text-center my-3">
            @lang('main.auth.reset_password.title')
        </div>

        <div class="px-4 text-muted text-center">
                @lang('main.auth.reset_password.instructions')
        </div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">@lang('main.auth.email')</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>
                                @lang('main.auth.reset_password.default_email_error')
                            </strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            @lang('main.auth.reset_password.send_password_link')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
