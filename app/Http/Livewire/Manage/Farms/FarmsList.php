<?php

namespace App\Http\Livewire\Manage\Farms;

use App\Models\Farms;
use App\Repositories\FarmRepository;
use App\Services\FarmServices;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FarmsList extends Component
{

    public $producerId;
    public $selectedFarm;

    public $filter = "";

    protected $listeners = [
        'scoped__farm_create' => 'createFarm',
        'global__farm_request_update' => 'requestUpdate',
        'scoped__farm_update' => 'updateFarm',
        'global__farm_request_remove' => 'requestRemove',
        'scoped__farm_remove' => 'removeFarm',
        'global__farm_updated' => 'render',
        'global__farm_removed' => 'render'
    ];

    public function mount($producerId)
    {
        $this->producerId = $producerId;
    }

    public function render()
    {
        // Get All Farms
        $data['farms'] = FarmServices::build()->loadProducer($this->producerId)->getFarms($this->filter);
        return view('livewire.manage.farms.farms-list', $data);
    }

    public function requestCreate()
    {
        // Dispatch event to farm create alert
        $this->dispatchBrowserEvent('inputAlert', [
            'title' => __('main.farms.actions.new_farm'),
            'message' => __('main.farms.table.name') . ":",
            'alert' => __('main.farms.creating_alert'),
            'initial_value' => '',
            'emit_when_confirmed' => 'scoped__farm_create',
            'emit_params' => $this->producerId
        ]);
    }

    public function requestUpdate()
    {
        // Dispatch event to farm create alert
        $this->dispatchBrowserEvent('inputAlert', [
            'title' => __('main.farms.actions.edit_farm'),
            'message' => __('main.farms.table.name') . ":",
            'alert' => '',
            'initial_value' => $this->selectedFarm->getAttribute('name'),
            'emit_when_confirmed' => 'scoped__farm_update',
            'emit_params' => $this->selectedFarm->getAttribute('id')
        ]);
    }

    public function requestRemove()
    {
        // Dispatch event to farm create alert
        $this->dispatchBrowserEvent('confirmationAlert', [
            'title' => __('main.farms.actions.remove_farm'),
            'message' => __('main.farms.to_remove', ['farm' => $this->selectedFarm->getAttribute('name')]),
            'emit_when_confirmed' => 'scoped__farm_remove',
            'emit_params' => $this->selectedFarm->getAttribute('id')
        ]);
    }

    public function selectFarm($farmId)
    {
        // Select to this component
        $this->selectedFarm = FarmServices::build()->getFarm($farmId);
        // Emit Up
        $this->emit('scoped__select_farm', $farmId);
    }

    /**
     * @param $farmName
     * @param $producerId
     *
     * Receive the event to create a new farm on the selected producer.
     * We use the producer id to recheck if the component who ask for creation is the same that
     * will create.
     */
    public function createFarm($farmName, $producerId)
    {
        if ($producerId == $this->producerId) {
            // Begin Transaction
            DB::beginTransaction();
            try {
                $newFarm = FarmServices::build()->loadProducer($producerId)->createFarm($farmName);
                DB::commit();
                // Select the created farm
                $this->selectFarm($newFarm->getAttribute('id'));
                // Empty filter
                $this->filter = '';
                // Show Success Message
                $this->dispatchBrowserEvent('successMessage', ['message' => __('main.farms.created')]);
            } catch (\Throwable $throwable) {
                DB::rollBack();
                $this->dispatchBrowserEvent('errorMessage', ['message' => $throwable->getMessage()]);
                return false;
            }
        }
    }

    public function updateFarm($farmName, $farmId)
    {
        if ($farmId == $this->selectedFarm->getAttribute('id')) {
            // Begin Transaction
            DB::beginTransaction();
            try {
                FarmServices::build()->loadFarm($farmId)->update($farmName);
                DB::commit();
                // Emit event to update
                $this->emit('global__farm_updated');
                // Show Success Message
                $this->dispatchBrowserEvent('successMessage', ['message' => __('main.farms.updated')]);
            } catch (\Throwable $throwable) {
                DB::rollBack();
                $this->dispatchBrowserEvent('errorMessage', ['message' => $throwable->getMessage()]);
                return false;
            }
        }
    }

    public function removeFarm($farmId)
    {
        if ($farmId == $this->selectedFarm->getAttribute('id')) {
            // Begin Transaction
            DB::beginTransaction();
            try {
                FarmServices::build()->loadFarm($farmId)->remove();
                DB::commit();
                // Unselect
                $this->selectedFarm = null;
                // Emit event to update
                $this->emit('global__farm_removed');
                // Show Success Message
                $this->dispatchBrowserEvent('successMessage', ['message' => __('main.farms.removed')]);
            } catch (\Throwable $throwable) {
                DB::rollBack();
                $this->dispatchBrowserEvent('errorMessage', ['message' => $throwable->getMessage()]);
                return false;
            }
        }
    }
}
