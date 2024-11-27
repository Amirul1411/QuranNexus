<?php

namespace App\Http\Resources\V1;

use App\Models\TranslationInfo;
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

        $response = [];

        if ($request->query('translation_info') === 'true') {
            $this->load('translationInfo');
        }

        if ($request->query('surah') === 'true' && ($request->route()->getName() === 'translation.index' || $request->route()->getName() === 'translation.show')) {
            $this->load('surah');
        }

        if ($request->query('ayah') === 'true' && ($request->route()->getName() === 'translation.index' || $request->route()->getName() === 'translation.show')) {
            $this->load('ayah');
        }

        $translationFields = $request->has('translation_fields') ? explode(',', $request->input('translation_fields')) : null;

        if($translationFields !== null){
            $fields = $translationFields;
        }elseif($request->route()->getName() === 'translation.show' || $request->route()->getName() === 'translation.index'){
            $fields = explode(',', $request->input('fields', ''));
        }

        // If no fields were provided, return all fields
        if (empty($fields[0])) {
            // Add all fields to the response
            $response = $this->getAllFields($request);
        } else {
            // Conditionally add fields based on the user's request
            if (in_array('Id', $fields)) {
                $response['Id'] = $this->_id;
            }

            if (in_array('Translation Info Id', $fields)) {
                $response['Translation Info Id'] = $this->translation_info_id;
            }

            if (in_array('Surah Id', $fields)) {
                $response['Surah Id'] = $this->surah_id;
            }

            if (in_array('Ayah Index', $fields)) {
                $response['Ayah Index'] = $this->ayah_index;
            }

            if (in_array('Ayah Key', $fields)) {
                $response['Ayah Key'] = $this->ayah_key;
            }

            if (in_array('Text', $fields)) {
                $response['Text'] = $this->text;
            }

        }

        if ($this->relationLoaded('translationInfo')) {
            $response['Translation Info'] = new TranslationInfoResource($this->whenLoaded('translationInfo'));
        }

        if ($this->relationLoaded('surah')) {
            $response['Surah'] = new SurahResource($this->whenLoaded('surah'));
        }

        if ($this->relationLoaded('ayah')) {
            $response['Ayah'] = new AyahResource($this->whenLoaded('ayah'));
        }

        return $response;

        // return parent::toArray($request);
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Translation Info Id' => $this->translation_info_id,
            'Surah Id' => $this->surah_id,
            'Ayah Index' => $this->ayah_index,
            'Ayah Key' => $this->ayah_key,
            'Text' => $this->text,
        ];
    }
}
