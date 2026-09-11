@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

    @include('layouts.navbar')

    <style>
        :root {
            --bg-main: #090d16;
            --card-bg: #1e293b;
            --card-border: rgba(255, 255, 255, 0.08);
            --accent-indigo: #6366f1;
            --accent-emerald: #10b981;
        }

        body {
            background-color: var(--bg-main) !important;
            color: #ffffff !important;
            font-family: 'Plus Jakarta Sans', 'Instrument Sans', system-ui, -apple-system, sans-serif;
        }

        /* SEMUA TEKS DI HALAMAN PUTIH */
        .container,
        .container * {
            color: #ffffff;
        }

        /* Container Glassmorphism Cards */
        .card-pro {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        /* Input Style Dark */
        .form-control-dark {
            background-color: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            border-radius: 0.75rem !important;
            padding: 0.7rem 1rem;
        }

        .form-control-dark:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
            color: #ffffff !important;
        }

        /* Placeholder Input */
        .form-control-dark::placeholder {
            color: #ffffff !important;
            opacity: 0.8;
        }

        /* File Input Styling */
        .form-control-dark::file-selector-button {
            background: #334155;
            color: #ffffff !important;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 0.5rem;
            margin-right: 0.75rem;
            transition: all 0.2s;
        }

        .form-control-dark::file-selector-button:hover {
            background: #475569;
            cursor: pointer;
        }

        /* Box Image Preview */
        .image-preview-container {
            width: 100%;
            height: 200px;
            background-color: #0f172a;
            border: 2px dashed rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .image-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Action Buttons */
        .btn-save-pro {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            font-weight: 700;
            border-radius: 0.75rem;
            padding: 0.75rem 1.75rem;
            border: none;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
            transition: all 0.25s ease;
        }

        .btn-save-pro:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
            color: #ffffff !important;
        }

        .btn-back-pro {
            background: rgba(148, 163, 184, 0.15);
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-back-pro:hover {
            background: rgba(148, 163, 184, 0.25);
            color: #ffffff !important;
        }

        /* Label */
        .form-label {
            color: #ffffff !important;
        }

        /* Input Group Rp */
        .input-group-text {
            color: #ffffff !important;
        }

        /* Text bantuan */
        small,
        .small {
            color: #ffffff !important;
        }

        /* Heading */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #ffffff !important;
        }

        /* Paragraf */
        p {
            color: #ffffff !important;
        }

        /* Ikon */
        i {
            color: inherit;
        }

        /* Error tetap merah */
        .text-danger,
        .invalid-feedback {
            color: #ff6b6b !important;
        }

        /* Border garis bawah */
        .border-secondary {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
    </style>

    <div class="container py-5">

        {{-- HEADER PAGE --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-black text-white mb-1" style="font-size: 2rem; letter-spacing: -0.02em;">
                    Edit Produk
                </h1>

                <p class="text-white mb-0 small">
                    Perbarui informasi, harga, stok, atau foto produk.
                </p>
            </div>

            <div>
                <a href="{{ route('produk.index') }}"
                    class="btn btn-back-pro d-inline-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        {{-- FORM CARD CONTAINER --}}
        <div class="card card-pro p-4 p-md-5">

            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- FORM INPUT (KIRI) --}}
                    <div class="col-12 col-lg-7">

                        {{-- NAMA PRODUK --}}
                        <div class="mb-3">

                            <label class="form-label fw-bold text-white small">
                                Nama Produk
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                name="nama"
                                class="form-control form-control-dark @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $produk->nama) }}"
                                required>

                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- HARGA BELI & HARGA JUAL --}}
                        <div class="row mb-3">

                            <div class="col-12 col-md-6 mb-3 mb-md-0">

                                <label class="form-label fw-bold text-white small">
                                    Harga Beli (Rp)
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text border-0 text-white"
                                        style="background: #0f172a; border-radius: 0.75rem 0 0 0.75rem;">
                                        Rp
                                    </span>

                                    <input type="number"
                                        name="harga_beli"
                                        class="form-control form-control-dark border-start-0 @error('harga_beli') is-invalid @enderror"
                                        value="{{ old('harga_beli', $produk->harga_beli) }}"
                                        style="border-radius: 0 0.75rem 0.75rem 0 !important;">

                                </div>

                                @error('harga_beli')
                                    <div class="text-danger fs-7 mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-12 col-md-6">

                                <label class="form-label fw-bold text-white small">
                                    Harga Jual (Rp)
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text border-0 text-white"
                                        style="background: #0f172a; border-radius: 0.75rem 0 0 0.75rem;">
                                        Rp
                                    </span>

                                    <input type="number"
                                        name="harga_jual"
                                        class="form-control form-control-dark border-start-0 @error('harga_jual') is-invalid @enderror"
                                        value="{{ old('harga_jual', $produk->harga_jual) }}"
                                        style="border-radius: 0 0.75rem 0.75rem 0 !important;"
                                        required>

                                </div>

                                @error('harga_jual')
                                    <div class="text-danger fs-7 mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        {{-- STOK --}}
                        <div class="mb-4">

                            <label class="form-label fw-bold text-white small">
                                Jumlah Stok
                                <span class="text-danger">*</span>
                            </label>

                            <input type="number"
                                name="stok"
                                class="form-control form-control-dark @error('stok') is-invalid @enderror"
                                value="{{ old('stok', $produk->stok) }}"
                                min="0"
                                required>

                            @error('stok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    {{-- UPLOAD & PREVIEW FOTO (KANAN) --}}
                    <div class="col-12 col-lg-5 d-flex flex-column justify-content-between">

                        <div>

                            <label class="form-label fw-bold text-white small">
                                Foto Produk
                            </label>

                            <div class="image-preview-container mb-3" id="previewBox">

                                @if ($produk->foto)

                                    <img id="imgPreview"
                                        src="{{ asset('storage/' . $produk->foto) }}"
                                        alt="{{ $produk->nama }}">

                                    <div class="text-center p-3 d-none"
                                        id="previewPlaceholder"
                                        style="color: #ffffff;">

                                        <i class="bi bi-cloud-arrow-up fs-1 d-block mb-1"></i>

                                        <span class="small fw-semibold">
                                            Preview Foto Baru
                                        </span>

                                    </div>

                                @else

                                    <div class="text-center p-3"
                                        id="previewPlaceholder"
                                        style="color: #ffffff;">

                                        <i class="bi bi-cloud-arrow-up fs-1 d-block mb-1"></i>

                                        <span class="small fw-semibold">
                                            Belum ada foto
                                        </span>

                                    </div>

                                    <img id="imgPreview"
                                        class="d-none"
                                        alt="Preview Gambar">

                                @endif

                            </div>

                            <input type="file"
                                name="foto"
                                id="fotoInput"
                                class="form-control form-control-dark @error('foto') is-invalid @enderror"
                                accept="image/*"
                                onchange="previewImage(this)">

                            <small class="text-white mt-1 d-block"
                                style="font-size: 0.75rem;">
                                Biarkan kosong jika tidak ingin mengubah foto.
                            </small>

                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- TOMBOL SUBMIT --}}
                        <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top border-secondary border-opacity-10">

                            <a href="{{ route('produk.index') }}"
                                class="btn btn-back-pro">
                                Batal
                            </a>

                            <button type="submit"
                                class="btn btn-save-pro d-inline-flex align-items-center gap-2">

                                <i class="bi bi-floppy-fill"></i>
                                Simpan Perubahan

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- SCRIPT PREVIEW GAMBAR LIVE --}}
    <script>
        function previewImage(input) {

            const preview = document.getElementById('imgPreview');
            const placeholder = document.getElementById('previewPlaceholder');

            if (input.files && input.files[0]) {

                const reader = new FileReader();

                reader.onload = function(e) {

                    preview.src = e.target.result;

                    preview.classList.remove('d-none');

                    if (placeholder) {
                        placeholder.classList.add('d-none');
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection