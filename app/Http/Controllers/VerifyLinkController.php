<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifiedLink;
use Illuminate\Support\Facades\Auth;

class VerifyLinkController extends Controller
{
    public function index()
    {
        // Fetch all links that need verification
        $links = VerifiedLink::where('status', 'pending')->get();
        return view('verify-links', compact('links'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        VerifiedLink::create([
            'url' => is_array($request->url) ? implode(', ', $request->url) : $request->url,
            'submitted_by' => Auth::check() ? (string)Auth::user()->name : 'Guest',
            'submitted_at' => [now()], // Store as an array
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Link submitted for verification.');
    }


    public function verify($id)
    {
        $link = VerifiedLink::findOrFail($id);

        // Check if a user is authenticated before accessing their name
        $verifiedBy = Auth::check() ? (string)Auth::user()->name : 'System';

        $link->update([
            'status' => 'verified',
            'verified_by' => $verifiedBy,
            'verified_at' => now()->toDateTimeString(),
        ]);

        return redirect()->back()->with('success', 'Link verified successfully.');
    }

    public function reject($id)
    {
        $link = VerifiedLink::findOrFail($id);

        // Check if a user is authenticated before accessing their name
        $verifiedBy = Auth::check() ? (string)Auth::user()->name : 'System';

        $link->update([
            'status' => 'rejected',
            'verified_by' => $verifiedBy,
            'verified_at' => now()->toDateTimeString(),
        ]);

        return redirect()->back()->with('success', 'Link rejected.');
    }
}
