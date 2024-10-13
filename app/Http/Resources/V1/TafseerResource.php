<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TafseerResource extends JsonResource
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
            'Tafseer Info Id' => $this->when($request->query('tafseer_info_tafseers') !== 'true', $this->tafseer_info_id),
            'Surah Id' => $this->when($request->query('tafseers') !== 'true', $this->surah_id),
            'Ayah Index' => $this->when($request->query('tafseers') !== 'true', $this->ayah_index),
            'Ayah Key' => $this->when($request->query('tafseers') !== 'true', $this->ayah_key),
            'Html' => $this->html,
        ];

        // return parent::toArray($request);
    }
}
