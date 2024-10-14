<?php

namespace App\Livewire;

use App\Models\AudioRecitationInfo;
use App\Models\Tafseer;
use App\Models\TafseerInfo;
use App\Models\TranslationInfo;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SettingsSideMenu extends Component
{
    public $tafseers, $translations, $audioRecitations;
    public $selectedTafseer, $selectedTranslation, $selectedAudio, $recitationGoal;

    public function mount()
    {
        $this->tafseers = TafseerInfo::all();
        $this->translations = TranslationInfo::all();
        $this->audioRecitations = AudioRecitationInfo::all();

        if (Auth::user() && isset(Auth::user()->settings['tafseer_id'])) {
            $this->selectedTafseer = Auth::user()->settings['tafseer_id'];
        }

        if (Auth::user() && isset(Auth::user()->settings['translation_id'])) {
            $this->selectedTranslation = Auth::user()->settings['translation_id'];
        }

        if (Auth::user() && isset(Auth::user()->settings['audio_id'])) {
            $this->selectedAudio = Auth::user()->settings['audio_id'];
        }

        if (Auth::user() && isset(Auth::user()->recitation_goal)) {
            $this->recitationGoal = Auth::user()->recitation_goal;
        }else{
            $this->recitationGoal = null;
        }
    }

    public function saveSettings()
    {
        if (Auth::guest()) {
            session()->flash('not logged in', 'You need to log in to change settings.');
            return;
        }

        // Validate user input, but allow settings to be optional
        $this->validate([
            'selectedTafseer' => 'nullable',
            'selectedTranslation' => 'nullable',
            'selectedAudio' => 'nullable',
            'recitationGoal' => 'nullable|numeric|min:10',
        ]);

        // Check if all fields are null
        if (is_null($this->selectedTafseer) && is_null($this->selectedTranslation) && is_null($this->selectedAudio) && $this->recitationGoal === 0) {
            session()->flash('all null', 'You must select at least one setting.');
            return;
        }

        // Prepare settings array
        $settings = Auth::user()->settings ?? [];

        if ($this->selectedTafseer) {
            $settings['tafseer_id'] = (string) $this->selectedTafseer;
        }

        if ($this->selectedTranslation) {
            $settings['translation_id'] = (string) $this->selectedTranslation;
        }

        if ($this->selectedAudio) {
            $settings['audio_id'] = (string) $this->selectedAudio;
        }

        // Save only the provided settings (without overwriting the entire settings array)
        Auth::user()->update([
            'settings' => $settings, // This will trigger the setSettingsAttribute method
            'recitation_goal' => (int) $this->recitationGoal,
        ]);

        session()->flash('successful', 'Settings successfully saved.');

        // Emit an event to notify the frontend to refresh the page
        $this->dispatch('settingsSaved');
    }

    #[Computed]
    public function selectedTafseerNameAndLanguage()
    {
        if ($this->selectedTafseer) {
            $tafseerInfo = TafseerInfo::find($this->selectedTafseer);
        } else {
            return null;
        }
        return $tafseerInfo->name . ' - ' . $tafseerInfo->language_name;
    }

    #[Computed]
    public function selectedTranslationNameAndLanguage()
    {
        if ($this->selectedTranslation) {
            $translationInfo = TranslationInfo::find($this->selectedTranslation);
        } else {
            return null;
        }
        return $translationInfo->translator . ' - ' . $translationInfo->language;
    }

    #[Computed]
    public function selectedAudioRecitationName()
    {
        if ($this->selectedAudio) {
            $audioInfo = AudioRecitationInfo::find($this->selectedAudio);
        } else {
            return null;
        }
        return $audioInfo->reciter_name;
    }

    public function render()
    {
        return view('livewire.settings-side-menu');
    }
}
