{{-- Shared form partial for destination create/edit --}}
<div class="row g-4">

    <!-- Left Column -->
    <div class="col-lg-8">
        <div class="admin-card mb-4">
            <h6 class="mb-4" style="font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: 1rem; padding-bottom: 12px; border-bottom: 1px solid var(--gray-100);">Basic Information</h6>
            <div class="row g-3 admin-form">
                <div class="col-sm-8">
                    <label>Destination Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $destination->name ?? '') }}"
                           placeholder="e.g. Santorini" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-4">
                    <label>Category *</label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="">Choose…</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $destination->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6">
                    <label>Country *</label>
                    <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                           value="{{ old('country', $destination->country ?? '') }}"
                           placeholder="e.g. Greece" required>
                    @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6">
                    <label>City / Region *</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                           value="{{ old('city', $destination->city ?? '') }}"
                           placeholder="e.g. Cyclades" required>
                    @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label>Cover Image URL *</label>
                    <input type="url" name="image" class="form-control @error('image') is-invalid @enderror"
                           value="{{ old('image', $destination->image ?? '') }}"
                           placeholder="https://images.unsplash.com/..." required>
                    <div class="form-hint">Use full HTTPS URL. Recommended: Unsplash (1200×800px)</div>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label>Short Description *</label>
                    <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror"
                           value="{{ old('short_description', $destination->short_description ?? '') }}"
                           placeholder="One-line SEO teaser (max 300 characters)" required maxlength="300">
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label>Full Description *</label>
                    <textarea name="description" rows="6"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Full destination description..." required>{{ old('description', $destination->description ?? '') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="admin-card mb-4">
            <h6 class="mb-4" style="font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: 1rem; padding-bottom: 12px; border-bottom: 1px solid var(--gray-100);">Gallery, Highlights & Activities</h6>
            <div class="row g-3 admin-form">
                <div class="col-12">
                    <label>Gallery Images (one URL per line)</label>
                    <textarea name="gallery" rows="4"
                              class="form-control" placeholder="https://images.unsplash.com/photo-1...&#10;https://images.unsplash.com/photo-2...">{{ old('gallery', isset($destination) ? implode("\n", $destination->gallery ?? []) : '') }}</textarea>
                    <div class="form-hint">Each line = one image URL. First 3 images are used in the gallery grid.</div>
                </div>
                <div class="col-md-6">
                    <label>Highlights (one per line)</label>
                    <textarea name="highlights" rows="5"
                              class="form-control" placeholder="Caldera sunset views&#10;Iconic blue-domed churches&#10;Volcanic beaches">{{ old('highlights', isset($destination) ? implode("\n", $destination->highlights ?? []) : '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label>Activities (one per line)</label>
                    <textarea name="activities" rows="5"
                              class="form-control" placeholder="Sailing tours&#10;Wine tasting&#10;Scuba diving">{{ old('activities', isset($destination) ? implode("\n", $destination->activities ?? []) : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">

        <div class="admin-card mb-4">
            <h6 class="mb-4" style="font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: 1rem; padding-bottom: 12px; border-bottom: 1px solid var(--gray-100);">Ratings & Info</h6>
            <div class="row g-3 admin-form">
                <div class="col-6">
                    <label>Rating (0–5) *</label>
                    <input type="number" name="rating" step="0.1" min="0" max="5"
                           class="form-control @error('rating') is-invalid @enderror"
                           value="{{ old('rating', $destination->rating ?? '4.5') }}" required>
                    @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6">
                    <label>Reviews Count *</label>
                    <input type="number" name="reviews_count" min="0"
                           class="form-control @error('reviews_count') is-invalid @enderror"
                           value="{{ old('reviews_count', $destination->reviews_count ?? '0') }}" required>
                    @error('reviews_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label>Best Time to Visit</label>
                    <input type="text" name="best_time" class="form-control"
                           value="{{ old('best_time', $destination->best_time ?? '') }}"
                           placeholder="e.g. April – October">
                </div>
                <div class="col-12">
                    <label>Estimated Budget</label>
                    <input type="text" name="estimated_budget" class="form-control"
                           value="{{ old('estimated_budget', $destination->estimated_budget ?? '') }}"
                           placeholder="e.g. $1,200 – $3,000 / week">
                </div>
            </div>
        </div>

        <div class="admin-card mb-4">
            <h6 class="mb-4" style="font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: 1rem; padding-bottom: 12px; border-bottom: 1px solid var(--gray-100);">Location (GPS)</h6>
            <div class="row g-3 admin-form">
                <div class="col-6">
                    <label>Latitude</label>
                    <input type="number" name="latitude" step="any"
                           class="form-control"
                           value="{{ old('latitude', $destination->latitude ?? '') }}"
                           placeholder="36.3932">
                </div>
                <div class="col-6">
                    <label>Longitude</label>
                    <input type="number" name="longitude" step="any"
                           class="form-control"
                           value="{{ old('longitude', $destination->longitude ?? '') }}"
                           placeholder="25.4615">
                </div>
            </div>
        </div>

        <div class="admin-card mb-4">
            <h6 class="mb-3" style="font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: 1rem; padding-bottom: 12px; border-bottom: 1px solid var(--gray-100);">Visibility</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                       {{ old('is_featured', $destination->is_featured ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured" style="font-size: .875rem; color: var(--navy); font-weight: 500;">
                    Featured Destination
                    <span style="display: block; font-size: .75rem; color: var(--gray-400); font-weight: 400;">Shown prominently on homepage</span>
                </label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" value="1"
                       {{ old('is_popular', $destination->is_popular ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_popular" style="font-size: .875rem; color: var(--navy); font-weight: 500;">
                    Popular Destination
                    <span style="display: block; font-size: .75rem; color: var(--gray-400); font-weight: 400;">Included in popular listings</span>
                </label>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-admin-primary flex-grow-1 justify-content-center">
                <i class="fas fa-save"></i> Save Destination
            </button>
            <a href="{{ route('admin.destinations.index') }}"
               style="background: var(--gray-100); color: var(--navy); border: none; padding: 10px 16px; border-radius: var(--radius-sm); font-size: .875rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                Cancel
            </a>
        </div>

    </div>
</div>
