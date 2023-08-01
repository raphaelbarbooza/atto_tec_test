<div wire:keyup.enter="login">

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">
                @lang('main.auth.email'):
            </label>

            <div class="col-md-6">
                <input wire:model.lazy="inputMail" id="email" type="email" class="form-control @error('inputMail') is-invalid @enderror" autofocus>

                @error('inputMail')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>

        </div>

        <div class="row mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-end">
                @lang('main.auth.password'):
            </label>

            <div class="col-md-6">
                <input wire:model.defer="inputPass" type="password" class="form-control @error('password') is-invalid @enderror">

                @error('inputPassword')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button wire:click.prevent="login" class="btn btn-primary w-100" wire:loading.attr="disabled">
                    <div wire:loading>
                        <i class="fa-solid fa-spinner fa-spin"></i>
                    </div>
                    <div wire:loading.remove>
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>
                        @lang('main.auth.login')
                    </div>
                </button>

                <div class="mt-3">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            @lang('main.auth.forgot_password')
                        </a>
                    @endif
                </div>
            </div>
            <livewire:general.language-switcher></livewire:general.language-switcher>
        </div>

</div>
