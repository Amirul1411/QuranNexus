<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurahInfoResource extends JsonResource
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

        if ($request->query('surah') === 'true' && ($request->route()->getName() === 'api_surah_info.index' || $request->route()->getName() === 'api_surah_info.show')) {
            $this->load('surah');
        }

        $surahInfoFields = $request->has('surah_info_fields') ? explode(',', $request->input('surah_info_fields')) : null;

        if($surahInfoFields !== null){
            $fields = $surahInfoFields;
        }elseif($request->route()->getName() === 'api_surah_info.show' || $request->route()->getName() === 'api_surah_info.index'){
            $fields = explode(',', $request->input('fields', ''));
        }

        // If no fields were provided, return all fields
        if (empty($fields[0])) {

            // Add all fields to the response
            $response = $this->getAllFields($request);

        } else {

            // Conditionally add fields
            if (in_array('Id', $fields)) {
                $response['Id'] = $this->_id;
            }

            if (in_array('Html', $fields)) {
                $response['Html'] = $this->html;
            }

        }

        if ($this->relationLoaded('surah')) {
            $response['Surah'] = new SurahResource($this->whenLoaded('surah'));
        }

        return $response;

        // return parent::toArray($request);
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Html' => $this->html,
        ];
    }
}
