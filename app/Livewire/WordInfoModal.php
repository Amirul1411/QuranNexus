<?php

namespace App\Livewire;

use App\Models\Word;
use Livewire\Component;
use Livewire\Attributes\On;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WordInfoModal extends Component
{
    public $show = false;
    public $word;

    #[On('openWordInfoModal')]
    public function open($wordKey)
    {
        $this->show = true;
        $this->word = Word::where('word_key', $wordKey)->first();
    }

    public function playWordAudioRecitation()
    {
        // Construct the path to the audio file in S3
        $audioFilePath = 'quran-audio/' . $this->word->audio_url;

        // Check if the audio file exists in S3
        if (Storage::exists($audioFilePath)) {
            // Get the public URL of the audio file
            $audioUrl = Storage::url($audioFilePath);

            // Dispatch an event with the audio URL
            $this->dispatch('play-audio', ['audioUrl' => $audioUrl]);
        } else {
            // Handle the case where the audio file does not exist
            Notification::make()->title('Audio file not found')->danger()->send();
        }
    }

    public function render()
    {
        return view('livewire.word-info-modal', [
            'word' => $this->word,
        ]);
    }
}
