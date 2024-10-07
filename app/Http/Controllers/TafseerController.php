<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ayah;
use App\Models\Tafseer;

class TafseerController extends Controller
{
    public function show(Tafseer $tafseer)
    {
        $ayah = Ayah::find($tafseer->id);

        $htmlContent = $tafseer->html;

        $htmlContent = str_replace('<h2>', '<h2 class="font-bold my-5 text-xl">', $htmlContent);
        $htmlContent = str_replace('<h3>', '<h3 class="font-semibold my-5 text-lg">', $htmlContent);
        // $htmlContent = str_replace('<p>', '<p class="my-5">', $htmlContent);
        $htmlContent = str_replace('<ol>', '<ol class="my-5">', $htmlContent);
        $htmlContent = str_replace('<li>', '<li class="my-5">', $htmlContent);
        $htmlContent = preg_replace('/\s*style=("|\')(.*?)("|\')/i', '', $htmlContent);

        // Detect Arabic characters using a regex pattern
        $arabicRegex = '/[\x{0600}-\x{06FF}\x{0750}-\x{077F}]/u';

        // Find all <p> tags and check for Arabic content
        $htmlContent = preg_replace_callback(
            '/<p>(.*?)<\/p>/s',
            function ($matches) use ($arabicRegex) {
                // Check if the content inside the <p> tag contains Arabic characters
                if (preg_match($arabicRegex, $matches[1])) {
                    // Add a special class for Arabic text
                    return '<p class="my-5 font-UthmanicHafs text-2xl">' . $matches[1] . '</p>';
                } else {
                    // Return the <p> tag with the default class for non-Arabic text
                    return '<p class="my-5">' . $matches[1] . '</p>';
                }
            },
            $htmlContent,
        );

        // Pass data to the view
        return view('tafseer', [
            'ayah' => $ayah,
            'htmlContent' => $htmlContent,
        ]);
    }
}
