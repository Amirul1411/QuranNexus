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
            'Surah Id' => $this->surah_id,
            'Ayah Index' => $this->ayah_index,
            'Ayah Key' => $this->ayah_key,
            'Html' => $this->html,
        ];

        // return parent::toArray($request);
    }
}
