<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        $categories = Category::all();
        return view('posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'category' => 'required'
        ]);
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->content;
        $post->category_id = $request->category;
        $post->user_id = Auth::user()->id;;
        $post->save();
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        if (Auth::user()->id == $post->user_id || AUth::user()->hasPermissionTo('edit_any_post')) {
            $categories = Category::all();
            return view("posts.edit", compact('post', 'categories'));
        }
        return abort(403, 'Unauthorized action');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        if (Auth::user()->id == $post->user_id || Auth::user()->hasPermissionTo('edit_any_post')) {
            $post->title = $request->title;
            $post->body = $request->content;
            $post->category_id = $request->category;
            $post->save();
            return redirect()->route('posts.show', $id)->with('success', 'Post updated');
        }
        return abort(403, 'Unauthorized action');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if (Auth::user()->id == $post->user_id || Auth::user()->hasPermissionTo('delete_any_post')) {
            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post deleted');
        }
        return abort(403, 'Unauthorized action');
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts;
        $categories = Category::all();
        return view('posts.index', compact('posts', 'categories'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $posts = Post::where('title', 'LIKE', '%' . $search . '%')->get();
        return view('search.posts', compact('posts', 'search'));
    }

    public function comment(Request $request, string $id)
    {
        $comment = new Comment();
        $comment->post_id = $id;
        $comment->user_id = Auth::user()->id;
        $comment->body = $request->comment;
        $comment->save();
        return redirect()->route('posts.show', $id)->with('success', 'Comment added');
    }

    public function deleteComment(string $post_id, string $id)
    {
        $comment = Comment::find($id);
        if (Auth::user()->id == $comment->user_id || Auth::user()->hasPermissionTo('delete_any_comment')) {
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted');
        }
        return abort(403, 'Unauthorized action');
    }

    public function like(string $id)
    {
        $like = Like::where(['post_id' => $id, 'user_id' => Auth::user()->id]);

        if ($like->count())
            $like->delete();
        else
            Like::create(['post_id' => $id, 'user_id' => Auth::user()->id]);

        return redirect()->route('posts.show', $id);
    }
}
