@extends('layouts.app')

@section('title', 'Roam — Find Your Next Dream Destination')

@section('extra-css')
<style>
/* ── Hero ──────────────────────────────────────────────────── */
#hero {
    position: relative; min-height: 100vh;
    display: flex; align-items: center; overflow: hidden;
}
.hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1800&q=85&fit=crop') center/cover no-repeat;
    transform: scale(1.04); transition: transform 8s ease;
}
.hero-bg.loaded { transform: scale(1); }
.hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(11,28,46,.72) 0%, rgba(11,28,46,.38) 55%, rgba(11,28,46,.2) 100%);
}
.hero-content { position: relative; z-index: 2; padding-top: 100px; }

.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.25); border-radius: var(--radius-full);
    padding: 6px 16px; font-size: 11px; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase;
    color: rgba(255,255,255,.9); margin-bottom: 24px;
}
.hero-badge-dot {
    width: 7px; height: 7px; background: var(--coral); border-radius: 50%;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .5; transform: scale(1.4); }
}
.hero-title {
    font-family: var(--font-display);
    font-size: clamp(2.6rem, 5.5vw, 5rem);
    font-weight: 700; color: white; line-height: 1.08;
    letter-spacing: -.02em; margin-bottom: 20px;
}
.hero-title em { font-style: italic; color: var(--sky); }
.hero-subtitle {
    font-size: 1.1rem; color: rgba(255,255,255,.72);
    line-height: 1.75; font-weight: 300; max-width: 500px;
    margin-bottom: 40px;
}
.hero-search {
    display: flex; align-items: center;
    background: white; border-radius: var(--radius-full);
    padding: 8px 8px 8px 24px; gap: 10px;
    box-shadow: 0 24px 60px rgba(11,28,46,.22);
    max-width: 560px; margin-bottom: 48px;
}
.hero-search input {
    flex: 1; border: none; outline: none;
    font-family: var(--font-body); font-size: .95rem;
    color: var(--gray-800); background: transparent;
}
.hero-search input::placeholder { color: var(--gray-400); }
.hero-stat-value {
    font-family: var(--font-display);
    font-size: 1.75rem; font-weight: 700; color: white;
    display: block; line-height: 1; margin-bottom: 4px;
}
.hero-stat-label { font-size: .78rem; color: rgba(255,255,255,.55); letter-spacing: .02em; }
.hero-stat-sep {
    width: 1px; height: 36px;
    background: rgba(255,255,255,.2); margin: 0 4px;
}
.scroll-hint {
    position: absolute; bottom: 36px; left: 50%; transform: translateX(-50%);
    z-index: 2; display: flex; flex-direction: column; align-items: center; gap: 7px;
    color: rgba(255,255,255,.45); font-size: 10px; letter-spacing: .1em; text-transform: uppercase;
    animation: bounce 2.2s ease-in-out infinite;
}
@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50%       { transform: translateX(-50%) translateY(8px); }
}

/* ── Destinations Section ────────────────────────────────── */
#destinations { padding: 110px 0; background: var(--cream); }

/* ── Category Section ────────────────────────────────────── */
#categories { padding: 80px 0 100px; background: white; }
.cat-card {
    display: flex; flex-direction: column; align-items: center;
    gap: 14px; padding: 28px 20px; border-radius: var(--radius-lg);
    background: var(--gray-100); cursor: pointer;
    transition: var(--transition); text-decoration: none; color: inherit;
    border: 1.5px solid transparent;
}
.cat-card:hover {
    background: var(--navy); border-color: var(--navy);
    transform: translateY(-6px); box-shadow: var(--shadow-lg);
}
.cat-icon {
    width: 56px; height: 56px; border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; transition: var(--transition);
}
.cat-card:hover .cat-icon { background: rgba(255,255,255,.12) !important; }
.cat-card:hover .cat-name { color: white; }
.cat-card:hover .cat-count { color: rgba(255,255,255,.5); }
.cat-name {
    font-size: .9rem; font-weight: 600; color: var(--navy);
    transition: var(--transition);
}
.cat-count {
    font-size: .78rem; color: var(--gray-400);
    transition: var(--transition);
}

