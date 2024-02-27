<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SuggestionController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function search(Request $request)
    {
        $users = $this->user->where('name', 'like', '%' . $request->search . '%')->paginate(3);//これを下のと合わせたい
        $suggested_users = $this->user->whereNotIn('id', [Auth::user()->id])
                                      ->whereDoesntHave('followers', function ($query) { $query->where('follower_id', Auth::user()->id); })
                                      ->paginate(3);

        return view('users.suggestions-search')->with('suggested_users',$suggested_users)->with('search', $request->search);
    }
}
