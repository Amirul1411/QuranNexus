<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AyahResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = [];

        // Load related resources if needed
        if ($request->query('surah') === 'true') {
            $this->load('surah');
        }
        if ($request->query('words') === 'true') {
            $this->load('words');
        }
        if ($request->query('tafseers') === 'true') {
            $this->load('tafseer');
        }
        if ($request->query('translations') === 'true') {
            $this->load('translations');
        }
        if ($request->query('audio_recitations') === 'true') {
            $this->load('audioRecitations');
        }

        // Determine fields to return
        $ayahFields = $request->has('ayah_fields') ? explode(',', $request->input('ayah_fields')) : null;
        $fields = $ayahFields ?: explode(',', $request->input('fields', ''));

        // If no fields were provided, return all fields
        if (empty($fields[0])) {
            $response = $this->getAllFields($request);
        } else {
            // Add fields conditionally
            foreach ($fields as $field) {
                switch ($field) {
                    case 'Id':
                        $response['Id'] = $this->_id;
                        break;
                    case 'Surah Id':
                        $response['Surah Id'] = $this->surah_id;
                        break;
                    case 'Ayah Index':
                        $response['Ayah Index'] = $this->ayah_index;
                        break;
                    case 'Ayah Key':
                        $response['Ayah Key'] = $this->ayah_key;
                        break;
                    case 'Page Id':
                        $response['Page Id'] = $this->when($request->query('page_ayahs') !== 'true', $this->page_id);
                        break;
                    case 'Juz Id':
                        $response['Juz Id'] = $this->when($request->query('juz_ayahs') !== 'true', $this->juz_id);
                        break;
                    case 'Bismillah':
                        $response['Bismillah'] = $this->bismillah;
                        break;
                    case 'Arabic Text':
                        $response['Arabic Text'] = $this->words->pluck('text')->implode(' ');
                        break;
                }
            }
        }

        // Include related resources if loaded
        if ($this->relationLoaded('surah')) {
            $response['Surah'] = new SurahResource($this->whenLoaded('surah'));
        }
        if ($this->relationLoaded('words')) {
            $response['Words'] = WordResource::collection($this->whenLoaded('words'));
        }
        if ($this->relationLoaded('translations')) {
            $response['Translations'] = TranslationResource::collection($this->whenLoaded('translations'));
        }
        if ($this->relationLoaded('tafseer')) {
            $response['Tafseer'] = TafseerResource::collection($this->whenLoaded('tafseer'));
        }
        if ($this->relationLoaded('audioRecitations')) {
            $response['Audio Recitation'] = AudioRecitationResource::collection($this->whenLoaded('audioRecitations'));
        }

        return $response;
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Surah Id' => $this->surah_id,
            'Ayah Index' => $this->ayah_index,
            'Ayah Key' => $this->ayah_key,
            'Page Id' => $this->page_id,
            'Juz Id' => $this->juz_id,
            'Bismillah' => $this->bismillah,
        ];
    }
}
