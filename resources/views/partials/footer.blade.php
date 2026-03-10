{{-- ================================================================
     FOOTER PARTIAL — resources/views/partials/footer.blade.php
================================================================ --}}
<footer id="siteFooter">
    <div class="container pt-5 pb-4">
        <div class="row gy-5">
            {{-- Brand & description --}}
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="brand-icon" style="background: var(--teal);">
                        <i class="fas fa-compass text-white"></i>
                    </span>
                    <span class="footer-brand">Roam</span>
                </div>
                <p style="color: rgba(255,255,255,.5); font-size: .9rem; line-height: 1.75; max-width: 280px;">
                    Curated travel destinations for the modern explorer. Discover, plan,
                    and experience the world's most breathtaking places.
                </p>
                <div class="footer-social mt-4">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            {{-- Explore links --}}
            <div class="col-6 col-lg-2 offset-lg-1">
                <h6>Explore</h6>
                <a href="{{ route('destinations.index') }}">All Destinations</a>
                <a href="{{ route('destinations.index', ['category' => 'Beach']) }}">Beach</a>
                <a href="{{ route('destinations.index', ['category' => 'Mountain']) }}">Mountain</a>
                <a href="{{ route('destinations.index', ['category' => 'City']) }}">City Breaks</a>
                <a href="{{ route('destinations.index', ['category' => 'Adventure']) }}">Adventure</a>
                <a href="{{ route('destinations.index', ['category' => 'Cultural']) }}">Cultural</a>
            </div>

            {{-- Company links --}}
            <div class="col-6 col-lg-2">
                <h6>Company</h6>
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('guide') }}">Travel Guide</a>
                <a href="{{ route('blog.index') }}">Blog</a>
                <a href="{{ route('contact') }}">Contact</a>
                @auth
                @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" style="color: var(--teal);">
                    <i class="fas fa-shield-alt me-1"></i>Admin Panel
                </a>
                @endif
                @endauth
            </div>

            {{-- Newsletter --}}
            <div class="col-lg-3">
                <h6>Stay Inspired</h6>
                <p style="color: rgba(255,255,255,.5); font-size: .85rem; margin-bottom: 14px;">
                    Get weekly travel inspiration delivered to your inbox.
                </p>
                <div class="d-flex gap-2">
                    <input type="email" id="footerEmail" class="form-control rounded-pill"
                           placeholder="your@email.com"
                           style="background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15); color: white; font-size: .85rem;">
                    <button class="btn-teal px-3 flex-shrink-0" id="footerSubscribe" style="padding: 10px 16px;">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
                <p style="color: rgba(255,255,255,.4); font-size: .75rem; margin-top: 10px;">
                    <i class="fas fa-shield-alt me-1" style="color: var(--teal);"></i>No spam. Unsubscribe anytime.
                </p>
            </div>
        </div>

        <hr class="footer-divider my-4">

        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <p class="footer-bottom mb-0">
                © {{ date('Y') }} Roam Travel Inc. All rights reserved.
            </p>
            <div class="d-flex gap-3 flex-wrap">
                <a href="#" class="footer-bottom" style="margin-bottom: 0;">Privacy Policy</a>
                <a href="#" class="footer-bottom" style="margin-bottom: 0;">Terms of Service</a>
                <a href="#" class="footer-bottom" style="margin-bottom: 0;">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>
