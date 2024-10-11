<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WordResource extends JsonResource
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
            'Word Index' => $this->word_index,
            'Ayah Key' => $this->ayah_key,
            'Word Key' => $this->word_key,
            'Page Id' => $this->page_id,
            'Line Number' => $this->line_number,
            'Text' => $this->text,
        ];

        // return parent::toArray($request);
    }
}
