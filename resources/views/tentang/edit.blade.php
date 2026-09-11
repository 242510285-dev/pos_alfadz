@extends('layouts.app')

@section('content')

<style>
    body {
        background: #080d19;
        color: #f8fafc;
    }

    .jenis-page {
        padding: 35px 0;
        min-height: calc(100vh - 70px);
    }

    .form-page {
        max-width: 750px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-title {
        font-size: 30px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 6px 0;
    }

    .page-subtitle {
        color: #94a3b8;
        font-size: 15px;
        margin: 0;
    }

    .form-card {
        background: #111827;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,.25);
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        color: #f8fafc;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 13px 15px;
        background: #0f172a;
        color: #ffffff;
        border: 1px solid #334155;
        border-radius: 10px;
        outline: none;
        font-size: 15px;
        transition: .2s;
    }

    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,.15);
    }

    .form-control::placeholder {
        color: #64748b;
    }

    .error-message {
        color: #f87171;
        font-size: 13px;
        margin-top: 7px;
    }

    .alert-success {
        background: rgba(34,197,94,.12);
        border: 1px solid rgba(34,197,94,.3);
        color: #86efac;
        padding: 13px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .button-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding-top: 10px;
        border-top: 1px solid rgba(255,255,255,.08);
        margin-top: 28px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: .2s;
    }

    .btn-back {
        background: #1e293b;
        color: #cbd5e1;
        border: 1px solid #334155;
    }

    .btn-back:hover {
        background: #334155;
        color: #ffffff;
    }

    .btn-update {
        background: #6366f1;
        color: #ffffff;
    }

    .btn-update:hover {
        background: #4f46e5;
        transform: translateY(-1px);
    }

    @media (max-width: 600px) {
        .form-card {
            padding: 20px;
        }

        .page-title {
            font-size: 25px;
        }

        .button-wrapper {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="jenis-page">
    <div class="form-page">

        
        <div class="page-header">
            <h1 class="page-title">Edit Jenis</h1>
            <p class="page-subtitle">
                Ubah informasi jenis makanan yang dipilih.
            </p>
        </div>

        
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        
        <div class="form-card">

            
            <form action="{{ route('jenis.update', ['jeni' => $jenis->id]) }}" method="POST">

                @csrf
                @method('PUT')

                
                <div class="form-group">
                    <label for="nama" class="form-label">
                        Nama Jenis
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        class="form-control"
                        value="{{ old('nama', $jenis->nama) }}"
                        placeholder="Masukkan nama jenis"
                        required
                    >

                    @error('nama')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                
                <div class="button-wrapper">

                    <a href="{{ route('jenis.index') }}" class="btn btn-back">
                        ← Kembali
                    </a>

                    <button type="submit" class="btn btn-update">
                        ✓ Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

@endsection