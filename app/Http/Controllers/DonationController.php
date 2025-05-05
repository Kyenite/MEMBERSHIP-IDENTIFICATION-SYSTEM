<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\FGMember;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;

class DonationController extends Controller
{
    public function index($folderId)
    {
        if (Auth::check()) {
            $folder = Folder::find($folderId);

            $folders = [
                'folderName' => $folder ? $folder->folder_name : null
            ];

            return view('pages.view_donation', compact('folders'));
        } else {
            return redirect()->route('login');
        }
    }

    public function getMembers($folderId, $year)
    {
        try {
            $members = FGMember::where('folder_id', $folderId)
                ->with(['donations' => function ($query) use ($year) {
                    $query->where('year', $year);
                }])
                ->orderBy('name', 'asc')
                ->get();

            return response()->json(['success' => true, 'members' => $members]);
        } catch (\Exception $e) {
            \Log::error('Error fetching members: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to retrieve members.'], 500);
        }
    }

    public function getYears()
    {
        try {
            $years = Donation::select('year')->distinct()->pluck('year');

            return response()->json(['success' => true, 'years' => $years]);
        } catch (\Exception $e) {
            \Log::error('Error fetching years: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to retrieve years.'], 500);
        }
    }

    public function saveDonation(Request $request)
    {
        $request->validate([
            'fg_member_id' => 'required|exists:fg_members,id',
            'month' => 'required',
            'amount' => 'required|numeric',
            'year' => 'required',
            'date' => 'required|date'
        ]);

        $donation = Donation::where([
            'fg_member_id' => $request->fg_member_id,
            'month' => strtolower($request->month),
            'year' => $request->year,
        ])->first();

        if ($donation) {
            // Update existing donation entry

            // Convert dates for accurate comparison
            $newDate = \Carbon\Carbon::parse($request->date);
            $existingDate = $donation->date ? \Carbon\Carbon::parse($donation->date) : null;

            if (
                $donation->amount != $request->amount ||
                !$existingDate || !$existingDate->equalTo($newDate)
            ) {
                $donation->amount = $request->amount;
                $donation->date = $newDate;
                $donation->save();
                $message = 'Donation updated successfully!';
            } else {
                $message = 'No changes detected.';
            }
        } else {
            // Create new donation entry
            $donation = Donation::create([
                'fg_member_id' => $request->fg_member_id,
                'month' => strtolower($request->month),
                'year' => $request->year,
                'amount' => $request->amount,
                'date' => $request->date,
            ]);
            $message = 'Donation saved successfully!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'donation' => $donation
        ]);
    }
}
