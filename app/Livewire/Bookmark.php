<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Bookmark extends Component
{

    public $itemId; // This will hold the item being bookmarked (Surah, Ayah, or Page)
    public $type; // This will hold the type of the item ('surah', 'ayah', or 'page')

    public function mount($type, $itemId)
    {
        $this->type = $type;
        $this->itemId = $itemId;
    }

    public function toggleBookmark()
    {

        if (Auth::guest()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->isBookmarked($this->type, $this->itemId)) {
            $user->removeBookmark($this->type, $this->itemId);
        } else {
            $user->addBookmark($this->type, $this->itemId);
        }
    }

    public function render()
    {
        return view('livewire.bookmark');
    }
}
