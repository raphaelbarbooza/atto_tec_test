<div>

    <div class="loading-alert" wire:loading>
        <i class="fa-solid fa-spinner me-2 fa-spin"></i> {{ucfirst(__('main.general.loading'))}}
    </div>

    <div class="row border-bottom pb-2">
        <div class="col-lg-3">
            <label>
                @lang('main.producers.filters.search'):
            </label>
            <input type="text" class="form-control" wire:model.debounce.250ms="term"/>
        </div>
        <div class="col-lg-2">
            <label>
                @lang('main.producers.filters.producer_type'):
            </label>
            <select class="form-control" wire:change.prevent="resetPage" wire:model="producerType">
                <option value="">
                    @lang('main.producers.filters.any')
                </option>
                <option value="individual">
                    @lang('main.producers.filters.individual')
                </option>
                <option value="collective">
                    @lang('main.producers.filters.collective')
                </option>
            </select>
        </div>
        <div class="col-lg-2 ms-auto d-flex align-items-end">
            <button class="btn btn-outline-primary" wire:click.prevent="$emit('global__producer_new')">
                <i class="fa-solid fa-user-plus me-2"></i>
                @lang('main.producers.actions.new_producer')
            </button>
        </div>
    </div>
    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead>
            <th>
                @lang('main.producers.table.company_name')
            </th>
            <th>
                @lang('main.producers.table.trade_name')
            </th>
            <th>
                @lang('main.producers.table.social_number')
            </th>
            <th>
                @lang('main.producers.table.state_registration')
            </th>
            <th>
                @lang('main.producers.table.phone')
            </th>
            <th class="text-center">
                @lang('main.producers.table.localization')
            </th>
            <th>
                #
            </th>
            </thead>
            <tbody>
            @foreach($results as $line)
                <tr>
                    <td>
                        <a href="{{route('manage.producers.farms',['producer' => $line->getAttribute('id')])}}">
                        {{$line->getAttribute('company_name')}}
                        </a>
                    </td>
                    <td>
                        {{$line->getAttribute('trading_name')}}
                    </td>
                    <td>
                        {{$line->getAttribute('social_number')}}
                    </td>
                    <td>
                        {{$line->getAttribute('state_registration')}}
                    </td>
                    <td>
                        {{$line->getAttribute('phone')}}
                    </td>
                    <td>
                        {{$line->city->state->getAttribute('letter')}}
                        -
                        {{$line->city->getAttribute('title')}}
                    </td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <a href="{{route('manage.producers.farms',['producer' => $line->getAttribute('id')])}}" type="button" class="btn btn-sm btn-outline-light"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('main.general.actions.details')}}">
                                <span class="text-primary">
                                    <i class="fa-regular fa-rectangle-list"></i>
                                </span>
                            </a>
                            <button wire:click.prevent="$emit('global__producer_edit','{{$line->getAttribute('id')}}')"
                                    type="button" class="btn btn-sm btn-outline-light"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('main.general.actions.edit')}}">
                                <span class="text-primary">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </span>
                            </button>
                            <button wire:click.prevent="$emit('global__producer_request_remove','{{$line->getAttribute('id')}}')"
                                    type="button" class="btn btn-sm btn-outline-light"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('main.general.actions.delete')}}">
                                <span class="text-danger">
                                    <i class="fa-regular fa-trash-can"></i>
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex align-items-center justify-content-center mt-3">
        {{$results->links()}}
    </div>
</div>
