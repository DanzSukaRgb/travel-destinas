@extends('layouts.app')

@section('title', $blog->title . ' — Roam Blog')
@section('meta_description', $blog->excerpt)

@section('extra-css')
<style>
.blog-hero {
    position: relative;
    height: 70vh; min-height: 500px;
    display: flex; align-items: flex-end; overflow: hidden;
    padding-top: 80px;
}
.blog-hero-img { position: absolute; inset: 0; }
.blog-hero-img img { width: 100%; height: 100%; object-fit: cover; }
.blog-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(11,28,46,.92) 0%, rgba(11,28,46,.4) 50%, rgba(11,28,46,.1) 100%);
}
.blog-hero-content { position: relative; z-index: 2; padding-bottom: 52px; width: 100%; }
.blog-category-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--teal); color: white;
    padding: 5px 14px; border-radius: var(--radius-full);
    font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
    margin-bottom: 14px;
}
.blog-hero-title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4.5vw, 3.4rem);
    font-weight: 700; color: white; line-height: 1.15;
    margin-bottom: 14px; letter-spacing: -.02em;
}
.blog-hero-meta span {
    color: rgba(255,255,255,.65); font-size: .875rem;
    padding-right: 16px; margin-right: 12px;
    border-right: 1px solid rgba(255,255,255,.2);
}
.blog-hero-meta span:last-child { border: none; }

.blog-body { padding: 60px 0 100px; background: var(--cream); }

/* Prose styles for blog content */
.blog-prose {
    font-size: 1.05rem; color: var(--gray-700);
    line-height: 1.9; font-weight: 300;
}
.blog-prose h2 {
    font-family: var(--font-display);
    font-size: 1.7rem; font-weight: 700;
    color: var(--navy); margin: 36px 0 16px;
    padding-bottom: 12px; border-bottom: 2px solid var(--gray-100);
}
.blog-prose h3 {
    font-family: var(--font-display);
    font-size: 1.3rem; font-weight: 700;
    color: var(--navy); margin: 28px 0 12px;
}
.blog-prose p { margin-bottom: 20px; }
.blog-prose ul, .blog-prose ol {
    padding-left: 24px; margin-bottom: 20px;
}
.blog-prose li { margin-bottom: 8px; }
.blog-prose blockquote {
    border-left: 4px solid var(--teal);
    padding: 16px 24px; margin: 28px 0;
    background: var(--sky-pale);
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
    font-style: italic; color: var(--navy);
}
.blog-prose img {
    width: 100%; border-radius: var(--radius-md);
    margin: 24px 0; box-shadow: var(--shadow-md);
}

.blog-sidebar-card {
    background: white; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm); padding: 24px; margin-bottom: 20px;
}
.blog-sidebar-card h5 {
    font-family: var(--font-display); font-weight: 700;
    color: var(--navy); font-size: .95rem;
    margin-bottom: 16px; padding-bottom: 12px;
    border-bottom: 1px solid var(--gray-100);
}

.related-blog-card {
    display: flex; gap: 14px; align-items: flex-start;
    padding: 12px 0; border-bottom: 1px solid var(--gray-100);
    text-decoration: none; color: inherit; transition: var(--transition);
}
.related-blog-card:last-child { border: none; padding-bottom: 0; }
.related-blog-card:hover { transform: translateX(4px); }
.related-blog-thumb {
    width: 64px; height: 64px; border-radius: var(--radius-sm);
    overflow: hidden; flex-shrink: 0;
}
.related-blog-thumb img { width: 100%; height: 100%; object-fit: cover; }
.related-blog-title { font-family: var(--font-display); font-size: .9rem; font-weight: 700; color: var(--navy); line-height: 1.3; margin-bottom: 4px; }
.related-blog-meta { font-size: .75rem; color: var(--gray-400); }
</style>
@endsection

@section('content')

<!-- Hero -->
<div class="blog-hero">
    <div class="blog-hero-img">
        <img src="{{ $blog->cover_image ?: 'https://images.unsplash.com/photo-1501554728187-ce583db33af7?w=1600&q=80' }}" alt="{{ $blog->title }}">
    </div>
    <div class="blog-hero-overlay"></div>
    <div class="container blog-hero-content">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size: .8rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: rgba(255,255,255,.55);">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" style="color: rgba(255,255,255,.55);">Blog</a></li>
                <li class="breadcrumb-item active" style="color: rgba(255,255,255,.8);">{{ Str::limit($blog->title, 40) }}</li>
            </ol>
        </nav>
        <span class="blog-category-chip">{{ $blog->category }}</span>
        <h1 class="blog-hero-title">{{ $blog->title }}</h1>
        <div class="blog-hero-meta d-flex flex-wrap">
            <span><i class="fas fa-user-circle me-1"></i>{{ $blog->author }}</span>
            <span><i class="fas fa-calendar-alt me-1"></i>{{ $blog->published_at?->format('M d, Y') }}</span>
            <span><i class="fas fa-clock me-1"></i>{{ $blog->read_time }}</span>
        </div>
    </div>
