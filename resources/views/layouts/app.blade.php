<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Roam — Find Your Next Dream Destination')</title>
    <meta name="description" content="@yield('meta_description', 'Discover the world\'s most beautiful destinations with Roam. Curated travel guides, tips, and inspiration for every type of traveler.')">

    {{-- Bootstrap 5 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    <style>
        /* ── Variables ─────────────────────────────────────────── */
        :root {
            --navy:        #0B1C2E;
            --navy-mid:    #152A42;
            --teal:        #0D7C78;
            --teal-light:  #13A89E;
            --sky:         #5BC4D4;
            --sky-pale:    #E8F7F9;
            --coral:       #E8714A;
            --coral-dark:  #d4623b;
            --cream:       #FAFAF8;
            --sand:        #F5EFE6;
            --white:       #FFFFFF;
            --gray-100:    #F4F4F2;
            --gray-200:    #E8E8E4;
            --gray-400:    #ADADAA;
            --gray-600:    #6B6B68;
            --gray-700:    #555553;
            --gray-800:    #3A3A38;
            --font-display: 'Playfair Display', Georgia, serif;
            --font-body:    'DM Sans', sans-serif;
            --transition:   0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --radius-sm:    8px;
            --radius-md:    16px;
            --radius-lg:    24px;
            --radius-xl:    36px;
            --radius-full:  9999px;
            --shadow-sm:    0 2px 12px rgba(11,28,46,.06);
            --shadow-md:    0 8px 32px rgba(11,28,46,.10);
            --shadow-lg:    0 20px 60px rgba(11,28,46,.14);
            --shadow-xl:    0 40px 100px rgba(11,28,46,.20);
        }

        /* ── Base ───────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font-body);
            color: var(--gray-800);
            background: var(--cream);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        .font-display { font-family: var(--font-display) !important; }

        /* ── Scrollbar ──────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--gray-100); }
        ::-webkit-scrollbar-thumb { background: var(--teal); border-radius: 3px; }

        /* ── Navbar ─────────────────────────────────────────────── */
        #mainNavbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1050;
            padding: 20px 0;
            transition: background .4s ease, padding .4s ease, box-shadow .4s ease;
        }
        #mainNavbar.scrolled {
            background: rgba(255,255,255,.97) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 12px 0;
            box-shadow: 0 1px 0 rgba(11,28,46,.07), var(--shadow-sm);
        }
        #mainNavbar .navbar-brand .brand-text {
            font-family: var(--font-display);
            font-size: 1.5rem; font-weight: 700;
            color: #fff;
            transition: color var(--transition);
            letter-spacing: -.01em;
        }
        #mainNavbar.scrolled .navbar-brand .brand-text { color: var(--navy); }
        #mainNavbar .brand-icon {
            width: 36px; height: 36px; background: var(--teal);
            border-radius: 10px; display: inline-flex;
            align-items: center; justify-content: center;
            color: white; font-size: 15px;
        }
        #mainNavbar .nav-link {
            color: rgba(255,255,255,.82) !important;
            font-size: .875rem; font-weight: 500;
            padding: 8px 12px !important;
            border-radius: var(--radius-full);
            transition: var(--transition);
        }
        #mainNavbar.scrolled .nav-link { color: var(--gray-600) !important; }
        #mainNavbar .nav-link:hover,
        #mainNavbar .nav-link.nav-active {
            background: rgba(255,255,255,.18);
            color: #fff !important;
        }
        #mainNavbar.scrolled .nav-link:hover,
        #mainNavbar.scrolled .nav-link.nav-active {
            background: var(--sky-pale);
            color: var(--teal) !important;
            font-weight: 600;
        }
        #mainNavbar .nav-link.nav-admin {
            color: rgba(255,255,255,.9) !important;
        }
        #mainNavbar.scrolled .nav-link.nav-admin {
            color: var(--coral) !important;
        }
        .btn-nav-search {
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(255,255,255,.15);
            color: white; font-size: 14px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: var(--transition); border: none; cursor: pointer;
        }
        #mainNavbar.scrolled .btn-nav-search { background: var(--gray-100); color: var(--navy); }
        .btn-nav-search:hover { background: rgba(255,255,255,.28); }
        #mainNavbar.scrolled .btn-nav-search:hover { background: var(--gray-200); }
        .btn-nav-cta {
            padding: 9px 20px; border-radius: var(--radius-full);
            font-size: .875rem; font-weight: 600;
            background: var(--coral); color: white;
            box-shadow: 0 4px 16px rgba(232,113,74,.35);
            transition: var(--transition); border: none; text-decoration: none;
            display: inline-flex; align-items: center;
        }
        .btn-nav-cta:hover {
            background: var(--coral-dark); color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(232,113,74,.45);
        }
        #mainNavbar.scrolled .btn-nav-cta { box-shadow: 0 4px 14px rgba(232,113,74,.3); }
        .navbar-toggler {
            border: none; padding: 6px;
            color: white; font-size: 20px;
            outline: none; box-shadow: none;
        }
        .navbar-toggler:focus { box-shadow: none; outline: none; }
        #mainNavbar.scrolled .navbar-toggler { color: var(--navy); }
        #navMenu.navbar-collapse { background: transparent; }
        #mainNavbar:not(.scrolled) #navMenu.show,
        #mainNavbar:not(.scrolled) #navMenu.collapsing {
            background: rgba(11,28,46,.97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
            padding: 12px 8px 16px;
            margin-top: 8px;
        }
        #mainNavbar.scrolled #navMenu.show,
        #mainNavbar.scrolled #navMenu.collapsing {
            background: white;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
            padding: 12px 8px 16px;
            margin-top: 8px;
            box-shadow: var(--shadow-md);
        }

        /* ── Section Label ───────────────────────────────────────── */
        .section-label {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 11px; font-weight: 600;
            letter-spacing: .12em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 12px;
        }
        .section-label::before {
            content: ''; display: block;
            width: 20px; height: 2px;
            background: currentColor; border-radius: 2px;
        }
        .section-title {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 3.5vw, 2.8rem);
            font-weight: 700; color: var(--navy); line-height: 1.15;
        }
        .section-subtitle {
            font-size: 1rem; color: var(--gray-600);
            line-height: 1.7; font-weight: 300;
        }

        /* ── Buttons ─────────────────────────────────────────────── */
        .btn-teal {
            background: var(--teal); color: white;
            border: none; padding: 12px 28px;
            border-radius: var(--radius-full);
            font-weight: 500; font-size: .9rem;
            box-shadow: 0 4px 20px rgba(13,124,120,.3);
            transition: var(--transition);
        }
        .btn-teal:hover {
            background: var(--teal-light); color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(13,124,120,.4);
        }
        .btn-coral {
            background: var(--coral); color: white; border: none;
            padding: 12px 28px; border-radius: var(--radius-full);
            font-weight: 600; font-size: .9rem;
            box-shadow: 0 4px 20px rgba(232,113,74,.3);
            transition: var(--transition);
        }
        .btn-coral:hover {
            background: var(--coral-dark); color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(232,113,74,.4);
        }
        .btn-outline-navy {
            background: transparent; color: var(--navy);
            border: 1.5px solid var(--gray-200);
            padding: 11px 26px; border-radius: var(--radius-full);
            font-weight: 500; font-size: .9rem;
            transition: var(--transition); text-decoration: none;
            display: inline-flex; align-items: center;
        }
        .btn-outline-navy:hover {
            border-color: var(--teal); color: var(--teal);
            transform: translateY(-2px);
        }

        /* ── Destination Card ────────────────────────────────────── */
        .dest-card {
            background: white; border-radius: var(--radius-lg);
            overflow: hidden; box-shadow: var(--shadow-sm);
            transition: var(--transition); cursor: pointer; border: none;
        }
        .dest-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); }
        .dest-card-img { position: relative; height: 220px; overflow: hidden; }
        .dest-card-img img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform .6s ease;
        }
        .dest-card:hover .dest-card-img img { transform: scale(1.08); }
        .dest-card-badge {
            position: absolute; top: 14px; left: 14px;
            padding: 4px 12px; border-radius: var(--radius-full);
            font-size: 11px; font-weight: 600;
            letter-spacing: .04em; text-transform: uppercase;
            backdrop-filter: blur(8px);
        }
        .dest-card-save {
            position: absolute; top: 14px; right: 14px;
            width: 34px; height: 34px; background: rgba(255,255,255,.92);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; color: var(--gray-400);
            font-size: 14px; transition: var(--transition);
            backdrop-filter: blur(8px); border: none; cursor: pointer;
        }
        .dest-card-save:hover, .dest-card-save.saved { color: var(--coral); }
        .dest-card-body { padding: 20px 22px 22px; }
        .dest-card-location {
            font-size: 11px; color: var(--gray-400);
            font-weight: 500; letter-spacing: .04em;
            text-transform: uppercase; margin-bottom: 4px;
        }
        .dest-card-name {
            font-family: var(--font-display);
            font-size: 1.2rem; font-weight: 700;
            color: var(--navy); margin-bottom: 6px; line-height: 1.25;
        }
        .dest-card-desc {
            font-size: .85rem; color: var(--gray-600);
            line-height: 1.6; margin-bottom: 14px;
        }
        .dest-card-footer {
            display: flex; align-items: center;
            justify-content: space-between;
            padding-top: 14px; border-top: 1px solid var(--gray-100);
        }
        .dest-card-rating { font-size: .82rem; color: var(--gray-600); }
        .dest-card-rating strong { color: var(--gray-800); }
        .btn-view {
            font-size: .8rem; font-weight: 600; color: var(--teal);
            background: var(--sky-pale); border: none;
            padding: 7px 16px; border-radius: var(--radius-full);
            transition: var(--transition); text-decoration: none;
        }
        .btn-view:hover { background: var(--teal); color: white; }

        /* Category badge colors */
        .badge-Beach     { background: rgba(13,124,120,.12); color: var(--teal); }
        .badge-Mountain  { background: rgba(46,125,50,.12);  color: #2E7D32; }
        .badge-City      { background: rgba(230,81,0,.12);   color: #E65100; }
        .badge-Nature    { background: rgba(51,105,30,.12);  color: #33691E; }
        .badge-Cultural  { background: rgba(69,39,160,.12);  color: #4527A0; }
        .badge-Adventure { background: rgba(191,54,12,.12);  color: #BF360C; }

        /* ── Filter Pills ─────────────────────────────────────────── */
        .filter-pill {
            padding: 8px 20px; border-radius: var(--radius-full);
            font-size: .85rem; font-weight: 500; color: var(--gray-600);
            background: white; border: 1.5px solid var(--gray-200);
            cursor: pointer; transition: var(--transition);
            white-space: nowrap;
        }
        .filter-pill:hover, .filter-pill.active {
            background: var(--navy); color: white; border-color: var(--navy);
        }

        /* ── Footer ──────────────────────────────────────────────── */
        #siteFooter { background: var(--navy); color: rgba(255,255,255,.7); }
        #siteFooter .footer-brand {
            font-family: var(--font-display);
            font-size: 1.4rem; font-weight: 700; color: white;
        }
        #siteFooter h6 {
            color: white; font-weight: 600;
            font-size: .85rem; letter-spacing: .06em;
            text-transform: uppercase; margin-bottom: 20px;
        }
        #siteFooter a {
            color: rgba(255,255,255,.55); text-decoration: none;
            font-size: .9rem; transition: color var(--transition);
            display: block; margin-bottom: 10px;
        }
        #siteFooter a:hover { color: white; }
        #siteFooter .footer-social a {
            width: 38px; height: 38px; display: inline-flex;
            align-items: center; justify-content: center;
            background: rgba(255,255,255,.08); border-radius: 50%;
            color: rgba(255,255,255,.6); font-size: 15px;
            margin-right: 8px; margin-bottom: 0;
            transition: var(--transition);
        }
        #siteFooter .footer-social a:hover { background: var(--teal); color: white; }
        .footer-divider { border-color: rgba(255,255,255,.08); }
        .footer-bottom { font-size: .83rem; color: rgba(255,255,255,.35); }

        /* ── Reveal Animations ───────────────────────────────────── */
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: .1s; }
        .reveal-delay-2 { transition-delay: .2s; }
        .reveal-delay-3 { transition-delay: .3s; }
        .reveal-delay-4 { transition-delay: .4s; }
        .reveal-delay-5 { transition-delay: .5s; }

        /* ── Toast ───────────────────────────────────────────────── */
        .toast-container { z-index: 9999; }
        .custom-toast { border: none; border-radius: var(--radius-md); box-shadow: var(--shadow-lg); min-width: 280px; }

        /* ── Loader ──────────────────────────────────────────────── */
        .spinner-roam {
            width: 40px; height: 40px;
            border: 3px solid var(--gray-200);
            border-top-color: var(--teal);
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Alert Flashes ───────────────────────────────────────── */
        .alert-roam {
            border: none; border-radius: var(--radius-md);
            padding: 14px 20px; font-size: .9rem;
        }

        @yield('extra-css')
    </style>
    @yield('extra-head')
</head>
<body>

{{-- Navbar --}}
@include('partials.navbar')

{{-- Search Modal --}}
@include('partials.search-modal')

{{-- Flash Messages --}}
@if(session('success'))
<div class="position-fixed top-0 start-50 translate-middle-x mt-5 pt-3" style="z-index: 1200; min-width: 320px;">
    <div class="alert alert-roam bg-success text-white d-flex align-items-center gap-2 shadow-lg" role="alert">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif
@if(session('error'))
<div class="position-fixed top-0 start-50 translate-middle-x mt-5 pt-3" style="z-index: 1200; min-width: 320px;">
    <div class="alert alert-roam bg-danger text-white d-flex align-items-center gap-2 shadow-lg" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

{{-- Page Content --}}
@yield('content')

{{-- Footer --}}
@include('partials.footer')

{{-- Toast Container --}}
<div class="toast-container position-fixed bottom-0 end-0 p-4">
    <div id="appToast" class="toast custom-toast align-items-center" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMsg"></div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

{{-- Bootstrap 5 JS Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
/* ── Global Setup ──────────────────────────────────────── */
const CSRF = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': CSRF } });

function showToast(msg, type = 'success') {
    const toast = document.getElementById('appToast');
    const body  = document.getElementById('toastMsg');
    body.textContent = msg;
    toast.className = 'toast custom-toast align-items-center';
    toast.classList.add(type === 'success' ? 'bg-success' : 'bg-danger', 'text-white', 'border-0');
    new bootstrap.Toast(toast, { delay: 3500 }).show();
}

/* ── Navbar Scroll ─────────────────────────────────────── */
$(window).on('scroll', function () {
    $('#mainNavbar').toggleClass('scrolled', $(this).scrollTop() > 50);
}).trigger('scroll');

/* ── Live Search (AJAX) ────────────────────────────────── */
let searchTimer;
$('#modalSearch').on('input', function () {
    const q = $(this).val().trim();
    clearTimeout(searchTimer);
    if (q.length < 2) { $('#searchResults').html(''); return; }

    searchTimer = setTimeout(function () {
        $('#searchResults').html('<div class="text-center py-3"><div class="spinner-roam mx-auto"></div></div>');
        $.get('{{ route("api.destinations.search") }}', { q })
            .done(function (res) {
                if (!res.results || !res.results.length) {
                    $('#searchResults').html('<p class="text-muted text-center py-3 small">No results for "<strong>' + q + '</strong>"</p>');
                    return;
                }
                let html = '<div class="list-group list-group-flush">';
                res.results.forEach(d => {
                    html += `<a href="${d.url}" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-2 border-0 rounded-3" data-bs-dismiss="modal">
                        <img src="${d.image}" alt="${d.name}" style="width:52px;height:52px;object-fit:cover;border-radius:10px;flex-shrink:0;">
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="color:var(--navy)">${d.name}</div>
                            <div class="small text-muted">${d.location} · ${d.category}</div>
                        </div>
                        <span class="small fw-semibold" style="color:var(--teal)"><i class="fas fa-star me-1" style="color:#FBBF24"></i>${d.rating}</span>
                    </a>`;
                });
                $('#searchResults').html(html + '</div>');
            })
            .fail(() => $('#searchResults').html('<p class="text-danger text-center small py-2">Search failed.</p>'));
    }, 350);
});

/* Quick pills in search modal */
$(document).on('click', '.search-quick-pill', function () {
    const term = $(this).data('term');
    $('#modalSearch').val(term).trigger('input');
});

/* ── Save / Unsave Destination ─────────────────────────── */
$(document).on('click', '.dest-card-save', function (e) {
    e.preventDefault(); e.stopPropagation();
    const $btn = $(this), id = $btn.data('id');
    $.post(`/api/destinations/${id}/save`)
        .done(res => {
            if (res.action === 'saved') {
                $btn.addClass('saved').html('<i class="fas fa-heart"></i>');
                showToast('✈️ Saved to your wishlist!', 'success');
            } else {
                $btn.removeClass('saved').html('<i class="far fa-heart"></i>');
                showToast('Removed from wishlist.', 'danger');
            }
        });
});

/* ── Footer Newsletter ─────────────────────────────────── */
$('#footerSubscribe').on('click', function () {
    const email = $('#footerEmail').val().trim();
    if (!email) return;
    $.post('{{ route("newsletter.subscribe") }}', { email })
        .done(res => { showToast(res.message, res.success ? 'success' : 'danger'); if (res.success) $('#footerEmail').val(''); })
        .fail(xhr => showToast(xhr.responseJSON?.message || 'Something went wrong.', 'danger'));
});

/* ── Scroll Reveal ─────────────────────────────────────── */
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>

@yield('extra-js')
</body>
</html>
