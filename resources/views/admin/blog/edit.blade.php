@extends('layouts.admin')

@section('title', 'Edit: ' . $blog->title)
@section('page-title', 'Edit Blog Post')

@section('topbar-actions')
@if($blog->is_published)
<a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn-admin-edit me-2">
    <i class="fas fa-eye"></i> View Live
</a>
@endif
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.blog.index') }}"
       style="color: var(--gray-400); text-decoration: none; font-size: .875rem;">
        <i class="fas fa-arrow-left me-1"></i>Back to Blog Posts
    </a>
    <div class="d-flex gap-2 align-items-center">
        <span style="font-size: .78rem; color: var(--gray-400);">
            Created {{ $blog->created_at->format('M d, Y') }}
        </span>
        <form method="POST" action="{{ route('admin.blog.destroy', $blog->id) }}"
              onsubmit="return confirm('Permanently delete this post?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-admin-danger">
                <i class="fas fa-trash me-1"></i> Delete
            </button>
        </form>
    </div>
</div>

<form method="POST" action="{{ route('admin.blog.update', $blog->id) }}">
    @csrf
    @method('PUT')
    @include('admin.blog._form')
</form>

@endsection
