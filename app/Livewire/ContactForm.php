<?php

namespace App\Livewire;

use App\Models\Inquiry;
use Livewire\Component;

class ContactForm extends Component
{

    public string $firstName;

    public string $lastName;

    public string $phone;

    public string $email;

    public string $message;

    public function submitForm(){

        Inquiry::create([
            '_id' => (string) getNextSequenceValue('inquiry_id'),
            'first_name' => (string) $this->firstName,
            'last_name' => (string) $this->lastName,
            'phone' => (string) $this->phone,
            'email' => (string) $this->email,
            'message' => (string) $this->message,
        ]);

        $this->reset(['firstName', 'lastName', 'phone', 'email', 'message']);

    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
