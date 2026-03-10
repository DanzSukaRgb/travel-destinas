@extends('layouts.app')

@section('title', $destination->name . ', ' . $destination->country . ' — Roam')
@section('meta_description', $destination->short_description)

@section('extra-css')
<style>
/* ── Detail Hero ────────────────────────────────────────── */
.detail-hero {
    position: relative;
    height: 80vh; min-height: 580px;
    display: flex; align-items: flex-end; overflow: hidden;
    padding-top: 80px;
}
.detail-hero-img {
    position: absolute; inset: 0;
}
.detail-hero-img img {
    width: 100%; height: 100%; object-fit: cover;
}
.detail-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        to top,
        rgba(11,28,46,.95) 0%,
        rgba(11,28,46,.60) 35%,
        rgba(11,28,46,.25) 65%,
        rgba(11,28,46,.10) 100%
    );
}
.detail-hero-content {
    position: relative; z-index: 2; padding-bottom: 60px; width: 100%;
}
.detail-category-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--coral); color: white;
    padding: 5px 14px; border-radius: var(--radius-full);
    font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
    margin-bottom: 14px;
}
.detail-title {
    font-family: var(--font-display);
    font-size: clamp(2.4rem, 5vw, 4rem);
    font-weight: 700; color: white; line-height: 1.1;
    margin-bottom: 16px; letter-spacing: -.02em;
}
.detail-meta span {
    color: rgba(255,255,255,.65); font-size: .875rem;
    padding-right: 18px; margin-right: 14px;
    border-right: 1px solid rgba(255,255,255,.2);
}
.detail-meta span:last-child { border: none; }

/* ── Detail Body ────────────────────────────────────────── */
.detail-body { padding: 56px 0 100px; background: var(--cream); }

/* Sticky sidebar */
.detail-sidebar { position: sticky; top: 100px; }
.detail-card {
    background: white; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md); padding: 28px; margin-bottom: 20px;
}
.detail-card h5 {
    font-family: var(--font-display); font-weight: 700;
    color: var(--navy); font-size: 1rem; margin-bottom: 16px;
    padding-bottom: 12px; border-bottom: 1px solid var(--gray-100);
}
.info-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 11px 0; border-bottom: 1px solid var(--gray-100);
    font-size: .875rem; gap: 10px;
}
.info-row:last-child { border: none; padding-bottom: 0; }
.info-row .label { color: var(--gray-500, #888884); display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
.info-row .value { color: var(--navy); font-weight: 600; text-align: right; font-size: .85rem; }

/* Gallery */
.gallery-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    gap: 10px;
}
.gallery-main { grid-column: 1 / -1; }
.gallery-item {
    border-radius: var(--radius-md); overflow: hidden; cursor: pointer;
    position: relative;
}
.gallery-item img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .5s ease;
}
.gallery-item:hover img { transform: scale(1.05); }
.gallery-main { height: 320px; }
.gallery-item:not(.gallery-main) { height: 160px; }

/* Highlights & Activities */
.highlight-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 0; border-bottom: 1px solid var(--gray-100);
    font-size: .9rem; color: var(--gray-800);
}
.highlight-item:last-child { border: none; }
.highlight-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: linear-gradient(135deg, var(--sky-pale) 0%, rgba(13,124,120,.12) 100%);
    color: var(--teal);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(13,124,120,.12);
}
.activity-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--gray-100); color: var(--navy);
    padding: 7px 16px; border-radius: var(--radius-full);
    font-size: .82rem; font-weight: 500; margin: 4px;
    transition: var(--transition); cursor: default;
    border: 1.5px solid transparent;
}
.activity-pill:hover {
    background: var(--teal); color: white;
    border-color: var(--teal);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13,124,120,.25);
}

/* Map placeholder */
.map-placeholder {
    height: 260px; background: var(--gray-100);
    border-radius: var(--radius-lg); overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    position: relative;
}
.map-placeholder img { width: 100%; height: 100%; object-fit: cover; }
.map-pin {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 40px; height: 40px; background: var(--coral);
    border-radius: 50% 50% 50% 0; transform: translate(-50%,-70%) rotate(-45deg);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 16px rgba(232,113,74,.4);
}
.map-pin i { transform: rotate(45deg); color: white; font-size: 16px; }

/* Related */
.related-card {
    background: white; border-radius: var(--radius-lg);
    overflow: hidden; box-shadow: var(--shadow-sm);
    transition: var(--transition); text-decoration: none; color: inherit;
    display: block;
}
.related-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); color: inherit; }
.related-img { height: 180px; overflow: hidden; }
.related-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
.related-card:hover .related-img img { transform: scale(1.07); }
.related-body { padding: 16px 18px 18px; }

