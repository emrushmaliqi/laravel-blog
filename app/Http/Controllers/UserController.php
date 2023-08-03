<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(string $id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function followers(string $id)
    {
        $user = User::find($id);
        return view('users.followers', compact('user'));
    }

    public function following(string $id)
    {
        $user = User::find($id);
        return view('users.following', compact('user'));
    }

    public function toggleFollow(string $id)
    {
        if (Auth::user()->id === $id)
            return back();
        $user = User::find($id);
        if ($user !== null) {
            $follow = Follower::where(['follower_id' => Auth::user()->id, 'user_id' => $id]);
            if ($follow->count() > 0)
                $follow->delete();
            else
                Follower::create(['follower_id' => Auth::user()->id, 'user_id' => $id]);
        }
        return back();
    }

    public function removeFollowing(string $id)
    {
        $follow = Follower::where(['follower_id' => $id, 'user_id' => Auth::user()->id]);
        $name = $follow->first()->follower->name;
        $follow->delete();
        return back()->with('success', $name . ' no longer follows you');
    }
    public function search(Request $request)
    {
        $search = $request->search;
        $users = User::where('name', 'like', '%' . $search . '%')->get();
        return view('search.users', compact('users', 'search'));
    }
}
