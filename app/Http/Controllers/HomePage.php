<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomePage extends Controller
{
    function index()
    {
        $data = Post::all();
        return view('test');
    }
}
