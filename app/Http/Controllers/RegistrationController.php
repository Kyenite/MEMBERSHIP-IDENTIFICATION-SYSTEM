<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Parishioner;

class RegistrationController extends Controller
{
    //
    public function index()
    {
        if (Auth::check()) {
            return view('pages.registration');;
        }
    
        return view('pages.login');
    }

    public function register_parish(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'month' => 'required|integer|between:1,12',
            'day' => 'required|integer|between:1,31',
            'year' => 'required|integer|min:1900|max:2025',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'mother_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
        ]);

        try {
            // Create a new parishioner record
            Parishioner::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'age' => $request->age,
                'birthdate' => $request->year . '-' . $request->month . '-' . $request->day,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'mother_name' => $request->mother_name,
                'father_name' => $request->father_name,
            ]);

            // Flash a success message to the session
            session()->flash('status', 'success');
            session()->flash('message', 'Parishioner has been successfully registered!');
        } catch (\Exception $e) {
            // Flash an error message to the session
            session()->flash('status', 'error');
            session()->flash('message', 'There was an error registering the parishioner. Please try again.');
        }

        return redirect()->back();
    }

    public function retrieve_records()
    {
        try {
            // Fetch the records from the Parishioners table
            $parishioners = Parishioner::select('id', 'first_name', 'middle_name', 'last_name', 'birthdate')->get();

            // Pass the data to the view
            return view('pages.parishioner_records', compact('parishioners'));
        } catch (\Exception $e) {
            
            session()->flash('status', 'error');
            session()->flash('message', 'There was an error retrieving the parishioner records. Please try again.');

            // Redirect back or to a specific route
            return redirect()->back();
        }
    }
    
    public function edit_parishioner($id)
    {
        // Fetch the parishioner details
        $parishioner = Parishioner::findOrFail($id);

        return view('pages.registration', compact('parishioner'));
    }


    public function delete_parishioner($id)
    {
        // Find the parishioner by ID
        $parishioner = Parishioner::find($id);

        // If parishioner is not found, redirect with an error message
        if (!$parishioner) {
            session()->flash('status', 'error');
            session()->flash('message', 'Parishioner not found!');
            return redirect()->route('parishioner.index');
        }

        try {
            // Delete the parishioner record
            $parishioner->delete();

            // Flash a success message
            session()->flash('status', 'success');
            session()->flash('message', 'Parishioner has been successfully deleted!');
        } catch (\Exception $e) {
            // Flash an error message
            session()->flash('status', 'error');
            session()->flash('message', 'There was an error deleting the parishioner. Please try again.');
        }

        return redirect()->route('parishioner.records');
    }

    public function update_parishioner(Request $request, $id)
    {
        $parishioner = Parishioner::findOrFail($id);

        $parishioner->update($request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer',
            'month' => 'required|integer',
            'day' => 'required|integer',
            'year' => 'required|integer',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'mother_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
        ]));
        
        session()->flash('status', 'success');
        session()->flash('message', 'Parishioner has been successfully updated!');

        return redirect()->route('registration')->with('success', 'Parishioner updated successfully!');
    }

}
