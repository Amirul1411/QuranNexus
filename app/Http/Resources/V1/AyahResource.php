<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AyahResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // Prepare the response data
        $response = [];

        if ($request->query('surah') === 'true' && ($request->route()->getName() === 'ayah.index' || $request->route()->getName() === 'ayah.show')) {
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

        $ayahFields = $request->has('ayah_fields') ? explode(',', $request->input('ayah_fields')) : null;

        // Get the fields parameter from the request
        if($ayahFields !== null){
            $fields = $ayahFields;
        }elseif($request->route()->getName() === 'ayah.show' || $request->route()->getName() === 'ayah.index'){
            $fields = explode(',', $request->input('fields', ''));
        }

        // If no fields were provided, return all fields
        if (empty($fields[0])) {
            // Add all fields to the response
            $response = $this->getAllFields($request);
        } else {
            // Conditionally add fields based on the user's request
            if (in_array('Id', $fields)) {
                $response['Id'] = $this->_id;
            }

            if (in_array('Surah Id', $fields)) {
                $response['Surah Id'] = $this->surah_id;
            }

            if (in_array('Ayah Index', $fields)) {
                $response['Ayah Index'] = $this->ayah_index;
            }

            if (in_array('Ayah Key', $fields)) {
                $response['Ayah Key'] = $this->ayah_key;
            }

            if (in_array('Page Id', $fields)) {
                $response['Page Id'] = $this->page_id;
            }

            if (in_array('Juz Id', $fields)) {
                $response['Juz Id'] = $this->juz_id;
            }

            if (in_array('Bismillah', $fields)) {
                $response['Bismillah'] = $this->bismillah;
            }

        }

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

        // return parent::toArray($request);
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
