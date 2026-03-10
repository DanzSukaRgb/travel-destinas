@extends('layouts.app')

@section('title', 'Sign In — Roam')

@section('extra-css')
<style>
body { background: var(--navy); }

.login-wrap {
    min-height: 100vh;
    display: flex; align-items: center;
    padding: 100px 0 60px;
    position: relative;
    overflow: hidden;
}
.login-wrap::before {
    content: '';
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1600&q=80') center/cover no-repeat;
    opacity: .08;
}
.login-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    padding: 48px;
    position: relative; z-index: 2;
    width: 100%; max-width: 460px;
    margin: 0 auto;
}
.login-brand { text-align: center; margin-bottom: 36px; }
.login-brand .brand-icon { width: 48px; height: 48px; background: var(--teal); border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 20px; margin-bottom: 10px; }
.login-brand h1 { font-family: var(--font-display); font-size: 1.7rem; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
.login-brand p { font-size: .875rem; color: var(--gray-400); }

.form-roam label { font-size: .82rem; font-weight: 600; color: var(--gray-800); margin-bottom: 6px; }
.form-roam .form-control {
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius-md);
    padding: 13px 16px;
    font-size: .9rem;
    color: var(--gray-800);
    transition: border-color var(--transition), box-shadow var(--transition);
}
.form-roam .form-control:focus {
    border-color: var(--teal);
    box-shadow: 0 0 0 3px rgba(13,124,120,.1);
    outline: none;
}
.btn-login {
    display: block; width: 100%;
    background: var(--teal); color: white;
    border-radius: var(--radius-md);
    padding: 14px;
    font-size: .95rem; font-weight: 600;
    border: none; cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 4px 20px rgba(13,124,120,.3);
    text-align: center;
}
.btn-login:hover {
    background: var(--teal-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(13,124,120,.4);
}
.divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; }
.divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--gray-200); }
.divider span { font-size: .75rem; color: var(--gray-400); white-space: nowrap; }
.back-home {
    position: absolute; top: 20px; left: 50%; transform: translateX(-50%);
    z-index: 10; display: inline-flex; align-items: center; gap: 8px;
    color: rgba(255,255,255,.6); font-size: .82rem; text-decoration: none;
    padding: 8px 18px; border-radius: var(--radius-full);
    border: 1px solid rgba(255,255,255,.2);
    background: rgba(255,255,255,.08);
    backdrop-filter: blur(8px);
    transition: var(--transition);
}
.back-home:hover { color: white; background: rgba(255,255,255,.15); }
</style>
@endsection

@section('content')
<div class="login-wrap">

    <a href="{{ route('home') }}" class="back-home">
        <i class="fas fa-arrow-left"></i>Back to Roam
    </a>

    <div class="container">
        <div class="login-card reveal" style="opacity: 1; transform: none;">

            <!-- Brand -->
            <div class="login-brand">
                <div class="brand-icon"><i class="fas fa-compass"></i></div>
                <h1>Welcome back</h1>
                <p>Sign in to access your Roam account</p>
            </div>

            <!-- Errors -->
            @if($errors->any())
            <div class="alert border-0 rounded-3 mb-4 d-flex align-items-center gap-2" style="background: #FEE2E2; color: #991B1B; font-size: .875rem;">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="alert border-0 rounded-3 mb-4 d-flex align-items-center gap-2" style="background: #FEE2E2; color: #991B1B; font-size: .875rem;">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.post') }}" class="form-roam">
                @csrf

                <div class="mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="your@email.com"
                           required autofocus autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password">Password</label>
                    <div class="position-relative">
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••"
                               required autocomplete="current-password"
                               style="padding-right: 46px;">
                        <button type="button" class="btn p-0 position-absolute" style="right: 14px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 15px;"
                                onclick="const p=document.getElementById('password'); p.type=p.type==='password'?'text':'password'; this.querySelector('i').className='fas fa-'+(p.type==='password'?'eye':'eye-slash');">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-size: .85rem; color: var(--gray-600);">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </form>

            <div class="divider"><span>Admin access only</span></div>

            <p class="text-center mb-0" style="font-size: .82rem; color: var(--gray-400);">
                <i class="fas fa-shield-alt me-1" style="color: var(--teal);"></i>
                This portal is for Roam administrators. Contact
                <a href="mailto:admin@roamtravel.com" style="color: var(--teal);">admin@roamtravel.com</a>
                if you need access.
            </p>

        </div>
    </div>
</div>
@endsection
