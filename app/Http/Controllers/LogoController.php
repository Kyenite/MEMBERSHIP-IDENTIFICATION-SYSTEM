<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
    
use App\Models\Logo;

class LogoController extends Controller
{
    // Show Logo Function
    public function showLogos()
    {
        // Redirect to /home if user is already logged in
        if (auth()->check()) {
            return redirect()->route('home');
        }

        // Fetch the logos from the database
        $site_logo1 = Logo::where('key', 'logo1')->value('value');
        $site_logo2 = Logo::where('key', 'logo2')->value('value');

        return view('pages.login', compact('site_logo1', 'site_logo2'));
    }

    // Update Logo Function
    public function updateLogo(Request $request)
    {
        $request->validate([
            'site_logo1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_logo2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logo1 = Logo::where('key', 'logo1')->first();
        $logo2 = Logo::where('key', 'logo2')->first();

        if ($request->hasFile('site_logo1') && $logo1) {
            $image1 = $request->file('site_logo1');
            $filename1 = Str::uuid() . '.' . $image1->getClientOriginalExtension();
            $path1 = $image1->storeAs('uploads/logos', $filename1, 'public');
            $logo1->value = 'uploads/logos/' . $filename1;
            $logo1->save();
        }

        if ($request->hasFile('site_logo2') && $logo2) {
            $image2 = $request->file('site_logo2');
            $filename2 = Str::uuid() . '.' . $image2->getClientOriginalExtension();
            $path2 = $image2->storeAs('uploads/logos', $filename2, 'public');
            $logo2->value = 'uploads/logos/' . $filename2;
            $logo2->save();
        }

        if (!$logo1) {
            Logo::create([
                'key' => 'logo1',
                'value' => 'uploads/logos/' . Str::uuid() . '.png',
            ]);
        }

        if (!$logo2) {
            Logo::create([
                'key' => 'logo2',
                'value' => 'uploads/logos/' . Str::uuid() . '.png',
            ]);
        }

        return back()->with('success', 'Logos updated successfully!');
    }
}
