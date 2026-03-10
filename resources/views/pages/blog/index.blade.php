@extends('layouts.app')

@section('title', 'Travel Blog — Roam')
@section('meta_description', 'Tips, guides, and inspiration for modern travelers. Real stories from real adventures.')

@section('extra-css')
<style>
.page-hero {
    background: var(--navy);
    padding: 170px 0 90px;
    position: relative; overflow: hidden;
}
.page-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1501554728187-ce583db33af7?w=1600&q=80') center/cover;
    opacity: .12;
}
.page-hero::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(11,28,46,.7) 0%, rgba(11,28,46,.2) 100%);
}
.page-hero-content { position: relative; z-index: 2; }
.page-hero h1 {
    font-family: var(--font-display);
    font-size: clamp(2.4rem, 4.5vw, 4rem);
    font-weight: 700; color: white;
    letter-spacing: -.02em; margin-bottom: 14px;
}
.page-hero p { color: rgba(255,255,255,.65); font-size: 1.05rem; }

.blog-card {
    background: white; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm); overflow: hidden;
    transition: var(--transition); text-decoration: none; color: inherit;
    display: flex; flex-direction: column; height: 100%;
}
.blog-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); color: inherit; }
.blog-card-img { height: 220px; overflow: hidden; position: relative; }
.blog-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
.blog-card:hover .blog-card-img img { transform: scale(1.07); }
.blog-card-cat {
    position: absolute; top: 14px; left: 14px;
    background: var(--teal); color: white;
    padding: 4px 12px; border-radius: var(--radius-full);
    font-size: 11px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase;
}
.blog-card-body { padding: 22px 24px 24px; flex: 1; display: flex; flex-direction: column; }
.blog-card-meta { font-size: .78rem; color: var(--gray-400); margin-bottom: 8px; }
.blog-card-title {
    font-family: var(--font-display); font-weight: 700;
    font-size: 1.15rem; color: var(--navy); line-height: 1.3;
    margin-bottom: 10px;
}
.blog-card-excerpt { font-size: .875rem; color: var(--gray-600); line-height: 1.65; flex: 1; }
.blog-card-footer {
    display: flex; align-items: center; justify-content: space-between;
    margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--gray-100);
}
.blog-card-author { font-size: .8rem; color: var(--gray-600); font-weight: 500; }
.blog-read-more { font-size: .8rem; color: var(--teal); font-weight: 600; }
</style>
@endsection

@section('content')

<!-- Hero -->
<div class="page-hero">
    <div class="container page-hero-content">
        <p class="section-label" style="color: var(--sky);">{!! \App\Models\PageContent::get('blog','hero_badge','Stories & Tips') !!}</p>
        <h1>{!! \App\Models\PageContent::get('blog','hero_title','Travel Blog') !!}</h1>
        <p>{!! \App\Models\PageContent::get('blog','hero_subtitle','Real experiences, expert tips, and inspiring stories to fuel your wanderlust.') !!}</p>
    </div>
</div>

<!-- Filters + Grid -->
<section style="padding: 70px 0 100px; background: var(--cream);">
    <div class="container">

        <!-- Category Filter Pills -->
        <div class="d-flex gap-2 flex-wrap mb-5 reveal">
            <a href="{{ route('blog.index') }}"
               class="filter-pill {{ !$category ? 'active' : '' }}">All</a>
            @foreach($categories as $cat)
            <a href="{{ route('blog.index', ['category' => $cat]) }}"
               class="filter-pill {{ $category === $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>

        @if($blogs->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-pen-nib" style="font-size: 3rem; color: var(--gray-200); display: block; margin-bottom: 16px;"></i>
                <h5 class="font-display" style="color: var(--navy);">No posts yet</h5>
                <p class="section-subtitle">Check back soon for fresh travel stories.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($blogs as $i => $blog)
                <div class="col-sm-6 col-lg-4 reveal" style="transition-delay: {{ ($i % 9) * 0.07 }}s;">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card">
                        <div class="blog-card-img">
                            @if($blog->cover_image)
                                <img src="{{ $blog->cover_image }}" alt="{{ $blog->title }}" loading="lazy">
                            @else
                                <img src="https://images.unsplash.com/photo-1501554728187-ce583db33af7?w=600&q=70" alt="Blog" loading="lazy">
                            @endif
                            <span class="blog-card-cat">{{ $blog->category }}</span>
                        </div>
                        <div class="blog-card-body">
                            <div class="blog-card-meta">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $blog->published_at?->format('M d, Y') }}
                                &nbsp;·&nbsp;
                                <i class="fas fa-clock me-1"></i>{{ $blog->read_time }}
                            </div>
                            <div class="blog-card-title">{{ $blog->title }}</div>
                            <div class="blog-card-excerpt">{{ Str::limit($blog->excerpt, 120) }}</div>
                            <div class="blog-card-footer">
                                <span class="blog-card-author"><i class="fas fa-user-circle me-1"></i>{{ $blog->author }}</span>
                                <span class="blog-read-more">Read more <i class="fas fa-arrow-right ms-1" style="font-size: 10px;"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            @if($blogs->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $blogs->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @endif
    </div>
</section>

@endsection
