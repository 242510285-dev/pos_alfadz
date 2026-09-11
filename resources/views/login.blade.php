@extends('layouts.app')

@section('title', 'Login - POSALFADZ')

@section('content')

<style>
    :root {
        --bg-main: #090d16;
        --card-bg: rgba(30, 41, 59, 0.7);
        --card-border: rgba(255, 255, 255, 0.1);
        --accent-indigo: #6366f1;
        --accent-indigo-hover: #4f46e5;
    }

    body {
        background-color: var(--bg-main) !important;
        color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        position: relative;
        overflow-x: hidden;
    }

    /* Ambient Background Glow Effect */
    body::before {
        content: '';
        position: absolute;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(0,0,0,0) 70%);
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 0;
        pointer-events: none;
    }

    .login-container {
        width: 100%;
        max-width: 440px;
        padding: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .card-login {
        background: var(--card-bg) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--card-border);
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        padding: 2.5rem 2rem;
    }

    .brand-logo {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border-radius: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        margin: 0 auto 1.25rem;
    }

    .form-label {
        color: #94a3b8 !important;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .input-group-text-dark {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-right: none !important;
        color: #64748b !important;
        border-radius: 0.75rem 0 0 0.75rem !important;
        padding-left: 1rem;
    }

    .form-control-dark {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-left: none !important;
        color: #f8fafc !important;
        border-radius: 0 0.75rem 0.75rem 0 !important;
        padding: 0.75rem 1rem 0.75rem 0;
        transition: all 0.2s ease;
    }

    .input-group:focus-within .input-group-text-dark,
    .input-group:focus-within .form-control-dark {
        border-color: #6366f1 !important;
    }

    .input-group:focus-within .input-group-text-dark {
        color: #818cf8 !important;
    }

    .form-control-dark::placeholder {
        color: #475569 !important;
    }

    .btn-login-pro {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: #ffffff;
        font-weight: 700;
        border-radius: 0.75rem;
        padding: 0.85rem 1.5rem;
        border: none;
        width: 100%;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        transition: all 0.25s ease;
        margin-top: 1rem;
    }

    .btn-login-pro:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.6);
        color: #ffffff;
    }

    .btn-login-pro:active {
        transform: translateY(0);
    }
</style>

<div class="login-container">
    
    <div class="card card-login">
        
        {{-- BRAND LOGO & TITLE --}}
        <div class="text-center mb-4">
            <div class="brand-logo">
                <i class="bi bi-box-seam-fill text-white fs-4"></i>
            </div>
            <h3 class="fw-black text-white mb-1" style="letter-spacing: -0.02em;">POS<span style="color: #818cf8;">ALFADZ</span></h3>
            <p class="text-slate-400 small mb-0" style="color: #94a3b8;">Masukkan kredensial untuk mengakses sistem</p>
        </div>

        {{-- ALERT ERROR --}}
        @if (session('error'))
            <div class="alert alert-danger border-0 mb-4 d-flex align-items-center gap-2" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border-radius: 0.75rem; font-size: 0.875rem;">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 mb-4" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border-radius: 0.75rem; font-size: 0.85rem;">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM LOGIN --}}
        <form action="{{ route('auth') }}" method="POST">
            @csrf

            {{-- EMAIL --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text input-group-text-dark">
                        <i class="bi bi-envelope-fill"></i>
                    </span>
                    <input type="email" name="email" id="email" class="form-control form-control-dark" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text input-group-text-dark">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" name="password" id="password" class="form-control form-control-dark" placeholder="••••••••" required>
                </div>
            </div>

            {{-- SUBMIT BUTTON --}}
            <button type="submit" class="btn btn-login-pro d-flex align-items-center justify-content-center gap-2">
                <span>Sign In</span>
                <i class="bi bi-arrow-right-short fs-4"></i>
            </button>
        </form>

    </div>

    <p class="text-center mt-4 small text-slate-500" style="color: #64748b;">
        &copy; {{ date('Y') }} ALFADZ Point of Sale System.
    </p>

</div>

@endsection