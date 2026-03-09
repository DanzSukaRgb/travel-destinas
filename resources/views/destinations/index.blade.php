@extends('layouts.app')

@section('title', 'All Destinations — Roam')

@section('extra-css')
<style>
.dest-hero {
    background: var(--navy);
    padding: 160px 0 72px;  /* top: navbar(80px) + extra(80px) */
    position: relative; overflow: hidden;
}
.dest-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=1600&q=80') center/cover;
    opacity: .14;
}
.dest-hero::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(11,28,46,.6) 0%, rgba(11,28,46,.15) 100%);
}
.dest-hero-content { position: relative; z-index: 2; }
.dest-hero h1 {
    font-family: var(--font-display);
    font-size: clamp(2.4rem, 4.5vw, 3.8rem);
    font-weight: 700; color: white; margin-bottom: 14px;
    letter-spacing: -.02em;
}
.dest-hero p { color: rgba(255,255,255,.65); font-size: 1rem; }
.dest-hero .search-bar {
    display: flex; align-items: center; gap: 10px;
    background: white; border-radius: var(--radius-full);
    padding: 8px 8px 8px 22px;
    box-shadow: var(--shadow-lg); max-width: 520px;
}
.dest-hero .search-bar input {
    flex: 1; border: none; outline: none;
    font-family: var(--font-body); font-size: .95rem; color: var(--gray-800);
}
.dest-body { padding: 60px 0 100px; background: var(--cream); }
.dest-sidebar .card {
    border: none; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm); margin-bottom: 20px;
}
.dest-sidebar .card-header {
    background: none; border-bottom: 1px solid var(--gray-100);
    font-family: var(--font-display); font-weight: 700;
    color: var(--navy); font-size: .95rem; padding: 16px 20px 12px;
}
.cat-filter-btn {
    display: flex; align-items: center; justify-content: space-between;
    width: 100%; padding: 9px 20px; font-size: .875rem;
    color: var(--gray-600); background: none; border: none;
    transition: var(--transition); border-radius: var(--radius-sm);
    cursor: pointer;
}
.cat-filter-btn:hover { background: var(--gray-100); color: var(--navy); }
.cat-filter-btn.active { color: var(--teal); font-weight: 600; }
.cat-filter-btn .count {
    background: var(--gray-100); color: var(--gray-400);
    font-size: 11px; padding: 2px 8px; border-radius: var(--radius-full);
}
.sort-select {
    border: 1.5px solid var(--gray-200); border-radius: var(--radius-full);
    padding: 9px 16px; font-size: .875rem; color: var(--gray-600);
    background: white; outline: none; cursor: pointer;
    transition: border var(--transition);
}
.sort-select:focus { border-color: var(--teal); }
.pagination .page-link {
    color: var(--teal); border-color: var(--gray-200);
    border-radius: var(--radius-full) !important;
    padding: 8px 14px; font-size: .875rem;
}
.pagination .page-item.active .page-link {
    background: var(--teal); border-color: var(--teal);
}
</style>
@endsection

@section('content')

<!-- Page Hero -->
<div class="dest-hero">
    <div class="container dest-hero-content">
        <p class="section-label" style="color: var(--sky); --teal: var(--sky);">
            <span style="width:20px;height:2px;background:var(--sky);display:inline-block;border-radius:2px;vertical-align:middle;margin-right:8px;"></span>
            Explore the World
        </p>
        <h1>All Destinations</h1>
        <p class="mb-4">Discover {{ $destinations->total() }} handpicked places for every type of traveler.</p>
        <form method="GET" action="{{ route('destinations.index') }}" class="search-bar">
            <i class="fas fa-search" style="color: var(--gray-400); font-size: 14px;"></i>
            <input type="text" name="q" value="{{ $search }}" placeholder="Search destinations, cities, categories...">
            @if($category)<input type="hidden" name="category" value="{{ $category }}">@endif
            @if($sort)<input type="hidden" name="sort" value="{{ $sort }}">@endif
            <button type="submit" class="btn-teal btn" style="padding: 10px 22px;">Search</button>
        </form>
    </div>