/* ── Breadcrumb in hero ─────────────────────────────────── */
.detail-breadcrumb .breadcrumb-item a {
    color: rgba(255,255,255,.55);
    text-decoration: none;
    font-size: .8rem;
    transition: color .2s;
}
.detail-breadcrumb .breadcrumb-item a:hover { color: white; }
.detail-breadcrumb .breadcrumb-item.active {
    color: rgba(255,255,255,.85);
    font-size: .8rem;
}
.detail-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,.3);
    content: "/";
}

/* ── Hero action buttons ─────────────────────────────────── */
.dest-card-save-lg {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,.15); backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.25);
    color: white; border-radius: var(--radius-full);
    padding: 9px 20px; font-size: .85rem; font-weight: 500;
    cursor: pointer; transition: var(--transition);
}
.dest-card-save-lg:hover, .dest-card-save-lg.saved {
    background: rgba(232,113,74,.85);
    border-color: rgba(232,113,74,.9);
}
.dest-card-save-lg.saved i { font-weight: 900; }
.detail-back-btn {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,.12); backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.2);
    color: rgba(255,255,255,.75); border-radius: var(--radius-full);
    padding: 9px 20px; font-size: .85rem; font-weight: 500;
    text-decoration: none; transition: var(--transition);
}
.detail-back-btn:hover {
    background: rgba(255,255,255,.22);
    color: white;
}
</style>
@endsection

@section('content')

<!-- ── Hero ─────────────────────────────────────────────────────── -->
<div class="detail-hero">
    <div class="detail-hero-img">
        <img src="{{ $destination->image }}" alt="{{ $destination->name }}">
    </div>
    <div class="detail-hero-overlay"></div>
    <div class="container detail-hero-content">
        {{-- Breadcrumb --}}
        <nav class="detail-breadcrumb mb-4" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('destinations.index') }}">Destinations</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('destinations.index', ['category' => $destination->category]) }}">{{ $destination->category }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $destination->name }}</li>
            </ol>
        </nav>

        <div class="detail-category-chip">
            <i class="fas {{ $destination->category_icon }}"></i>
            {{ $destination->category }}
        </div>
        <h1 class="detail-title">{{ $destination->name }}</h1>
        <div class="detail-meta d-flex flex-wrap">
            <span><i class="fas fa-map-marker-alt me-1" style="color: var(--coral);"></i>{{ $destination->city }}, {{ $destination->country }}</span>
            <span><i class="fas fa-star me-1" style="color: #FBBF24;"></i>{{ $destination->rating }} ({{ number_format($destination->reviews_count) }} reviews)</span>
            @if($destination->best_time)
            <span><i class="fas fa-sun me-1" style="color: var(--sky);"></i>Best: {{ $destination->best_time }}</span>
            @endif
            @if($destination->estimated_budget)
            <span><i class="fas fa-wallet me-1" style="color: #A5D6A7;"></i>{{ $destination->estimated_budget }}</span>
            @endif
        </div>

        {{-- Action row --}}
        <div class="d-flex gap-2 mt-4 flex-wrap">
            <button class="dest-card-save-lg" data-id="{{ $destination->id }}" title="Save to wishlist">
                <i class="far fa-heart"></i> Save
            </button>
            <a href="{{ route('destinations.index') }}" class="detail-back-btn">
                <i class="fas fa-arrow-left me-1"></i> All Destinations
            </a>
        </div>
    </div>
</div>


