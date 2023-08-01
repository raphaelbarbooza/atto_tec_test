<?php

namespace App\Http\Livewire\Auth;

use App\Services\AuthServices;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class LoginBox extends Component
{

    public $inputMail;
    public $inputPass;

    /**
     * Laravel Validation with Livewire
     */
    protected $rules = [
      'inputMail' => 'required|email',
      'inputPass' => 'required|min:6'
    ];

    public function messages() : array
    {
        return [
            'inputMail.required' => __('main.auth.messages.required_mail'),
            'inputMail.email' => __('main.auth.messages.invalid_mail'),
            'inputPass.required' => __('main.auth.messages.required_password'),
            'inputPass.min' => __('main.auth.messages.min_password')
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.auth.login-box');
    }

    public function login(){
        // Validate
        $this->validate();

        // For fe tests, delay 1 seconds on staging mode
        if(App::isLocal())
            sleep(1);

        // Try to login
        if(!AuthServices::attempt($this->inputMail, $this->inputPass)){
            // Show the login error
            $this->dispatchBrowserEvent('errorMessage',['message' => __('main.auth.invalid_credentials')]);
            return false;
        }

        // Redirect to the home page
        $this->redirect(route('home'));
    }

}
