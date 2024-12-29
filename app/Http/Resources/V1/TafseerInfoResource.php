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

        $response = [];

        if ($request->query('tafseers') === 'true' && ($request->route()->getName() === 'api_tafseer_info.index' || $request->route()->getName() === 'api_tafseer_info.show')) {
            $this->load('tafseers');
        }

        $tafseerInfoFields = $request->has('tafseer_info_fields') ? explode(',', $request->input('tafseer_info_fields')) : null;

        if($tafseerInfoFields !== null){
            $fields = $tafseerInfoFields;
        }elseif($request->route()->getName() === 'api_tafseer_info.show' || $request->route()->getName() === 'api_tafseer_info.index'){
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

            if (in_array('Author Name', $fields)) {
                $response['Author Name'] = $this->author_name;
            }

            if (in_array('Slug', $fields)) {
                $response['Slug'] = $this->slug;
            }

            if (in_array('Language Name', $fields)) {
                $response['Language Name'] = $this->language_name;
            }

            if (in_array('Translated Name', $fields)) {
                $response['Translated Name'] = $this->translated_name;
            }

        }

        if ($this->relationLoaded('tafseers')) {
            $response['Tafseers'] = TafseerResource::collection($this->whenLoaded('tafseers'));
        }

        return $response;

        // return parent::toArray($request);
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Name' => $this->name,
            'Author Name' => $this->author_name,
            'Slug' => $this->slug,
            'Language Name' => $this->language_name,
            'Translated Name' => $this->translated_name,
        ];
    }
}
