@extends('layouts.app')

@section('title', 'About Us — Roam')
@section('meta_description', 'Learn about Roam, a curated travel platform created by explorers for explorers.')

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
    background: url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1600&q=80') center/cover;
    opacity: .12;
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
    font-weight: 700; color: white; margin-bottom: 14px;
    letter-spacing: -.02em;
}
.page-hero p { color: rgba(255,255,255,.65); font-size: 1.05rem; max-width: 540px; line-height: 1.8; }

.team-card {
    background: white; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm); overflow: hidden;
    transition: var(--transition); text-align: center;
}
.team-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
.team-avatar {
    height: 200px; overflow: hidden;
}
.team-avatar img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
.team-card:hover .team-avatar img { transform: scale(1.06); }
.team-body { padding: 20px 22px 22px; }
.team-name { font-family: var(--font-display); font-size: 1.15rem; font-weight: 700; color: var(--navy); }
.team-role { font-size: .82rem; color: var(--teal); font-weight: 600; letter-spacing: .05em; text-transform: uppercase; margin-bottom: 8px; }
.team-bio { font-size: .85rem; color: var(--gray-600); line-height: 1.65; }

.stat-box {
    background: white; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm); padding: 32px 24px; text-align: center;
    border-top: 4px solid var(--teal);
}
.stat-number { font-family: var(--font-display); font-size: 2.8rem; font-weight: 700; color: var(--navy); line-height: 1; }
.stat-label { font-size: .875rem; color: var(--gray-600); margin-top: 6px; }

.value-card {
    background: white; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm); padding: 28px;
    display: flex; gap: 18px; align-items: flex-start;
    transition: var(--transition);
}
.value-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
.value-icon {
    width: 48px; height: 48px; border-radius: var(--radius-md);
    background: var(--sky-pale); color: var(--teal);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.value-title { font-family: var(--font-display); font-weight: 700; color: var(--navy); font-size: 1rem; margin-bottom: 6px; }
.value-desc { font-size: .875rem; color: var(--gray-600); line-height: 1.65; }
</style>
@endsection

@section('content')

<!-- Hero -->
<div class="page-hero">
    <div class="container page-hero-content">
        <p class="section-label" style="color: var(--sky);">{!! \App\Models\PageContent::get('about','hero_badge','Our Story') !!}</p>
        <h1>{!! \App\Models\PageContent::get('about','hero_title','About Roam') !!}</h1>
        <p>{!! \App\Models\PageContent::get('about','hero_subtitle',"We're a team of passionate travelers who believe the world is best experienced firsthand.") !!}</p>
    </div>
</div>

<!-- Mission -->
<section style="padding: 90px 0; background: var(--cream);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <p class="section-label">{!! \App\Models\PageContent::get('about','mission_label','Our Mission') !!}</p>
                <h2 class="section-title mb-4">{!! \App\Models\PageContent::get('about','mission_title','Inspiring a world full of <em style="font-style:italic;color:var(--teal)">explorers</em>') !!}</h2>
                <p class="section-subtitle mb-4">
                    {!! \App\Models\PageContent::get('about','mission_text','Roam was born from a simple belief: that travel transforms lives.') !!}
                </p>
                <p style="font-size: .95rem; color: var(--gray-600); line-height: 1.8;">
                    {!! \App\Models\PageContent::get('about','mission_text2','We hand-curate every destination on our platform — verified by our team of travel experts.') !!}
                </p>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <a href="{{ route('destinations.index') }}" class="btn-teal btn">Explore Destinations</a>
                    <a href="{{ route('contact') }}" class="btn-outline-navy btn">Get in Touch</a>
                </div>
            </div>
            <div class="col-lg-6 reveal">
                <div class="row g-3">
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&q=80" alt="Mountain landscape" class="img-fluid rounded-4 shadow" style="aspect-ratio: 3/4; object-fit: cover; width: 100%;">
                    </div>
                    <div class="col-6 pt-4">
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&q=80" alt="Beach view" class="img-fluid rounded-4 shadow mb-3" style="aspect-ratio: 1/1; object-fit: cover; width: 100%;">
                        <img src="https://images.unsplash.com/photo-1538485399081-7191377e8241?w=400&q=80" alt="City skyline" class="img-fluid rounded-4 shadow" style="aspect-ratio: 4/3; object-fit: cover; width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section style="padding: 70px 0; background: white;">
    <div class="container">
        <div class="row g-4 text-center">
            @foreach(\App\Models\PageContent::json('about','stats',[['num'=>'200+','label'=>'Destinations'],['num'=>'50K+','label'=>'Happy Travelers'],['num'=>'95%','label'=>'Satisfaction Rate'],['num'=>'40+','label'=>'Countries']]) as $stat)
            <div class="col-6 col-md-3 reveal">
                <div class="stat-box">
                    <div class="stat-number">{{ $stat['num'] }}</div>
                    <div class="stat-label">{{ $stat['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Values -->
<section style="padding: 90px 0; background: var(--cream);">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <p class="section-label">{!! \App\Models\PageContent::get('about','values_label','What We Stand For') !!}</p>
            <h2 class="section-title">{!! \App\Models\PageContent::get('about','values_title','Our Core Values') !!}</h2>
        </div>
        <div class="row g-4">
            @foreach(\App\Models\PageContent::json('about','values',[]) as $val)
            <div class="col-md-6 col-lg-4 reveal">
                <div class="value-card">
                    <div class="value-icon"><i class="fas {{ $val['icon'] }}"></i></div>
                    <div>
                        <div class="value-title">{{ $val['title'] }}</div>
                        <div class="value-desc">{{ $val['desc'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Team -->
<section style="padding: 90px 0; background: white;">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <p class="section-label">{!! \App\Models\PageContent::get('about','team_label','The People Behind Roam') !!}</p>
            <h2 class="section-title">{!! \App\Models\PageContent::get('about','team_title','Meet Our Team') !!}</h2>
            <p class="section-subtitle mx-auto" style="max-width: 500px; margin-top: 12px;">
                {!! \App\Models\PageContent::get('about','team_subtitle','Explorers, writers, designers, and tech enthusiasts united by a love for travel.') !!}
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach(\App\Models\PageContent::json('about','team',[]) as $member)
            <div class="col-sm-6 col-lg-3 reveal">
                <div class="team-card">
                    <div class="team-avatar"><img src="{{ $member['img'] }}" alt="{{ $member['name'] }}"></div>
                    <div class="team-body">
                        <div class="team-name">{{ $member['name'] }}</div>
                        <div class="team-role">{{ $member['role'] }}</div>
                        <div class="team-bio">{{ $member['bio'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section style="padding: 90px 0; background: var(--navy);">
    <div class="container text-center reveal">
        <p class="section-label" style="color: var(--sky);">{!! \App\Models\PageContent::get('about','cta_label','Ready?') !!}</p>
        <h2 class="section-title mb-4" style="color: white;">{!! \App\Models\PageContent::get('about','cta_title','Start Exploring Today') !!}</h2>
        <p style="color: rgba(255,255,255,.6); font-size: 1rem; max-width: 460px; margin: 0 auto 36px;">
            {!! \App\Models\PageContent::get('about','cta_subtitle',"Join thousands of travelers discovering the world's most breathtaking destinations with Roam.") !!}
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('destinations.index') }}" class="btn-coral btn">Browse Destinations</a>
            <a href="{{ route('contact') }}" class="btn" style="background: rgba(255,255,255,.12); color: white; border-radius: var(--radius-full); padding: 12px 28px; border: 1px solid rgba(255,255,255,.2);">Contact Us</a>
        </div>
    </div>
</section>

@endsection
