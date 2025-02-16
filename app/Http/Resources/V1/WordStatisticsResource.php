<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WordStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [];

        $wordStatisticsFields = $request->has('word_statistics_fields') ? explode(',', $request->input('word_statistics_fields')) : null;

        if($wordStatisticsFields !== null){
            $fields = $wordStatisticsFields;
        }elseif($request->route()->getName() === 'api_word_statistics.show' || $request->route()->getName() === 'api_word_statistics.index'){
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

            if (in_array('Word', $fields)) {
                $response['Word'] = $this->word;
            }

            if (in_array('Transliteration', $fields)) {
                $response['Transliteration'] = $this->transliteration;
            }

            if (in_array('Translation', $fields)) {
                $response['Translation'] = $this->translation;
            }
            if (in_array('Characters', $fields)) {
                $response['Characters'] = $this->characters;
            }

            if (in_array('Total Occurrences', $fields)) {
                $response['Total Occurrences'] = $this->total_occurrences;
            }

            if (in_array('Occurrences by Surah', $fields)) {
                $response['Occurrences by Surah'] = $this->occurrences_by_surah;
            }

            if (in_array('Occurrences by Juz', $fields)) {
                $response['Occurrences by Juz'] = $this->occurrences_by_juz;
            }
            if (in_array('Occurrences by Page', $fields)) {
                $response['Occurrences by Page'] = $this->occurrences_by_page;
            }

            if (in_array('Positions', $fields)) {
                $response['Positions'] = $this->positions;
            }
        }

        return $response;
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Word' => $this->word,
            'Transliteration' => $this->transliteration,
            'Translation' => $this->translation,
            'Characters' => $this->characters,
            'Total Occurences' => $this->total_occurrences,
            'Occurences by Surah' => $this->occurrences_by_surah,
            'Occurences by Juz' => $this->occurrences_by_juz,
            'Occurrences by Page' => $this->occurrences_by_page,
            'Positions' => $this->positions,
        ];
    }
}