/* ── Why Us ──────────────────────────────────────────────── */
#why-us { padding: 100px 0; background: var(--cream); }
.value-card {
    padding: 36px 28px; border-radius: var(--radius-lg);
    background: white; box-shadow: var(--shadow-sm);
    transition: var(--transition); height: 100%;
    border-left: 3px solid transparent;
}
.value-card:hover {
    transform: translateY(-6px); box-shadow: var(--shadow-md);
    border-left-color: var(--teal);
}
.value-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--sky-pale);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: var(--teal); margin-bottom: 20px;
}

/* ── Featured Banner ─────────────────────────────────────── */
#featured { padding: 0 0 110px; background: var(--cream); }
.featured-wrapper {
    border-radius: var(--radius-xl); overflow: hidden;
    box-shadow: var(--shadow-lg); display: flex; min-height: 480px;
}
.featured-img {
    width: 55%; position: relative; overflow: hidden; flex-shrink: 0;
}
.featured-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .8s ease;
}
.featured-wrapper:hover .featured-img img { transform: scale(1.04); }
.featured-body {
    flex: 1; background: var(--navy); padding: 56px 52px;
    display: flex; flex-direction: column; justify-content: center;
}
.featured-chip {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,.1); border-radius: var(--radius-full);
    padding: 5px 14px; font-size: 11px; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase; color: var(--sky);
    margin-bottom: 20px; width: fit-content;
}
.featured-title {
    font-family: var(--font-display); font-size: clamp(2rem, 3vw, 2.8rem);
    font-weight: 700; color: white; line-height: 1.15; margin-bottom: 16px;
}
.featured-meta span {
    font-size: .83rem; color: rgba(255,255,255,.5);
    padding-right: 16px; margin-right: 12px;
    border-right: 1px solid rgba(255,255,255,.15);
}
.featured-meta span:last-child { border: none; }
.featured-desc {
    font-size: .95rem; color: rgba(255,255,255,.65);
    line-height: 1.75; margin: 20px 0 28px;
}
.featured-tag {
    display: inline-block; background: rgba(255,255,255,.08);
    border-radius: var(--radius-full);
    padding: 4px 12px; font-size: .78rem;
    color: rgba(255,255,255,.55); margin: 3px;
}

/* ── Travel Guide ────────────────────────────────────────── */
#travel-guide { padding: 0 0 110px; background: var(--cream); }
.guide-card {
    background: white; border-radius: var(--radius-lg);
    overflow: hidden; box-shadow: var(--shadow-sm);
    transition: var(--transition); height: 100%;
}
.guide-card:hover {
    transform: translateY(-6px); box-shadow: var(--shadow-lg);
}
.guide-img { height: 200px; overflow: hidden; position: relative; }
.guide-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
.guide-card:hover .guide-img img { transform: scale(1.07); }
.guide-cat {
    position: absolute; top: 14px; left: 14px;
    background: var(--coral); color: white;
    padding: 4px 12px; border-radius: var(--radius-full);
    font-size: 11px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase;
}
.guide-body { padding: 22px; }
.guide-meta { font-size: .78rem; color: var(--gray-400); margin-bottom: 10px; }
.guide-title {
    font-family: var(--font-display); font-size: 1.1rem; font-weight: 700;
    color: var(--navy); margin-bottom: 10px; line-height: 1.3;
}
.guide-excerpt { font-size: .875rem; color: var(--gray-600); line-height: 1.65; }
.guide-link {
    font-size: .83rem; font-weight: 600; color: var(--teal);
    text-decoration: none; transition: var(--transition);
    display: inline-flex; align-items: center; gap: 5px;
}
.guide-link:hover { color: var(--teal-light); gap: 8px; }

/* ── Testimonials ────────────────────────────────────────── */
#testimonials { padding: 100px 0; background: white; }
.testi-card {
    background: var(--gray-100); border-radius: var(--radius-lg);
    padding: 32px; height: 100%; transition: var(--transition);
}
.testi-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
.testi-avatar {
    width: 48px; height: 48px; border-radius: 50%; object-fit: cover;
    border: 2px solid white; box-shadow: var(--shadow-sm);
}
.testi-quote {
    font-size: .95rem; color: var(--gray-700); line-height: 1.75;
    font-style: italic; margin: 16px 0;
}
.testi-name { font-weight: 600; color: var(--navy); font-size: .9rem; }
.testi-country { font-size: .78rem; color: var(--gray-400); }

