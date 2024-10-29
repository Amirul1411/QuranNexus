<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Juz;
use App\Models\Page;
use App\Models\Surah;

class RecitationSideMenu extends Component
{

    // public $search='';

    public function redirectToSurah($surahId)
    {
      return redirect()->route('surah.show', ['surah' => (int) $surahId]);
    }

    public function redirectToJuz($juzId)
    {
      return redirect()->route('juz.show', ['juz' => (int) $juzId]);
    }

    public function redirectToPage($pageId)
    {
      return redirect()->route('page.show', ['page' => (int) $pageId]);
    }

    #[Computed()]
    public function surahs()
    {
        // if($this->search === ''){
        // $surahs = Surah::all();
        // }else{
        //     // General search across multiple fields
        //     $surahs = Surah::where(function ($query) {
        //             $query->where('tname', 'like', '%' . $this->search . '%')
        //                 ->orWhere('ename', 'like', '%' . $this->search . '%')
        //                 ->orWhere('_id', $this->search);
        //         })->get();
        // }

        return Surah::all();
    }

    #[Computed()]
    public function juzs()
    {
        // if($this->search === ''){
        //     $juzs = Juz::all();
        // }else{
        //     $juzs = Juz::where('_id', $this->search)->get();
        // }

        return Juz::all();
    }

    #[Computed()]
    public function pages()
    {
        // if($this->search === ''){
        //     $pages = Page::all();
        // }else{
        //     $pages = Page::where('_id', $this->search)->get();
        // }

        return Page::all();
    }

    public function render()
    {
        return view('livewire.recitation-side-menu');
    }
}
