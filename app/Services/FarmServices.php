<?php

namespace App\Services;

use App\Models\Farms;
use App\Repositories\FarmRepository;
use App\Repositories\PlotRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Shapefile\ShapefileReader;

class FarmServices
{
    protected $filters = [];
    protected $data = [];

    protected $paginate = 0;

    protected $farmRepository;
    protected $plotRepository;

    protected $selectedProducerId = false;
    protected $selectedFarmId = false;

    /**
     * If we are not using SOLID,
     * we can use a Service to interact with more than one instances or repository.
     */
    public function __construct()
    {
        $this->farmRepository = new FarmRepository();
        $this->plotRepository = new PlotRepository();
    }

    /**
     * @return FarmServices
     * In this service layer, we are using Builder Pattern
     * A static method build will return a new instance
     */
    public static function build(){
        return new FarmServices();
    }

    /**
     * @param $producerId
     * @return $this
     *
     * Load a producer id to this services
     */
    public function loadProducer($producerId){
        $this->selectedProducerId = $producerId;
        return $this;
    }

    /**
     * @param string $farmName
     * @return Farms
     *
     * Use the loaded producer and create a farm to it
     */
    public function createFarm(
        string $farmName
    ): Farms
    {
        return $this->farmRepository->create(
            producerId: $this->selectedProducerId,
            farmName: $farmName
        );
    }

    /**
     * @param $farmId
     * @return $this
     *
     * The same way we are loading a producer
     * we will load a farm by its id
     */
    public function loadFarm($farmId)
    {
        $this->selectedFarmId = $farmId;
        return $this;
    }

    /**
     * Different of the Producer Services we are using loaders to
     * select the model objet to update later.
     * I'm using it just to show other ways to do the same thing
     */
    public function update(
        string $farmName
    ): Farms
    {
        return $this->farmRepository->update(
            id: $this->selectedFarmId,
            farmName: $farmName
        );
    }

    /**
     * Return all farms from a selected producer
     */
    public function getFarms($filter = ""){
        return $this->farmRepository->getAllFromProducer($this->selectedProducerId, $filter);
    }

    /**
     * @param false $id
     * @return Farms
     *
     * If we load a producer, we find a farm into this producer
     * If we load a farm, we return the loaded farm
     * If we pass a id, we return the farm by it's id
     */
    public function getFarm($id = false) : Farms
    {
        if(!$id && !$this->selectedFarmId)
            throw new \Error("To get a farm object, you have to pass a farm id or load a farm into the service.");

        // Select with producer id
        if($this->selectedProducerId)
            return $this->farmRepository->getFromProducer($this->selectedProducerId, $id);

        // Select by load
        if($this->selectedFarmId)
            return $this->farmRepository->get($this->selectedFarmId);

        // Select by id
        return $this->farmRepository->get($id);
    }

    /**
     * @param $id
     * @return bool
     *
     * Remove by it's id or the loaded farm
     */
    public function remove($id = false) : bool
    {
        if(!$id && !$this->selectedFarmId)
            throw new \Error("To remove a farm object, you have to pass a farm id or load a farm into the service.");

        // Select by load
        if($this->selectedFarmId)
            return $this->farmRepository->remove($this->selectedFarmId);

        // Select by id
        return $this->farmRepository->remove($id);

    }


    /**
     * @param string $identification
     * @param array $files
     *
     * Receive the identification and the uploaded files
     */
    public function createPlot(string $identification, array $files){
        /**
         * Check if the array contains valid files
         * If its geojson, only can get one
         * If has a shape file, can have shp, shx, prj and dbf file too
         */
        $isJson = false;
        $hasShp = false;

        $arr = [];

        foreach($files as $file){

            $fileOriginalExtension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));

            if( $fileOriginalExtension == 'json' && count($files) > 1)
                throw new \Error(__('main.plot.form.invalid_file'));

            if( $fileOriginalExtension == 'json')
                $isJson = true;

            if(!in_array(strtolower($fileOriginalExtension),['json','dbf','shx','shp','prj','bin']))
                throw new \Error(__('main.plot.form.invalid_file')."|".$fileOriginalExtension);

            if(strtolower($fileOriginalExtension == 'shp'))
                $hasShp = true;

        }

        if(!$isJson && !$hasShp)
            throw new \Error(__('main.plot.form.invalid_file')."|Json or Shape");

        // Handle the Files
        if($isJson){
            // Handle it as a geojson
            // Store the first file
            $fileName = $files[0]->store('geojson');
        }
        if($hasShp){

            try {

                // Handle it as shape file
                // Store all in a temp folder
                $shpPath = '';
                foreach($files as $file){
                    $fileOriginalExtension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));

                    $path = $file->storeAs('shptemp','TMP.'.$fileOriginalExtension);
                    if($fileOriginalExtension == 'shp'){
                        $shpPath = $path;
                    }
                }
                // Process the shape from shape path
                $geoJsonContents = false;
                $shapeFile = new ShapefileReader(Storage::path($shpPath));
                while ($geometry = $shapeFile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($geometry->isDeleted()) {
                        continue;
                    }
                    // Get the GeoJson File, and ignore anothers geometry, we are assuming that a simples shape
                    $geoJsonContents = $geometry->getGeoJSON();
                    break;
                }
                // Save the geojson contents on a geojson file
                $fileName = 'geojson/'.Str::random(30).'.geo.json';
                Storage::put($fileName,$geoJsonContents);

            }catch (\Throwable $throwable){
                throw new \Error(__('main.plot.form.invalid_file')."|Invalid Shape Files");
            }

        }

        // Now add this data as plot
        return $this->plotRepository->create($this->selectedFarmId, $identification, $fileName);

    }

    /**
     * @param $id
     * Get a plot on the selected farm
     */
    public function getPlot($id){
        return $this->plotRepository->getFromFarm($this->selectedFarmId, $id);
    }

    /**
     * @return Collection|LengthAwarePaginator
     *
     * Get all the plots from the selected farm
     */
    public function getFarmPlots(){
        return $this->plotRepository->getAllFromFarm($this->selectedFarmId);
    }

    public function removePlot($id){
        return $this->plotRepository->remove($id);
    }

    public function getTotalFarmCount(){
        return $this->farmRepository->getTotalCount();
    }

    public function getTotalPlotCount(){
        return $this->plotRepository->getTotalCount();
    }

}
