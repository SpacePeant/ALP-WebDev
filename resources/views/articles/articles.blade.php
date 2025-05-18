 
{{-- @extends('base.base2') --}}
@section('content')
<a href="{{ route('blog') }}" class="back-button">← Back to Blog</a>

<main style="max-width: 800px; margin: auto; padding: 20px;">
    <h1>{{ $article->title }}</h1>
    <img src="{{ asset('image/image_article/' . $article->filename) }}" alt="{{ $article->title }}" style="width: 100%; border-radius: 8px; margin-bottom: 20px;">
    <h4>{{ $article->description }}</h4>
    <p>{{ $article->article }}</p>
</main>
@endsection
@extends('articles.layout')