</div>

<!-- Blog Body -->
<div class="blog-body">
    <div class="container">
        <div class="row g-5">

            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="blog-prose">
                    {!! nl2br(e($blog->body)) !!}
                </div>

                <!-- Tags / Share -->
                <div class="mt-5 pt-4 border-top" style="border-color: var(--gray-200) !important;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <span style="font-size: .82rem; color: var(--gray-400); font-weight: 600; text-transform: uppercase; letter-spacing: .06em; margin-right: 8px;">Category</span>
                            <span style="background: var(--sky-pale); color: var(--teal); padding: 4px 12px; border-radius: var(--radius-full); font-size: .82rem; font-weight: 600;">{{ $blog->category }}</span>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <span style="font-size: .82rem; color: var(--gray-400); align-self: center;">Share:</span>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="btn" style="background: #1DA1F2; color: white; border-radius: var(--radius-full); padding: 7px 14px; font-size: .8rem;"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.facebook.com/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn" style="background: #1877F2; color: white; border-radius: var(--radius-full); padding: 7px 14px; font-size: .8rem;"><i class="fab fa-facebook-f"></i></a>
                            <button onclick="navigator.clipboard.writeText(window.location.href); showToast('Link copied!', 'success');" class="btn" style="background: var(--gray-100); color: var(--navy); border-radius: var(--radius-full); padding: 7px 14px; font-size: .8rem;"><i class="fas fa-link"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Author Box -->
                <div class="mt-4 p-4 rounded-4 d-flex gap-4 align-items-center reveal" style="background: white; box-shadow: var(--shadow-sm);">
                    <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--teal); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; font-family: var(--font-display); font-weight: 700;">
                        {{ strtoupper(substr($blog->author, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: 1rem;">{{ $blog->author }}</div>
                        <div style="font-size: .82rem; color: var(--teal); font-weight: 600; margin-bottom: 6px;">Roam Travel Writer</div>
                        <div style="font-size: .85rem; color: var(--gray-600); line-height: 1.6;">Passionate about uncovering hidden gems around the world and sharing practical tips for every type of traveler.</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div style="position: sticky; top: 100px;">

                    <!-- Newsletter -->
                    <div class="blog-sidebar-card" style="background: var(--navy);">
                        <h5 style="color: white; border-color: rgba(255,255,255,.1);">Stay Inspired</h5>
                        <p style="color: rgba(255,255,255,.55); font-size: .85rem; margin-bottom: 14px;">Weekly travel tips delivered to your inbox.</p>
                        <div class="d-flex gap-2" id="sidebarNlForm">
                            <input type="email" id="sidebarNlEmail" class="form-control rounded-pill"
                                   placeholder="your@email.com"
                                   style="background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); color: white; font-size: .85rem;">
                            <button class="btn-coral btn flex-shrink-0 px-3" id="sidebarNlBtn"><i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if($related->isNotEmpty())
                    <div class="blog-sidebar-card reveal">
                        <h5>Related Posts</h5>
                        @foreach($related as $rel)
                        <a href="{{ route('blog.show', $rel->slug) }}" class="related-blog-card">
                            <div class="related-blog-thumb">
                                <img src="{{ $rel->cover_image ?: 'https://images.unsplash.com/photo-1501554728187-ce583db33af7?w=150&q=70' }}"
                                     alt="{{ $rel->title }}" loading="lazy">
                            </div>
                            <div>
                                <div class="related-blog-title">{{ Str::limit($rel->title, 60) }}</div>
                                <div class="related-blog-meta"><i class="fas fa-clock me-1"></i>{{ $rel->read_time }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Browse Destinations CTA -->
                    <div class="blog-sidebar-card text-center reveal" style="background: var(--teal);">
                        <div style="font-size: 2.2rem; margin-bottom: 10px;">🗺️</div>
                        <h5 style="color: white; border: none; padding: 0; margin-bottom: 8px;">Inspired to travel?</h5>
                        <p style="color: rgba(255,255,255,.7); font-size: .85rem; margin-bottom: 18px;">Explore our curated destinations.</p>
                        <a href="{{ route('destinations.index') }}" class="btn d-block" style="background: white; color: var(--teal); border-radius: var(--radius-full); font-weight: 600; padding: 11px;">Browse Destinations</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('extra-js')
<script>
$('#sidebarNlBtn').on('click', function () {
    const email = $('#sidebarNlEmail').val().trim();
    if (!email) return;
    $.post('{{ route("newsletter.subscribe") }}', { email })
        .done(function (res) {
            showToast(res.message, res.success ? 'success' : 'danger');
            if (res.success) $('#sidebarNlEmail').val('');
        });
});
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection
