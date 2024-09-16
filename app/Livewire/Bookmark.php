<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Bookmark extends Component
{

    public $item; // This will hold the item being bookmarked (Surah, Ayah, or Page)
    public $type; // This will hold the type of the item ('surah', 'ayah', or 'page')

    public function mount($type, $item)
    {
        $this->type = $type;
        $this->item = $item;
    }

    public function toggleBookmark()
    {
        dd($this->type, $this->item);

        if (Auth::guest()) {
            return $this->redirect(route('login'), true);
        }

        $user = Auth::user();

        if ($user->isBookmarked($this->type, $this->item)) {
            $user->toggleBookmark($this->type, $this->item);
        } else {
            $user->toggleBookmark($this->type, $this->item);
        }
    }

    public function render()
    {
        return view('livewire.bookmark');
    }
}
