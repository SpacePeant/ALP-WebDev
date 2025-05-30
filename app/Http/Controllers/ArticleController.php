<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ArticleController extends Controller
{
    public function show($id)
    {
        $article = DB::table('articles')->where('id', $id)->first();

        if (!$article) {
            abort(404);
        }

        return view('articles.articles', ['article' => $article]);
    }

    public function showAdmin()
    {
        $articles = DB::table('articles')->orderBy('created_at', 'desc')->get();
        $carouselImages = DB::table('blog_image')->get();
    
        return view('articles.adminblog', [
            'articles' => $articles,
            'carouselImages' => $carouselImages
        ]);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'article' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('image/image_article'), $imageName);

        Article::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'article' => $validated['article'],
            'filename' => $imageName,
        ]);

        return back()->with('success', 'Article successfully created!');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'article' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $article = Article::findOrFail($id);
        $article->title = $validated['title'];
        $article->description = $validated['description'];
        $article->article = $validated['article'];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('image/image_article'), $imageName);
            $article->filename = $imageName;
        }

        $article->save();

        return response()->json(['success' => true, 'message' => 'Article updated successfully!']);
    }
    
    public function destroy($id) {
        Article::findOrFail($id)->delete();
        return redirect()->route('articles.destroy')->with('success', 'Article deleted successfully');
    }

}







