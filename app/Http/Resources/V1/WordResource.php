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

        // Load related resources if needed
        if ($request->query('ayah') === 'true') {
            $this->load('ayah');
        }
        if ($request->query('surah') === 'true') {
            $this->load('surah');
        }

        // Determine fields to return
        $wordFields = $request->has('word_fields') ? explode(',', $request->input('word_fields')) : null;
        $fields = $wordFields ?: explode(',', $request->input('fields', ''));

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
                        $response['Surah Id'] = $this->when($request->query('words') !== 'true', $this->surah_id);
                        break;
                    case 'Ayah Index':
                        $response['Ayah Index'] = $this->when($request->query('words') !== 'true', $this->ayah_index);
                        break;
                    case 'Word Index':
                        $response['Word Index'] = $this->word_index;
                        break;
                    case 'Ayah Key':
                        $response['Ayah Key'] = $this->when($request->query('words') !== 'true', $this->ayah_key);
                        break;
                    case 'Word Key':
                        $response['Word Key'] = $this->word_key;
                        break;
                    case 'Audio Url':
                        $response['Audio Url'] = $this->audio_url;
                        break;
                    case 'Page Id':
                        $response['Page Id'] = $this->when($request->query('words') !== 'true', $this->page_id);
                        break;
                    case 'Line Number':
                        $response['Line Number'] = $this->line_number;
                        break;
                    case 'Text':
                        $response['Text'] = $this->text;
                        break;
                    case 'Characters':
                        $response['Characters'] = $this->characters;
                        break;
                    case 'Translation':
                        $response['Translation'] = $this->translation;
                        break;
                    case 'Transliteration':
                        $response['Transliteration'] = $this->transliteration;
                        break;
                }
            }
        }

        // Include related resources if loaded
        if ($this->relationLoaded('surah')) {
            $response['Surah'] = new SurahResource($this->whenLoaded('surah'));
        }
        if ($this->relationLoaded('ayah')) {
            $response['Ayah'] = new AyahResource($this->whenLoaded('ayah'));
        }

        return $response;
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
