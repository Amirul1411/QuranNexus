<?php

namespace App\Livewire;

use App\Models\Word;
use App\Models\WordStatistics;
use Livewire\Component;
use Livewire\Attributes\On;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WordInfoModal extends Component
{
    public $show = false;
    public $firstWordOccurrence;
    public $wordStatistics;
    public $firstWordOccurrenceFullVerse = '';
    public $highestJuzId;
    public $leastJuzId;
    public $highestCount;
    public $leastCount;

    #[On('openWordInfoModal')]
    public function open($wordText)
    {
        $this->show = true;
        $this->wordStatistics = WordStatistics::where('word', $wordText)->first();
        $this->firstWordOccurrence = Word::where('text', $wordText)->first();

        // Iterate over the words in the ayah and append them to the full verse string
        foreach ($this->firstWordOccurrence->ayah->words as $word) {
            if ($word->audio_url != null) {
                $this->firstWordOccurrenceFullVerse .= $word->text . ' ';
            }
        }

        $counts = array_column($this->wordStatistics->occurrences_by_juz, 'count');
        $juzIds = array_column($this->wordStatistics->occurrences_by_juz, 'juz_id');

        // Find the highest and least counts
        $this->highestCount = max($counts);
        $this->leastCount = min($counts);

        // Find the corresponding juz_ids
        $this->highestJuzId = $juzIds[array_search($this->highestCount, $counts)];
        $this->leastJuzId = $juzIds[array_search($this->leastCount, $counts)];
    }

    #[On('login-error')]
    public function loginError()
    {
        $this->addError('auth', 'You must be logged in to add this word to your vocabularies.');
    }

    #[On('bookmark-success')]
    public function bookmarkSuccess()
    {
        session()->flash('status', 'Word added to your vocabularies successfully!');
    }

    #[On('unbookmark-success')]
    public function unbookmarkSuccess()
    {
        session()->flash('status', 'Word removed from your vocabularies successfully!');
    }

    // public function playWordAudioRecitation()
    // {
    //     // Construct the path to the audio file in S3
    //     $audioFilePath = 'quran-audio/' . $this->word->audio_url;

    //     // Check if the audio file exists in S3
    //     if (Storage::exists($audioFilePath)) {
    //         // Get the public URL of the audio file
    //         $audioUrl = Storage::url($audioFilePath);

    //         // Dispatch an event with the audio URL
    //         $this->dispatch('play-audio', ['audioUrl' => $audioUrl]);
    //     } else {
    //         // Handle the case where the audio file does not exist
    //         Notification::make()->title('Audio file not found')->danger()->send();
    //     }
    // }

    public function render()
    {
        return view('livewire.word-info-modal', [
            'wordStatistics' => $this->wordStatistics,
            'firstWordOccurrence' => $this->firstWordOccurrence,
            'firstOccurrenceWordFullVerse' => $this->firstWordOccurrenceFullVerse,
            'highestCount' => $this->highestCount,
            'leastCount' => $this->leastCount,
            'highestJuzId' => $this->highestJuzId,
            'leaseJuzId' => $this->leastJuzId,
        ]);
    }
}
