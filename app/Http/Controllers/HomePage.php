<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use resources\views\welcome;

class HomePage extends Controller
{
    function index()
    {
        $data = Post::all();
        return view('home', ['data' => $data]);
    }
}
