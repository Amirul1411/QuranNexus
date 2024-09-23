<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentlyRead extends Component
{
    public $itemId; // This will hold the item being bookmarked (Surah, Ayah, or Page)
    public $type; // This will hold the type of the item ('surah', 'ayah', or 'page')

    public function mount($type, $itemId)
    {
        $this->type = $type;
        $this->itemId = $itemId;
    }

    public function checkRecentlyRead()
    {
        $user = Auth::user();
        if ($this->type === 'surah') {
            $user->markAsRecentlyRead('surah', $this->itemId);
        } elseif ($this->type === 'page') {
            $user->markAsRecentlyRead('page', $this->itemId);
        } elseif ($this->type === 'juz') {
            $user->markAsRecentlyRead('juz', $this->itemId);
        }
    }

    public function render()
    {
        return view('livewire.recently-read');
    }
}
