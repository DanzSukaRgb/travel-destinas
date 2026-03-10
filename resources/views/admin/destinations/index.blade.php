@extends('layouts.admin')

@section('title', 'Destinations')
@section('page-title', 'Destinations')

@section('topbar-actions')
<a href="{{ route('admin.destinations.create') }}" class="btn-admin-primary">
    <i class="fas fa-plus"></i> Add Destination
</a>
@endsection

@section('content')

<!-- Filters -->
<div class="admin-card mb-4">
    <form method="GET" action="{{ route('admin.destinations.index') }}" class="row g-3 align-items-end">
        <div class="col-sm-5">
            <input type="text" name="q" class="form-control" value="{{ $search }}"
                   placeholder="Search name, country, city..." style="border: 1.5px solid var(--gray-200); border-radius: var(--radius-sm); padding: 10px 14px; font-size: .875rem;">
        </div>
        <div class="col-sm-3">
            <select name="category" class="form-select" style="border: 1.5px solid var(--gray-200); border-radius: var(--radius-sm); padding: 10px 14px; font-size: .875rem;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn-admin-primary">
                <i class="fas fa-search"></i> Filter
            </button>
            @if(request()->hasAny(['q','category']))
            <a href="{{ route('admin.destinations.index') }}" style="margin-left: 8px; font-size: .8rem; color: var(--gray-400); text-decoration: none;">Clear</a>
            @endif
        </div>
    </form>
</div>

<!-- Table -->
<div class="admin-card">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <span style="font-size: .82rem; color: var(--gray-400);">
            {{ $destinations->total() }} destination{{ $destinations->total() !== 1 ? 's' : '' }} found
        </span>
    </div>
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Destination</th>
                    <th>Category</th>
                    <th>Rating</th>
                    <th>Reviews</th>
                    <th>Featured</th>
                    <th>Popular</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($destinations as $dest)
                <tr>
                    <td style="color: var(--gray-400); font-size: .78rem;">{{ $dest->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $dest->image }}" alt="{{ $dest->name }}"
                                 style="width: 44px; height: 44px; border-radius: 10px; object-fit: cover; flex-shrink: 0;">
                            <div>
                                <div style="font-weight: 600; color: var(--navy);">{{ $dest->name }}</div>
                                <div style="font-size: .75rem; color: var(--gray-400);">{{ $dest->city }}, {{ $dest->country }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-size: .78rem; background: var(--sky-pale); color: var(--teal); padding: 3px 10px; border-radius: 999px; font-weight: 600;">{{ $dest->category }}</span>
                    </td>
                    <td>
                        <span style="font-weight: 700; color: var(--navy);">{{ $dest->rating }}</span>
                        <i class="fas fa-star" style="color: #FBBF24; font-size: 10px;"></i>
                    </td>
                    <td style="color: var(--gray-600);">{{ number_format($dest->reviews_count) }}</td>
                    <td>
                        @if($dest->is_featured)
                            <span class="badge-on">Yes</span>
                        @else
                            <span class="badge-off">No</span>
                        @endif
                    </td>
                    <td>
                        @if($dest->is_popular)
                            <span class="badge-on" style="background: #FEF3C7; color: #92400E;">Yes</span>
                        @else
                            <span class="badge-off">No</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('destinations.show', $dest->slug) }}" target="_blank"
                               class="btn-admin-edit" style="padding: 6px 10px;" title="Preview">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.destinations.edit', $dest->id) }}" class="btn-admin-edit">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.destinations.destroy', $dest->id) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($dest->name) }}? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-admin-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5" style="color: var(--gray-400);">
                        No destinations found.
                        <a href="{{ route('admin.destinations.create') }}" style="color: var(--teal);">Add one now</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($destinations->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $destinations->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection
