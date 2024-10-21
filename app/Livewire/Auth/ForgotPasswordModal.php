<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\On;

class ForgotPasswordModal extends Component
{

    public $show = false;

    #[On('openForgotPasswordModal')]
    public function open()
    {
        $this->show = true;
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-modal');
    }
}
