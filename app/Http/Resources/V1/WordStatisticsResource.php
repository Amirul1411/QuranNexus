<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WordStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [];

        $wordStatisticsFields = $request->has('word_statistics_fields') ? explode(',', $request->input('word_statistics_fields')) : null;

        if ($wordStatisticsFields !== null) {
            $fields = $wordStatisticsFields;
        } elseif ($request->route()->getName() === 'api_word_statistics.show' || $request->route()->getName() === 'api_word_statistics.index') {
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

            if (in_array('Word', $fields)) {
                $response['Word'] = $this->word;
            }

            if (in_array('Transliteration', $fields)) {
                $response['Transliteration'] = $this->transliteration;
            }

            if (in_array('Translation', $fields)) {
                $response['Translation'] = $this->translation;
            }
            if (in_array('Characters', $fields)) {
                $response['Characters'] = $this->characters;
            }

            if (in_array('Total Occurrences', $fields)) {
                $response['Total Occurrences'] = $this->total_occurrences;
            }

            if (in_array('Occurrences by Surah', $fields)) {
                $occurrencesBySurahArr = [];

                foreach ($this->occurrences_by_surah as $occurrence) {
                    $occurrencesBySurahArr[] = [
                        'Surah Id' => $occurrence['surah_id'],
                        'Count' => $occurrence['count'],
                    ];
                }

                $response['Occurrences by Surah'] = $occurrencesBySurahArr;
            }

            if (in_array('Occurrences by Juz', $fields)) {
                $occurrencesByJuzArr = [];

                foreach ($this->occurrences_by_juz as $occurrence) {
                    $occurrencesByJuzArr[] = [
                        'Juz Id' => $occurrence['juz_id'],
                        'Count' => $occurrence['count'],
                    ];
                }

                $response['Occurrences by Juz'] = $occurrencesByJuzArr;
            }

            if (in_array('Occurrences by Page', $fields)) {
                $occurrencesByPageArr = [];

                foreach ($this->occurrences_by_page as $occurrence) {
                    $occurrencesByPageArr[] = [
                        'Page Id' => $occurrence['page_id'],
                        'Count' => $occurrence['count'],
                    ];
                }

                $response['Occurrences by Page'] = $occurrencesByPageArr;
            }

            if (in_array('Positions', $fields)) {
                $positionsPagePositionsArr = [];

                foreach ($this->positions['page_positions'] as $position) {
                    $positionsPagePositionsLinesArr = [];

                    foreach ($position['lines'] as $line) {
                        $positionsPagePositionsLinesArr[] = [
                            'Line Number' => $line['line_number'],
                            'Count' => $line['count'],
                        ];
                    }

                    $positionsPagePositionsArr[] = [
                        'Page Id' => $position['page_id'],
                        'Total Count' => $position['total_count'],
                        'Lines' => $positionsPagePositionsLinesArr,
                    ];
                }

                $response['Positions'] = [
                    'Word Keys' => $this->positions['word_keys'],
                    'Page Positions' => $positionsPagePositionsArr,
                ];
            }
        }

        return $response;
    }

    private function getAllFields($request)
    {
        $occurrencesBySurahArr = [];

        foreach ($this->occurrences_by_surah as $occurrence) {
            $occurrencesBySurahArr[] = [
                'Surah Id' => $occurrence['surah_id'],
                'Count' => $occurrence['count'],
            ];
        }

        $occurrencesByJuzArr = [];

        foreach ($this->occurrences_by_juz as $occurrence) {
            $occurrencesByJuzArr[] = [
                'Juz Id' => $occurrence['juz_id'],
                'Count' => $occurrence['count'],
            ];
        }

        $occurrencesByPageArr = [];

        foreach ($this->occurrences_by_page as $occurrence) {
            $occurrencesByPageArr[] = [
                'Page Id' => $occurrence['page_id'],
                'Count' => $occurrence['count'],
            ];
        }

        $positionsPagePositionsLinesArr = [];
        $positionsPagePositionsArr = [];

        foreach ($this->positions['page_positions'] as $position) {
            foreach ($position['lines'] as $line) {
                $positionsPagePositionsLinesArr[] = [
                    'Line Number' => $line['line_number'],
                    'Count' => $line['count'],
                ];
            }

            $positionsPagePositionsArr[] = [
                'Page Id' => $position['page_id'],
                'Total Count' => $position['total_count'],
                'Lines' => $positionsPagePositionsLinesArr,
            ];
        }

        return [
            'Id' => $this->_id,
            'Word' => $this->word,
            'Transliteration' => $this->transliteration,
            'Translation' => $this->translation,
            'Characters' => $this->characters,
            'Total Occurences' => $this->total_occurrences,
            'Occurences by Surah' => $occurrencesBySurahArr,
            'Occurences by Juz' => $occurrencesByJuzArr,
            'Occurrences by Page' => $occurrencesByPageArr,
            'Positions' => [
                'Word Keys' => $this->positions['word_keys'],
                'Page Positions' => $positionsPagePositionsArr,
            ],
        ];
    }
}
