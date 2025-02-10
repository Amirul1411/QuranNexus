<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChaptersInitialsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $response = [];

        $chaptersInitialsFields = $request->has('chapters_initials_fields') ? explode(',', $request->input('chapters_initials_fields')) : null;

        if($chaptersInitialsFields !== null){
            $fields = $chaptersInitialsFields;
        }elseif($request->route()->getName() === 'api_chapters_initials.show' || $request->route()->getName() === 'api_chapters_initials.index'){
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

            if (in_array('Ayah Key', $fields)) {
                $response['Ayah Key'] = $this->ayah_key;
            }

            if (in_array('Initials', $fields)) {
                $response['Initials'] = $this->initials;
            }
        }

        return $response;
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Surah Id' => $this->surah_id,
            'Ayah Key' => $this->ayah_key,
            'Initials' => $this->initials,
        ];
    }
}
