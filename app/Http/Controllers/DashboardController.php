<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function users(Request $request)
    {
        $limit = 20;
        $sort = 'id';
        $order = 'asc';
        $search = $request->search;
        $users = User::query();
        $page = $request->page ?? 1;
        $total = User::count();

        if ($request->sort !== null) {
            $sort = explode('-', $request->sort)[0];
            $order = explode('-', $request->sort)[1];
        }
        if ($search)
            $users->where('name', 'like', '%' . $search . '%');

        $users = $users->orderBy($sort, $order)->offset(($page - 1) * $limit)->limit($limit)->get();

        return view('dashboard.users', compact('users', 'sort', 'order', 'total', 'limit'));
    }

    public function toggleAdmin($id)
    {
        $is_admin = DB::table('model_has_roles')->where(['model_id' => $id, 'role_id' => 1, 'model_type' => User::class]);

        if ($is_admin->count())
            $is_admin->delete();
        else
            DB::table('model_has_roles')->insert(['model_id' => $id, 'role_id' => 1, 'model_type' => User::class]);

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('dashboard.users')->with('success', 'User deleted successfully');
    }

    public function posts(Request $request)
    {
        $limit = 10;
        $sort = 'id';
        $order = 'asc';
        $search = $request->search;
        $category = $request->category;
        $user = $request->user;
        $categories = Category::all();
        $posts = Post::query();
        $query_params = [];
        $page = $request->page ?? 1;
        $total = Post::count();

        if ($request->sort !== null) {
            $sort = explode('-', $request->sort)[0];
            $order = explode('-', $request->sort)[1];
        }


        if ($search) {
            $posts->where('title', 'like', '%' . $search . '%');
            $query_params['search'] = $search;
        }
        if ($category) {
            $posts->where('category_id', $category);
            $query_params['category'] = $category;
        }

        if ($user) {
            $posts->where('user_id', $user);
            $query_params['user'] = $user;
        }

        $posts = $posts->orderBy($sort, $order)->offset(($page - 1) * $limit)->limit($limit)->get();

        return view('dashboard.posts', compact('posts', 'sort', 'order', 'categories', 'query_params', 'total', 'limit'));
    }

    public function comments(Request $request)
    {
        $limit = 20;
        $sort = 'id';
        $order = 'asc';
        $search = $request->search;
        $comments = Comment::query();
        $page = $request->page ?? 1;
        $total = Comment::count();

        $query_params = [];

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
            $query_params['filter'] = $request->filter;
        }

        if ($search) {
            $comments->where('body', 'like', '%' . $search . '%');
            $query_params['search'] = $search;
        }


        $comments = $comments->orderBy($sort, $order)->offset(($page - 1) * $limit)->limit($limit)->get();

        return view('dashboard.comments', compact('comments', 'sort', 'order', 'query_params', 'total', 'limit'));
    }

    public function likes(Request $request)
    {
        $limit = 20;
        $sort = 'created_at';
        $order = 'desc';
        $likes = Like::query();
        $page =  $request->page ?? 1;
        $total = Like::count();

        if ($request->sort) {
            $sort = explode('-', $request->sort)[0];
            $order = explode('-', $request->sort)[1];
        }

        if ($request->filter) {
            $filter = explode('-', $request->filter)[0];
            $value = explode('-', $request->filter)[1];
            if ($filter == 'user')
                $likes->where('user_id', $value);
            else if ($filter == 'post')
                $likes->where('post_id', $value);
        }


        $likes = $likes->orderBy($sort, $order)->offset(($page - 1) * $limit)->limit($limit)->get();

        return view('dashboard.likes', compact('likes', 'sort', 'order', 'total', 'limit'));
    }

    public function deleteLike(Request $request)
    {
        Like::where(['post_id' => $request->post_id, 'user_id' => $request->user_id])->delete();

        return redirect()->back()->with('success', 'Like deleted successfully');
    }
}
