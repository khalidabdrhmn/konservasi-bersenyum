@extends('layouts.frontend')

@section('title', 'Berita | Konservasi Bersenyum')
@section('meta_description', 'Berita dan artikel terbaru dari Konservasi Bersenyum.')

@section('content')
<section class="content-section">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title">Berita & Artikel</h1>
            <p class="text-secondary mb-0">Kabar dan cerita terbaru dari kegiatan kami.</p>
        </div>
        <div class="row g-4">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <article class="program-card p-0">
                        @if ($post->image)
                            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" loading="lazy">
                        @endif
                        <div class="p-4">
                            <small class="text-secondary">{{ $post->published_at->translatedFormat('d F Y') }}</small>
                            <h2 class="h5 mt-2">{{ $post->title }}</h2>
                            <p class="text-secondary">{{ $post->excerpt }}</p>
                            <a class="btn btn-primary-custom" href="{{ route('frontend.posts.show', $post->slug) }}">Baca selengkapnya</a>
                        </div>
                    </article>
                </div>
            @empty
                <p class="text-center text-secondary">Belum ada berita yang dipublikasikan.</p>
            @endforelse
        </div>
        <div class="mt-5 d-flex justify-content-center">{{ $posts->links() }}</div>
    </div>
</section>
@endsection
