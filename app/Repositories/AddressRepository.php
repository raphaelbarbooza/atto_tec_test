<?php

namespace App\Repositories;

use App\Models\AddressCity;
use App\Models\AddressState;
use Illuminate\Database\Eloquent\Collection;

class AddressRepository
{

    /**
     * We can use Repositorys to work directly with one model, or to join a bunch of related models
     * In this case we will use the City and the State model to handle Addresses
     */

    protected $cityModel;
    protected $stateModel;

    public function __construct()
    {
        $this->cityModel = new AddressCity();
        $this->stateModel = new AddressState();
    }

    public function getStateByLetter($letter):array
    {
        return $this->stateModel->where('letter',$letter)->first()->toArray();
    }

    public function allStates(){
        return $this->stateModel->all();
    }

    public function getStatesCitiesByStateLetter($letter)
    {
        return $this->stateModel->where('letter',$letter)->first()->cities->toArray();
    }

    public function getStatesCitiesByState($state_id): Collection
    {
        return $this->stateModel->where('id',$state_id)->first()->cities;
    }

}
