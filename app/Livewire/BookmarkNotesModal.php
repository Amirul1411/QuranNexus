<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class BookmarkNotesModal extends Component
{

    public $show = false;
    public $type;
    public $itemProperties;

    #[Validate('nullable|string|max:200')]
    public $notes = '';

    #[On('openBookmarkNotesModal')]
    public function open($type, $itemProperties)
    {
        $this->show = true;
        $this->type = $type;
        $this->itemProperties = $itemProperties;
    }

    public function saveBookmarks()
    {
        // Validate the notes (optional)
        $this->validate();

        $user = Auth::user();

        $user->addBookmark($this->type, $this->itemProperties, $this->notes);

        Notification::make()
            ->title('Bookmarked successfully.')
            ->success()
            ->color('success')
            ->send();

        // Reset and close the modal
        $this->notes = '';
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.bookmark-notes-modal');
    }
}
