<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterFrequencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $response = [];

        $characterFrequencyFields = $request->has('character_frequency_fields') ? explode(',', $request->input('character_frequency_fields')) : null;

        if($characterFrequencyFields !== null){
            $fields = $characterFrequencyFields;
        }elseif($request->route()->getName() === 'api_character_frequency.show' || $request->route()->getName() === 'api_character_frequency.index'){
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

            if (in_array('Character', $fields)) {
                $response['Character'] = $this->character;
            }

            if (in_array('Count', $fields)) {
                $response['Count'] = $this->count;
            }

            if (in_array('Locations', $fields)) {
                $response['Locations'] = $this->locations;
            }
        }

        return $response;
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Character' => $this->character,
            'Count' => $this->count,
            'Locations' => $this->locations,
        ];
    }
}
