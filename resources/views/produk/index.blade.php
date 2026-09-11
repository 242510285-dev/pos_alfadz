@extends('layouts.app')

@section('title', 'Manajemen Produk')

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
            color: #f8fafc !important;
            font-family: 'Plus Jakarta Sans', 'Instrument Sans', system-ui, -apple-system, sans-serif;
        }

        /* Card Container */
        .card-pro {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        /* Input Search Style */
        .input-search-dark {
            background-color: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
            border-radius: 0.75rem 0 0 0.75rem !important;
            padding: 0.65rem 1rem;
        }

        .input-search-dark:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
        }

        .btn-search-dark {
            background-color: #6366f1 !important;
            color: #ffffff !important;
            border-radius: 0 0.75rem 0.75rem 0 !important;
            padding: 0.65rem 1.25rem;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
        }

        .btn-search-dark:hover {
            background-color: #4f46e5 !important;
        }

        /* Custom Table Styling */
        .table-pro {
            color: #f1f5f9 !important;
            margin-bottom: 0;
            --bs-table-bg: transparent !important;
            --bs-table-color: #f1f5f9 !important;
        }

        .table-pro th {
            background-color: #0f172a !important;
            color: #94a3b8 !important;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            padding: 1rem;
        }

        .table-pro td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 1rem;
            vertical-align: middle;
            background-color: transparent !important;
            color: #f1f5f9 !important;
        }

        .table-pro tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.025) !important;
        }

        /* Thumbnail Foto */
        .product-img-thumb {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: 0.65rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: transform 0.2s ease;
        }

        .product-img-thumb:hover {
            transform: scale(1.15);
        }

        /* Action Buttons */
        .btn-action {
            padding: 0.4rem 0.7rem;
            font-size: 0.8rem;
            border-radius: 0.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-action-info {
            background: rgba(14, 165, 233, 0.2);
            color: #38bdf8;
            border: 1px solid rgba(14, 165, 233, 0.3);
        }

        .btn-action-info:hover {
            background: #0284c7;
            color: #fff;
        }

        .btn-action-warning {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .btn-action-warning:hover {
            background: #d97706;
            color: #fff;
        }

        .btn-action-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-action-danger:hover {
            background: #dc2626;
            color: #fff;
        }

        /* Button Create Glow */
        .btn-create-pro {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 0.75rem;
            padding: 0.65rem 1.25rem;
            border: none;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .btn-create-pro:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
            color: #ffffff;
        }
    </style>

    <div class="container py-5">

        {{-- ALERT NOTIFIKASI SUCCESS & ERROR --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" 
                 style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3) !important; border-radius: 0.75rem;">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert" 
                 style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3) !important; border-radius: 0.75rem;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- HEADER PAGE --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h1 class="fw-black text-white mb-1" style="font-size: 2rem; letter-spacing: -0.02em;">
                    Daftar Produk
                </h1>

                <p class="text-slate-400 mb-0 small" style="color: #94a3b8;">
                    Kelola informasi stok, harga beli, dan harga jual barang.
                </p>
            </div>

            <div>
                <a href="{{ route('produk.create') }}"
                    class="btn btn-create-pro d-inline-flex align-items-center gap-2">
                    <i class="bi bi-plus-lg fs-6"></i> Tambah Produk
                </a>
            </div>
        </div>

        {{-- FORM SEARCH --}}
        <div class="row mb-4">
            <div class="col-12 col-md-6 col-lg-5">

                <form action="{{ route('produk.index') }}" method="GET">

                    <div class="input-group">

                        <input type="text"
                            name="search"
                            class="form-control input-search-dark"
                            placeholder="Cari nama atau jenis produk..."
                            value="{{ request('search') }}">

                        <button class="btn btn-search-dark" type="submit">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>

                    </div>

                </form>

            </div>
        </div>

        {{-- TABLE CARD CONTAINER --}}
        <div class="card card-pro">

            <div class="table-responsive">

                <table class="table table-pro align-middle">

                    <thead>
                        <tr>

                            <th class="text-center" style="width: 60px;">
                                #
                            </th>

                            <th>
                                User
                            </th>

                            <th class="text-center" style="width: 80px;">
                                Foto
                            </th>

                            <th>
                                Nama Produk
                            </th>

                            <th>
                                Jenis Produk
                            </th>

                            <th>
                                Harga Beli
                            </th>

                            <th>
                                Harga Jual
                            </th>

                            <th class="text-center">
                                Stok
                            </th>

                            <th class="text-center" style="width: 220px;">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $dataProduk = $produks ?? ($produk ?? []);
                        @endphp

                        @forelse ($dataProduk as $index => $item)

                            <tr>

                                {{-- NOMOR --}}
                                <td class="text-center fw-medium"
                                    style="color: #64748b;">

                                    {{ method_exists($dataProduk, 'firstItem')
                                        ? $dataProduk->firstItem() + $index
                                        : $index + 1 }}

                                </td>


                                {{-- USER --}}
                                <td>

                                    <span class="badge rounded-pill border px-2.5 py-1.5"
                                        style="background: rgba(30, 41, 59, 0.8); border-color: rgba(255, 255, 255, 0.1) !important; color: #cbd5e1;">

                                        <i class="bi bi-person-circle me-1"></i>

                                        {{ $item->user->name ?? 'kude' }}

                                    </span>

                                </td>


                                {{-- FOTO --}}
                                <td class="text-center">

                                    @if ($item->foto)

                                        <img src="{{ asset('storage/' . $item->foto) }}"
                                            alt="{{ $item->nama }}"
                                            class="product-img-thumb">

                                    @else

                                        <div class="product-img-thumb d-flex align-items-center justify-content-center mx-auto"
                                            style="background: #0f172a; color: #64748b;">

                                            <i class="bi bi-image fs-5"></i>

                                        </div>

                                    @endif

                                </td>


                                {{-- NAMA PRODUK --}}
                                <td class="fw-bold text-white fs-6">

                                    {{ $item->nama }}

                                </td>


                                {{-- JENIS PRODUK DENGAN LOGO DINAMIS --}}
                                <td>

                                    @php
                                        $iconJenis = match($item->jenis_produk) {
                                            'Minuman' => 'bi-cup-straw',
                                            'Makanan' => 'bi-egg-fried',
                                            'Kopi'    => 'bi-cup-hot-fill',
                                            'Snack'   => 'bi-cookie',
                                            'Sembako' => 'bi-box-seam',
                                            default   => 'bi-tag-fill',
                                        };
                                    @endphp

                                    <span class="badge rounded-pill border px-2.5 py-1.5"
                                        style="background: rgba(99, 102, 241, 0.15); border-color: rgba(99, 102, 241, 0.3) !important; color: #818cf8;">

                                        <i class="bi {{ $iconJenis }} me-1"></i>

                                        {{ $item->jenis_produk ?? '-' }}

                                    </span>

                                </td>


                                {{-- HARGA BELI --}}
                                <td class="font-monospace"
                                    style="color: #cbd5e1;">

                                    Rp {{ number_format($item->harga_beli ?? 0, 0, ',', '.') }}

                                </td>


                                {{-- HARGA JUAL --}}
                                <td class="fw-bold font-monospace"
                                    style="color: #34d399;">

                                    Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}

                                </td>


                                {{-- STOK --}}
                                <td class="text-center">

                                    @if (($item->stok ?? 0) <= 0)

                                        <span class="badge px-3 py-1.5 rounded-pill fw-bold"
                                            style="background: rgba(239, 68, 68, 0.2); color: #f87171;">

                                            Habis

                                        </span>

                                    @elseif(($item->stok ?? 0) <= 5)

                                        <span class="badge px-3 py-1.5 rounded-pill fw-bold"
                                            style="background: rgba(245, 158, 11, 0.2); color: #fbbf24;">

                                            {{ $item->stok }}

                                        </span>

                                    @else

                                        <span class="badge px-3 py-1.5 rounded-pill fw-bold"
                                            style="background: rgba(16, 185, 129, 0.2); color: #34d399;">

                                            {{ $item->stok }}

                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td class="text-center">

                                    <div class="d-flex justify-content-center gap-1">

                                        {{-- DETAIL --}}
                                        <a href="{{ route('produk.show', $item->id) }}"
                                            class="btn btn-action btn-action-info"
                                            title="Detail">

                                            <i class="bi bi-eye-fill"></i>
                                            Detail

                                        </a>


                                        {{-- EDIT --}}
                                        <a href="{{ route('produk.edit', $item->id) }}"
                                            class="btn btn-action btn-action-warning"
                                            title="Edit">

                                            <i class="bi bi-pencil-fill"></i>
                                            Edit

                                        </a>


                                        {{-- HAPUS --}}
                                        <form action="{{ route('produk.destroy', $item->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-action btn-action-danger"
                                                title="Hapus">

                                                <i class="bi bi-trash-fill"></i>
                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="text-center py-5"
                                    style="color: #94a3b8;">

                                    <i class="bi bi-inbox fs-1 d-block mb-2"
                                        style="color: #475569;">
                                    </i>

                                    Belum ada data produk tersedia.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection