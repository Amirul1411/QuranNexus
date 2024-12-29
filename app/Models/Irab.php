<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Sushi\Sushi;

class Irab extends Model
{
    use Sushi;

    public function getRows(): array
    {

        $analysisTable = [];

        try {
            // // Define before requiring Java.inc
            define ('JAVA_HOSTS', '13.229.243.29:8080'); // EC2 instance public IP and port
            define ('JAVA_SERVLET', '/JavaBridge'); // Java servlet path
            define ('JAVA_PREFER_VALUES', true); // Optional: to prefer PHP values over Java objects

            // Include Java.inc
            require_once('http://13.229.243.29:8080/JavaBridge/java/Java.inc');

            // Load the jqurantree.jar file
            // java_require('http://13.229.243.29:8080/opt/tomcat/lib/jqurantree-1.0.0.jar'); // Full path to the JAR file on Tomcat

            // Test JavaBridge connection
            $document = new \Java('org.jqurantree.orthography.Document');

            dd('test');

            // Retrieve the file from the S3 bucket
            $fileContent = Storage::disk('s3')->get('/quran-data/quranic-corpus-morphology-0.4.txt');

            // Ensure file is read correctly
            if (!$fileContent) {
                throw new \Exception('Failed to retrieve the file from S3.');
            }

            $lines = explode("\r\n", $fileContent);
            $startReading = false;
            $groupedData = [];


            foreach ($lines as $line) {
                // Skip empty lines
                if (trim($line) === '') {
                    continue;
                }

                // Start processing once we encounter the first line starting with '('
                if (!$startReading && strpos($line, '(') === 0) {
                    $startReading = true;
                }

                if ($startReading && !empty($line)) {
                    // dd($line);

                    // Parse the line (adjust the delimiter or parsing logic based on file structure)
                    [$location, $form, $tag, $features] = explode('\t', $line);

                    // Simplify location to chapter:verse:character
                    if (preg_match('/(\d+):(\d+):(\d+):\d+/', $location, $matches)) {
                        $simplifiedLocation = "{$matches[1]}:{$matches[2]}:{$matches[3]}";
                    } else {
                        continue;
                    }

                    // Group data by simplified location
                    if (!isset($groupedData[$simplifiedLocation])) {
                        $groupedData[$simplifiedLocation] = [
                            'form' => '',
                            'tag' => $tag,
                            'features' => $features,
                        ];
                    }

                    // Combine the form for the same location
                    $groupedData[$simplifiedLocation]['form'] .= $form; // Concatenate forms

                    // Retrieve the token using the simplified location
                    [$chapter, $verse, $character] = explode(':', $simplifiedLocation);
                    $token = $document->getToken((int) $chapter, (int) $verse, (int) $character);

                    // Iterate over the token's characters
                    $characterIterator = $token->iterator();
                    $styledCharacters = [];
                    $combinedForm = '';

                    while (java_is_true($characterIterator->hasNext())) {
                        $char = $characterIterator->next();
                        $buckwalter = $char->toBuckwalter();

                        // Check if the buckwalter string is inside the FORM string
                        if (strpos($form, $buckwalter) !== false) {
                            // Apply color based on the tag
                            $color = match ($tag) {
                                'P' => 'blue',
                                'N' => 'red',
                                default => 'black', // Default color
                            };

                            $styledCharacters[] = "<span style='color: {$color};'>{$buckwalter}</span>";
                        }
                    }

                    // Combine styled characters into one token representation
                    $combinedForm = implode('', $styledCharacters);

                    // Add processed data to the groupedData array for the simplified location
                    $groupedData[$simplifiedLocation]['styledForm'] = $combinedForm;

                    // Add processed data to the analysis table
                    $analysisTable[] = [
                        'location' => $simplifiedLocation,
                        'form' => $combinedForm,
                        'tag' => $tag,
                        'features' => $features,
                    ];
                }
            }

        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            echo 'Stack Trace: ' . $e->getTraceAsString();
        }

        return $analysisTable;

    }
}
