<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [];

        if ($request->query('ayah') === 'true' && ($request->route()->getName() === 'word.index' || $request->route()->getName() === 'word.show')) {
            $this->load('ayah');
        }

        if ($request->query('surah') === 'true' && ($request->route()->getName() === 'word.index' || $request->route()->getName() === 'word.show')) {
            $this->load('surah');
        }

        $wordFields = $request->has('word_fields') ? explode(',', $request->input('word_fields')) : null;

        if($wordFields !== null){
            $fields = $wordFields;
        }elseif($request->route()->getName() === 'word.show' || $request->route()->getName() === 'word.index'){
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

            if (in_array('Word Index', $fields)) {
                $response['Word Index'] = $this->word_index;
            }

            if (in_array('Ayah Key', $fields)) {
                $response['Ayah Key'] = $this->ayah_key;
            }

            if (in_array('Word Key', $fields)) {
                $response['Word Key'] = $this->word_key;
            }

            if (in_array('Audio Url', $fields)) {
                $response['Audio Url'] = $this->audio_url;
            }

            if (in_array('Page Id', $fields)) {
                $response['Page Id'] = $this->page_id;
            }

            if (in_array('Line Number', $fields)) {
                $response['Line Number'] = $this->line_number;
            }

            if (in_array('Text', $fields)) {
                $response['Text'] = $this->text;
            }

            if (in_array('Characters', $fields)) {
                $response['Characters'] = $this->characters;
            }

            if (in_array('Translation', $fields)) {
                $response['Translation'] = $this->translation;
            }

            if (in_array('Transliteration', $fields)) {
                $response['Transliteration'] = $this->transliteration;
            }

        }

        if ($this->relationLoaded('surah')) {
            $response['Surah'] = new SurahResource($this->whenLoaded('surah'));
        }

        if ($this->relationLoaded('ayah')) {
            $response['Ayah'] = new AyahResource($this->whenLoaded('ayah'));
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
            'Word Index' => $this->word_index,
            'Ayah Key' => $this->ayah_key,
            'Word Key' => $this->word_key,
            'Audio Url' => $this->audio_url,
            'Page Id' => $this->page_id,
            'Line Number' => $this->line_number,
            'Text' => $this->text,
            'Characters' => $this->characters,
            'Translation' => $this->translation,
            'Transliteration' => $this->transliteration,
        ];
    }
}
