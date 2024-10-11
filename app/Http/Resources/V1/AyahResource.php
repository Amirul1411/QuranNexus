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
        if ($this->whenLoaded('ayahs')) {
            return [
                'Id' => $this->_id,
                'Ayah Index' => $this->ayah_index,
                'Ayah Key' => $this->ayah_key,
                'Page Id' => $this->page_id,
                'Juz Id' => $this->juz_id,
                'Bismillah' => $this->bismillah,
            ];
        }

        return [
            'Id' => $this->_id,
            'Surah Id' => $this->surah_id,
            'Ayah Index' => $this->ayah_index,
            'Ayah Key' => $this->ayah_key,
            'Page Id' => $this->page_id,
            'Juz Id' => $this->juz_id,
            'Bismillah' => $this->bismillah,
            'Words' => WordResource::collection($this->whenLoaded('words')),
            'Translations' => TranslationResource::collection($this->whenLoaded('translations')),
            'Tafseer' => TafseerResource::collection($this->whenLoaded('tafseers')),
            'Audio Recitation' => AudioRecitationResource::collection($this->whenLoaded('audioRecitations')),
        ];

        // return parent::toArray($request);
    }
}
