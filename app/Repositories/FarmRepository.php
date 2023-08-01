<?php

namespace App\Repositories;

use App\Helpers\StringHelper;
use App\Models\Farms;
use App\Models\Producer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FarmRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Farms();
    }


    /**
     * @param string $producerId
     * @param string $farmName
     * @return Farms
     *
     * Create a new farm using base data
     */
    public function create(
        string $producerId,
        string $farmName,
    ): Farms
    {
        return $this->model->create([
            'producer_id' => $producerId,
            'name' => $farmName
        ]);
    }

    /**
     * @param string $id
     * @param string $producerId
     * @param string $farmName
     * @return Farms
     *
     * The farm only have one updateable column... farmname
     * so we don't need to check for individually update.
     */
    public function update(
        string $id, // We don't change the producer_id
        string $farmName,
    ): Farms
    {
        // Get the farm to return later
        $farm = $this->model->findOrFail($id);
        // Update
        $farm->update([
            'name' => $farmName
        ]);

        // Return farm
        return $farm;
    }

    /**
     * @param array $filters
     * @param int $pagination
     * @return Collection|LengthAwarePaginator
     *
     * Get all farms from a especific
     */
    public function getAllFromProducer(
        string $producerId,
        string $filter = '',
        int   $pagination = 0
    ): Collection | LengthAwarePaginator
    {
        // Create Query
        $query = $this->model->where('producer_id',$producerId)->where('name','LIKE','%'.$filter.'%');

        // Return
        return $pagination ? $query->paginate($pagination) : $query->get();
    }

    /**
     * @param $id
     * @return Farms
     *
     * Get a Farm from its id
     */
    public function get($id) : Farms
    {
        return $this->model->findOrFail($id);
    }

    public function getFromProducer($producerId, $id) : Farms
    {
        return $this->model->where('producer_id',$producerId)->where('id',$id)->first();
    }

    /**
     * @param $id
     * @return bool
     *
     * Remove a Farm by id
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
