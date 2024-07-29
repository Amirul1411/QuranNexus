<?php

namespace App\Livewire;

use Livewire\Component;

class ContactForm extends Component
{

    public $firstName;

    public $lastName;

    public $phone;

    public $email;

    public $message;

    public function submitForm(){

    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
