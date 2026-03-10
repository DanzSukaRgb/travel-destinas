@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('page-title', 'Blog Posts')

@section('topbar-actions')
<a href="{{ route('admin.blog.create') }}" class="btn-admin-primary">
    <i class="fas fa-plus"></i> New Post
</a>
@endsection

@section('content')

{{-- Filters --}}
<div class="admin-card mb-4">
    <form method="GET" action="{{ route('admin.blog.index') }}" class="row g-3 align-items-end">
        <div class="col-sm-5">
            <input type="text" name="q" class="form-control" value="{{ $search ?? '' }}"
                   placeholder="Search title or author…"
                   style="border: 1.5px solid var(--gray-200); border-radius: var(--radius-sm); padding: 10px 14px; font-size: .875rem;">
        </div>
        <div class="col-sm-3">
            <select name="category" class="form-select"
                    style="border: 1.5px solid var(--gray-200); border-radius: var(--radius-sm); padding: 10px 14px; font-size: .875rem;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto d-flex gap-2">
            <button type="submit" class="btn-admin-primary">
                <i class="fas fa-search"></i> Filter
            </button>
            @if(request('q') || request('category'))
            <a href="{{ route('admin.blog.index') }}" class="btn-admin-edit">
                <i class="fas fa-times"></i> Clear
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Table --}}
<div class="admin-card">
    @if($blogs->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-pen-nib" style="font-size: 2.5rem; color: var(--gray-200); display: block; margin-bottom: 12px;"></i>
        <p style="color: var(--gray-600);">No blog posts yet.</p>
        <a href="{{ route('admin.blog.create') }}" class="btn-admin-primary mt-2">
            <i class="fas fa-plus"></i> Create First Post
        </a>
    </div>
    @else
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Published</th>
                    <th>Date</th>
                    <th style="width: 130px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                <tr>
                    <td style="color: var(--gray-400); font-size: .8rem;">{{ $blog->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($blog->cover_image)
                            <img src="{{ $blog->cover_image }}" alt=""
                                 style="width: 46px; height: 34px; object-fit: cover; border-radius: 6px; flex-shrink: 0;">
                            @else
                            <div style="width: 46px; height: 34px; background: var(--gray-100); border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-image" style="color: var(--gray-400); font-size: 12px;"></i>
                            </div>
                            @endif
                            <div>
                                <div style="font-weight: 600; color: var(--navy); font-size: .875rem; max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $blog->title }}
                                </div>
                                <div style="font-size: .75rem; color: var(--gray-400);">{{ $blog->read_time }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="background: var(--sky-pale); color: var(--teal); padding: 3px 10px; border-radius: var(--radius-full); font-size: .75rem; font-weight: 600;">
                            {{ $blog->category }}
                        </span>
                    </td>
                    <td style="font-size: .875rem; color: var(--gray-600);">{{ $blog->author }}</td>
                    <td>
                        @if($blog->is_published)
                            <span class="badge-on"><i class="fas fa-check-circle me-1"></i>Live</span>
                        @else
                            <span class="badge-off"><i class="fas fa-clock me-1"></i>Draft</span>
                        @endif
                    </td>
                    <td style="font-size: .8rem; color: var(--gray-400);">
                        {{ $blog->created_at->format('M d, Y') }}
                    </td>
                    <td>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn-admin-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($blog->is_published)
                            <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn-admin-edit">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endif
                            <form method="POST" action="{{ route('admin.blog.destroy', $blog->id) }}"
                                  onsubmit="return confirm('Delete this post permanently?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-admin-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($blogs->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $blogs->links('pagination::bootstrap-5') }}
    </div>
    @endif
    @endif
</div>

@endsection
