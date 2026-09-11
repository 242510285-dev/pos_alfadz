@extends('layouts.app')

@section('title', 'Detail Produk')

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
            font-family: 'Plus Jakarta Sans', 'Instrument Sans', system-ui, -apple-system, sans-serif;
        }

        /* Modern Card Container */
        .card-pro {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        /* Card Header Styling */
        .card-header-pro {
            background: #0f172a !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            padding: 1.25rem 1.5rem;
        }

        /* Thumbnail Gambar */
        .product-img-detail {
            width: 100%;
            max-width: 280px;
            height: 200px;
            object-fit: cover;
            border-radius: 0.85rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }

        /* Info Field Label & Value */
        .info-label {
            color: #94a3b8;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .info-value {
            color: #f8fafc;
            font-weight: 700;
        }

        /* Button Back Style */
        .btn-back-pro {
            background: rgba(148, 163, 184, 0.15);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.65rem 1.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back-pro:hover {
            background: rgba(148, 163, 184, 0.25);
            color: #ffffff;
        }
    </style>

    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">

                {{-- CARD DETAIL --}}
                <div class="card card-pro">

                    {{-- HEADER CARD --}}
                    <div class="card-header-pro">
                        <h5 class="fw-black text-white mb-0" style="letter-spacing: -0.01em;">
                            <i class="bi bi-box-seam text-indigo-400 me-2" style="color: #818cf8;"></i> Detail Produk
                        </h5>
                    </div>

                    {{-- BODY CARD --}}
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4 align-items-center">

                            {{-- GAMBAR PRODUK --}}
                            <div class="col-12 col-md-5 text-center">
                                @if ($produk->foto)
                                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}"
                                        class="product-img-detail">
                                @else
                                    <div class="product-img-detail d-flex align-items-center justify-content-center mx-auto"
                                        style="background: #0f172a; color: #64748b;">
                                        <i class="bi bi-image fs-1"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- INFORMASI PRODUK --}}
                            <div class="col-12 col-md-7">
                                <h2 class="fw-bold text-white mb-3" style="font-size: 1.75rem;">
                                    {{ $produk->nama }}
                                </h2>
                                <hr class="border-secondary border-opacity-25 my-3">

                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex align-items-center">
                                        <span class="info-label" style="width: 120px;">Harga Beli:</span>
                                        <span class="info-value font-monospace" style="color: #cbd5e1;">
                                            Rp {{ number_format($produk->harga_beli ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <span class="info-label" style="width: 120px;">Harga Jual:</span>
                                        <span class="info-value font-monospace fs-5" style="color: #34d399;">
                                            Rp {{ number_format($produk->harga_jual ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <span class="info-label" style="width: 120px;">Stok:</span>
                                        <span class="badge px-3 py-1.5 rounded-pill fw-bold"
                                            style="background: rgba(16, 185, 129, 0.2); color: #34d399;">
                                            {{ $produk->stok }} Pcs
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- FOOTER CARD --}}
                    <div class="card-footer p-3"
                        style="background: rgba(15, 23, 42, 0.6); border-top: 1px solid rgba(255, 255, 255, 0.05);">
                        <a href="{{ route('produk.index') }}" class="btn btn-back-pro">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection
