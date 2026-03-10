{{-- ================================================================
     NAVBAR PARTIAL — resources/views/partials/navbar.blade.php
================================================================ --}}
<nav id="mainNavbar" class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
            <span class="brand-icon"><i class="fas fa-compass"></i></span>
            <span class="brand-text">Roam</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'nav-active' : '' }}"
                       href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('destinations.*') ? 'nav-active' : '' }}"
                       href="{{ route('destinations.index') }}">Destinations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guide') ? 'nav-active' : '' }}"
                       href="{{ route('guide') }}">Travel Guide</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog.*') ? 'nav-active' : '' }}"
                       href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'nav-active' : '' }}"
                       href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'nav-active' : '' }}"
                       href="{{ route('contact') }}">Contact</a>
                </li>
                @auth
                @if(auth()->user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link nav-admin {{ request()->routeIs('admin.*') ? 'nav-active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-shield-alt me-1"></i>Admin
                    </a>
                </li>
                @endif
                @endauth
            </ul>

            <div class="d-flex align-items-center gap-2">
                <button class="btn-nav-search" data-bs-toggle="modal" data-bs-target="#searchModal" title="Search">
                    <i class="fas fa-search"></i>
                </button>

                @auth
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-nav-cta ms-1"
                            style="background: transparent; border: 1.5px solid rgba(255,255,255,.4); color: white; padding: 9px 18px;"
                            onmouseover="this.style.background='rgba(255,255,255,.15)'"
                            onmouseout="this.style.background='transparent'">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="btn-nav-cta ms-1">
                    <i class="fas fa-user me-1"></i> Login
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
