<div>
    <div class="fs-5 text-muted border-bottom pb-2 mb-2 d-flex align-items-center">
        <div>
            Registered Farms:
        </div>
        <button class="btn btn-outline-primary ms-auto" wire:click.prevent="requestCreate">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    <div>
        <input type="text" class="form-control" placeholder="Filter..." wire:model.debounce.250ms="filter"/>

        <ul class="list-group mt-2">
            @foreach($farms as $farm)

                    <li class="list-group-item @if($selectedFarm && $farm->getAttribute('id') == $selectedFarm->getAttribute('id')) active @endif" aria-current="true">
                        <a href="#" wire:click.prevent="selectFarm('{{$farm->getAttribute('id')}}')"><i class="fa-regular fa-map me-2"></i> {{$farm->getAttribute('name')}}</a>
                    </li>

            @endforeach
        </ul>
    </div>
</div>
