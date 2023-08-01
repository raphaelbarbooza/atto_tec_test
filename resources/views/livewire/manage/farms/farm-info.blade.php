<div class="h-100 flex-column d-flex border">

    @if(!$farm)
        <div class="h-100 w-100 d-flex align-items-center justify-content-center">
            <div class="fs-3">
                @lang('main.farms.select_alert')
            </div>
        </div>
    @else
        <div class="p-2 bg-light w-100 border-bottom d-flex align-items-center">
            <div class="d-flex">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#" wire:click.prevent="$emit('global__farm_request_update')">
                                <i class="fa-solid fa-pencil me-2"></i> {{__('main.farms.actions.edit_farm')}}
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" wire:click.prevent="$emit('global__farm_request_remove')">
                                <i class="fa-solid fa-trash-can me-2"></i> {{__('main.farms.actions.remove_farm')}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="ms-2">
                    {{$farm->getAttribute('name')}}
                </div>
            </div>
            <div class="ms-auto d-flex">
                <div class="ps-3">
                    <select class="form-control" wire:model.debounce.250ms="selectedPlotId">
                        <option value="0" disabled>{{__('main.plot.actions.select_plot')}}</option>
                        @foreach($plot_list as $plotItem)
                            <option value="{{$plotItem->getAttribute('id')}}">
                                {{$plotItem->getAttribute('identification')}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="ms-3 border-start ps-3">
                    <button class="btn btn-outline-dark" data-bs-target="#newPlotModal" data-bs-toggle="modal">
                        <i class="fa-solid fa-plus me-2"></i> {{__('main.plot.actions.new_plot')}}
                    </button>

                    @if($selectedPlotId)
                        <button class="ms-3 btn btn-outline-danger" wire:click.prevent="requestPlotRemove">
                            <i class="fa-solid fa-xmark me-2"></i> {{__('main.general.actions.delete')}}
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @if($selectedPlotId)
            <div id="map" class="bg-dark flex-grow-1">

            </div>
        @else
            <div class="bg-light flex-grow-1 d-flex justify-content-center align-items-center">
                <div class="fs-4">
                    {{__('main.plot.no_loaded')}}
                </div>
            </div>
        @endif

        <div wire:ignore.self class="modal fade" id="newPlotModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">
                            {{__('main.plot.actions.new_plot')}}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label>
                                {{__('main.plot.form.identification')}}:
                            </label>
                            <input type="text" class="form-control @error('plotData.identification') is-invalid @enderror"
                                   wire:model.defer="plotData.identification"/>
                            @error('plotData.identification')
                            <small class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label>
                                {{__('main.plot.form.file')}}:
                            </label>
                            <input multiple type="file" class="form-control @error('plotData.file') is-invalid @enderror"
                                   wire:model.defer="plotData.file"/>
                            @error('plotData.file')
                            <small class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <div class="d-flex align-items-center">
                            <div wire:loading>
                                <i class="fa-solid fa-spinner fa-spin me-2"></i>
                                {{__('main.general.loading')}}
                            </div>
                        </div>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("main.general.actions.close")}}</button>
                            <button wire:loading.attr="disabled" type="button"
                                    wire:click.prevent="createPlot" class="btn btn-primary">{{__('main.general.actions.save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

</div>
