@extends('layouts.frontend')

@section('title', $post->title.' | Konservasi Bersenyum')
@section('meta_description', $post->excerpt ?: $post->title)

@section('content')
<article class="content-section">
    <div class="container" style="max-width: 850px;">
        <a href="{{ route('frontend.posts') }}" class="text-decoration-none">&larr; Kembali ke berita</a>
        <p class="text-secondary mt-4 mb-2">{{ $post->published_at->translatedFormat('d F Y') }}</p>
        <h1 class="section-title mb-4">{{ $post->title }}</h1>
        @if ($post->image)
            <img class="img-fluid rounded-4 mb-4" src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}">
        @endif
        <div class="lh-lg">{!! nl2br(e(strip_tags($post->content))) !!}</div>
    </div>
</article>
@endsection
