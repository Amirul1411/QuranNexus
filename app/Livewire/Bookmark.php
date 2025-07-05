<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;

class Bookmark extends Component
{
    public $itemProperties; // This will hold the item being bookmarked (Surah, Ayah, or Page)
    public $type; // This will hold the type of the item ('surah', 'ayah', or 'page')

    public function mount($type, $itemProperties)
    {
        $this->type = $type;
        $this->itemProperties = $itemProperties;
    }

    public function toggleBookmark()
    {
        if (Auth::guest()) {
            if($this->type != 'word'){
                Notification::make()->title('You have to login to perform this operation')->color('danger')->danger()// ->body()
                ->send();
            }else{
                $this->dispatch('login-error')->to('word-info-modal');
            }

            return;
        }

        $user = Auth::user();

        if ($user->isBookmarked($this->type, $this->itemProperties)) {
            $user->removeBookmark($this->type, $this->itemProperties);
            if($this->type != 'word'){
                Notification::make()->title('Bookmark removed succesfully.')->success()->color('success')->send();
            }else{
                $this->dispatch('unbookmark-success')->to('word-info-modal');
            }
        } else if ($this->type != 'word') {
            $this->dispatch('openBookmarkNotesModal', $this->type, $this->itemProperties)->to('bookmark-notes-modal');
        } else {
            $user->addBookmark($this->type, $this->itemProperties, '');
            $this->dispatch('bookmark-success')->to('word-info-modal');
        }
    }

    public function render()
    {
        return view('livewire.bookmark');
    }
}
