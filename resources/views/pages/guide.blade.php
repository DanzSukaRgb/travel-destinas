@extends('layouts.app')

@section('title', 'Travel Guide — Roam')
@section('meta_description', 'Everything you need to know before your next trip — packing tips, visa guides, budgeting advice, and more.')

@section('extra-css')
<style>
.page-hero {
    background: var(--navy);
    padding: 170px 0 90px;
    position: relative; overflow: hidden;
}
.page-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1526772662000-3f88f10405ff?w=1600&q=80') center/cover;
    opacity: .13;
}
.page-hero::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(11,28,46,.7) 0%, rgba(11,28,46,.2) 100%);
}
.page-hero-content { position: relative; z-index: 2; }
.page-hero h1 {
    font-family: var(--font-display);
    font-size: clamp(2.4rem, 4.5vw, 4rem);
    font-weight: 700; color: white;
    letter-spacing: -.02em; margin-bottom: 14px;
}
.page-hero p { color: rgba(255,255,255,.65); font-size: 1.05rem; max-width: 520px; line-height: 1.8; }

.guide-card {
    background: white; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm); overflow: hidden;
    transition: var(--transition);
}
.guide-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
.guide-card-header {
    padding: 28px 28px 22px;
    display: flex; align-items: center; gap: 14px;
}
.guide-icon {
    width: 52px; height: 52px; border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; flex-shrink: 0;
}
.guide-card-title { font-family: var(--font-display); font-weight: 700; font-size: 1.15rem; color: var(--navy); margin-bottom: 2px; }
.guide-card-tag { font-size: .75rem; color: var(--gray-400); text-transform: uppercase; letter-spacing: .06em; }
.guide-card-body { padding: 0 28px 28px; }
.guide-step {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 10px 0; border-bottom: 1px solid var(--gray-100);
}
.guide-step:last-child { border: none; padding-bottom: 0; }
.step-num {
    width: 26px; height: 26px; border-radius: 50%;
    background: var(--sky-pale); color: var(--teal);
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700; flex-shrink: 0;
}
.step-text { font-size: .875rem; color: var(--gray-600); line-height: 1.65; }
.step-text strong { color: var(--navy); }

.tip-banner {
    background: linear-gradient(135deg, var(--teal) 0%, var(--teal-light) 100%);
    border-radius: var(--radius-lg);
    padding: 40px; color: white;
    position: relative; overflow: hidden;
}
.tip-banner::before {
    content: '✈️';
    position: absolute; right: 30px; top: 50%; transform: translateY(-50%);
    font-size: 80px; opacity: .15;
}
</style>
@endsection

@section('content')

<!-- Hero -->
<div class="page-hero">
    <div class="container page-hero-content">
        <p class="section-label" style="color: var(--sky);">{!! \App\Models\PageContent::get('guide','hero_badge','Plan Smarter') !!}</p>
        <h1>{!! \App\Models\PageContent::get('guide','hero_title','Travel Guide') !!}</h1>
        <p>{!! \App\Models\PageContent::get('guide','hero_subtitle','Everything you need before, during, and after your trip — expertly compiled by our team of seasoned travelers.') !!}</p>
    </div>
</div>

<!-- Quick Navigation -->
<section style="background: white; padding: 28px 0; border-bottom: 1px solid var(--gray-100); position: sticky; top: 72px; z-index: 100;">
    <div class="container">
        <div class="d-flex gap-2 flex-wrap">
            @foreach(['Before You Go','Packing Lists','Budgeting','Safety Tips','Local Etiquette','Booking Hacks'] as $label)
            <a href="#{{ strtolower(str_replace(' ', '-', $label)) }}" class="filter-pill">{{ $label }}</a>
            @endforeach
        </div>
    </div>
</section>

<!-- Guides Grid -->
<section style="padding: 80px 0 100px; background: var(--cream);">
    <div class="container">

        <div class="text-center mb-5 reveal">
            <p class="section-label">{!! \App\Models\PageContent::get('guide','guides_label','Essential Guides') !!}</p>
            <h2 class="section-title">{!! \App\Models\PageContent::get('guide','guides_title','Your Complete Travel Toolkit') !!}</h2>
        </div>

        <div class="row g-4">
            @foreach(\App\Models\PageContent::json('guide','guide_cards',[]) as $card)
            <div class="col-md-6 col-lg-4 reveal" id="{{ $card['id'] }}">
                <div class="guide-card">
                    <div class="guide-card-header">
                        <div class="guide-icon" style="background: {{ $card['color_bg'] }}; color: {{ $card['color'] }};"><i class="fas {{ $card['icon'] }}"></i></div>
                        <div>
                            <div class="guide-card-title">{{ $card['title'] }}</div>
                            <div class="guide-card-tag">{{ $card['tag'] }}</div>
                        </div>
                    </div>
                    <div class="guide-card-body">
                        @foreach($card['steps'] as $step)
                        <div class="guide-step">
                            <div class="step-num">{{ $loop->iteration }}</div>
                            <div class="step-text">{!! $step !!}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pro Tip Banner -->
        <div class="tip-banner mt-5 reveal">
            <p class="section-label" style="color: rgba(255,255,255,.7);">{!! \App\Models\PageContent::get('guide','pro_tip_label','Pro Tip') !!}</p>
            <h3 style="font-family: var(--font-display); font-size: 1.6rem; font-weight: 700; color: white; margin-bottom: 10px;">
                {!! \App\Models\PageContent::get('guide','pro_tip_title','The best travel hack? Embrace the unexpected.') !!}
            </h3>
            <p style="color: rgba(255,255,255,.75); font-size: .95rem; max-width: 600px; line-height: 1.8; margin-bottom: 24px;">
                {!! \App\Models\PageContent::get('guide','pro_tip_text','Over-planning kills spontaneity. Leave at least 30% of your itinerary open for detours, local recommendations, and happy accidents.') !!}
            </p>
            <a href="{{ route('destinations.index') }}" class="btn" style="background: white; color: var(--teal); border-radius: var(--radius-full); padding: 12px 28px; font-weight: 600; text-decoration: none;">
                Start Exploring
            </a>
        </div>

    </div>
</section>

@endsection
