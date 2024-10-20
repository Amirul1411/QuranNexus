<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\On;

class RegisterModal extends Component
{

    public $show = false;

    #[On('openRegisterModal')]
    public function open()
    {
        $this->show = true;
    }

    public function render()
    {
        return view('livewire.auth.register-modal');
    }
}
