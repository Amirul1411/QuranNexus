<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LongestTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $response = [];

        $longestTokenFields = $request->has('longest_token_fields') ? explode(',', $request->input('longest_token_fields')) : null;

        if($longestTokenFields !== null){
            $fields = $longestTokenFields;
        }elseif($request->route()->getName() === 'api_longest_token.show' || $request->route()->getName() === 'api_longest_token.index'){
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

            if (in_array('Text', $fields)) {
                $response['Text'] = $this->text;
            }

            if (in_array('Length', $fields)) {
                $response['Length'] = $this->length;
            }
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
            'Text' => $this->text,
            'Length' => $this->length,
        ];
    }
}