<!-- ── Body ─────────────────────────────────────────────────────── -->
<div class="detail-body">
    <div class="container">
        <div class="row g-5">

            <!-- Main Content -->
            <div class="col-lg-8">

                <!-- Overview -->
                <div class="mb-5 reveal">
                    <div class="section-label">Overview</div>
                    <p style="font-size: 1.05rem; color: var(--gray-700); line-height: 1.85; font-weight: 300;">
                        {{ $destination->description }}
                    </p>
                </div>

                <!-- Gallery -->
                @if ($destination->gallery && count($destination->gallery))
                <div class="mb-5 reveal">
                    <div class="section-label">Photo Gallery</div>
                    <div class="gallery-grid">
                        <div class="gallery-item gallery-main">
                            <img src="{{ $destination->gallery[0] }}" alt="{{ $destination->name }} gallery 1" loading="lazy">
                        </div>
                        @foreach (array_slice($destination->gallery, 1, 2) as $i => $img)
                        <div class="gallery-item">
                            <img src="{{ $img }}" alt="{{ $destination->name }} gallery {{ $i + 2 }}" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Highlights -->
                @if ($destination->highlights)
                <div class="mb-5 reveal">
                    <div class="section-label">Must-See Highlights</div>
                    <div class="row g-2">
                        @foreach ($destination->highlights as $hl)
                        <div class="col-md-6">
                            <div class="highlight-item">
                                <div class="highlight-icon"><i class="fas fa-star" style="font-size: 11px;"></i></div>
                                <span>{{ $hl }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Activities -->
                @if ($destination->activities)
                <div class="mb-5 reveal">
                    <div class="section-label">Things to Do</div>
                    <div>
                        @foreach ($destination->activities as $act)
                        <span class="activity-pill">
                            <i class="fas fa-check-circle" style="font-size: 11px; color: var(--teal);"></i>
                            {{ $act }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Map -->
                @if ($destination->latitude && $destination->longitude)
                <div class="mb-5 reveal">
                    <div class="section-label">Location</div>
                    <div class="map-placeholder">
                        <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $destination->latitude }},{{ $destination->longitude }}&zoom=8&size=800x300&maptype=roadmap&style=feature:all|element:labels.icon|visibility:off&key=YOUR_KEY"
                             onerror="this.style.display='none'"
                             alt="Map of {{ $destination->name }}" loading="lazy">
                        <div class="map-pin"><i class="fas fa-map-marker-alt"></i></div>
                        <p style="position:absolute;bottom:14px;left:50%;transform:translateX(-50%);color:var(--gray-600);font-size:.8rem;background:white;padding:4px 12px;border-radius:var(--radius-full);box-shadow:var(--shadow-sm);white-space:nowrap;">
                            {{ $destination->city }}, {{ $destination->country }}
                            · {{ $destination->latitude }}, {{ $destination->longitude }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Newsletter inline -->
                <div class="detail-card reveal" style="background: var(--navy);">
                    <h5 style="color: white; border-color: rgba(255,255,255,.1);">Stay Inspired</h5>
                    <p style="color: rgba(255,255,255,.55); font-size: .875rem; margin-bottom: 16px;">
                        Get travel tips and hidden gems for {{ $destination->country }} and beyond.
                    </p>
                    <div class="d-flex gap-2" id="inlineNlForm">
                        <input type="email" id="inlineNlEmail" class="form-control rounded-pill"
                            placeholder="your@email.com"
                            style="background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); color: white; font-size: .875rem;">
                        <button class="btn-coral btn flex-shrink-0" id="inlineNlBtn">Subscribe</button>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="detail-sidebar">

                    <!-- CTA Card -->
                    <div class="detail-card text-center" style="background: var(--teal);">
                        <div style="font-size: 2.5rem; margin-bottom: 12px;">✈️</div>
                        <h5 style="color: white; border: none; padding: 0; margin-bottom: 10px;">Ready to Go?</h5>
                        <p style="color: rgba(255,255,255,.7); font-size: .875rem; margin-bottom: 20px;">
                            Start planning your {{ $destination->name }} adventure today.
                        </p>
                        <a href="#" class="btn" style="background: white; color: var(--teal); border-radius: var(--radius-full); padding: 12px 28px; font-weight: 600; display: block; width: 100%; margin-bottom: 10px; transition: var(--transition);">
                            <i class="fas fa-calendar-alt me-2"></i>Plan This Trip
                        </a>
                        <a href="#" class="btn" style="background: rgba(255,255,255,.15); color: white; border-radius: var(--radius-full); padding: 12px 28px; font-weight: 500; display: block; width: 100%; font-size: .875rem; text-decoration: none;">
                            <i class="fas fa-bookmark me-2"></i>Save to Wishlist
                        </a>
                    </div>

                    <!-- Quick Info -->
                    <div class="detail-card reveal">
                        <h5>Quick Info</h5>
                        <div class="info-row">
                            <span class="label"><i class="fas fa-map-marker-alt me-2" style="color: var(--coral);"></i>Location</span>
                            <span class="value">{{ $destination->city }}, {{ $destination->country }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label"><i class="fas fa-tag me-2" style="color: var(--teal);"></i>Category</span>
                            <span class="value">{{ $destination->category }}</span>
                        </div>
                        @if($destination->best_time)
                        <div class="info-row">
                            <span class="label"><i class="fas fa-sun me-2" style="color: #FBBF24;"></i>Best Time</span>
                            <span class="value">{{ $destination->best_time }}</span>
                        </div>
                        @endif
                        @if($destination->estimated_budget)
                        <div class="info-row">
                            <span class="label"><i class="fas fa-wallet me-2" style="color: #81C784;"></i>Est. Budget</span>
                            <span class="value">{{ $destination->estimated_budget }}</span>
                        </div>
                        @endif
                        <div class="info-row">
                            <span class="label"><i class="fas fa-star me-2" style="color: #FBBF24;"></i>Rating</span>
                            <span class="value">{{ $destination->rating }}/5 ({{ number_format($destination->reviews_count) }})</span>
                        </div>
                    </div>

                    <!-- Share -->
                    <div class="detail-card reveal">
                        <h5>Share This Destination</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="#" class="btn" style="background: #1877F2; color: white; border-radius: var(--radius-full); padding: 9px 16px; font-size: .82rem; text-decoration: none;"><i class="fab fa-facebook-f me-1"></i>Facebook</a>
                            <a href="#" class="btn" style="background: #1DA1F2; color: white; border-radius: var(--radius-full); padding: 9px 16px; font-size: .82rem; text-decoration: none;"><i class="fab fa-twitter me-1"></i>Twitter</a>
                            <a href="#" class="btn" style="background: #E1306C; color: white; border-radius: var(--radius-full); padding: 9px 16px; font-size: .82rem; text-decoration: none;"><i class="fab fa-instagram me-1"></i>Instagram</a>
                            <button onclick="navigator.clipboard.writeText(window.location.href); showToast('Link copied!','success');" class="btn" style="background: var(--gray-100); color: var(--navy); border-radius: var(--radius-full); padding: 9px 16px; font-size: .82rem;"><i class="fas fa-link me-1"></i>Copy Link</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Related Destinations -->
        @if ($related->isNotEmpty())
        <div class="mt-5 pt-4 border-top reveal" style="border-color: var(--gray-200) !important;">
            <div class="d-flex align-items-end justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <div class="section-label">More to Explore</div>
                    <h3 class="section-title" style="font-size: 1.8rem;">You Might Also Like</h3>
                </div>
                <a href="{{ route('destinations.index', ['category' => $destination->category]) }}" class="btn-outline-navy btn" style="font-size: .875rem;">
                    See All {{ $destination->category }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="row g-4">
                @foreach ($related as $i => $rel)
                <div class="col-md-4 reveal" style="transition-delay: {{ $i * 0.1 }}s;">
                    <a href="{{ route('destinations.show', $rel->slug) }}" class="related-card">
                        <div class="related-img">
                            <img src="{{ $rel->image }}" alt="{{ $rel->name }}" loading="lazy">
                        </div>
                        <div class="related-body">
                            <div class="dest-card-location mb-1">
                                <i class="fas fa-map-marker-alt me-1" style="color: var(--coral); font-size: 10px;"></i>
                                {{ $rel->city }}, {{ $rel->country }}
                            </div>
                            <div class="dest-card-name" style="font-size: 1.05rem;">{{ $rel->name }}</div>
                            <div class="mt-2" style="font-size: .8rem; color: var(--gray-400);">
                                {!! $rel->stars_html !!}
                                <span class="ms-1">{{ $rel->rating }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection

@section('extra-js')
<script>
/* Save button large (hero) */
$('.dest-card-save-lg').on('click', function () {
    const $btn = $(this);
    const id   = $btn.data('id');

    $.post(`/api/destinations/${id}/save`)
        .done(function (res) {
            if (res.action === 'saved') {
                $btn.addClass('saved').html('<i class="fas fa-heart me-1"></i> Saved!');
                showToast('\u2708\uFE0F Saved to your wishlist!', 'success');
            } else {
                $btn.removeClass('saved').html('<i class="far fa-heart me-1"></i> Save');
                showToast('Removed from wishlist.', 'danger');
            }
        });
});

/* Newsletter inline (detail page) */
$('#inlineNlBtn').on('click', function () {
    const email = $('#inlineNlEmail').val().trim();
    if (!email) return;

    $.post('{{ route("newsletter.subscribe") }}', { email })
        .done(function (res) {
            showToast(res.message, res.success ? 'success' : 'danger');
            if (res.success) $('#inlineNlEmail').val('');
        })
        .fail(function (xhr) {
            showToast(xhr.responseJSON?.message || 'Error, please try again.', 'danger');
        });
});

/* Re-observe reveals */
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection
