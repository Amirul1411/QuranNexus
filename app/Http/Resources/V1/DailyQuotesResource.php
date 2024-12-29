<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyQuotesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [];

        $dailyQuotesFields = $request->has('daily_quotes_fields') ? explode(',', $request->input('daily_quotes_fields')) : null;

        if($dailyQuotesFields !== null){
            $fields = $dailyQuotesFields;
        }elseif($request->route()->getName() === 'api_daily_quotes.show' || $request->route()->getName() === 'api_daily_quotes.index'){
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

            if (in_array('Title', $fields)) {
                $response['Title'] = $this->title;
            }

            if (in_array('Description', $fields)) {
                $response['Description'] = $this->description;
            }

            if (in_array('Source', $fields)) {
                $response['Source'] = $this->source;
            }

        }

        return $response;
    }

    private function getAllFields($request)
    {
        return [
            'Id' => $this->_id,
            'Title' => $this->title,
            'Description' => $this->description,
            'Source' => $this->source,
        ];
    }
}
