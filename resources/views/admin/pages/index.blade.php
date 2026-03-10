@extends('layouts.admin')

@section('title', 'Pages')
@section('page-title', 'Page Management')

@section('topbar-actions')
<span class="badge" style="background: var(--teal); color: white; padding: 6px 14px; border-radius: 20px; font-size: .82rem;">
    <i class="fas fa-layer-group me-1"></i> {{ $pages->count() }} Pages
</span>
@endsection

@section('content')

<div class="mb-4">
    <p style="color: var(--gray-600); font-size: .95rem;">
        Edit the text content on each public page. Changes are saved to the database and reflected immediately on the live site.
    </p>
</div>

<div class="row g-4">
    @foreach ($pages as $page)
    <div class="col-md-6 col-xl-4">
        <div class="admin-card h-100 d-flex flex-column" style="transition: transform .2s, box-shadow .2s;">
            <div class="d-flex align-items-start gap-3 mb-3">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: var(--sky-pale); color: var(--teal); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fas {{ $page['icon'] }}"></i>
                </div>
                <div>
                    <div style="font-family: var(--font-display); font-size: 1.05rem; font-weight: 700; color: var(--navy);">{{ $page['label'] }}</div>
                    <div style="font-size: .8rem; color: var(--gray-400);">{{ $page['count'] }} editable fields</div>
                </div>
            </div>

            <p style="font-size: .855rem; color: var(--gray-600); line-height: 1.65; flex: 1;">
                {{ $page['desc'] }}
            </p>

            <div class="d-flex gap-2 mt-3 pt-3" style="border-top: 1px solid var(--gray-100);">
                <a href="{{ $page['route'] }}" class="btn-admin-primary" style="flex: 1; text-align: center;">
                    <i class="fas fa-pencil me-1"></i> Edit Content
                </a>
                <a href="{{ $page['public_url'] }}" target="_blank" class="btn-admin-edit" style="flex-shrink: 0;" title="View live page">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
