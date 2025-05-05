<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forum;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    //
    public function index()
    {
        $forums = Forum::with('user')->latest()->paginate(10);
        
        if(Auth::check()) {
            return view('pages.forum', compact('forums'));
        }

        return view('pages.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        Forum::create([
            'user_id' => Auth::id(),
            'username' => Auth::user()->name,
            'content' => $request->content
        ]);

        return redirect()->back();
    }

    public function loadMoreMessages(Request $request)
    {
        $lastMessageId = $request->last_message_id;

        // Fetch the next older messages (previous ones)
        $messages = Forum::where('id', '<', $lastMessageId)
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->with('user')
                        ->get();

        return response()->json($messages->reverse());
    }

}
