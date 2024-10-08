<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AyahResource extends JsonResource
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
            'Page Id' => $this->page_id,
            'Juz Id' => $this->juz_id,
            'Bismillah' => $this->bismillah,
            'Words' => WordResource::collection($this->whenLoaded('words')),
        ];

        // return parent::toArray($request);
    }
}
