@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-main: #090d16;
        --card-bg: #1e293b;
        --card-border: rgba(255, 255, 255, 0.08);
        --accent-indigo: #6366f1;
    }

    body {
        background-color: var(--bg-main) !important;
        color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }

    .card-pro {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border);
        border-radius: 1.25rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    .card-header-pro {
        background: #0f172a !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 1.25rem 1.5rem;
    }

    .form-label {
        color: #94a3b8 !important;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control-dark,
    .form-select-dark {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #f8fafc !important;
        border-radius: 0.75rem !important;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }

    .form-control-dark::placeholder {
        color: #64748b !important;
    }

    .form-control-dark:focus,
    .form-select-dark:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
        background-color: #0f172a !important;
        color: #ffffff !important;
    }

    .form-select-dark option {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    .btn-update-pro {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
        font-weight: 700;
        border-radius: 0.75rem;
        padding: 0.75rem 1.5rem;
        border: none;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
        transition: all 0.25s ease;
    }

    .btn-update-pro:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
        color: #ffffff;
    }

    .btn-back-pro {
        background: rgba(148, 163, 184, 0.15);
        color: #cbd5e1;
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-weight: 600;
        border-radius: 0.75rem;
        padding: 0.75rem 1.5rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back-pro:hover {
        background: rgba(148, 163, 184, 0.25);
        color: #ffffff;
    }

    .input-group .input-group-text {
        border-radius: 0.75rem 0 0 0.75rem !important;
    }

    .input-group .form-control {
        border-radius: 0 0.75rem 0.75rem 0 !important;
    }

    .input-group .form-select {
        border-radius: 0 0.75rem 0.75rem 0 !important;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.15) !important;
        color: #f87171 !important;
        border: 1px solid rgba(239, 68, 68, 0.2) !important;
    }

    .success-message {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.25);
        color: #34d399;
        border-radius: 0.75rem;
        padding: 0.85rem 1rem;
        margin-bottom: 1.5rem;
    }
</style>

<div class="container py-5" style="max-width: 800px;">

    {{-- HEADER PAGE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="fw-black text-white mb-1"
                style="font-size: 1.75rem; letter-spacing: -0.02em;">

                Edit User

            </h1>

            <p class="mb-0 small"
               style="color: #94a3b8;">

                Perbarui informasi akun, email, atau peranan pengguna.

            </p>

        </div>

        <a href="{{ route('admin.users') }}"
           class="btn btn-back-pro d-inline-flex align-items-center gap-2">

            <i class="bi bi-arrow-left"></i>

            Kembali

        </a>

    </div>


    {{-- FORM CARD --}}
    <div class="card card-pro">

        {{-- HEADER CARD --}}
        <div class="card-header-pro">

            <h6 class="fw-bold text-white mb-0">

                <i class="bi bi-pencil-square me-2"
                   style="color: #fbbf24;"></i>

                Edit Data Akun #{{ $user->id }}

            </h6>

        </div>


        {{-- BODY --}}
        <div class="card-body p-4 p-md-5">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))

                <div class="success-message">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    {{ session('success') }}

                </div>

            @endif


            {{-- ERROR VALIDASI --}}
            @if ($errors->any())

                <div class="alert alert-danger mb-4">

                    <div class="fw-bold mb-2">

                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                        Terjadi kesalahan:

                    </div>

                    <ul class="mb-0 ps-4">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORM UPDATE --}}
            <form action="{{ route('admin.users.update', $user->id) }}"
                  method="POST">

                @csrf

                {{-- INI PENTING UNTUK ROUTE PUT --}}
                @method('PUT')


                <div class="row g-4">

                    {{-- ========================= --}}
                    {{-- NAMA --}}
                    {{-- ========================= --}}
                    <div class="col-12">

                        <label for="name"
                               class="form-label">

                            Nama Lengkap

                        </label>

                        <div class="input-group">

                            <span class="input-group-text"
                                  style="
                                    background-color: #0f172a !important;
                                    color: #64748b;
                                    border-color: rgba(255,255,255,0.1) !important;
                                  ">

                                <i class="bi bi-person"></i>

                            </span>

                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control form-control-dark"
                                   placeholder="Masukkan nama pengguna"
                                   value="{{ old('name', $user->name) }}"
                                   required>

                        </div>

                    </div>


                    {{-- ========================= --}}
                    {{-- EMAIL --}}
                    {{-- ========================= --}}
                    <div class="col-12 col-md-6">

                        <label for="email"
                               class="form-label">

                            Alamat Email

                        </label>

                        <div class="input-group">

                            <span class="input-group-text"
                                  style="
                                    background-color: #0f172a !important;
                                    color: #64748b;
                                    border-color: rgba(255,255,255,0.1) !important;
                                  ">

                                <i class="bi bi-envelope"></i>

                            </span>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control form-control-dark"
                                   placeholder="nama@email.com"
                                   value="{{ old('email', $user->email) }}"
                                   required>

                        </div>

                    </div>


                    {{-- ========================= --}}
                    {{-- PASSWORD --}}
                    {{-- ========================= --}}
                    <div class="col-12 col-md-6">

                        <label for="password"
                               class="form-label">

                            Password Baru

                            <small class="fw-normal"
                                   style="color: #64748b;">

                                (Kosongkan jika tidak diubah)

                            </small>

                        </label>

                        <div class="input-group">

                            <span class="input-group-text"
                                  style="
                                    background-color: #0f172a !important;
                                    color: #64748b;
                                    border-color: rgba(255,255,255,0.1) !important;
                                  ">

                                <i class="bi bi-lock"></i>

                            </span>

                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control form-control-dark"
                                   placeholder="Password baru...">

                        </div>

                    </div>


                    {{-- ========================= --}}
                    {{-- ROLE --}}
                    {{-- ========================= --}}
                    <div class="col-12">

                        <label for="role_id"
                               class="form-label">

                            Peranan (Role)

                        </label>

                        <div class="input-group">

                            <span class="input-group-text"
                                  style="
                                    background-color: #0f172a !important;
                                    color: #64748b;
                                    border-color: rgba(255,255,255,0.1) !important;
                                  ">

                                <i class="bi bi-shield-check"></i>

                            </span>


                            <select name="role_id"
                                    id="role_id"
                                    class="form-select form-select-dark"
                                    required>

                                @if(isset($roles))

                                    @foreach($roles as $role)

                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>

                                            {{ ucfirst($role->name) }}

                                        </option>

                                    @endforeach

                                @else

                                    <option value="1"
                                        {{ old('role_id', $user->role_id ?? '') == 1 ? 'selected' : '' }}>

                                        Admin

                                    </option>

                                    <option value="2"
                                        {{ old('role_id', $user->role_id ?? '') == 2 ? 'selected' : '' }}>

                                        Kasir

                                    </option>

                                @endif

                            </select>

                        </div>

                    </div>

                </div>


                {{-- GARIS PEMISAH --}}
                <hr class="border-secondary border-opacity-10 my-4">


                {{-- BUTTON --}}
                <div class="d-flex justify-content-end gap-3">

                    <a href="{{ route('admin.users') }}"
                       class="btn btn-back-pro">

                        <i class="bi bi-x-lg me-1"></i>

                        Batal

                    </a>


                    <button type="submit"
                            class="btn btn-update-pro d-inline-flex align-items-center gap-2">

                        <i class="bi bi-check-circle-fill"></i>

                        Update Akun

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection