<?php

namespace App\Http\Livewire\Manage;

use App\Repositories\ProducerRepository;
use App\Services\ProducerServices;
use Livewire\Component;
use Livewire\WithPagination;

class ProducersList extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $term;
    public $producerType;

    protected $listeners = [
        'global__producer_updated' => 'render', // When a producer is updated, just render the list again to get the new data
        'global__producer_removed' => 'render'
    ];

    public function render()
    {
        // Get the service handler
        $data['results'] = ProducerServices::build()
            ->filterByTerm($this->term)
            ->filterByType($this->producerType)
            ->paginate(10)
            ->match();

        return view('livewire.manage.producers-list', $data);
    }
}
