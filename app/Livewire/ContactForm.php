<?php

namespace App\Livewire;

use App\Models\Inquiry;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Filament\Notifications\Notification;

class ContactForm extends Component
{

    #[Validate('required')]
    public string $firstName;

    #[Validate('required')]
    public string $lastName;

    #[Validate('required|digits:10')]
    public string $phone;

    #[Validate('required|email')]
    public string $email;

    #[Validate('required')]
    public string $message;

    public function submitForm(){

        $this->validate();

        Inquiry::create([
            '_id' => (string) getNextSequenceValue('inquiry_id'),
            'first_name' => (string) $this->firstName,
            'last_name' => (string) $this->lastName,
            'phone' => (string) $this->phone,
            'email' => (string) $this->email,
            'message' => (string) $this->message,
        ]);

        $this->reset(['firstName', 'lastName', 'phone', 'email', 'message']);

        Notification::make()
        ->title('Message sent succcessfully.')
        ->success()
        ->color('success') 
        ->send();
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
