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

        $response = [];

        if ($request->query('translations') === 'true' && ($request->route()->getName() === 'api_translation_info.index' || $request->route()->getName() === 'api_translation_info.show')) {
            $this->load('translations');
        }

        $translationInfoFields = $request->has('translation_info_fields') ? explode(',', $request->input('translation_info_fields')) : null;

        if($translationInfoFields !== null){
            $fields = $translationInfoFields;
        }elseif($request->route()->getName() === 'api_translation_info.show' || $request->route()->getName() === 'api_translation_info.index'){
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

            if (in_array('Name', $fields)) {
                $response['Name'] = $this->name;
            }

            if (in_array('Translator', $fields)) {
                $response['Translator'] = $this->translator;
            }

            if (in_array('Language', $fields)) {
                $response['Language'] = $this->language;
            }

        }

        if ($this->relationLoaded('translations')) {
            $response['Translations'] = TranslationResource::collection($this->whenLoaded('translations'));
        }

        return $response;

        // return parent::toArray($request);
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Name' => $this->name,
            'Translator' => $this->translator,
            'Language' => $this->language,
        ];
    }
}
