<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;


class BlogController extends Controller
{
    // BlogController.php
    public function loadMore(Request $request)
    {
    $offset = $request->input('offset', 0);
    $limit = 3; // Load 3 at a time

    $blogs = Blog::skip($offset)->take($limit)->get();

    return response()->json($blogs);
    }

}
