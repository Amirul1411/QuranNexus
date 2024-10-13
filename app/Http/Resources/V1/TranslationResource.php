<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslationResource extends JsonResource
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
            'Translation Info Id' => $this->when($request->query('translation_info_translations') !== 'true', $this->translation_info_id),
            'Surah Id' => $this->when($request->query('translations') !== 'true', $this->surah_id),
            'Ayah Index' => $this->when($request->query('translations') !== 'true', $this->ayah_index),
            'Ayah Key' => $this->when($request->query('translations') !== 'true', $this->ayah_key),
            'Text' => $this->text,
        ];

        // return parent::toArray($request);
    }
}