/* ── Newsletter ──────────────────────────────────────────── */
#newsletter { padding: 80px 0; background: var(--navy); }
.nl-title {
    font-family: var(--font-display); font-size: clamp(2rem, 3.5vw, 2.8rem);
    font-weight: 700; color: white; margin-bottom: 14px;
}
.nl-input {
    background: rgba(255,255,255,.1); border: 1.5px solid rgba(255,255,255,.2);
    color: white; border-radius: var(--radius-full);
    padding: 14px 24px; font-size: .95rem; width: 100%; outline: none;
    transition: border var(--transition);
}
.nl-input::placeholder { color: rgba(255,255,255,.4); }
.nl-input:focus { border-color: var(--sky); background: rgba(255,255,255,.15); }

/* ── Destination card skeleton ───────────────────────────── */
.skeleton {
    background: linear-gradient(90deg, #f0f0ee 25%, #e8e8e4 50%, #f0f0ee 75%);
    background-size: 200% 100%; animation: shimmer 1.4s infinite;
    border-radius: var(--radius-md);
}
@keyframes shimmer { to { background-position: -200% 0; } }
</style>
@endsection

@section('content')

<!-- ================================================================
     HERO SECTION
================================================================ -->
<section id="hero">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 col-xl-7">

                <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    Explore 500+ Destinations Worldwide
                </div>

                <h1 class="hero-title">
                    Find Your Next<br>
                    <em>Dream Destination</em>
                </h1>

                <p class="hero-subtitle">
                    Curated travel experiences for the modern explorer. Discover breathtaking places, plan unforgettable journeys, and turn wanderlust into reality.
                </p>

                <!-- Search Bar -->
                <form class="hero-search" id="heroSearchForm">
                    <i class="fas fa-search" style="color: var(--gray-400); font-size: 15px; flex-shrink: 0;"></i>
                    <input type="text" id="heroSearchInput" placeholder="Search destinations, cities, countries..." autocomplete="off">
                    <button type="submit" class="btn-teal" style="padding: 12px 24px; flex-shrink: 0;">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </form>

                <!-- Hero Stats -->
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        <span class="hero-stat-value">{{ number_format($stats['destinations']) }}+</span>
                        <span class="hero-stat-label">Destinations</span>
                    </div>
                    <div class="hero-stat-sep"></div>
                    <div>
                        <span class="hero-stat-value">{{ number_format($stats['cities']) }}+</span>
                        <span class="hero-stat-label">Cities</span>
                    </div>
                    <div class="hero-stat-sep"></div>
                    <div>
                        <span class="hero-stat-value">50k+</span>
                        <span class="hero-stat-label">Happy Travelers</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="scroll-hint">
        <span>Scroll</span>
        <i class="fas fa-chevron-down" style="font-size: 10px;"></i>
    </div>
</section>


<!-- ================================================================
     POPULAR DESTINATIONS
================================================================ -->
<section id="destinations">
    <div class="container">

        <!-- Header -->
        <div class="row align-items-end mb-5 reveal">
            <div class="col-md-7">
                <div class="section-label">Popular Destinations</div>
                <h2 class="section-title">Handpicked for<br>Your Next Adventure</h2>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <p class="section-subtitle" style="max-width: 300px; margin-left: auto;">
                    From sun-kissed beaches to towering mountain peaks — your perfect trip starts here.
                </p>
            </div>
        </div>

        <!-- Filter Pills -->
        <div class="d-flex gap-2 flex-wrap mb-5 reveal reveal-delay-1" id="destFilters">
            <button class="filter-pill active" data-cat="All">All</button>
            <button class="filter-pill" data-cat="Beach"><i class="fas fa-umbrella-beach me-1"></i>Beach</button>
            <button class="filter-pill" data-cat="Mountain"><i class="fas fa-mountain me-1"></i>Mountain</button>
            <button class="filter-pill" data-cat="City"><i class="fas fa-city me-1"></i>City</button>
            <button class="filter-pill" data-cat="Nature"><i class="fas fa-leaf me-1"></i>Nature</button>
            <button class="filter-pill" data-cat="Cultural"><i class="fas fa-landmark me-1"></i>Cultural</button>
            <button class="filter-pill" data-cat="Adventure"><i class="fas fa-person-hiking me-1"></i>Adventure</button>
        </div>

        <!-- Destination Cards Grid -->
        <div class="row g-4" id="destGrid">
            @foreach ($popularDestinations as $i => $dest)
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: {{ $i * 0.07 }}s;" data-dest-id="{{ $dest->id }}">
                @include('partials.dest-card', ['dest' => $dest])
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5 reveal">
            <a href="{{ route('destinations.index') }}" class="btn-outline-navy btn">
                View All Destinations <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>


<!-- ================================================================
     EXPLORE BY CATEGORY
================================================================ -->
<section id="categories">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-label mx-auto" style="justify-content: center;">Browse by Category</div>
            <h2 class="section-title">What Kind of Traveler<br>Are You?</h2>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach ($categories as $i => $cat)
            <div class="col-6 col-sm-4 col-lg-2 reveal" style="transition-delay: {{ $i * 0.07 }}s;">
                <a href="{{ route('destinations.index', ['category' => $cat['name']]) }}" class="cat-card text-decoration-none">
                    <div class="cat-icon" style="background: {{ $cat['color'] }}1a; color: {{ $cat['color'] }};">
                        <i class="fas {{ $cat['icon'] }}"></i>
                    </div>
                    <span class="cat-name">{{ $cat['name'] }}</span>
                    <span class="cat-count">{{ $cat['count'] }} places</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ================================================================
     WHY CHOOSE US
================================================================ -->
<section id="why-us">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-label mx-auto" style="justify-content: center;">Why Roam</div>
            <h2 class="section-title">Your Perfect Travel<br>Companion</h2>
        </div>
        <div class="row g-4">
            @php
            $values = [
                ['icon' => 'fa-map-marked-alt', 'title' => 'Curated Destinations',    'desc' => 'Every destination is handpicked and verified by our team of expert travelers. No generic lists — only the best.'],
                ['icon' => 'fa-route',          'title' => 'Easy Trip Planning',       'desc' => 'Intuitive tools to plan your perfect itinerary in minutes. From flights to hidden gems, we\'ve got you covered.'],
                ['icon' => 'fa-lightbulb',      'title' => 'Rich Travel Inspiration',  'desc' => 'Discover stunning photography, insider tips, and travel stories that spark your next adventure.'],
                ['icon' => 'fa-shield-alt',     'title' => 'Trusted Recommendations',  'desc' => 'Backed by thousands of verified traveler reviews, you can explore with complete confidence.'],
            ];
            @endphp
            @foreach ($values as $i => $val)
            <div class="col-sm-6 col-lg-3 reveal" style="transition-delay: {{ $i * 0.1 }}s;">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas {{ $val['icon'] }}"></i>
                    </div>
                    <h5 class="font-display fw-bold mb-2" style="color: var(--navy); font-size: 1.05rem;">{{ $val['title'] }}</h5>
                    <p class="section-subtitle" style="font-size: .875rem;">{{ $val['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ================================================================
     FEATURED DESTINATION BANNER
================================================================ -->
@if ($featuredDestination)
<section id="featured">
    <div class="container">
        <div class="featured-wrapper reveal">
            <div class="featured-img">
                <img src="{{ $featuredDestination->image }}" alt="{{ $featuredDestination->name }}" loading="lazy">
            </div>
            <div class="featured-body">
                <div class="featured-chip">
                    <i class="fas fa-star" style="color: #FBBF24; font-size: 11px;"></i>
                    Editor's Choice
                </div>
                <h2 class="featured-title">{{ $featuredDestination->name }}</h2>
                <div class="featured-meta mb-2">
                    <span><i class="fas fa-map-marker-alt me-1" style="color: var(--coral);"></i>{{ $featuredDestination->city }}, {{ $featuredDestination->country }}</span>
                    <span><i class="fas fa-star me-1" style="color: #FBBF24;"></i>{{ $featuredDestination->rating }} ({{ number_format($featuredDestination->reviews_count) }} reviews)</span>
                    <span><i class="fas fa-clock me-1" style="color: var(--sky);"></i>{{ $featuredDestination->best_time }}</span>
                </div>
                <p class="featured-desc">{{ $featuredDestination->short_description }}</p>

                @if ($featuredDestination->highlights)
                <div class="mb-4">
                    @foreach (array_slice($featuredDestination->highlights, 0, 3) as $hl)
                    <span class="featured-tag"><i class="fas fa-check me-1" style="color: var(--teal); font-size: 10px;"></i>{{ $hl }}</span>
                    @endforeach
                </div>
                @endif

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('destinations.show', $featuredDestination->slug) }}" class="btn-coral btn">
                        <i class="fas fa-compass me-2"></i>Explore Destination
                    </a>
                    <a href="{{ route('destinations.show', $featuredDestination->slug) }}" class="btn" style="color: rgba(255,255,255,.6); font-size:.875rem; padding: 12px 0; text-decoration: none;">
                        Plan This Trip <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif


<!-- ================================================================
     TRAVEL GUIDE / INSPIRATION
================================================================ -->
<section id="travel-guide">
    <div class="container">
        <div class="row align-items-end mb-5 reveal">
            <div class="col-md-7">
                <div class="section-label">Travel Guide</div>
                <h2 class="section-title">Stories & Tips for<br>Smart Travelers</h2>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="#" class="btn-outline-navy btn" style="font-size: .875rem;">
                    View All Articles <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        <div class="row g-4">
            @foreach ($travelGuides as $i => $guide)
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: {{ $i * 0.1 }}s;">
                <div class="guide-card">
                    <div class="guide-img">
                        <img src="{{ $guide['image'] }}" alt="{{ $guide['title'] }}" loading="lazy">
                        <span class="guide-cat">{{ $guide['category'] }}</span>
                    </div>
                    <div class="guide-body">
                        <div class="guide-meta">
                            <i class="far fa-clock me-1"></i>{{ $guide['read_time'] }}
                            <span class="mx-2">·</span>
                            <i class="far fa-calendar me-1"></i>{{ $guide['date'] }}
                        </div>
                        <h4 class="guide-title">{{ $guide['title'] }}</h4>
                        <p class="guide-excerpt mb-3">{{ $guide['excerpt'] }}</p>
                        <a href="#" class="guide-link">
                            Read Article <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ================================================================
     TESTIMONIALS
================================================================ -->
<section id="testimonials">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-label mx-auto" style="justify-content: center;">Travelers Love Roam</div>
            <h2 class="section-title">Real Stories from<br>Real Explorers</h2>
        </div>
        <div class="row g-4">
            @foreach ($testimonials as $i => $t)
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: {{ $i * 0.12 }}s;">
                <div class="testi-card">
                    <div class="d-flex gap-1 mb-3">
                        @for ($s = 0; $s < $t['rating']; $s++)
                        <i class="fas fa-star text-warning" style="font-size: 13px;"></i>
                        @endfor
                    </div>
                    <p class="testi-quote">"{{ $t['text'] }}"</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ $t['avatar'] }}" alt="{{ $t['name'] }}" class="testi-avatar" loading="lazy">
                        <div>
                            <div class="testi-name">{{ $t['name'] }}</div>
                            <div class="testi-country">{{ $t['country'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ================================================================
     NEWSLETTER CTA
================================================================ -->
<section id="newsletter">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-7 reveal">
                <div class="section-label mx-auto" style="justify-content: center; color: var(--sky);">
                    Stay Inspired
                </div>
                <h2 class="nl-title mb-3">Never Miss a Hidden Gem</h2>
                <p style="color: rgba(255,255,255,.55); font-size: 1rem; margin-bottom: 36px; line-height: 1.75;">
                    Join 50,000+ travelers who get weekly destination guides, travel tips, and exclusive deals delivered straight to their inbox.
                </p>
                <form id="nlForm" class="d-flex gap-3 justify-content-center" style="max-width: 480px; margin: 0 auto;">
                    @csrf
                    <input type="email" name="email" id="nlEmail" class="nl-input" placeholder="Enter your email address" required>
                    <button type="submit" class="btn-coral btn flex-shrink-0" id="nlSubmit">
                        <span id="nlBtnText">Subscribe</span>
                        <span id="nlBtnSpinner" class="d-none">
                            <span class="spinner-border spinner-border-sm"></span>
                        </span>
                    </button>
                </form>
                <p style="color: rgba(255,255,255,.3); font-size: .78rem; margin-top: 14px;">
                    <i class="fas fa-lock me-1" style="color: var(--teal);"></i>No spam ever. Unsubscribe with one click.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection

@section('extra-js')
<script>
/* ============================================================
   HERO — parallax bg load
============================================================ */
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        document.getElementById('heroBg').classList.add('loaded');
    }, 100);

    // Re-trigger reveal observer after DOM ready
    document.querySelectorAll('.reveal').forEach(function (el) {
        observer.observe(el);
    });
});

