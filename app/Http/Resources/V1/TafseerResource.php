<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TafseerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $response = [];

        if ($request->query('tafseer_info') === 'true') {
            $this->load('tafseerInfo');
        }

        if ($request->query('surah') === 'true' && ($request->route()->getName() === 'tafseer.index' || $request->route()->getName() === 'tafseer.show')) {
            $this->load('surah');
        }

        if ($request->query('ayah') === 'true' && ($request->route()->getName() === 'tafseer.index' || $request->route()->getName() === 'tafseer.show')) {
            $this->load('ayah');
        }

        $tafseerFields = $request->has('tafseer_fields') ? explode(',', $request->input('tafseer_fields')) : null;

        if($tafseerFields !== null){
            $fields = $tafseerFields;
        }elseif($request->route()->getName() === 'tafseer.show' || $request->route()->getName() === 'tafseer.index'){
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

            if (in_array('Tafseer Info Id', $fields)) {
                $response['Tafseer Info Id'] = $this->translation_info_id;
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

            if (in_array('Html', $fields)) {
                $response['Html'] = $this->html;
            }

        }

        if ($this->relationLoaded('tafseerInfo')) {
            $response['Tafseer Info'] = new TafseerInfoResource($this->whenLoaded('tafseerInfo'));
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
            'Tafseer Info Id' => $this->tafseer_info_id,
            'Surah Id' => $this->surah_id,
            'Ayah Index' => $this->ayah_index,
            'Ayah Key' => $this->ayah_key,
            'Html' => $this->html,
        ];
    }
}
