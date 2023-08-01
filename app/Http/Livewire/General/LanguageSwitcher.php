<?php

namespace App\Http\Livewire\General;

use App\Services\LocalizationServices;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class LanguageSwitcher extends Component
{

    public $currentLocale = 'en';
    public $currentUrl;

    public function mount(){
        $this->currentLocale = LocalizationServices::getLocale();
        $this->currentUrl = Request::url();
    }

    public function render()
    {
        return view('livewire.general.language-switcher');
    }

    public function changeLocale($locale){
        if(!LocalizationServices::setLocale($locale))
            $this->dispatchBrowserEvent('errorMessage',['message' => __('main.localization.switcher_error')]);
        else
            $this->redirect($this->currentUrl);
    }
}
