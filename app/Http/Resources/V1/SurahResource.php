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
        return [
            'Id' => $this->_id,
            'Arabic Name' => $this->name,
            'Name' => $this->tname,
            'Name Meaning' => $this->ename,
            'Type' => $this->type,
            'Number of ayahs' => $this->ayas,
            'Ayahs' => AyahResource::collection($this->whenLoaded('ayahs')),
            'Surah Info' => new SurahInfoResource($this->whenLoaded('surahInfo')),
        ];

        // return parent::toArray($request);
    }
}
