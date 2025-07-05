<?php

namespace App\Http\Resources\V1;

use App\Models\AudioRecitation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AudioRecitationInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $response = [];

        if ($request->query('audio_recitations') === 'true' && ($request->route()->getName() === 'api_audio_recitation_info.index' || $request->route()->getName() === 'api_audio_recitation_info.show')) {
            $this->load('audioRecitations');
        }

        $audioRecitationInfoFields = $request->has('audio_recitation_info_fields') ? explode(',', $request->input('audio_recitation_info_fields')) : null;

        if($audioRecitationInfoFields !== null){
            $fields = $audioRecitationInfoFields;
        }elseif($request->route()->getName() === 'api_audio_recitation_info.show' || $request->route()->getName() === 'api_audio_recitation_info.index'){
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

            if (in_array('Reciter Name', $fields)) {
                $response['Reciter Name'] = $this->reciter_name;
            }

            if (in_array('Style', $fields)) {
                $response['Style'] = $this->style;
            }

            if (in_array('Translated Name', $fields)) {
                $response['Translated Name'] = [
                    'Name' => $this->translated_name['name'],
                    'Language Name' => $this->translated_name['language_name'],
                ];
            }

        }

        if ($this->relationLoaded('audioRecitations')) {
            $response['Audio Recitations'] = AudioRecitationResource::collection($this->whenLoaded('audioRecitations'));
        }

        return $response;

        // return parent::toArray($request);
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Reciter Name' => $this->reciter_name,
            'Style' => $this->style,
            'Translated Name' => [
                'Name' => $this->translated_name['name'],
                'Language Name' => $this->translated_name['language_name'],
            ],
        ];
    }
}
