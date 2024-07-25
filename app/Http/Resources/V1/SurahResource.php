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
            '_id' => $this->_id,
            'name' => $this->name,
            'tname' => $this->tname,
            'ename' => $this->ename,
            'ayas' => $this->ayas,
            'ayahs' => AyahResource::collection($this->whenLoaded('ayah')),
        ];

        // return parent::toArray($request);
    }
}
