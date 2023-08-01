<div class="border-start ms-3 ps-3 d-flex">
    <div>
        <b>{{__('main.producers.table.company_name')}}</b>: {{$producer->getAttribute('company_name')}} <br/>
        <b>{{__('main.producers.table.social_number')}}</b>: {{$producer->getAttribute('social_number')}}
    </div>
    <div class="border-start ms-3 ps-3">
        <b>{{__('main.producers.table.trade_name')}}</b>: {{$producer->getAttribute('trading_name')}} <br/>
        <b>{{__('main.producers.table.state_registration')}}</b>: {{$producer->getAttribute('state_registration')}}
    </div>
    <div class="border-start ms-3 ps-3">
        <b>{{__('main.producers.table.phone')}}</b>: {{$producer->getAttribute('phone')}} <br/>
        <b>{{__('main.producers.table.city')}}</b>: {{$producer->city->getAttribute('title')}} - {{$producer->city->state->getAttribute('letter')}}
    </div>
    <div class="border-start ms-3 ps-3 d-flex flex-column">
        <a href="#" wire:click.prevent="$emit('global__producer_edit','{{$producer->getAttribute('id')}}')">
                                <span class="text-primary">
                                    <i class="fa-regular fa-pen-to-square me-2"></i>
                                    {{__('main.general.actions.edit')}}
                                </span>
        </a>

        <a href="#" wire:click.prevent="$emit('global__producer_request_remove','{{$producer->getAttribute('id')}}')">
                                <span class="text-danger">
                                    <i class="fa-regular fa-trash-can me-2"></i>
                                    {{__('main.general.actions.delete')}}
                                </span>
        </a>
    </div>
</div>
