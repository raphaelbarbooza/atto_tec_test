<?php

namespace App\Repositories;

use App\Helpers\StringHelper;
use App\Models\Farms;
use App\Models\Plots;
use App\Models\Producer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PlotRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Plots();
    }


    /**
     * @param string $farmId
     * @param string $plotIdentification
     * @param string $geoJsonFile
     * @return Plots
     *
     * Create a new Plot into a farm
     */
    public function create(
        string $farmId,
        string $plotIdentification,
        string $geoJsonFile
    ): Plots
    {
        return $this->model->create([
            'farm_id' => $farmId,
            'identification' => $plotIdentification,
            'geojson_file' => $geoJsonFile
        ]);
    }

    /**
     * @param array $filters
     * @param int $pagination
     * @return Collection|LengthAwarePaginator
     *
     * Get all plots from a farm
     */
    public function getAllFromFarm(
        string $farmId,
    ): Collection | LengthAwarePaginator
    {
        // Create Query
        $query = $this->model->where('farm_id',$farmId);

        // Return
        return $query->get();
    }

    public function getFromFarm($farmId, $id) : Plots | null
    {
        return $this->model->where('farm_id',$farmId)->where('id',$id)->first();
    }

    /**
     * @param $id
     * @return bool
     *
     * Remove a Plot by id
     */
    public function remove($id) : bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function getTotalCount(): int
    {
        return $this->model->count();
    }

}
