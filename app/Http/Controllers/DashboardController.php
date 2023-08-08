<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function users(Request $request)
    {

        $sort = 'id';
        $order = 'asc';
        $search = $request->search;
        $users = [];
        if ($request->sort !== null) {
            $sort = explode('-', $request->sort)[0];
            $order = explode('-', $request->sort)[1];
        }
        if ($search)
            $users = User::where('name', 'like', '%' . $search . '%')->orderBy($sort, $order)->get();
        else
            $users = User::orderBy($sort, $order)->get();

        return view('dashboard.users', compact('users', 'sort', 'order'));
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function posts(Request $request)
    {
        $sort = 'id';
        $order = 'asc';
        $search = $request->search;
        $category = $request->category;
        $user = $request->user;
        $categories = Category::all();
        $posts = Post::query();

        if ($request->sort !== null) {
            $sort = explode('-', $request->sort)[0];
            $order = explode('-', $request->sort)[1];
        }


        if ($search)
            $posts->where('title', 'like', '%' . $search . '%');
        if ($category)
            $posts->where('category_id', $category);

        if ($user)
            $posts->where('user_id', $user);

        $posts = $posts->orderBy($sort, $order)->get();

        return view('dashboard.posts', compact('posts', 'sort', 'order', 'categories'));
    }

    public function comments(Request $request)
    {
        $sort = 'id';
        $order = 'asc';
        $search = $request->search;
        $comments = Comment::query();


        if ($request->sort !== null) {
            $sort = explode('-', $request->sort)[0];
            $order = explode('-', $request->sort)[1];
        }

        if ($request->filter) {
            $filter = explode('-', $request->filter)[0];
            $value = explode('-', $request->filter)[1];
            if ($filter == 'user')
                $comments->where('user_id', $value);
            else if ($filter == 'post')
                $comments->where('post_id', $value);
        }

        if ($search)
            $comments->where('body', 'like', '%' . $search . '%');

        $comments = $comments->orderBy($sort, $order)->get();

        return view('dashboard.comments', compact('comments', 'sort', 'order'));
    }
}