</div>

<!-- Body -->
<div class="dest-body">
    <div class="container">
        <div class="row g-4">

            <!-- Sidebar -->
            <div class="col-lg-3 dest-sidebar">

                <!-- Category Filter -->
                <div class="card">
                    <div class="card-header">Browse by Category</div>
                    <div class="card-body p-2">
                        @foreach ($categories as $cat)
                        <a href="{{ route('destinations.index', array_merge(request()->query(), ['category' => $cat === 'All' ? null : $cat, 'page' => null])) }}"
                           class="cat-filter-btn {{ ($category ?? 'All') === $cat ? 'active' : '' }}">
                            <span>
                                @if ($cat !== 'All')
                                @php $icons = ['Beach'=>'fa-umbrella-beach','Mountain'=>'fa-mountain','City'=>'fa-city','Nature'=>'fa-leaf','Cultural'=>'fa-landmark','Adventure'=>'fa-person-hiking']; @endphp
                                <i class="fas {{ $icons[$cat] ?? 'fa-map-pin' }} me-2" style="width:16px;text-align:center;"></i>
                                @else
                                <i class="fas fa-globe me-2" style="width:16px;text-align:center;"></i>
                                @endif
                                {{ $cat }}
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="card">
                    <div class="card-header">Quick Stats</div>
                    <div class="card-body px-4 py-3">
                        <div class="d-flex justify-content-between small mb-2">
                            <span style="color: var(--gray-600);">Showing</span>
                            <span class="fw-semibold" style="color: var(--navy);">{{ $destinations->count() }} of {{ $destinations->total() }}</span>
                        </div>
                        <div class="d-flex justify-content-between small mb-2">
                            <span style="color: var(--gray-600);">Category</span>
                            <span class="fw-semibold" style="color: var(--navy);">{{ $category ?? 'All' }}</span>
                        </div>
                        @if($search)
                        <div class="d-flex justify-content-between small">
                            <span style="color: var(--gray-600);">Search</span>
                            <span class="fw-semibold" style="color: var(--teal);">"{{ $search }}"</span>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Main Grid -->
            <div class="col-lg-9">

                <!-- Toolbar -->
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                    <p class="mb-0" style="color: var(--gray-600); font-size: .9rem;">
                        @if($search)
                        Results for <strong style="color: var(--navy);">"{{ $search }}"</strong> —
                        @endif
                        <strong style="color: var(--navy);">{{ $destinations->total() }}</strong> destination{{ $destinations->total() !== 1 ? 's' : '' }} found
                    </p>
                    <form method="GET" action="{{ route('destinations.index') }}" id="sortForm">
                        @if($category)<input type="hidden" name="category" value="{{ $category }}">@endif
                        @if($search)<input type="hidden" name="q" value="{{ $search }}">@endif
                        <select name="sort" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                            <option value="rating"  {{ $sort === 'rating'  ? 'selected' : '' }}>Top Rated</option>
                            <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="name"    {{ $sort === 'name'    ? 'selected' : '' }}>Name A–Z</option>
                        </select>
                    </form>
                </div>

                @if ($destinations->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-map-marked-alt" style="font-size: 3rem; color: var(--gray-200); margin-bottom: 16px; display: block;"></i>
                        <h5 class="font-display" style="color: var(--navy);">No destinations found</h5>
                        <p class="section-subtitle">Try a different search term or category.</p>
                        <a href="{{ route('destinations.index') }}" class="btn-teal btn mt-3">View All Destinations</a>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach ($destinations as $i => $dest)
                        <div class="col-sm-6 col-xl-4 reveal" style="transition-delay: {{ ($i % 9) * 0.07 }}s;" data-dest-id="{{ $dest->id }}">
                            @include('partials.dest-card', ['dest' => $dest])
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($destinations->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $destinations->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
<script>
// Re-trigger reveal for paginated content
document.querySelectorAll('.reveal').forEach(function (el) {
    observer.observe(el);
});
</script>
@endsection
