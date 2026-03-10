{{-- ============================================================
     Admin Blog: Shared Form Partial
     resources/views/admin/blog/_form.blade.php
============================================================ --}}
<div class="row g-4">

    <!-- Left Column — main content -->
    <div class="col-lg-8">
        <div class="admin-card mb-4">
            <h6 class="mb-4" style="font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: 1rem; padding-bottom: 12px; border-bottom: 1px solid var(--gray-100);">
                Post Content
            </h6>
            <div class="row g-3 admin-form">
                <div class="col-12">
                    <label>Post Title *</label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $blog->title ?? '') }}"
                           placeholder="e.g. 10 Hidden Gems in Southeast Asia" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-sm-6">
                    <label>Category *</label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="">Choose…</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $blog->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-sm-6">
                    <label>Author *</label>
                    <input type="text" name="author"
                           class="form-control @error('author') is-invalid @enderror"
                           value="{{ old('author', $blog->author ?? 'Roam Editorial') }}"
                           placeholder="Author name" required>
                    @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label>Cover Image URL</label>
                    <input type="url" name="cover_image"
                           class="form-control @error('cover_image') is-invalid @enderror"
                           value="{{ old('cover_image', $blog->cover_image ?? '') }}"
                           placeholder="https://images.unsplash.com/...">
                    <div class="form-hint">Full HTTPS URL for the blog cover image.</div>
                    @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label>Excerpt / Teaser *</label>
                    <textarea name="excerpt" rows="2"
                              class="form-control @error('excerpt') is-invalid @enderror"
                              placeholder="Short teaser for listing pages (max 400 chars)" required
                              maxlength="400">{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>
                    @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label>Body Content *</label>
                    <textarea name="body" rows="18"
                              id="blogBody"
                              class="form-control @error('body') is-invalid @enderror"
                              placeholder="Write your full blog post here. HTML is supported." required
                              style="font-family: 'Courier New', monospace; font-size: .84rem; line-height: 1.7;">{{ old('body', $blog->body ?? '') }}</textarea>
                    <div class="form-hint">HTML is supported. Use &lt;p&gt;, &lt;h2&gt;, &lt;ul&gt;, &lt;strong&gt;, etc.</div>
                    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column — settings -->
    <div class="col-lg-4">

        <!-- Publish Card -->
        <div class="admin-card mb-4">
            <h6 class="mb-3" style="font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: .95rem; padding-bottom: 10px; border-bottom: 1px solid var(--gray-100);">
                Publish Settings
            </h6>
            <div class="admin-form">
                <div class="mb-3">
                    <label>Read Time Override</label>
                    <input type="text" name="read_time"
                           class="form-control @error('read_time') is-invalid @enderror"
                           value="{{ old('read_time', $blog->read_time ?? '') }}"
                           placeholder="e.g. 5 min read">
                    <div class="form-hint">Leave blank to auto-calculate.</div>
                    @error('read_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-check d-flex align-items-center gap-2 p-0 mb-2" style="margin-top: 16px;">
                    <input class="form-check-input me-0" type="checkbox" name="is_published"
                           id="isPublished" value="1"
                           {{ old('is_published', $blog->is_published ?? false) ? 'checked' : '' }}
                           style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--teal);">
                    <label class="form-check-label fw-semibold" for="isPublished" style="font-size: .875rem; cursor: pointer;">
                        Publish immediately
                    </label>
                </div>
                <p style="font-size: .75rem; color: var(--gray-400); margin-left: 26px;">
                    When checked, post is visible on the blog page.
                </p>
            </div>

            <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn-admin-primary" style="justify-content: center; padding: 12px;">
                    <i class="fas fa-save me-1"></i>
                    {{ isset($blog->id) ? 'Update Post' : 'Create Post' }}
                </button>
                <a href="{{ route('admin.blog.index') }}"
                   style="text-align: center; padding: 10px; font-size: .8rem; color: var(--gray-400); text-decoration: none;">
                    Cancel
                </a>
            </div>
        </div>

        <!-- Cover Preview -->
        <div class="admin-card">
            <h6 class="mb-3" style="font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: .95rem; padding-bottom: 10px; border-bottom: 1px solid var(--gray-100);">
                Cover Preview
            </h6>
            <div id="coverPreview" style="width: 100%; height: 160px; border-radius: var(--radius-sm); overflow: hidden; background: var(--gray-100); display: flex; align-items: center; justify-content: center;">
                @if(isset($blog) && $blog->cover_image)
                <img src="{{ $blog->cover_image }}" alt="Cover" style="width:100%;height:100%;object-fit:cover;">
                @else
                <i class="fas fa-image" style="font-size: 2rem; color: var(--gray-400);"></i>
                @endif
            </div>
            <p style="font-size: .72rem; color: var(--gray-400); margin-top: 8px; text-align: center;">
                Updates when you paste a URL above.
            </p>
        </div>

    </div>
</div>

@push('scripts')
<script>
// Live cover image preview
document.querySelector('[name="cover_image"]')?.addEventListener('input', function () {
    const url = this.value.trim();
    const preview = document.getElementById('coverPreview');
    if (url) {
        preview.innerHTML = `<img src="${url}" alt="Cover" style="width:100%;height:100%;object-fit:cover;" onerror="this.parentElement.innerHTML = '<i class=\\'fas fa-exclamation-triangle\\' style=\\'font-size:2rem;color:var(--coral);\\'></i>'">`;
    } else {
        preview.innerHTML = '<i class="fas fa-image" style="font-size: 2rem; color: var(--gray-400);"></i>';
    }
});
</script>
@endpush
