<?php

namespace App\Http\Livewire\Manage\Producers;

use App\Helpers\StringHelper;
use App\Repositories\AddressRepository;
use App\Services\ProducerServices;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormModal extends Component
{
    public $title;
    public $creating = true;

    public $selectedProducerId;

    public $statesList = [];
    public $cityList = [];

    public $producerData = [];

    public $listeners = [
        'global__producer_new' => 'openCreateForm',
        'global__producer_edit' => 'openEditForm',
        'global__producer_request_remove' => 'requestRemove',
        'scoped__producer_force_remove' => 'forceRemove'
    ];

    public function rules(){
        $rules = [
            'producerData.company_name' => 'required|string|min:4',
            'producerData.trading_name' => 'required|string|min:4',
            'producerData.phone' => 'sometimes|nullable|celular_com_ddd',
            'producerData.state_registration' => 'sometimes|nullable|string|size:12',
            'producerData.state_id' => 'required',
            'producerData.city_id' => 'required'
        ];

        if($this->creating)
            $rules['producerData.social_number'] = 'required|string|cpf_ou_cnpj|unique:producers,social_number';
        else
            $rules['producerData.social_number'] = 'required|string|cpf_ou_cnpj';

        return $rules;
    }

    public function validationAttributes()
    {
        return [
            'producerData.company_name' => __('main.producers.table.company_name'),
            'producerData.trading_name' => __('main.producers.table.trade_name'),
            'producerData.social_number' => __('main.producers.table.social_number'),
            'producerData.state_registration' => __('main.producers.table.state_registration'),
            'producerData.phone' => __('main.producers.table.phone'),
            'producerData.state_id' => __('main.producers.table.state'),
            'producerData.city_id' => __('main.producers.table.city')
        ];
    }

    public function dehydrate()
    {
        /**
         * Force mask the social number based on the chars number
         */
        // Social Number
        if (strlen($this->producerData['social_number']) <= 14) {
            $this->dispatchBrowserEvent('mask', [
                'selector' => "#producer-social-number",
                'pattern' => '999.999.999-99S'
            ]);
        } else {
            $this->dispatchBrowserEvent('mask', [
                'selector' => "#producer-social-number",
                'pattern' => '99.999.999/9999-99'
            ]);
        }
        // Phone
        $this->dispatchBrowserEvent('mask', [
            'selector' => "#producer-phone",
            'pattern' => '(99) 99999-9999'
        ]);
        // State Registration
        $this->dispatchBrowserEvent('mask', [
            'selector' => "#producer-state-registration",
            'pattern' => '9999999999-9'
        ]);
    }

    public function resetData(){
        $this->selectedProducerId = false;
        $this->producerData = [
            'company_name' => '',
            'trading_name' => '',
            'social_number' => '',
            'state_registration' => '',
            'phone' => '',
            'state_id' => 13,
            'city_id' => 5290
        ];
    }

    public function mount()
    {
        // Get the Address Repository
        $addressRepository = new AddressRepository();
        $this->statesList = $addressRepository->allStates()->sortBy('title');
        // Reset Data
        $this->resetData();
    }

    public function render()
    {
        // Get the Address Repository
        $addressRepository = new AddressRepository();
        // Prepare the city list by selected state id
        if ($this->producerData['state_id'])
            $this->cityList = $addressRepository->getStatesCitiesByState($this->producerData['state_id']);
        else
            $this->cityList = [];

        return view('livewire.manage.producers.form-modal');
    }

    public function openModal()
    {
        // Clear Validations
        $this->resetValidation();
        $this->resetErrorBag();

        $this->dispatchBrowserEvent('openModal', ['modalId' => 'producer-form-modal']);
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal', ['modalId' => 'producer-form-modal']);
    }

    public function openCreateForm()
    {
        // Clear data
        $this->resetData();
        // Title
        $this->title = __('main.producers.actions.new_producer');
        // Actions
        $this->creating = true;
        $this->openModal();
    }

    public function openEditForm($producerId)
    {
        try {
            // Getting the producer by it's id
            $producer = ProducerServices::build()->get($producerId);
            // Pass data to the producerData
            $this->producerData = [
                'company_name' => $producer->getAttribute('company_name'),
                'trading_name' => $producer->getAttribute('trading_name'),
                'social_number' => $producer->getAttribute('social_number'),
                'state_registration' => $producer->getAttribute('state_registration'),
                'phone' => $producer->getAttribute('phone'),
                'state_id' => $producer->city->getAttribute('state_id'),
                'city_id' => $producer->city->getAttribute('id')
            ];
            // Set creating as false
            $this->creating = false;
            $this->selectedProducerId = $producer->getAttribute('id');

            // Title
            $this->title = __('main.producers.actions.edit_producer');

            // Open Modal
            $this->openModal();

        }catch (\Throwable $throwable){
            $this->dispatchBrowserEvent('errorMessage', ['message' => $throwable->getMessage()]);
            return false;
        }
    }

    public function save()
    {
        // Remove special chars from social number for validation
        $this->producerData['social_number'] = StringHelper::onlyNumbers($this->producerData['social_number']);

        $this->validate();
        // Transaction
        DB::beginTransaction();
        try {
            if($this->creating){
                // Create a new Producer
                /**
                 * We can use updateOrCreate to eliminate some duplicate lines.
                 * But it's just a test with short time to execute.
                 */
                $newProducer = ProducerServices::build()->create(
                    companyName: $this->producerData['company_name'],
                    tradingName: $this->producerData['trading_name'],
                    socialNumber: $this->producerData['social_number'],
                    phone: $this->producerData['phone'],
                    stateRegistration: $this->producerData['state_registration'],
                    cityId: $this->producerData['city_id']
                );

                // Commit Transaction
                DB::commit();
                // Prepare Message
                session()->flash('alertSuccess', __('main.producers.created'));
                // Redirect to the detail page
                $this->redirect(route('manage.producers.farms',['producer' => $newProducer->getAttribute('id')]));
            }else{
                // Update an existing Producer
                $producer = ProducerServices::build()->update(
                    id: $this->selectedProducerId,
                    companyName: $this->producerData['company_name'],
                    tradingName: $this->producerData['trading_name'],
                    phone: $this->producerData['phone'],
                    stateRegistration: $this->producerData['state_registration'],
                    cityId: $this->producerData['city_id']);
                // Commit Transaction
                DB::commit();
                // Dispatch Success
                $this->dispatchBrowserEvent('successMessage', ['message' => __('main.producers.updated')]);
                // Emit Global Event
                $this->emit('global__producer_updated');
                // Close modal
                $this->closeModal();
            }
        } catch (\Throwable $throwable) {
            DB::rollBack();
            $this->dispatchBrowserEvent('errorMessage', ['message' => $throwable->getMessage()]);
            return false;
        }
        return true;
    }

    /**
     * We use the same component to render and handle Producer Remove
     */

    public function requestRemove($producerId){
        // Select this producer
        $this->selectedProducerId = $producerId;
        // Get the producer
        $producer = ProducerServices::build()->get($producerId);
        // Ask for user consent
        $this->dispatchBrowserEvent('confirmationAlert',[
            "message" => __('main.producers.to_remove', ['producer' => $producer->getAttribute('company_name')]),
            "emit_when_confirmed" => "scoped__producer_force_remove",
            "emit_params" => $producerId
        ]);
    }

    public function forceRemove($producerId){
        // Check if the selected producer id is the same as asked producer id
        if($this->selectedProducerId == $producerId){
            // Now we can remove
            DB::beginTransaction();
            try {
                // Remove
                ProducerServices::build()->remove($producerId);
                // Commit
                DB::commit();
                // Dispatch Success
                $this->dispatchBrowserEvent('successMessage', ['message' => __('main.producers.removed')]);
                // Emit Global Event
                $this->emit('global__producer_removed');
            }catch (\Throwable $throwable) {
                DB::rollBack();
                $this->dispatchBrowserEvent('errorMessage', ['message' => $throwable->getMessage()]);
                return false;
            }
        }
    }

}
