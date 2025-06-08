@extends('base.baseadmin')
@section('content')
<link rel="icon" href="{{ asset('image/logg.png') }}" type="image/png">
<div class="ki"></div>
<a href="{{ route('showadmin') }}" class="back-to-collection" title="Kembali ke koleksi">
  <i data-feather="corner-down-left"></i>
</a>

<main style="max-width: 800px; margin: auto; padding: 20px;">
    <h1>{{ $article->title }}</h1>
    <img src="{{ asset('image/image_article/' . $article->filename) }}" alt="{{ $article->title }}" style="width: 100%; border-radius: 8px; margin-bottom: 20px;">
    <h4>{{ $article->description }}</h4>
    <p>{{ $article->article }}</p>

    
</main>

<style>
    .ki{
        margin-top:100px;
    }
    .back-to-collection {
    position: fixed;
    top: 100px;
    right: 20px;
    background: #fff;
    border-radius: 50%;
    padding: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: inherit;
}
.back-to-collection:hover {
    background: #f0f0f0;
}
</style>
@endsection

