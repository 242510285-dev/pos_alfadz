@extends('layouts.app')

@section('content')

<style>

    body {
        background: #080d19;
        color: white;
    }

    .form-page {
        max-width: 750px;
        margin: 40px auto;
    }

    .form-card {
        background: #111827;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 15px 40px rgba(0,0,0,.25);
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: white;
    }

    .page-description {
        color: #64748b;
        margin-bottom: 24px;
    }

    .form-label {
        color: #cbd5e1;
        font-weight: 600;
    }

    .form-control {
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        color: white !important;
        padding: 12px;
        border-radius: 6px;
    }

    .form-control::placeholder {
        color: #64748b;
    }

    .form-control:focus {
        background: #0f172a !important;
        color: white !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 .2rem rgba(99,102,241,.15);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 130px;
    }

    .btn-save {
        background: #6366f1;
        border: none;
        color: white;
        font-weight: 700;
        padding: 11px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: .2s;
    }

    .btn-save:hover {
        background: #4f46e5;
        color: white;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        background: #334155;
        color: white;
        padding: 11px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: .2s;
    }

    .btn-back:hover {
        background: #475569;
        color: white;
    }

    .text-danger {
        font-size: 13px;
        color: #f87171 !important;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f1aeb5;
        color: #842029;
        border-radius: 6px;
        padding: 12px 16px;
    }

</style>


<div class="container form-page">

    <div class="form-card">

        {{-- =========================
             JUDUL
        ========================== --}}
        <h1 class="page-title mb-2">

            <i class="bi bi-plus-square me-2"></i>

            Tambah Jenis

        </h1>


        <p class="page-description">

            Tambahkan jenis produk baru ke dalam sistem.

        </p>


        {{-- =========================
             ERROR VALIDASI
        ========================== --}}
        @if($errors->any())

            <div class="alert alert-danger mb-4">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =========================
             FORM
        ========================== --}}
        <form
            action="{{ route('jenis.store') }}"
            method="POST"
        >

            @csrf


            {{-- =========================
                 NAMA JENIS
            ========================== --}}
            <div class="mb-3">

                <label
                    for="nama_jenis"
                    class="form-label"
                >
                    Nama Jenis
                    <span class="text-danger">*</span>
                </label>


                <input
                    type="text"
                    id="nama_jenis"
                    name="nama_jenis"
                    class="form-control @error('nama_jenis') is-invalid @enderror"
                    placeholder="Contoh: Makanan"
                    value="{{ old('nama_jenis') }}"
                    required
                    autofocus
                >


                @error('nama_jenis')

                    <div class="text-danger mt-1">

                        {{ $message }}

                    </div>

                @enderror

            </div>


            {{-- =========================
                 DESKRIPSI
            ========================== --}}
            <div class="mb-4">

                <label
                    for="deskripsi"
                    class="form-label"
                >
                    Deskripsi
                </label>


                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    class="form-control @error('deskripsi') is-invalid @enderror"
                    rows="5"
                    placeholder="Contoh: Jenis produk makanan dan minuman..."
                >{{ old('deskripsi') }}</textarea>


                @error('deskripsi')

                    <div class="text-danger mt-1">

                        {{ $message }}

                    </div>

                @enderror

            </div>


            {{-- =========================
                 BUTTON
            ========================== --}}
            <div class="d-flex gap-2">

                <a
                    href="{{ route('jenis.index') }}"
                    class="btn-back"
                >

                    <i class="bi bi-arrow-left me-1"></i>

                    Kembali

                </a>


                <button
                    type="submit"
                    class="btn-save"
                >

                    <i class="bi bi-save me-1"></i>

                    Simpan

                </button>

            </div>


        </form>

    </div>

</div>

@endsection