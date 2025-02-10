<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiacriticFrequencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $response = [];

        $diacriticFrequencyFields = $request->has('diacritic_frequency_fields') ? explode(',', $request->input('diacritic_frequency_fields')) : null;

        if($diacriticFrequencyFields !== null){
            $fields = $diacriticFrequencyFields;
        }elseif($request->route()->getName() === 'api_diacritic_frequency.show' || $request->route()->getName() === 'api_diacritic_frequency.index'){
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

            if (in_array('Diacritic', $fields)) {
                $response['Diacritic'] = $this->diacritic;
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
            'Diacritic' => $this->diacritic,
            'Count' => $this->count,
            'Locations' => $this->locations,
        ];
    }
}
