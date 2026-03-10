{{-- ================================================================
     SEARCH MODAL PARTIAL — resources/views/partials/search-modal.blade.php
================================================================ --}}
<div class="modal fade" id="searchModal" tabindex="-1" aria-label="Search destinations">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 p-3" style="box-shadow: 0 40px 100px rgba(11,28,46,.22);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-display" style="color: var(--navy);">
                    <i class="fas fa-search me-2" style="color: var(--teal);"></i>Search Destinations
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <div class="position-relative">
                    <input type="text" id="modalSearch" class="form-control form-control-lg rounded-pill ps-4"
                           placeholder="Try 'Bali', 'Beach', 'Japan'..."
                           autocomplete="off"
                           style="border: 1.5px solid var(--gray-200); font-size: .95rem; padding-right: 50px;">
                    <span class="position-absolute top-50 translate-middle-y" style="right: 18px; color: var(--gray-400);">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <div id="searchResults" class="mt-3"></div>
                <div class="d-flex gap-2 flex-wrap mt-3">
                    <span style="font-size: .75rem; color: var(--gray-400); margin-top: 2px;">Popular:</span>
                    @foreach(['Bali', 'Paris', 'Santorini', 'Kyoto', 'Maldives'] as $p)
                    <button class="filter-pill search-quick-pill" data-term="{{ $p }}" style="font-size: .78rem; padding: 5px 14px;">{{ $p }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
