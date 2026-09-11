@extends('layouts.app')

@section('title', 'Riwayat Penjualan')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-main: #090d16;
        --card-bg: #1e293b;
        --card-border: rgba(255, 255, 255, 0.08);
        --card-hover-border: rgba(99, 102, 241, 0.4);
        --accent-indigo: #6366f1;
    }

    body {
        background-color: var(--bg-main) !important;
        color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans', 'Instrument Sans', system-ui, -apple-system, sans-serif;
    }

    .card-pro {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border);
        border-radius: 1.25rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    .input-search-dark {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #f8fafc !important;
        border-radius: 0.75rem 0 0 0.75rem !important;
        padding: 0.65rem 1rem;
    }

    .input-search-dark::placeholder {
        color: #64748b !important;
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
        white-space: nowrap;
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

    .btn-action {
        padding: 0.35rem 0.75rem;
        font-size: 0.8rem;
        border-radius: 0.5rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: all 0.2s ease;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
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

    .btn-action-edit {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .btn-action-edit:hover {
        background: #d97706;
        color: #fff;
    }

    .btn-action-delete {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-action-delete:hover {
        background: #dc2626;
        color: #fff;
    }

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

    .badge {
        white-space: nowrap;
    }
</style>

<div class="container py-5">

    {{-- HEADER PAGE --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        <div>
            <h1
                class="fw-black text-white mb-1"
                style="font-size: 2rem; letter-spacing: -0.02em;"
            >
                Riwayat Penjualan
            </h1>

            <p
                class="text-slate-400 mb-0 small"
                style="color: #94a3b8;"
            >
                Daftar seluruh transaksi kasir dan riwayat pembayaran.
            </p>
        </div>

        <div>

            <a
                href="{{ route('penjualan.create') }}"
                class="btn btn-create-pro d-inline-flex align-items-center gap-2"
            >
                <i class="bi bi-cart-plus-fill fs-6"></i>

                Transaksi Baru
            </a>

        </div>

    </div>


    {{-- PESAN SUCCESS --}}
    @if(session('success'))

        <div
            class="alert"
            style="
                background: rgba(16,185,129,.12);
                border: 1px solid rgba(16,185,129,.25);
                color: #6ee7b7;
                border-radius: 1rem;
            "
        >

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- PESAN ERROR --}}
    @if(session('error'))

        <div
            class="alert"
            style="
                background: rgba(239,68,68,.12);
                border: 1px solid rgba(239,68,68,.25);
                color: #fca5a5;
                border-radius: 1rem;
            "
        >

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- FORM SEARCH --}}
    <div class="row mb-4">

        <div class="col-12 col-md-6 col-lg-5">

            <form
                action="{{ route('penjualan.index') }}"
                method="GET"
            >

                <div class="input-group">

                    <input
                        type="text"
                        name="search"
                        class="form-control input-search-dark"
                        placeholder="Cari transaksi / kasir..."
                        value="{{ request('search') }}"
                    >

                    <button
                        class="btn btn-search-dark"
                        type="submit"
                    >

                        <i class="bi bi-search me-1"></i>

                        Cari

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

                        <th
                            class="text-center"
                            style="width: 60px;"
                        >
                            #
                        </th>

                        <th>
                            Tanggal Transaksi
                        </th>

                        <th>
                            Kasir
                        </th>

                        <th>
                            Total Pembayaran
                        </th>

                        <th class="text-center">
                            Metode Pembayaran
                        </th>

                        <th class="text-center">
                            Status
                        </th>

                        <th
                            class="text-center"
                            style="min-width: 250px;"
                        >
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @php

                        $listPenjualan =
                            $penjualan
                            ?? $penjualans
                            ?? $data
                            ?? $transaksi
                            ?? [];

                    @endphp


                    @forelse ($listPenjualan as $index => $item)

                        <tr>

                            {{-- NOMOR --}}
                            <td
                                class="text-center fw-medium"
                                style="color: #64748b;"
                            >

                                {{
                                    method_exists($listPenjualan, 'firstItem')
                                        ? $listPenjualan->firstItem() + $index
                                        : $index + 1
                                }}

                            </td>


                            {{-- TANGGAL --}}
                            <td class="fw-semibold text-slate-200">

                                <i
                                    class="bi bi-clock-history me-1"
                                    style="color: #64748b;"
                                ></i>

                                {{
                                    isset($item->created_at)
                                        ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s')
                                        : ($item->tanggal_transaksi ?? '-')
                                }}

                            </td>


                            {{-- KASIR --}}
                            <td>

                                <span
                                    class="badge rounded-pill border px-2.5 py-1.5"
                                    style="
                                        background: rgba(30, 41, 59, 0.8);
                                        border-color: rgba(255, 255, 255, 0.1) !important;
                                        color: #cbd5e1;
                                    "
                                >

                                    <i class="bi bi-person-circle me-1"></i>

                                    {{ $item->user->name ?? $item->kasir ?? 'kude' }}

                                </span>

                            </td>


                            {{-- TOTAL PEMBAYARAN --}}
                            <td
                                class="fw-bold font-monospace fs-6"
                                style="color: #34d399;"
                            >

                                Rp

                                {{
                                    number_format(
                                        $item->total_pembayaran
                                        ?? $item->total_harga
                                        ?? $item->total
                                        ?? 0,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                            </td>


                            {{-- METODE PEMBAYARAN --}}
                            <td class="text-center">

                                @if(
                                    strtoupper(
                                        $item->metode_pembayaran
                                        ?? $item->metode
                                        ?? 'QRIS'
                                    ) == 'QRIS'
                                )

                                    <span
                                        class="badge px-3 py-1.5 rounded-pill fw-bold"
                                        style="
                                            background: rgba(59, 130, 246, 0.2);
                                            color: #60a5fa;
                                            border: 1px solid rgba(59, 130, 246, 0.3);
                                        "
                                    >

                                        <i class="bi bi-qr-code-scan me-1"></i>

                                        QRIS

                                    </span>

                                @else

                                    <span
                                        class="badge px-3 py-1.5 rounded-pill fw-bold"
                                        style="
                                            background: rgba(16, 185, 129, 0.2);
                                            color: #34d399;
                                            border: 1px solid rgba(16, 185, 129, 0.3);
                                        "
                                    >

                                        <i class="bi bi-cash-stack me-1"></i>

                                        CASH

                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}
                            <td class="text-center">

                                @if(
                                    strtoupper(
                                        $item->status
                                        ?? 'COMPLETED'
                                    ) == 'COMPLETED'
                                )

                                    <span
                                        class="badge px-3 py-1.5 rounded-pill fw-bold"
                                        style="
                                            background: rgba(16, 185, 129, 0.15);
                                            color: #34d399;
                                        "
                                    >

                                        <i class="bi bi-check-circle-fill me-1"></i>

                                        COMPLETED

                                    </span>

                                @else

                                    <span
                                        class="badge px-3 py-1.5 rounded-pill fw-bold"
                                        style="
                                            background: rgba(245, 158, 11, 0.15);
                                            color: #fbbf24;
                                        "
                                    >

                                        <i class="bi bi-hourglass-split me-1"></i>

                                        PENDING

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td class="text-center">

                                <div
                                    class="d-flex justify-content-center align-items-center gap-1 flex-wrap"
                                >

                                    {{-- DETAIL --}}
                                    <a
                                        href="{{ route('penjualan.show', $item->id) }}"
                                        class="btn btn-action btn-action-info"
                                        title="Detail Transaksi"
                                    >

                                        <i class="bi bi-eye-fill"></i>

                                        Detail

                                    </a>


                                    {{-- EDIT DAN HAPUS KHUSUS PENDING --}}
                                    @if(strtoupper($item->status ?? '') === 'PENDING')

                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('penjualan.edit', $item->id) }}"
                                            class="btn btn-action btn-action-edit"
                                            title="Edit Transaksi"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                            Edit

                                        </a>


                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('penjualan.destroy', $item->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus transaksi PENDING ini? Stok produk akan dikembalikan.');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-action btn-action-delete"
                                                title="Hapus Transaksi"
                                            >

                                                <i class="bi bi-trash-fill"></i>

                                                Hapus

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                                style="color: #94a3b8;"
                            >

                                <i
                                    class="bi bi-receipt fs-1 d-block mb-2"
                                    style="color: #475569;"
                                ></i>

                                Belum ada riwayat penjualan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection