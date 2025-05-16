<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;


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


    // public function showBlogPage()
    // {
    //     $carouselImages = DB::table('blog_image')->get(); 

    //     return view('blog', compact('carouselImages')); 
    // }

    // public function showArticlePage()
    // {
    //     $articles = DB::table('article_image')->get(); 

    //     return view('blog', compact('articles')); 
    // }

    public function showBlogPage()
    {
        $articles = DB::table('article_image')->get(); 
        $carouselImages = DB::table('blog_image')->get(); // Adjust table name if needed

        return view('blog', compact('articles', 'carouselImages'));
    }

    public function loadMoreBlogs(Request $request)
{
    $offset = $request->input('offset', 0);
    $blogs = DB::table('article_image')
                ->offset($offset)
                ->limit(6)
                ->get()
                ->map(function ($blog) {
                    return [
                        'title' => $blog->title,
                        'excerpt' => $blog->description,
                        'image_url' => asset('image/image_article/' . $blog->filename),
                    ];
                });

    return response()->json($blogs);
}


}
