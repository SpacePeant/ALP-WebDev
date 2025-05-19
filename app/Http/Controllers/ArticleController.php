<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

}
