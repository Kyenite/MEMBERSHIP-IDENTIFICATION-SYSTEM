<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\FGMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FG_Controller extends Controller
{
    //
    public function retrieve_fg_members($folder_id)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        $folder = Folder::with('members')
            ->withCount('members')
            ->find($folder_id);

        if (!$folder) {
            return redirect()->back()->with('error', 'Folder not found.');
        }

        return view('pages.fg_members', [
            'folder' => $folder,
            'members' => $folder->members,
            'members_count' => $folder->members_count,
        ]);
    }





    public function create(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to perform this action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $member = new FGMember();
        $member->name = $request->input('name');
        $member->folder_id = $request->folder_id;
        $member->save();

        return redirect()->route('fg.members', ['folder_id' => $request->folder_id])->with('success', 'Member created successfully!');
    }





    // Update an existing member
    public function update(Request $request, $member_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to perform this action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $member = FGMember::find($member_id);
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        $member->name = $request->input('name');
        $member->save();

        return redirect()->route('fg.members', ['folder_id' => $request->folder_id])->with('success', 'Member updated successfully!');
    }





    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to perform this action.');
        }

        $member = FGMember::find($id);
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }
        
        // Delete the member
        $member->delete();

        return redirect()->route('fg.members')->with('success', 'Member deleted successfully!');
    }





    public function complete_update(Request $request, $member_id)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to perform this action.');
        }

        // Validate input, including profile image
        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string|max:10',
            'status' => 'nullable|string|max:255',
            'fathers_name' => 'nullable|string|max:255',
            'mothers_name' => 'nullable|string|max:255',
            'activity' => 'nullable|string|max:255',
            'baptism' => 'nullable|boolean',
            'communion' => 'nullable|boolean',
            'confirmation' => 'nullable|boolean',
            'marriage' => 'nullable|boolean',
            'profile' => 'nullable|image|max:2048',
            'family_code' => 'nullable|string|min:1|max:10|regex:/^\d+$/',
        ]);

        // Find the member by ID
        $member = FGMember::find($member_id);
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        try {
            if ($request->hasFile('profile')) {
                $image = $request->file('profile');
                $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            
                $path = $image->storeAs('uploads/profile_images', $filename, 'public');
            
                $dbPath = 'uploads/profile_images/' . $filename;
            
                if ($member->profile !== 'images/default_profile.png') {
                    Storage::disk('public')->delete($member->profile);
                }
            
                $member->profile = $dbPath;
            }





            // Update member fields
            $member->update([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'age' => $request->age,
                'gender' => $request->gender,
                'status' => $request->status,
                'fathers_name' => $request->fathers_name,
                'mothers_name' => $request->mothers_name,
                'activity' => $request->activity,
                'baptism' => $request->has('baptism') ? 1 : 0,
                'communion' => $request->has('communion') ? 1 : 0,
                'confirmation' => $request->has('confirmation') ? 1 : 0,
                'marriage' => $request->has('marriage') ? 1 : 0,
                'profile' => $member->profile,
                'family_code' => $request->family_code,
            ]);

            return redirect()->route('fg.members', ['folder_id' => $request->folder_id])
                ->with('success', 'Member updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }





    public function retrieve_fg_data($member_id)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        // Find the FG member with its folder
        $member = FGMember::with('folder')->find($member_id);

        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        return view('pages.fg_profile', compact('member'));
    }



    

    public function on_view_destroy($id, $folder_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to perform this action.');
        }

        $member = FGMember::find($id);
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        if ($member->profile) {
            Storage::delete('public/' . $member->profile);
        }

        $member->delete();

        return redirect()->route('fg.members', ['folder_id' => $folder_id])
            ->with('success', 'Member deleted successfully!');
    }
}