/* ============================================================
   HERO SEARCH → redirect to destinations
============================================================ */
$('#heroSearchForm').on('submit', function (e) {
    e.preventDefault();
    const q = $('#heroSearchInput').val().trim();
    if (q) {
        window.location.href = '{{ route("destinations.index") }}?q=' + encodeURIComponent(q);
    }
});

/* ============================================================
   DESTINATION FILTER — AJAX
============================================================ */
$('#destFilters').on('click', '.filter-pill', function () {
    const $btn = $(this);
    const cat  = $btn.data('cat');

    // Active state
    $('.filter-pill').removeClass('active');
    $btn.addClass('active');

    // Show loading skeletons
    let skeletons = '';
    for (let i = 0; i < 6; i++) {
        skeletons += `
            <div class="col-md-6 col-lg-4">
                <div style="border-radius: var(--radius-lg); overflow: hidden;">
                    <div class="skeleton" style="height: 220px; border-radius: var(--radius-lg) var(--radius-lg) 0 0;"></div>
                    <div style="background: white; padding: 20px 22px 22px; border-radius: 0 0 var(--radius-lg) var(--radius-lg);">
                        <div class="skeleton mb-2" style="height: 12px; width: 60%;"></div>
                        <div class="skeleton mb-3" style="height: 20px; width: 80%;"></div>
                        <div class="skeleton mb-1" style="height: 10px; width: 100%;"></div>
                        <div class="skeleton"       style="height: 10px; width: 75%;"></div>
                    </div>
                </div>
            </div>`;
    }
    $('#destGrid').html(skeletons);

    $.get('{{ route("api.destinations.filter") }}', { category: cat, limit: 6 })
        .done(function (res) {
            if (!res.destinations || res.destinations.length === 0) {
                $('#destGrid').html(
                    '<div class="col-12 text-center py-5"><p class="section-subtitle">No destinations found in this category yet.</p></div>'
                );
                return;
            }

            let html = '';
            res.destinations.forEach(function (d, i) {
                html += `
                <div class="col-md-6 col-lg-4 reveal visible" data-dest-id="${d.id}">
                    <div class="dest-card">
                        <div class="dest-card-img">
                            <img src="${d.image}" alt="${d.name}" loading="lazy">
                            <span class="dest-card-badge badge-${d.category}">${d.category}</span>
                            <button class="dest-card-save" data-id="${d.id}">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <div class="dest-card-body">
                            <div class="dest-card-location">
                                <i class="fas fa-map-marker-alt me-1" style="color: var(--coral);"></i>
                                ${d.city}, ${d.country}
                            </div>
                            <div class="dest-card-name">${d.name}</div>
                            <p class="dest-card-desc">${d.short_description}</p>
                            <div class="dest-card-footer">
                                <div class="dest-card-rating">
                                    ${d.stars_html}
                                    <span class="ms-1"><strong>${d.rating}</strong> (${d.reviews_count})</span>
                                </div>
                                <a href="${d.url}" class="btn-view">Details</a>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
            $('#destGrid').html(html);
        })
        .fail(function () {
            showToast('Failed to load destinations. Please try again.', 'danger');
        });
});

/* ============================================================
   NEWSLETTER FORM — AJAX
============================================================ */
$('#nlForm').on('submit', function (e) {
    e.preventDefault();
    const email = $('#nlEmail').val().trim();
    if (!email) return;

    $('#nlBtnText').addClass('d-none');
    $('#nlBtnSpinner').removeClass('d-none');
    $('#nlSubmit').prop('disabled', true);

    $.post('{{ route("newsletter.subscribe") }}', { email })
        .done(function (res) {
            showToast(res.message, res.success ? 'success' : 'danger');
            if (res.success) $('#nlEmail').val('');
        })
        .fail(function (xhr) {
            const msg = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
            showToast(msg, 'danger');
        })
        .always(function () {
            $('#nlBtnText').removeClass('d-none');
            $('#nlBtnSpinner').addClass('d-none');
            $('#nlSubmit').prop('disabled', false);
        });
});
</script>
@endsection
