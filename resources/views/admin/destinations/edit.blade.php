@extends('layouts.admin')

@section('title', 'Edit: ' . $destination->name)
@section('page-title', 'Edit Destination')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.destinations.index') }}" style="color: var(--gray-400); text-decoration: none; font-size: .875rem;">
        <i class="fas fa-arrow-left me-1"></i>Back to Destinations
    </a>
    <a href="{{ route('destinations.show', $destination->slug) }}" target="_blank"
       class="btn-admin-edit">
        <i class="fas fa-eye"></i> Preview
    </a>
</div>

<form method="POST" action="{{ route('admin.destinations.update', $destination->id) }}">
    @csrf
    @method('PUT')
    @include('admin.destinations._form')
</form>

@endsection
