@extends('layouts.admin')

@section('title', 'Add Destination')
@section('page-title', 'Add Destination')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.destinations.index') }}" style="color: var(--gray-400); text-decoration: none; font-size: .875rem;">
        <i class="fas fa-arrow-left me-1"></i>Back to Destinations
    </a>
</div>

<form method="POST" action="{{ route('admin.destinations.store') }}">
    @csrf
    @include('admin.destinations._form')
</form>

@endsection
