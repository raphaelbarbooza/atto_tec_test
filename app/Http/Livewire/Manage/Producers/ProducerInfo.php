<?php

namespace App\Http\Livewire\Manage\Producers;

use App\Services\ProducerServices;
use Livewire\Component;

class ProducerInfo extends Component
{

    protected $producer;

    protected $listeners = [
        'global__producer_removed' => 'returnToList', // If a producer is removed, just return to the list
        'global__producer_updated' => 'render', // If a producer is update, re-render
    ];

    public function mount($producerId){
        $this->producer = ProducerServices::build()->get($producerId);

        $this->dispatchBrowserEvent('loadMap');
    }

    public function render()
    {
        return view('livewire.manage.producers.producer-info',['producer' => $this->producer]);
    }

    public function returnToList(){
        // Sleep two seconds before redirect
        sleep(2);
        $this->redirect(route('manage.producers'));
        return false;
    }
}
