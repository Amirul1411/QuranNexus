<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AudioRecitationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $response = [];

        if ($request->query('audio_recitation_info') === 'true') {
            $this->load('audioInfo');
        }

        if ($request->query('surah') === 'true' && ($request->route()->getName() === 'api_audio_recitation.index' || $request->route()->getName() === 'api_audio_recitation.show')) {
            $this->load('surah');
        }

        if ($request->query('ayah') === 'true' && ($request->route()->getName() === 'api_audio_recitation.index' || $request->route()->getName() === 'api_audio_recitation.show')) {
            $this->load('ayah');
        }

        $audioRecitationFields = $request->has('audio_recitation_fields') ? explode(',', $request->input('audio_recitation_fields')) : null;

        if($audioRecitationFields !== null){
            $fields = $audioRecitationFields;
        }elseif($request->route()->getName() === 'api_audio_recitation.show' || $request->route()->getName() === 'api_audio_recitation.index'){
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

            if (in_array('Audio Info Id', $fields)) {
                $response['Audio Info Id'] = $this->audio_info_id;
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

            if (in_array('Audio Url', $fields)) {
                $response['Audio Url'] = $this->audio_url;
            }

        }

        if ($this->relationLoaded('audioInfo')) {
            $response['Audio Recitation Info'] = new AudioRecitationInfoResource($this->whenLoaded('audioInfo'));
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
            'Audio Info Id' => $this->audio_info_id,
            'Surah Id' => $this->surah_id,
            'Ayah Index' => $this->ayah_index,
            'Ayah Key' => $this->ayah_key,
            'Audio Url' => $this->audio_url,
        ];
    }
}
