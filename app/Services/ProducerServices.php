<?php

namespace App\Services;

use App\Models\Producer;
use App\Repositories\ProducerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProducerServices
{
    protected $filters = [];
    protected $data = [];

    protected $paginate = 0;

    protected $producerRepository;

    public function __construct()
    {
        $this->producerRepository = new ProducerRepository();
    }

    /**
     * @return ProducerServices
     * In this service layer, we are using Builder Pattern
     * A static method build will return a new instance
     */
    public static function build(){
        return new ProducerServices();
    }

    /**
     * @param string $companyName
     * @param string $tradingName
     * @param string $socialNumber
     * @param string $phone
     * @param string $stateRegistration
     * @param int $cityId
     * @return Producer
     *
     * Create a new producer using it's default data
     */
    public function create(
        string $companyName,
        string $tradingName,
        string $socialNumber,
        string $phone,
        string $stateRegistration,
        int $cityId
    ): Producer
    {
        return $this->producerRepository->create(
            companyName: $companyName,
            tradingName: $tradingName,
            socialNumber: $socialNumber,
            stateRegistration: $stateRegistration,
            phone: $phone,
            cityId: $cityId
        );
    }

    /**
     * @param string $id
     * @param string $companyName
     * @param string $tradingName
     * @param string $phone
     * @param string $stateRegistration
     * @param int $cityId
     * @return Producer
     *
     * We can't change the social number after created.
     */
    public function update(
        string $id,
        string $companyName,
        string $tradingName,
        string $phone,
        string $stateRegistration,
        int $cityId
    ): Producer
    {
        return $this->producerRepository->update(
            id: $id,
            companyName: $companyName,
            tradingName: $tradingName,
            stateRegistration: $stateRegistration,
            phone: $phone,
            cityId: $cityId
        );
    }

    /**
     * @param $producerId
     * @return false
     *
     * Get a producer by its id
     */
    public function get($id) : Producer
    {
        return $this->producerRepository->get($id);
    }

    /**
     * @param $id
     * @return bool
     *
     * Simple remove a producer by it's id
     */
    public function remove($id) : bool
    {
       return $this->producerRepository->remove($id);
    }

    /**
     * @return Collection|LengthAwarePaginator
     * Get all settled filters and get matched data
     */
    public function match(): Collection | LengthAwarePaginator
    {
        // Get data that match with the filters
        return $this->producerRepository->all(
            filters: array_filter($this->filters), // Avoid empty values
            pagination: $this->paginate
        );
    }

    /**
     * @param int $perPage
     * @return $this
     *
     * Set the perPage on paginate.
     * If it's 0, the match function will return all results without pagination
     */
    public function paginate(int $perPage){
        $this->paginate = $perPage;
        return $this;
    }

    /**
     * @param $term
     * @return $this
     *
     * Add 'term' as a filter
     */
    public function filterByTerm($term){
        $this->filters['term'] = $term;
        return $this;
    }

    /**
     * @param $producerType
     * @return $this
     *
     * Add producert type as a filter
     */
    public function filterByType($producerType){
        $this->filters['type'] = $producerType;
        return $this;
    }

    public function getTotalCount(){
        return $this->producerRepository->getTotalCount();
    }

}
