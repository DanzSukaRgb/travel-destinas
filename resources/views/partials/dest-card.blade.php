<div class="dest-card">
    <div class="dest-card-img">
        <img src="{{ $dest->image }}" alt="{{ $dest->name }}" loading="lazy">
        <span class="dest-card-badge badge-{{ $dest->category }}">{{ $dest->category }}</span>
        <button class="dest-card-save" data-id="{{ $dest->id }}">
            <i class="far fa-heart"></i>
        </button>
    </div>
    <div class="dest-card-body">
        <div class="dest-card-location">
            <i class="fas fa-map-marker-alt me-1" style="color: var(--coral);"></i>
            {{ $dest->city }}, {{ $dest->country }}
        </div>
        <div class="dest-card-name">{{ $dest->name }}</div>
        <p class="dest-card-desc">{{ $dest->short_description }}</p>
        <div class="dest-card-footer">
            <div class="dest-card-rating">
                {!! $dest->stars_html !!}
                <span class="ms-1"><strong>{{ $dest->rating }}</strong> ({{ number_format($dest->reviews_count) }})</span>
            </div>
            <a href="{{ route('destinations.show', $dest->slug) }}" class="btn-view">Details</a>
        </div>
    </div>
</div>
