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

        return [
            'Id' => $this->_id,
            'Audio Info Id' => $this->when($request->query('audio_info_audio_recitations') !== 'true', $this->audio_info_id),
            'Surah Id' => $this->when($request->query('audio_recitations') !== 'true', $this->surah_id),
            'Ayah Index' => $this->when($request->query('audio_recitations') !== 'true', $this->ayah_index),
            'Ayah Key' => $this->when($request->query('audio_recitations') !== 'true', $this->ayah_key),
            'Audio Url' => $this->audio_url,
        ];

        // return parent::toArray($request);
    }
}
