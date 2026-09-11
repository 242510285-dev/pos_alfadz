@extends('layouts.app')

@section('title', 'Tambah User Baru')

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

        .form-control-dark:focus,
        .form-select-dark:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
            background-color: #0f172a !important;
            color: #ffffff !important;
        }

        .form-control-dark::placeholder {
            color: #475569 !important;
        }

        .btn-save-pro {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            border: none;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            transition: all 0.25s ease;
        }

        .btn-save-pro:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
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
    </style>

    <div class="container py-5" style="max-width: 800px;">

        {{-- HEADER PAGE --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-black text-white mb-1" style="font-size: 1.75rem; letter-spacing: -0.02em;">
                    Tambah User Baru
                </h1>
                <p class="text-slate-400 mb-0 small" style="color: #94a3b8;">
                    Buat akun baru untuk kasir atau administrator sistem.
                </p>
            </div>
            <a href="{{ route('admin.users') }}" class="btn btn-back-pro d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="card card-pro">
            <div class="card-header-pro">
                <h6 class="fw-bold text-white mb-0">
                    <i class="bi bi-person-plus-fill text-indigo-400 me-2" style="color: #818cf8;"></i> Formulir Pengguna
                </h6>
            </div>
            <div class="card-body p-4 p-md-5">

                @if ($errors->any())
                    <div class="alert alert-danger border-0 mb-4"
                        style="background: rgba(239, 68, 68, 0.2); color: #f87171; border-radius: 0.75rem;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        {{-- NAMA --}}
                        <div class="col-12">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-slate-400 border-secondary border-opacity-25"
                                    style="background-color: #0f172a !important; color: #64748b; border-color: rgba(255, 255, 255, 0.1) !important;">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" id="name" class="form-control form-control-dark"
                                    placeholder="Masukkan nama pengguna" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-slate-400 border-secondary border-opacity-25"
                                    style="background-color: #0f172a !important; color: #64748b; border-color: rgba(255, 255, 255, 0.1) !important;">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" id="email" class="form-control form-control-dark"
                                    placeholder="nama@email.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="col-12 col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-slate-400 border-secondary border-opacity-25"
                                    style="background-color: #0f172a !important; color: #64748b; border-color: rgba(255, 255, 255, 0.1) !important;">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control form-control-dark"
                                    placeholder="Minimal 6-8 karakter" required>
                            </div>
                        </div>

                        {{-- ROLE --}}
                        <div class="col-12">
                            <label for="role_id" class="form-label">Peranan (Role)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-slate-400 border-secondary border-opacity-25"
                                    style="background-color: #0f172a !important; color: #64748b; border-color: rgba(255, 255, 255, 0.1) !important;">
                                    <i class="bi bi-shield-check"></i>
                                </span>
                                <select name="role_id" id="role_id" class="form-select form-select-dark" required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    {{-- Jika memakai relasi ke tabel roles --}}
                                    @if (isset($roles))
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    @else
                                        {{-- Opsi cadangan berupa ID hardcode jika belum kirim data $roles dari Controller --}}
                                        <option value="1">Admin</option>
                                        <option value="2">Kasir</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="border-secondary border-opacity-10 my-4">

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-back-pro">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-save-pro d-inline-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill"></i> Simpan User
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection
