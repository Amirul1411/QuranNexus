<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JuzResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $response = [];

        if ($request->query('surah') === 'true' && ($request->route()->getName() === 'api_juz.index' || $request->route()->getName() === 'api_juz.show')) {
            $this->load('surah');
        }

        if ($request->query('ayahs') === 'true' && ($request->route()->getName() === 'api_juz.index' || $request->route()->getName() === 'api_juz.show')) {
            $this->load('ayahs');
        }

        $juzFields = $request->has('juz_fields') ? explode(',', $request->input('juz_fields')) : null;

        if($juzFields !== null){
            $fields = $juzFields;
        }elseif($request->route()->getName() === 'api_juz.show' || $request->route()->getName() === 'api_juz.index'){
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

        }

        if ($this->relationLoaded('surah')) {
            $response['Surah'] = new SurahResource($this->whenLoaded('surah'));
        }

        if ($this->relationLoaded('ayahs')) {
            $response['Ayahs'] = AyahResource::collection($this->whenLoaded('ayahs'));
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
        ];
    }
}
