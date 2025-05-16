<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public function showBlog()
    {
        $articles = ArticleImage::all(); // This fetches the article data
    
        return view('blog', compact('articles'));
    }
    // Optional: If your table name isn't 'blogs', specify it:
    // protected $table = 'your_table_name';
}
