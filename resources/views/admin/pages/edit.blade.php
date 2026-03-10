@extends('layouts.admin')

@section('title', $pageInfo['label'] . ' Page')
@section('page-title', $pageInfo['label'] . ' Page Content')

@section('topbar-actions')
<a href="{{ route('admin.pages.index') }}" class="btn-admin-edit me-2">
    <i class="fas fa-arrow-left me-1"></i> All Pages
</a>
<a href="{{ $publicUrl ?? '#' }}" target="_blank" class="btn-admin-edit">
    <i class="fas fa-external-link-alt me-1"></i> View Live
</a>
@endsection

@section('content')

@if(session('success'))
<div class="alert border-0 rounded-3 mb-4 d-flex align-items-center gap-2" style="background: #D1FAE5; color: #065F46;">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<form method="POST" action="{{ route('admin.pages.update', $page) }}" class="admin-form">
    @csrf
    @method('PUT')

    @php
    // Group fields by section: before___ prefix or just show all flat
    $grouped = [];
    foreach ($fields as $field) {
        // Use the section prefix from key (everything before first underscore that maps to a known section)
        $sectionParts = explode('_', $field->key);
        // Map common prefixes to readable section names
        $sectionMap = [
            'hero'    => 'Hero Section',
            'dest'    => 'Destinations Section',
            'cat'     => 'Categories Section',
            'whyus'   => 'Why Roam Section',
            'guide'   => 'Guide Section',
            'guides'  => 'Guide Section',
            'testi'   => 'Testimonials Section',
            'nl'      => 'Newsletter Section',
            'mission' => 'Mission Section',
            'stats'   => 'Statistics',
            'values'  => 'Core Values',
            'team'    => 'Team Section',
            'cta'     => 'Call to Action',
            'form'    => 'Contact Form',
            'info'    => 'Contact Info',
            'email'   => 'Contact Info',
            'phone'   => 'Contact Info',
            'office'  => 'Contact Info',
            'hours'   => 'Contact Info',
            'social'  => 'Social Media',
            'pro'     => 'Pro Tip Banner',
        ];
        $section = $sectionMap[$sectionParts[0]] ?? 'General';
        $grouped[$section][] = $field;
    }
    @endphp

    <div class="row g-4">
        <div class="col-lg-8">

            @foreach ($grouped as $sectionName => $sectionFields)
            <div class="admin-card mb-4">
                <h6 style="font-family: var(--font-display); font-size: .95rem; font-weight: 700; color: var(--navy); padding-bottom: 14px; border-bottom: 1px solid var(--gray-100); margin-bottom: 20px;">
                    <i class="fas fa-section me-2" style="color: var(--teal); font-size: .8rem;"></i>
                    {{ $sectionName }}
                </h6>

                @foreach ($sectionFields as $field)
                <div class="mb-4">
                    <label for="field_{{ $field->key }}" class="d-flex align-items-center justify-content-between mb-2">
                        <span>{{ $field->label }}</span>
                        <span class="badge" style="background: {{ $field->type === 'json' ? 'rgba(124,58,237,.1)' : ($field->type === 'textarea' ? 'rgba(13,124,120,.1)' : 'rgba(91,196,212,.2)') }}; color: {{ $field->type === 'json' ? '#7C3AED' : ($field->type === 'textarea' ? 'var(--teal)' : 'var(--sky)') }}; font-size: .68rem; font-weight: 600; padding: 3px 9px; border-radius: 20px; text-transform: uppercase;">{{ $field->type }}</span>
                    </label>

                    @if ($field->type === 'text')
                        <input
                            type="text"
                            id="field_{{ $field->key }}"
                            name="{{ $field->key }}"
                            value="{{ old($field->key, $field->value) }}"
                            class="form-control"
                        >
                        @if (str_contains(strtolower($field->label), 'html') || str_contains($field->key, 'title'))
                        <div class="mt-1" style="font-size: .73rem; color: var(--gray-400);">
                            <i class="fas fa-code me-1"></i> HTML tags like <code>&lt;br&gt;</code> and <code>&lt;em&gt;</code> are allowed.
                        </div>
                        @endif

                    @elseif ($field->type === 'textarea')
                        <textarea
                            id="field_{{ $field->key }}"
                            name="{{ $field->key }}"
                            class="form-control"
                            rows="4"
                        >{{ old($field->key, $field->value) }}</textarea>

                    @elseif ($field->type === 'json')
                        {{-- JSON Editor --}}
                        <div class="position-relative">
                            <textarea
                                id="field_{{ $field->key }}"
                                name="{{ $field->key }}"
                                class="form-control font-monospace"
                                rows="10"
                                style="font-size: .78rem; line-height: 1.6;"
                            >{{ old($field->key, $field->value) }}</textarea>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <button type="button" class="btn-admin-edit json-format-btn" data-target="field_{{ $field->key }}" style="font-size: .75rem; padding: 5px 12px;">
                                <i class="fas fa-magic me-1"></i> Format JSON
                            </button>
                            <button type="button" class="btn-admin-edit json-validate-btn" data-target="field_{{ $field->key }}" style="font-size: .75rem; padding: 5px 12px;">
                                <i class="fas fa-check me-1"></i> Validate
                            </button>
                            <span class="json-status" id="status_{{ $field->key }}" style="font-size: .73rem;"></span>
                        </div>
                        <div class="mt-2" style="font-size: .73rem; color: var(--gray-400);">
                            <i class="fas fa-info-circle me-1"></i> Edit as raw JSON. Use "Format" to pretty-print, "Validate" to check syntax.
                        </div>

                    @elseif ($field->type === 'image' || $field->type === 'url')
                        <input
                            type="url"
                            id="field_{{ $field->key }}"
                            name="{{ $field->key }}"
                            value="{{ old($field->key, $field->value) }}"
                            class="form-control"
                            placeholder="https://"
                        >
                    @endif
                </div>
                @endforeach

            </div>
            @endforeach

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="admin-card" style="position: sticky; top: 90px;">
                <h6 style="font-family: var(--font-display); font-size: .95rem; font-weight: 700; color: var(--navy); margin-bottom: 16px;">
                    Page Info
                </h6>
                <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background: var(--gray-100);">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: var(--sky-pale); color: var(--teal); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                        <i class="fas {{ $pageInfo['icon'] }}"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--navy); font-size: .9rem;">{{ $pageInfo['label'] }} Page</div>
                        <div style="font-size: .78rem; color: var(--gray-400);">{{ $fields->count() }} fields</div>
                    </div>
                </div>

                <div class="mb-3" style="font-size: .82rem; color: var(--gray-600); line-height: 1.7;">
                    {{ $pageInfo['desc'] }}
                </div>

                <div class="d-grid gap-2 mt-4 pt-3" style="border-top: 1px solid var(--gray-100);">
                    <button type="submit" class="btn-admin-primary">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                    <a href="{{ $publicUrl ?? '#' }}" target="_blank" class="btn-admin-edit text-center">
                        <i class="fas fa-eye me-1"></i> Preview Live Page
                    </a>
                    <a href="{{ route('admin.pages.index') }}" class="btn-admin-edit text-center">
                        <i class="fas fa-grid me-1"></i> All Pages
                    </a>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection

@section('extra-js')
<script>
// Pretty-print JSON in textarea
document.querySelectorAll('.json-format-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const targetId = this.dataset.target;
        const textarea = document.getElementById(targetId);
        const statusEl = document.getElementById('status_' + targetId);
        try {
            const obj = JSON.parse(textarea.value);
            textarea.value = JSON.stringify(obj, null, 4);
            statusEl.innerHTML = '<span style="color:#059669;"><i class="fas fa-check-circle me-1"></i>Valid JSON</span>';
        } catch (e) {
            statusEl.innerHTML = '<span style="color:#DC2626;"><i class="fas fa-times-circle me-1"></i>' + e.message + '</span>';
        }
    });
});

document.querySelectorAll('.json-validate-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const targetId = this.dataset.target;
        const textarea = document.getElementById(targetId);
        const statusEl = document.getElementById('status_' + targetId);
        try {
            JSON.parse(textarea.value);
            statusEl.innerHTML = '<span style="color:#059669;"><i class="fas fa-check-circle me-1"></i>Valid JSON</span>';
        } catch (e) {
            statusEl.innerHTML = '<span style="color:#DC2626;"><i class="fas fa-times-circle me-1"></i>' + e.message + '</span>';
        }
    });
});
</script>
@endsection
