<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\On;

class LoginModal extends Component
{

    public $showOpenModal = false;

    #[On('openLoginModal')]
    public function open()
    {
        $this->showOpenModal = true;
    }

    #[On('closeLoginModal')]
    public function close()
    {
        $this->showOpenModal = false;
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}
