@extends('layouts.app')

@section('title', 'Contact Us — Roam')
@section('meta_description', 'Get in touch with the Roam team. We love hearing from fellow travelers.')

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
    background: url('https://images.unsplash.com/photo-1423996736856-01c2b2601f59?w=1600&q=80') center/cover;
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
.page-hero p { color: rgba(255,255,255,.65); font-size: 1.05rem; }

.contact-card {
    background: white; border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md); padding: 40px;
}
.contact-info-item {
    display: flex; gap: 16px; align-items: flex-start;
    padding: 18px 0; border-bottom: 1px solid var(--gray-100);
}
.contact-info-item:last-child { border: none; padding-bottom: 0; }
.contact-info-icon {
    width: 42px; height: 42px; border-radius: var(--radius-md);
    background: var(--sky-pale); color: var(--teal);
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; flex-shrink: 0;
}
.contact-info-label { font-size: .75rem; color: var(--gray-400); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 2px; }
.contact-info-value { font-size: .95rem; color: var(--navy); font-weight: 500; }

.form-roam .form-control,
.form-roam .form-select {
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius-md);
    padding: 12px 16px;
    font-size: .9rem;
    color: var(--gray-800);
    transition: border-color var(--transition), box-shadow var(--transition);
}
.form-roam .form-control:focus,
.form-roam .form-select:focus {
    border-color: var(--teal);
    box-shadow: 0 0 0 3px rgba(13,124,120,.1);
    outline: none;
}
.form-roam label {
    font-size: .82rem;
    font-weight: 600;
    color: var(--gray-800);
    margin-bottom: 6px;
    letter-spacing: .02em;
}
</style>
@endsection

@section('content')

<!-- Hero -->
<div class="page-hero">
    <div class="container page-hero-content">
        <p class="section-label" style="color: var(--sky);">{!! \App\Models\PageContent::get('contact','hero_badge','Say Hello') !!}</p>
        <h1>{!! \App\Models\PageContent::get('contact','hero_title','Contact Us') !!}</h1>
        <p>{!! \App\Models\PageContent::get('contact','hero_subtitle',"Questions, suggestions, or just want to share a travel story? We'd love to hear from you.") !!}</p>
    </div>
</div>

<!-- Contact Body -->
<section style="padding: 90px 0; background: var(--cream);">
    <div class="container">
        <div class="row g-5">

            <!-- Contact Form -->
            <div class="col-lg-7 reveal">
                <div class="contact-card">
                    <p class="section-label">Send a Message</p>
                    <h3 class="section-title mb-2" style="font-size: 1.8rem;">{!! \App\Models\PageContent::get('contact','form_title',"We'll reply within 24 hours") !!}</h3>
                    <p class="section-subtitle mb-4">{!! \App\Models\PageContent::get('contact','form_subtitle','Fill in the form below and a member of our team will get back to you shortly.') !!}</p>

                    @if(session('success'))
                    <div class="alert border-0 rounded-3 mb-4 d-flex align-items-center gap-2" style="background: #D1FAE5; color: #065F46;">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}" class="form-roam">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label>Your Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Alex Rivera" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label>Email Address *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       placeholder="alex@example.com" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label>Subject *</label>
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                                       placeholder="What's on your mind?" value="{{ old('subject') }}" required>
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label>Message *</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                          rows="5" placeholder="Tell us more..." required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-teal btn px-4">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="col-lg-5 reveal">
                <div class="contact-card mb-4">
                    <p class="section-label">{!! \App\Models\PageContent::get('contact','info_label','Get in Touch') !!}</p>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div class="contact-info-label">Email</div>
                            <div class="contact-info-value">{!! \App\Models\PageContent::get('contact','email','hello@roamtravel.com') !!}</div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <div class="contact-info-label">Phone</div>
                            <div class="contact-info-value">{!! \App\Models\PageContent::get('contact','phone','+1 (555) 012–3456') !!}</div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div class="contact-info-label">Office</div>
                            <div class="contact-info-value">{!! \App\Models\PageContent::get('contact','office','San Francisco, CA, USA') !!}</div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <div class="contact-info-label">Hours</div>
                            <div class="contact-info-value">{!! \App\Models\PageContent::get('contact','hours','Mon – Fri, 9am – 6pm PST') !!}</div>
                        </div>
                    </div>
                </div>

                <div class="contact-card" style="background: var(--navy); border: none;">
                    <p class="section-label" style="color: var(--sky);">{!! \App\Models\PageContent::get('contact','social_label','Social Media') !!}</p>
                    <p style="color: rgba(255,255,255,.55); font-size: .875rem; margin-bottom: 20px; line-height: 1.7;">
                        {!! \App\Models\PageContent::get('contact','social_subtitle','Follow us for daily travel inspiration, destination spotlights, and behind-the-scenes content.') !!}
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach(\App\Models\PageContent::json('contact','social_links',[['icon'=>'fa-instagram','name'=>'Instagram','url'=>'#'],['icon'=>'fa-twitter','name'=>'Twitter','url'=>'#'],['icon'=>'fa-facebook-f','name'=>'Facebook','url'=>'#'],['icon'=>'fa-pinterest-p','name'=>'Pinterest','url'=>'#']]) as $social)
                        <a href="{{ $social['url'] }}" class="btn" style="background: rgba(255,255,255,.1); color: white; border-radius: var(--radius-full); padding: 8px 16px; font-size: .82rem; border: 1px solid rgba(255,255,255,.15); text-decoration: none;">
                            <i class="fab {{ $social['icon'] }} me-1"></i>{{ $social['name'] }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
