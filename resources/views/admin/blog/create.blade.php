@extends('layouts.admin')

@section('title', 'New Blog Post')
@section('page-title', 'New Blog Post')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.blog.index') }}"
       style="color: var(--gray-400); text-decoration: none; font-size: .875rem;">
        <i class="fas fa-arrow-left me-1"></i>Back to Blog Posts
    </a>
</div>

<form method="POST" action="{{ route('admin.blog.store') }}">
    @csrf
    @include('admin.blog._form')
</form>

@endsection

@push('scripts')
{{-- push scripts are stacked from _form partial --}}
@endpush
