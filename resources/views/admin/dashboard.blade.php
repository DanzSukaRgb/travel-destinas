@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('topbar-actions')
<a href="{{ route('admin.destinations.create') }}" class="btn-admin-primary me-2">
    <i class="fas fa-plus"></i> New Destination
</a>
@endsection

@section('content')

<!-- Stats Row -->
<div class="row g-4 mb-5">
    @foreach([
        ['fa-map-marked-alt','Destinations', $stats['destinations'],'rgba(13,124,120,.12)','var(--teal)'],
        ['fa-star','Featured',        $stats['featured'],'rgba(232,113,74,.12)','var(--coral)'],
        ['fa-fire','Popular',         $stats['popular'],'rgba(91,196,212,.2)','var(--sky)'],
        ['fa-pen-nib','Blog Posts',   $stats['blogs'],'rgba(124, 58, 237,.1)','#7C3AED'],
        ['fa-check-circle','Published',$stats['blogs_published'],'rgba(5, 150, 105,.12)','#059669'],
        ['fa-envelope','Newsletters', $stats['newsletters'],'rgba(11,28,46,.07)','var(--navy)'],
    ] as [$icon,$label,$val,$bg,$color])
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: {{ $bg }}; color: {{ $color }};">
                <i class="fas {{ $icon }}"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($val) }}</div>
                <div class="stat-label">{{ $label }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">

    <!-- Recent Destinations -->
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0" style="font-family: var(--font-display); font-size: 1rem; color: var(--navy); font-weight: 700;">
                    Recent Destinations
                </h6>
                <a href="{{ route('admin.destinations.index') }}" class="btn-admin-edit" style="font-size: .75rem; padding: 5px 12px;">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Destination</th>
                            <th>Category</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_destinations as $dest)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $dest->image }}" alt="{{ $dest->name }}"
                                         style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
                                    <div>
                                        <div style="font-weight: 600; color: var(--navy); font-size: .875rem;">{{ $dest->name }}</div>
                                        <div style="font-size: .75rem; color: var(--gray-400);">{{ $dest->city }}, {{ $dest->country }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span style="font-size: .78rem; color: var(--teal); background: var(--sky-pale); padding: 3px 10px; border-radius: 999px; font-weight: 600;">{{ $dest->category }}</span></td>
                            <td><span style="font-size: .82rem; font-weight: 600; color: var(--navy);">{{ $dest->rating }}</span> <i class="fas fa-star" style="color: #FBBF24; font-size: 10px;"></i></td>
                            <td>
                                @if($dest->is_featured)
                                    <span class="badge-on">Featured</span>
                                @elseif($dest->is_popular)
                                    <span class="badge-on" style="background: #FEF3C7; color: #92400E;">Popular</span>
                                @else
                                    <span class="badge-off">Normal</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.destinations.edit', $dest->id) }}" class="btn-admin-edit" style="padding: 5px 12px; font-size: .75rem;">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4" style="color: var(--gray-400);">No destinations yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Blog Posts + Quick Actions -->
    <div class="col-lg-5">

        <!-- Quick Actions -->
        <div class="admin-card mb-4">
            <h6 class="mb-3" style="font-family: var(--font-display); font-size: 1rem; color: var(--navy); font-weight: 700;">Quick Actions</h6>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('admin.destinations.create') }}" class="btn-admin-primary justify-content-center">
                    <i class="fas fa-plus-circle"></i> Add Destination
                </a>
                <a href="{{ route('admin.blog.create') }}" class="btn-admin-edit d-flex justify-content-center">
                    <i class="fas fa-file-alt"></i> Write Blog Post
                </a>
                <a href="{{ route('destinations.index') }}" target="_blank"
                   style="background: var(--gray-100); color: var(--navy); border: none; padding: 10px 20px; border-radius: var(--radius-sm); font-size: .875rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 7px; transition: var(--transition);">
                    <i class="fas fa-eye"></i> Preview Front-End
                </a>
            </div>
        </div>

        <!-- Recent Blog -->
        <div class="admin-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0" style="font-family: var(--font-display); font-size: 1rem; color: var(--navy); font-weight: 700;">Recent Posts</h6>
                <a href="{{ route('admin.blog.index') }}" class="btn-admin-edit" style="font-size: .75rem; padding: 5px 12px;">View All</a>
            </div>
            @forelse($recent_blogs as $blog)
            <div class="d-flex align-items-start gap-3 py-3 border-bottom" style="border-color: var(--gray-100) !important;">
                <div style="width: 8px; height: 8px; border-radius: 50%; margin-top: 5px; flex-shrink: 0; background: {{ $blog->is_published ? 'var(--teal)' : 'var(--gray-400)' }};"></div>
                <div class="flex-grow-1 min-w-0">
                    <div style="font-size: .875rem; font-weight: 600; color: var(--navy); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $blog->title }}</div>
                    <div style="font-size: .75rem; color: var(--gray-400);">{{ $blog->category }} · {{ $blog->created_at->diffForHumans() }}</div>
                </div>
                <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn-admin-edit flex-shrink-0" style="padding: 4px 10px; font-size: .72rem;">Edit</a>
            </div>
            @empty
            <p class="text-center py-2" style="color: var(--gray-400); font-size: .875rem;">No blog posts yet.</p>
            @endforelse
        </div>

    </div>

</div>

@endsection
