<div class="modal fade" id="producer-form-modal" wire:ignore.self>

    <div class="loading-alert" wire:loading>
        <i class="fa-solid fa-spinner me-2 fa-spin"></i> {{ucfirst(__('main.general.loading'))}}
    </div>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    {{$title}}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-5">
                <div>
                    <label>
                        @lang('main.producers.table.company_name')
                    </label>
                    <input type="text" class="form-control @error('producerData.company_name') is-invalid @enderror" wire:model.lazy="producerData.company_name" />
                    {{-- It's weird... but usually we don't use camel case on array index - \_(o.o)_/ --}}

                    @error('producerData.company_name')
                    <small class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </small>
                    @enderror

                </div>
                <div class="mt-3">
                    <label>
                        @lang('main.producers.table.trade_name')
                    </label>
                    <input type="text" class="form-control @error('producerData.trading_name') is-invalid @enderror" wire:model.lazy="producerData.trading_name" />

                    @error('producerData.trading_name')
                    <small class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </small>
                    @enderror

                </div>
                <div class="mt-3">
                    <label>
                        @lang('main.producers.table.social_number')
                    </label>
                    <input @if(!$creating) disabled @endif id="producer-social-number" type="text" class="form-control @error('producerData.social_number') is-invalid @enderror"
                           wire:model.debounce="producerData.social_number" />
                    @error('producerData.social_number')
                    <small class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>
                        @lang('main.producers.table.state_registration')
                    </label>
                    <input id="producer-state-registration" type="text" class="form-control @error('producerData.state_registration') is-invalid @enderror"
                           wire:model.debounce="producerData.state_registration" />
                    @error('producerData.state_registration')
                    <small class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>
                        @lang('main.producers.table.phone')
                    </label>
                    <input id="producer-phone" type="text" class="form-control @error('producerData.phone') is-invalid @enderror"
                           wire:model.lazy="producerData.phone" />

                    @error('producerData.phone')
                    <small class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>
                        @lang('main.producers.table.state')
                    </label>
                    <select class="form-control @error('producerData.state_id') is-invalid @enderror" wire:model="producerData.state_id">
                        @foreach($statesList as $state)
                            <option value="{{$state->getAttribute('id')}}">
                                {{$state->getAttribute('title')}}
                            </option>
                        @endforeach
                    </select>

                    @error('producerData.state_id')
                    <small class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
                <div class="mt-3">
                    <label>
                        @lang('main.producers.table.city')
                    </label>
                    <select class="form-control @error('producerData.city_id') is-invalid @enderror" wire:model="producerData.city_id">
                        @foreach($cityList as $city)
                            <option value="{{$city->getAttribute('id')}}">
                                {{$city->getAttribute('title')}}
                            </option>
                        @endforeach
                    </select>

                    @error('producerData.city_id')
                    <small class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('main.general.actions.close')}}</button>
                <button type="button" class="btn btn-primary" wire:click.prevent="save">
                    <i class="fa-regular fa-floppy-disk me-2"></i>
                    {{__('main.general.actions.save')}}
                </button>
            </div>
        </div>
    </div>
</div>
