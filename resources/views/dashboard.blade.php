@extends('layouts.app')

@section('title', 'Dashboard - Executive Cosmic Analytics')

@section('content')

    @include('layouts.navbar')

    <style>
        /* ==========================================================================
           1. CSS ROOT — DEEP COSMIC / INDIGO-VIOLET
           ========================================================================== */
        :root {
            --bg-app-base: #07060f;
            --bg-main: #0c0a16;
            --bg-surface: #13111f;
            --bg-surface-glass: rgba(19, 17, 31, 0.82);

            --card-bg: rgba(19, 17, 31, 0.9);
            --card-border: rgba(139, 92, 246, 0.18);
            --card-border-hover: rgba(167, 139, 250, 0.5);

            --accent-primary: #8b5cf6;
            --accent-light: #a78bfa;
            --accent-cyan: #22d3ee;
            --accent-indigo: #6366f1;
            --accent-emerald: #34d399;
            --accent-amber: #fbbf24;
            --accent-rose: #fb7185;
            --accent-fuchsia: #e879f9;

            --text-main: #f5f3ff;
            --text-muted: #a5b4c8;
            --text-subtle: #6b7280;

            --shadow-subtle: 0 14px 36px -12px rgba(0, 0, 0, 0.75);
            --shadow-hover: 0 24px 55px -16px rgba(139, 92, 246, 0.38);

            --radius-card: 1.5rem;
            --radius-box: 1.15rem;
        }

        body {
            background-color: var(--bg-app-base) !important;
            background-image:
                radial-gradient(at 0% 0%, rgba(109, 40, 217, 0.16) 0px, transparent 52%),
                radial-gradient(at 100% 100%, rgba(6, 182, 212, 0.1) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(139, 92, 246, 0.04) 0px, transparent 70%) !important;
            background-attachment: fixed !important;
            color: var(--text-main) !important;
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important;
            letter-spacing: -0.015em;
            overflow-x: hidden;
        }

        @keyframes panelFadeInUp {
            0% { opacity: 0; transform: translateY(24px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseLiveIndicator {
            0% { transform: scale(0.92); box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.65); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(52, 211, 153, 0); }
            100% { transform: scale(0.92); box-shadow: 0 0 0 0 rgba(52, 211, 153, 0); }
        }

        .anim-fade {
            animation: panelFadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.12s; }
        .delay-3 { animation-delay: 0.19s; }
        .delay-4 { animation-delay: 0.26s; }
        .delay-5 { animation-delay: 0.33s; }

        /* ==========================================================================
           2. GLASS CARDS — LEBIH BESAR
           ========================================================================== */
        .dashboard-card {
            background: var(--card-bg) !important;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-card);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(167, 139, 250, 0.45), transparent);
            opacity: 0.7;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            border-color: var(--card-border-hover);
            box-shadow: var(--shadow-hover);
        }

        /* ==========================================================================
           3. STAT GRADIENTS
           ========================================================================== */
        .grad-sales {
            background: linear-gradient(135deg, rgba(19, 17, 31, 0.97) 0%, rgba(76, 29, 149, 0.5) 100%) !important;
        }
        .grad-trx {
            background: linear-gradient(135deg, rgba(19, 17, 31, 0.97) 0%, rgba(8, 145, 178, 0.48) 100%) !important;
        }
        .grad-cash {
            background: linear-gradient(135deg, rgba(19, 17, 31, 0.97) 0%, rgba(6, 95, 70, 0.5) 100%) !important;
        }
        .grad-qris {
            background: linear-gradient(135deg, rgba(19, 17, 31, 0.97) 0%, rgba(112, 26, 117, 0.48) 100%) !important;
        }

        /* ==========================================================================
           4. ICON — LEBIH BESAR
           ========================================================================== */
        .stat-icon-wrap {
            width: 68px;
            height: 68px;
            border-radius: var(--radius-box);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.85rem;
            transition: transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
        }

        .dashboard-card:hover .stat-icon-wrap {
            transform: scale(1.12) rotate(5deg);
        }

        /* ==========================================================================
           5. LIVE STATUS
           ========================================================================== */
        .live-status-pill {
            background: rgba(19, 17, 31, 0.88);
            border: 1px solid rgba(139, 92, 246, 0.28);
            backdrop-filter: blur(12px);
            padding: 0.65rem 1.35rem;
            border-radius: 50rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25);
        }

        .live-dot {
            width: 11px;
            height: 11px;
            background-color: var(--accent-emerald);
            border-radius: 50%;
            display: inline-block;
            animation: pulseLiveIndicator 2s infinite;
        }

        /* ==========================================================================
           6. TABLE — LEBIH BESAR
           ========================================================================== */
        .table-enterprise {
            color: var(--text-main) !important;
            margin-bottom: 0 !important;
            --bs-table-bg: transparent !important;
            --bs-table-border-color: rgba(139, 92, 246, 0.09);
        }

        .table-enterprise thead th {
            background-color: rgba(10, 8, 20, 0.9) !important;
            color: var(--text-muted) !important;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-bottom: 1px solid rgba(139, 92, 246, 0.16) !important;
            padding: 1.35rem 1.5rem;
        }

        .table-enterprise tbody td {
            border-bottom: 1px solid rgba(139, 92, 246, 0.07) !important;
            padding: 1.3rem 1.5rem;
            vertical-align: middle;
            color: #e0e7ff !important;
            font-size: 1rem;
            transition: background-color 0.2s ease;
        }

        .table-enterprise tbody tr:last-child td {
            border-bottom: none !important;
        }

        .table-enterprise tbody tr:hover td {
            background-color: rgba(139, 92, 246, 0.06) !important;
        }

        /* ==========================================================================
           7. RANK BADGES
           ========================================================================== */
        .rank-indicator {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .badge-gold {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.28), rgba(217, 119, 6, 0.28));
            color: #fcd34d;
            border: 1px solid rgba(251, 191, 36, 0.45);
        }
        .badge-silver {
            background: linear-gradient(135deg, rgba(148, 163, 184, 0.28), rgba(100, 116, 139, 0.28));
            color: #e2e8f0;
            border: 1px solid rgba(148, 163, 184, 0.45);
        }
        .badge-bronze {
            background: linear-gradient(135deg, rgba(180, 83, 9, 0.28), rgba(146, 64, 14, 0.28));
            color: #fb923c;
            border: 1px solid rgba(180, 83, 9, 0.45);
        }

        .table-responsive::-webkit-scrollbar { height: 7px; }
        .table-responsive::-webkit-scrollbar-track { background: rgba(7, 6, 15, 0.5); }
        .table-responsive::-webkit-scrollbar-thumb {
            background: rgba(139, 92, 246, 0.3);
            border-radius: 4px;
        }
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: rgba(139, 92, 246, 0.55);
        }
    </style>

    {{-- CONTAINER LEBIH LEBAR --}}
    <div class="container-fluid px-4 px-lg-5 py-4 py-lg-5" style="max-width: 1600px; margin: 0 auto;">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-4 mb-4 border-bottom anim-fade delay-1"
             style="border-color: rgba(139, 92, 246, 0.2) !important;">
            <div>
                <div class="d-flex align-items-center gap-2 fw-semibold mb-2"
                     style="color: var(--accent-light); letter-spacing: 0.04em; font-size: 0.95rem;">
                    <i class="bi bi-calendar-event fs-5"></i>
                    <span>{{ $tanggalHariIni->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 class="fw-extrabold text-white mb-0" style="font-size: 2.6rem; letter-spacing: -0.04em; line-height: 1.15;">
                    Dashboard Analitik
                </h1>
            </div>
            <div class="mt-3 mt-md-0">
                <div class="live-status-pill">
                    <span class="live-dot"></span>
                    <span class="fw-semibold" style="font-size: 0.92rem; color: #e0e7ff;">
                        Sistem Berjalan Normal &amp; Sinkron
                    </span>
                </div>
            </div>
        </div>

        {{-- METRIK FINANSIAL --}}
        @can('viewAny', App\Models\User::class)
            <div class="mb-5">
                <div class="d-flex align-items-center justify-content-between mb-4 anim-fade delay-1">
                    <h5 class="fw-bold text-white mb-0 d-flex align-items-center gap-2" style="font-size: 1.35rem;">
                        <i class="bi bi-pie-chart-fill" style="color: var(--accent-primary); font-size: 1.4rem;"></i>
                        Metrik Finansial &amp; Kinerja Penjualan
                    </h5>
                </div>

                <div class="row g-4">
                    {{-- Total Penjualan --}}
                    <div class="col-12 col-sm-6 col-xl-3 anim-fade delay-1">
                        <div class="dashboard-card grad-sales p-4 p-lg-5">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-uppercase fw-bold d-block mb-2"
                                          style="font-size: 0.8rem; letter-spacing: 0.1em; color: var(--text-muted);">
                                        Total Penjualan
                                    </span>
                                    <h3 class="fw-bold text-white mb-0"
                                        style="font-size: 1.85rem; letter-spacing: -0.03em; line-height: 1.2;">
                                        Rp {{ number_format($ringkasan['total_penjualan']) }}
                                    </h3>
                                </div>
                                <div class="stat-icon-wrap"
                                     style="background: rgba(139, 92, 246, 0.2); color: var(--accent-light); border: 1px solid rgba(139, 92, 246, 0.4);">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Transaksi --}}
                    <div class="col-12 col-sm-6 col-xl-3 anim-fade delay-2">
                        <div class="dashboard-card grad-trx p-4 p-lg-5">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-uppercase fw-bold d-block mb-2"
                                          style="font-size: 0.8rem; letter-spacing: 0.1em; color: var(--text-muted);">
                                        Total Transaksi
                                    </span>
                                    <h3 class="fw-bold text-white mb-0"
                                        style="font-size: 1.85rem; letter-spacing: -0.03em; line-height: 1.2;">
                                        {{ number_format($ringkasan['total_transaksi']) }}
                                        <span class="fs-5 fw-normal" style="color: var(--text-muted);">trx</span>
                                    </h3>
                                </div>
                                <div class="stat-icon-wrap"
                                     style="background: rgba(34, 211, 238, 0.18); color: var(--accent-cyan); border: 1px solid rgba(34, 211, 238, 0.38);">
                                    <i class="bi bi-receipt-cutoff"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tunai --}}
                    <div class="col-12 col-sm-6 col-xl-3 anim-fade delay-3">
                        <div class="dashboard-card grad-cash p-4 p-lg-5">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-uppercase fw-bold d-block mb-2"
                                          style="font-size: 0.8rem; letter-spacing: 0.1em; color: var(--text-muted);">
                                        Pembayaran Tunai
                                    </span>
                                    <h3 class="fw-bold mb-0"
                                        style="color: #6ee7b7; font-size: 1.85rem; letter-spacing: -0.03em; line-height: 1.2;">
                                        Rp {{ number_format($ringkasan['total_cash']) }}
                                    </h3>
                                </div>
                                <div class="stat-icon-wrap"
                                     style="background: rgba(52, 211, 153, 0.18); color: #6ee7b7; border: 1px solid rgba(52, 211, 153, 0.38);">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Non-Tunai / QRIS --}}
                    <div class="col-12 col-sm-6 col-xl-3 anim-fade delay-4">
                        <div class="dashboard-card grad-qris p-4 p-lg-5">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-uppercase fw-bold d-block mb-2"
                                          style="font-size: 0.8rem; letter-spacing: 0.1em; color: var(--text-muted);">
                                        Non-Tunai / QRIS
                                    </span>
                                    <h3 class="fw-bold mb-0"
                                        style="color: #f0abfc; font-size: 1.85rem; letter-spacing: -0.03em; line-height: 1.2;">
                                        Rp {{ number_format($ringkasan['total_non_tunai']) }}
                                    </h3>
                                </div>
                                <div class="stat-icon-wrap"
                                     style="background: rgba(232, 121, 249, 0.18); color: #f0abfc; border: 1px solid rgba(232, 121, 249, 0.38);">
                                    <i class="bi bi-qr-code-scan"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        {{-- PERINGATAN STOK --}}
        <div class="mb-5 anim-fade delay-2">
            <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2" style="font-size: 1.35rem;">
                <i class="bi bi-shield-exclamation" style="color: var(--accent-amber); font-size: 1.4rem;"></i>
                Peringatan Kritis Inventaris Stok
            </h5>

            <div class="row g-4">
                {{-- Stok Menipis --}}
                <div class="col-12 col-lg-6">
                    <div class="dashboard-card h-100">
                        <div class="p-3 px-4 d-flex justify-content-between align-items-center"
                             style="background: rgba(10, 8, 20, 0.7); border-bottom: 1px solid rgba(139, 92, 246, 0.12); border-top-left-radius: var(--radius-card); border-top-right-radius: var(--radius-card);">
                            <span class="fw-bold d-flex align-items-center gap-2"
                                  style="color: #fbbf24; font-size: 1.05rem;">
                                <i class="bi bi-exclamation-triangle-fill"></i> Stok Menipis (&lt; 5)
                            </span>
                            <span class="badge rounded-pill fw-semibold px-3 py-1.5"
                                  style="background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.35); font-size: 0.8rem;">
                                Perhatian
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-enterprise align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 60px;">#</th>
                                        <th>Nama Produk</th>
                                        <th class="text-center" style="width: 110px;">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkStokRendah as $index => $produk)
                                        <tr>
                                            <td class="text-center text-muted fw-medium">
                                                {{ $produkStokRendah->firstItem() + $index }}
                                            </td>
                                            <td class="fw-semibold text-white" style="font-size: 1.02rem;">
                                                {{ $produk->nama }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge px-3 py-2 rounded-pill fw-bold"
                                                      style="background: rgba(251, 191, 36, 0.16); color: #fbbf24; font-size: 0.9rem;">
                                                    {{ $produk->stok }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5 text-muted" style="font-size: 1rem;">
                                                <i class="bi bi-check-circle-fill fs-1 d-block mb-2"
                                                   style="color: var(--accent-emerald);"></i>
                                                Aman, tidak ada produk dengan stok menipis.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($produkStokRendah->hasPages())
                            <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
                                {{ $produkStokRendah->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Stok Habis --}}
                <div class="col-12 col-lg-6">
                    <div class="dashboard-card h-100">
                        <div class="p-3 px-4 d-flex justify-content-between align-items-center"
                             style="background: rgba(10, 8, 20, 0.7); border-bottom: 1px solid rgba(139, 92, 246, 0.12); border-top-left-radius: var(--radius-card); border-top-right-radius: var(--radius-card);">
                            <span class="fw-bold d-flex align-items-center gap-2"
                                  style="color: #fb7185; font-size: 1.05rem;">
                                <i class="bi bi-x-circle-fill"></i> Stok Habis (0)
                            </span>
                            <span class="badge rounded-pill fw-semibold px-3 py-1.5"
                                  style="background: rgba(251, 113, 133, 0.15); color: #fb7185; border: 1px solid rgba(251, 113, 133, 0.35); font-size: 0.8rem;">
                                Kritis
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-enterprise align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 60px;">#</th>
                                        <th>Nama Produk</th>
                                        <th class="text-center" style="width: 110px;">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkStokHabis as $index => $produk)
                                        <tr>
                                            <td class="text-center text-muted fw-medium">
                                                {{ $produkStokHabis->firstItem() + $index }}
                                            </td>
                                            <td class="fw-semibold text-white" style="font-size: 1.02rem;">
                                                {{ $produk->nama }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge px-3 py-2 rounded-pill fw-bold"
                                                      style="background: rgba(251, 113, 133, 0.16); color: #fb7185; font-size: 0.9rem;">
                                                    {{ $produk->stok }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5 text-muted" style="font-size: 1rem;">
                                                <i class="bi bi-box-seam fs-1 text-muted opacity-50 d-block mb-2"></i>
                                                Sangat baik, tidak ada produk yang habis total.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($produkStokHabis->hasPages())
                            <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
                                {{ $produkStokHabis->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- PRODUK TERLARIS --}}
        <div class="mb-4 anim-fade delay-3">
            <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2" style="font-size: 1.35rem;">
                <i class="bi bi-trophy-fill" style="color: #fbbf24; font-size: 1.4rem;"></i>
                Peringkat Produk Terlaris (Leaderboard)
            </h5>

            <div class="dashboard-card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-enterprise align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 120px;">Peringkat</th>
                                <th>Nama Produk</th>
                                <th class="text-center">Sisa Stok Gudang</th>
                                <th class="text-end pe-4">Total Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkTerlaris as $index => $produk)
                                <tr>
                                    <td class="ps-4">
                                        @if ($index == 0)
                                            <span class="rank-indicator badge-gold">1</span>
                                        @elseif ($index == 1)
                                            <span class="rank-indicator badge-silver">2</span>
                                        @elseif ($index == 2)
                                            <span class="rank-indicator badge-bronze">3</span>
                                        @else
                                            <span class="text-muted fw-bold ps-2" style="font-size: 1rem;">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-white" style="font-size: 1.05rem;">
                                        {{ $produk->nama }}
                                    </td>
                                    <td class="text-center text-muted font-monospace" style="font-size: 1rem;">
                                        {{ $produk->stok }} unit
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="badge fw-bold px-3 py-2 rounded-pill"
                                              style="background: rgba(139, 92, 246, 0.18); color: #c4b5fd; border: 1px solid rgba(139, 92, 246, 0.35); font-size: 0.9rem;">
                                            {{ number_format($produk->total_terjual) }} terjual
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted" style="font-size: 1rem;">
                                        <i class="bi bi-bar-chart fs-1 text-muted opacity-50 d-block mb-2"></i>
                                        Belum ada riwayat transaksi penjualan yang terekam pada sistem.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection