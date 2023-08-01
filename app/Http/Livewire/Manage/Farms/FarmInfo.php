<?php

namespace App\Http\Livewire\Manage\Farms;

use App\Repositories\FarmRepository;
use App\Services\FarmServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class FarmInfo extends Component
{
    use WithFileUploads;

    public $selectedFarmId = false;
    public $selectedPlotId = 0;

    protected $listeners = [
        'scoped__select_farm' => 'loadFarm',
        'global__farm_updated' => 'render',
        'global__farm_removed' => 'unselect',
        'scoped__plot_remove' => 'removePlot'
    ];

    public $plotData = [
        'identification' => '',
        'file' => []
    ];

    protected $rules = [
        'plotData.identification' => 'required|min:1|string',
        'plotData.file.*' => 'file'
    ];

    public function validationAttributes()
    {
        return [
            'plotData.identification' => __('main.plot.form.identification'),
            'plotData.file' => __('main.plot.form.file_field')
        ];
    }

    public function render()
    {
        if($this->selectedFarmId){
            // Load the Farm
            $data['farm'] = FarmServices::build()->getFarm($this->selectedFarmId);
            // Load Selected Plot
            if($this->selectedPlotId)
                $data['plot'] = FarmServices::build()->loadFarm($this->selectedFarmId)->getPlot($this->selectedPlotId);
            else
                $data['plot'] = false;

            // Get Plot List
            $data['plot_list'] = FarmServices::build()->loadFarm($this->selectedFarmId)->getFarmPlots();
        }
        else
            $data['farm'] = false;

        return view('livewire.manage.farms.farm-info', $data);
    }

    public function updated($name, $value)
    {
        // Load the Map
        if($name == 'selectedPlotId'){
           $this->plotOnMap($value);
        }
    }

    public function plotOnMap($value){
        // Load the plot and insert on the map
        $plot = FarmServices::build()->loadFarm($this->selectedFarmId)->getPlot($value);
        // Load json content
        $json = Storage::get($plot->getAttribute('geojson_file'));
        // Plot on map
        $this->dispatchBrowserEvent('loadGeoJson',['jsonContent' => $json]);
    }

    public function loadFarm($farmId){
        $this->selectedFarmId = $farmId;
        $this->selectedPlotId = 0;
    }

    public function unselect(){
        $this->selectedFarmId = null;
        $this->selectedPlotId = 0;
    }

    public function createPlot(){
        $this->validate();
        DB::beginTransaction();
        try {
            $newPlot = FarmServices::build()->loadFarm($this->selectedFarmId)->createPlot($this->plotData['identification'], $this->plotData['file']);
            DB::commit();
        }catch (\Throwable $throwable){
            DB::rollBack();
            $this->dispatchBrowserEvent('errorMessage', ['message' => $throwable->getMessage()]);
            return false;
        }
        // Created
        $this->dispatchBrowserEvent('successMessage', ['message' => __('main.plot.created')]);
        // Close Modal
        $this->dispatchBrowserEvent('closeModal',['modalId' => 'newPlotModal']);
        // Clear data
        $this->plotData = [
            'identification' => '',
            'file' => []
        ];
        // Plot on Map
        $this->plotOnMap($newPlot->getAttribute('id'));
        // Select the new created plot
        $this->selectedPlotId = $newPlot->getAttribute('id');
    }

    public function requestPlotRemove(){
        // Load the plot
        $selectedPlot = FarmServices::build()->loadFarm($this->selectedFarmId)->getPlot($this->selectedPlotId);
        // Dispatch event to plot remove
        $this->dispatchBrowserEvent('confirmationAlert', [
            'title' => __('main.plot.actions.remove_plot'),
            'message' => __('main.plot.to_remove', ['plot' => $selectedPlot->getAttribute('identification')]),
            'emit_when_confirmed' => 'scoped__plot_remove',
            'emit_params' => $selectedPlot->getAttribute('id')
        ]);
    }

    public function removePlot($plotId)
    {
        if ($plotId == $this->selectedPlotId) {
            // Begin Transaction
            DB::beginTransaction();
            try {
                FarmServices::build()->loadFarm($this->selectedFarmId)->removePlot($plotId);
                DB::commit();
                // Unselect
                $this->selectedPlotId = '0';
                // Emit event to update
                $this->emit('global__plot_removed');
                // Show Success Message
                $this->dispatchBrowserEvent('successMessage', ['message' => __('main.plot.removed')]);
            } catch (\Throwable $throwable) {
                DB::rollBack();
                $this->dispatchBrowserEvent('errorMessage', ['message' => $throwable->getMessage()]);
                return false;
            }
        }
    }

}
