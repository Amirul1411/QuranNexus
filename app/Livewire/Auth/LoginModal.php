<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\On;

class LoginModal extends Component
{

    public $show = false;

    #[On('openLoginModal')]
    public function open()
    {
        $this->show = true;
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}
