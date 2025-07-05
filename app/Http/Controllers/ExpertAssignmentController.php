<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpertAssignment;
use App\Models\User;

class ExpertAssignmentController extends Controller
{
    /**
     * Display the manage experts page.
     */
    public function index()
    {
        // Get all editors (users with role 'editor')
        $editors = User::where('role', 'editor')->get();

        // Get all assigned experts
        $assignments = ExpertAssignment::with('expert')->get();

        return view('manage-experts', compact('editors', 'assignments'));
    }

    /**
     * Assign an expert to an Ayah, Word, or Translation.
     */
    public function assignExpert(Request $request)
    {
        $request->validate([
            'data_type' => 'required',
            'expert_id' => 'required',
        ]);

        // Create assignment record in the database
        ExpertAssignment::create([
            'data_type' => $request->input('data_type'),
            'surah_id' => $request->input('surah_id'),
            'ayah_index' => $request->input('ayah_index'),
            'expert_id' => $request->input('expert_id'),
        ]);

        return redirect()->back()->with('success', 'Expert assigned successfully.');
    }

    /**
     * Remove an expert assignment.
     */
    public function unassignExpert($id)
    {
        ExpertAssignment::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Expert unassigned successfully.');
    }
}
