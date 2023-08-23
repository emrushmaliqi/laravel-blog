<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Save;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = 20;
        $total_pages = ceil(Post::count() / $limit);
        $page = $request->page ?? 1;
        $posts = Post::orderBy('created_at', 'desc')->offset(($page - 1) * $limit)->limit($limit)->get();
        $categories = Category::all();
        return view('posts.index', compact('posts', 'categories', 'total_pages'));
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
        $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:30',
            'category' => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->content;
        $post->category_id = $request->category;
        $post->user_id = Auth::user()->id;;
        $post->save();
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $image->store('public/posts/images/');
                $db_image = new Image();
                $db_image->path = $image->hashName();
                $db_image->post_id = $post->id;
                $db_image->save();
            }
        }
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
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
        $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:30',
            'category' => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $post = Post::find($id);
        if (Auth::user()->id == $post->user_id || Auth::user()->hasPermissionTo('edit_any_post')) {
            $post->title = $request->title;
            $post->body = $request->content;
            $post->category_id = $request->category;
            $post->save();

            if ($request->has('images')) {
                foreach ($request->images as $image) {
                    $image->store('public/posts/images/');
                    $db_image = new Image();
                    $db_image->path = $image->hashName();
                    $db_image->post_id = $post->id;
                    $db_image->save();
                }
            }
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

    public function category(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $limit = 20;
        $total_pages = ceil(Post::where('category_id', $category->id)->count() / $limit);
        $page = $request->page ?? 1;
        $posts = $category->posts()->orderBy('created_at', 'desc')->offset(($page - 1) * $limit)->limit($limit)->get();
        $categories = Category::all();
        return view('posts.index', compact('posts', 'categories', 'total_pages'));
    }

    public function search(Request $request)
    {
        $request->validate(['search' => 'required']);

        $search = $request->search;
        $posts = Post::where('title', 'LIKE', '%' . $search . '%')->get();
        return view('search.posts', compact('posts', 'search'));
    }

    public function comment(Request $request, string $id)
    {
        $request->validate(['comment' => 'required']);

        $comment = new Comment();
        $comment->post_id = $id;
        $comment->user_id = Auth::user()->id;
        $comment->body = $request->comment;
        $comment->save();
        return redirect()->route('posts.show', $id)->with('success', 'Comment added');
    }

    public function editComment(string $id)
    {
        $comment = Comment::find($id);
        if (Auth::user()->id == $comment->user_id || Auth::user()->hasPermissionTo('edit_any_comment')) {
            return view('comments.edit', compact('comment'));
        }
        return abort(403, 'Unauthorized action');
    }
    public function updateComment(Request $request, string $id)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        $comment = Comment::find($id);
        if (Auth::user()->id == $comment->user_id || Auth::user()->hasPermissionTo('edit_any_comment')) {
            $comment->body = $request->comment;
            $comment->save();
            return redirect()->route('posts.show', $comment->post_id)->with('success', 'Post updated');
        }
        return abort(403, 'Unauthorized action');
    }

    public function deleteComment(string $id)
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

    public function saved(Request $request)
    {
        $limit = 20;
        $total_pages = ceil(Auth::user()->savedPosts()->count() / $limit);
        $page = $request->page ?? 1;

        $posts = Auth::user()->savedPosts()->offset(($page - 1) * $limit)->limit($limit)->get();

        return view('posts.saved', compact('posts', 'limit', 'total_pages'));
    }

    public function save(string $id)
    {
        $save = Save::where(['post_id' => $id, 'user_id' => Auth::user()->id]);
        if ($save->count())
            $save->delete();
        else {
            $save = new Save();
            $save->post_id = $id;
            $save->user_id = Auth::user()->id;
            $save->save();
        }
        return redirect()->back();
    }

    public function deleteImage(string $post_id, string $image_id)
    {
        $image = Image::find($image_id);
        if (Auth::user()->id == $image->post->user_id || Auth::user()->hasRole('admin')) {
            $image->delete();
            Storage::delete('public/posts/images/' . $image->path);
            return redirect()->route('posts.show', $post_id)->with('success', 'Image deleted');
        }

        return abort(403, 'Unauthorized action');
    }
}
