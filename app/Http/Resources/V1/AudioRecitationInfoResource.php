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

        return [
            'Id' => $this->_id,
            'Reciter Name' => $this->reciter_name,
            'Style' => $this->style,
            'Translated Name' => $this->translated_name,
            'Audio Recitations' => AudioRecitationResource::collection($this->whenLoaded('audioRecitations')),
        ];

        // return parent::toArray($request);
    }
}
