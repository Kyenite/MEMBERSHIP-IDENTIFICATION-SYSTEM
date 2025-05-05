<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class FolderController extends Controller
{
    // Retrieve all folders
    public function retrieve_folders()
    {
        $folders = Folder::orderby('folder_name', 'asc')->get();

        if(Auth::check()) {
            return view('pages.list', compact('folders'));
        }

        return view('pages.login');
    }





    // Create a new folder
    public function create(Request $request)
    {
        // Validate input
        $request->validate([
            'folder_name' => 'required|string|max:255|unique:folders,folder_name',
        ], [
            'folder_name.unique' => 'The folder name already exists. Please choose another name.',
        ]);

        try {
            Folder::create(['folder_name' => $request->folder_name]);

            return redirect()->back()->with('success', 'Folder created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating folder: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred while creating the folder.');
        }
    }





    // Update an existing folder
    public function update(Request $request, $id)
    {
        $request->validate([
            'folder_name' => 'required|unique:folders,folder_name,' . $id,
        ]);

        $folder = Folder::findOrFail($id);
        $folder->update([
            'folder_name' => $request->folder_name,
        ]);

        return redirect()->back()->with('success', 'Folder updated successfully!');
    }





    // Delete a folder
    public function delete($id)
    {
        $folder = Folder::findOrFail($id);
        $folder->delete();

        return redirect()->back()->with('success', 'Folder deleted successfully!');
    }





    // Search for folders
    public function searchFolders(Request $request)
    {
        $query = $request->input('query');
        
        $folders = Folder::where('folder_name', 'LIKE', "%{$query}%")->pluck('folder_name');

        return response()->json($folders);
    }



    

    // Retrieve all folders
    public function retrieve_folders_donation()
    {
        $folders = Folder::orderby('folder_name', 'asc')->get();

        if(Auth::check()) {
            return view('pages.donation', compact('folders'));
        }

        return view('pages.login');
    }
}
