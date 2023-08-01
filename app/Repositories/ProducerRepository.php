<?php

namespace App\Repositories;

use App\Helpers\StringHelper;
use App\Models\Producer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProducerRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Producer();
    }

    /**
     * @param string $company_name
     * @param string $trading_name
     * @param string $social_number
     * @param string $state_registraion
     * @param string $phone
     * @param int $city_id
     * @return array
     *
     * Create a new producer using the base data
     */

    public function create(
        string $companyName,
        string $tradingName,
        string $socialNumber,
        string $stateRegistration,
        string $phone,
        int    $cityId
    ): Producer
    {
        return $this->model->create([
            'company_name' => $companyName,
            'trading_name' => $tradingName,
            'social_number' => $socialNumber,
            'state_registration' => $stateRegistration,
            'phone' => $phone,
            'city_id' => $cityId
        ]);
    }

    /**
     * @param string $companyName
     * @param string $tradingName
     * @param string $socialNumber
     * @param string $stateRegistration
     * @param string $phone
     * @param int $cityId
     * @return Producer
     *
     * We can't update social number after create.
     * When we are update, we run for every variable and update individually
     */
    public function update(
        string $id,
        string|bool $companyName = false,
        string|bool $tradingName = false,
        string|bool $stateRegistration = false,
        string|bool $phone = false,
        int|bool    $cityId = false
    ): Producer
    {
        // Get the producer
        $producer = $this->model->findOrFail($id);

        // Update
        if($companyName !== false)
            $producer->setAttribute('company_name',$companyName);

        if($tradingName !== false)
            $producer->setAttribute('trading_name',$tradingName);

        /**
         * We check if it's diff of the bool false.
         * So if you send a empty state_registration, we can update it as well.
         */
        if($stateRegistration !== false)
            $producer->setAttribute('state_registration', $stateRegistration);

        if($phone !== false)
            $producer->setAttribute('phone', $phone);

        if($cityId !== false)
            $producer->setAttribute('city_id', $cityId);

        // Save
        $producer->saveOrFail();

        return $producer;
    }

    /**
     * @param array $filters
     * @param int $pagination
     * @return Collection
     *
     * Return all results that matches with the filters.
     * If a pagination is indicate, returns x per page
     * We use default laravel page request variable to get the selected page
     */
    public function all(
        array $filters = [],
        int   $pagination = 0
    ): Collection | LengthAwarePaginator
    {
        // Create Query
        $query = $this->model->newQuery();
        /**
         * This method can use pré determined filters, that must be well documented
         * Filters:
         * term : Used to filter LIKE company_name, trading_name, social_number and state_registration.
         * type : Filter the producers by individual or collective person.
         */
        // Filter by Term
        if (isset($filters['term']))
            $query->where(function ($q) use ($filters) {
                $q->orWhere('company_name', 'LIKE', '%' . $filters['term'] . '%');
                $q->orWhere('trading_name', 'LIKE', '%' . $filters['term'] . '%');
                $q->orWhere('social_number', 'LIKE', '%' . StringHelper::removeChars($filters['term'],['.','-']) . '%');
                $q->orWhere('state_registration', 'LIKE', '%' . StringHelper::removeChars($filters['term'],['.']) . '%');
            });

        // Filter by type
        if (isset($filters['type'])){
            if($filters['type'] == 'individual')
                $query->whereRaw('LENGTH(social_number) = ?',11);
            elseif($filters['type'] == 'collective')
                $query->whereRaw('LENGTH(social_number) = ?',14);
        }

        // Return
        return $pagination ? $query->paginate($pagination) : $query->get();
    }

    /**
     * @param $id
     * @return Producer
     * Get a producer by its id
     */
    public function get($id) : Producer
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $id
     * @return bool
     *
     * Simple remove a producer by it's id
     */
    public function remove($id) : bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * @return int
     * Get total count of producers
     */
    public function getTotalCount(): int
    {
        return $this->model->count();
    }

}
