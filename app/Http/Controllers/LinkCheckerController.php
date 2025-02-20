<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifiedLink;
use Illuminate\Support\Facades\Auth;

class LinkCheckerController extends Controller
{
    /**
     * Display the Link Checker page.
     */
    public function index()
    {
        $verifiedLinks = VerifiedLink::where('status', 'verified')->get();
        return view('link-checker', compact('verifiedLinks'));
    }

    /**
     * Check if a link is verified.
     */
    public function check(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        $url = $request->input('url');
        $link = VerifiedLink::where('url', $url)->first();

        if ($link) {
            return back()->with('verificationResult', [
                'status' => $link->status == 'verified' ? 'verified' : 'pending',
                'message' => $link->status == 'verified' 
                    ? '✅ This link is already verified and safe.' 
                    : '⏳ This link is pending verification.'
            ]);
        } else {
            return back()->with('verificationResult', [
                'status' => 'not_verified',
                'message' => '❌ This link is NOT verified yet. You can submit it for review.'
            ]);
        }
    }

    /**
     * Submit a new link for verification.
     */
    public function submit(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        $existingLink = VerifiedLink::where('url', $request->input('url'))->first();

        if ($existingLink) {
            // Notify user if the link already exists in the database
            return back()->with('error', $existingLink->status === 'verified'
                ? '⚠️ This link is already verified and safe.'
                : '⏳ This link has already been submitted and is pending verification.');
        }

        // Create a new entry if the link doesn't exist
        VerifiedLink::create([
            'url' => $request->input('url'),
            'status' => 'pending',
            'submitted_by' => Auth::user() ? Auth::user()->name : 'Guest',
            'submitted_at' => now(),
        ]);

        return back()->with('success', '✅ Your link has been submitted for verification.');
    }
}
