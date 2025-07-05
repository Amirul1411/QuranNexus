<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadedData;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function index()
    {
        // Render the upload page
        return view('upload');
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/quranic_data_template.xlsx');
        return response()->download($filePath);
    }

    public function store(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        $file = $request->file('excel_file');

        if (!$file) {
            return back()->withErrors(['error' => 'No file uploaded.']);
        }

        // Parse the Excel file
        $data = Excel::toArray([], $file);

        if (empty($data) || !isset($data[0])) {
            return back()->withErrors(['error' => 'Invalid or empty Excel file.']);
        }

        $formattedData = [];

        foreach ($data[0] as $row) {
            if (isset($row['ayah_key'], $row['text'], $row['translation'], $row['surah_id'], $row['ayah_index'])) {
                $formattedData[] = [
                    'ayah_key' => $row['ayah_key'],
                    'text' => $row['text'],
                    'translation' => $row['translation'],
                    'surah_id' => $row['surah_id'],
                    'ayah_index' => $row['ayah_index'],
                ];
            }
        }

        if (empty($formattedData)) {
            return back()->withErrors(['error' => 'No valid data found in the uploaded file.']);
        }

        UploadedData::create([
            'type' => 'ayah',
            'data' => $formattedData,
            'uploaded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'File uploaded and data stored successfully!');
    }
}
