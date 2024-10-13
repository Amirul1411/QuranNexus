<?php

namespace App\Http\Resources\V1;

use App\Models\Tafseer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TafseerInfoResource extends JsonResource
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
            'Name' => $this->name,
            'Author Name' => $this->author_name,
            'Slug' => $this->slug,
            'Language Name' => $this->language_name,
            'Translated Name' => $this->translated_name,
            'Tafseers' => TafseerResource::collection($this->whenLoaded('tafseers')),
        ];

        // return parent::toArray($request);
    }
}
