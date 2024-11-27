<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurahResource extends JsonResource
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

        if ($request->query('ayahs') === 'true' && ($request->route()->getName() === 'surah.index' || $request->route()->getName() === 'surah.show')) {
            $this->load('ayahs');
        }

        if ($request->query('surah_info') === 'true') {
            $this->load('surahInfo');
        }

        $surahFields = $request->has('surah_fields') ? explode(',', $request->input('surah_fields')) : null;

        if($surahFields !== null){
            $fields = $surahFields;
        }elseif($request->route()->getName() === 'surah.show' || $request->route()->getName() === 'surah.index'){
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

            if (in_array('Arabic Name', $fields)) {
                $response['Arabic Name'] = $this->name;
            }

            if (in_array('Name', $fields)) {
                $response['Name'] = $this->tname;
            }

            if (in_array('Name Meaning', $fields)) {
                $response['Name Meaning'] = $this->ename;
            }

            if (in_array('Type', $fields)) {
                $response['Type'] = $this->type;
            }

            if (in_array('Number of Ayahs', $fields)) {
                $response['Number of Ayahs'] = $this->ayas;
            }

        }

        // Add Ayahs relationship data if loaded
        if ($this->relationLoaded('ayahs')) {
            $response['Ayahs'] = AyahResource::collection($this->whenLoaded('ayahs'));
        }

        // Add surah info relationship data if loaded
        if ($this->relationLoaded('surahInfo')) {
            $response['Surah Info'] = (new SurahInfoResource($this->whenLoaded('surahInfo')));
        }

        return $response;

        // return parent::toArray($request);
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Arabic Name' => $this->name,
            'Name' => $this->tname,
            'Name Meaning' => $this->ename,
            'Type' => $this->type,
            'Number of ayahs' => $this->ayas,
        ];
    }
}
