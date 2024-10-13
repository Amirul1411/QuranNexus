<?php

namespace App\Http\Resources\V1;

use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslationInfoResource extends JsonResource
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
            'Translator' => $this->translator,
            'Language' => $this->language,
            'Translation' => TranslationResource::collection($this->whenLoaded('translations')),
        ];

        // return parent::toArray($request);
    }
}
