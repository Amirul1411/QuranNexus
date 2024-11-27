<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchievementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $response = [];

        $achievementFields = $request->has('achievement_fields') ? explode(',', $request->input('achievement_fields')) : null;

        if($achievementFields !== null){
            $fields = $achievementFields;
        }elseif($request->route()->getName() === 'achievement.show' || $request->route()->getName() === 'achievement.index'){
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

            if (in_array('Badge Image', $fields)) {
                $response['Badge Image'] = $this->badge_image;
            }

            if (in_array('Title', $fields)) {
                $response['Title'] = $this->title;
            }

            if (in_array('Description', $fields)) {
                $response['Description'] = $this->description;
            }

        }

        return $response;

        // return parent::toArray($request);

    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Badge Image' => $this->badge_image,
            'Title' => $this->title,
            'Description' => $this->description,
        ];
    }
}
