@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-main: #090d16;
        --card-bg: #1e293b;
        --card-border: rgba(255, 255, 255, 0.08);
        --accent-indigo: #6366f1;
        --accent-emerald: #10b981;
        --accent-red: #ef4444;
    }

    body {
        background-color: var(--bg-main) !important;
        color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans', 'Instrument Sans', system-ui, sans-serif;
    }

    .card-pro {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border);
        border-radius: 1.25rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    .form-control-dark,
    .form-select-dark {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #f8fafc !important;
        border-radius: 0.75rem !important;
        padding: 0.7rem 1rem;
    }

    .form-control-dark:focus,
    .form-select-dark:focus {
        border-color: var(--accent-indigo) !important;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
    }

    .form-select-dark option {
        background: #0f172a;
        color: #f8fafc;
    }

    .table-pro {
        color: #f1f5f9 !important;
        margin-bottom: 0;
        --bs-table-bg: transparent !important;
    }

    .table-pro th {
        background: #0f172a !important;
        color: #94a3b8 !important;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-bottom: 1px solid rgba(255,255,255,.08) !important;
        padding: 1rem;
    }

    .table-pro td {
        background: transparent !important;
        color: #f1f5f9 !important;
        border-bottom: 1px solid rgba(255,255,255,.05) !important;
        padding: 1rem;
        vertical-align: middle;
    }

    .btn-save {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        font-weight: 700;
        border: none;
        border-radius: .75rem;
        padding: .7rem 1.5rem;
        box-shadow: 0 4px 14px rgba(16,185,129,.35);
        transition: .2s;
    }

    .btn-save:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16,185,129,.5);
    }

    .btn-back {
        background: rgba(148,163,184,.15);
        color: #cbd5e1;
        border: 1px solid rgba(255,255,255,.1);
        font-weight: 600;
        border-radius: .75rem;
        padding: .7rem 1.5rem;
        text-decoration: none;
    }

    .btn-back:hover {
        background: rgba(148,163,184,.25);
        color: #fff;
    }

    .summary-box {
        background: #0f172a;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 1rem;
        padding: 1.25rem;
    }

    .total-value {
        color: #34d399;
        font-size: 1.5rem;
        font-weight: 800;
    }

    .badge-pending {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: rgba(245,158,11,.15);
        color: #fbbf24;
        border: 1px solid rgba(245,158,11,.25);
        border-radius: 999px;
        padding: .4rem .8rem;
        font-size: .8rem;
        font-weight: 700;
    }
</style>

<div class="container py-5">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        <div>
            <h1 class="fw-bold text-white mb-1"
                style="font-size: 2rem;">
                Edit Penjualan
            </h1>

            <p class="mb-0"
                style="color:#94a3b8;">
                Ubah data transaksi yang masih berstatus pending.
            </p>
        </div>

        <div>
            <span class="badge-pending">
                <i class="bi bi-hourglass-split"></i>
                PENDING
            </span>
        </div>

    </div>


    {{-- ERROR VALIDATION --}}
    @if ($errors->any())

        <div class="alert alert-danger"
            style="
                background:rgba(239,68,68,.12);
                border:1px solid rgba(239,68,68,.25);
                color:#fca5a5;
                border-radius:1rem;
            ">

            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM --}}
    <form
        action="{{ route('penjualan.update', $penjualan->id) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        <div class="card card-pro">

            {{-- INFORMASI TRANSAKSI --}}
            <div class="p-4 p-md-5">

                <h5 class="fw-bold text-white mb-4">
                    <i class="bi bi-receipt me-2"
                        style="color:#818cf8;"></i>

                    Informasi Transaksi
                </h5>


                <div class="row g-4">

                    {{-- ID TRANSAKSI --}}
                    <div class="col-12 col-md-4">

                        <label class="form-label fw-bold small"
                            style="color:#cbd5e1;">

                            ID Transaksi

                        </label>

                        <input
                            type="text"
                            class="form-control form-control-dark"
                            value="#{{ $penjualan->id }}"
                            readonly
                        >

                    </div>


                    {{-- KASIR --}}
                    <div class="col-12 col-md-4">

                        <label class="form-label fw-bold small"
                            style="color:#cbd5e1;">

                            Kasir

                        </label>

                        <input
                            type="text"
                            class="form-control form-control-dark"
                            value="{{ $penjualan->user->name ?? '-' }}"
                            readonly
                        >

                    </div>


                    {{-- METODE PEMBAYARAN --}}
                    <div class="col-12 col-md-4">

                        <label class="form-label fw-bold small"
                            style="color:#cbd5e1;">

                            Metode Pembayaran
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="metode_pembayaran"
                            class="form-select form-select-dark"
                            required
                        >

                            <option value="CASH"
                                {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'CASH' ? 'selected' : '' }}>

                                💵 CASH

                            </option>

                            <option value="QRIS"
                                {{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'QRIS' ? 'selected' : '' }}>

                                📱 QRIS

                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- ITEM PENJUALAN --}}
            <div class="px-4 px-md-5 pb-4 pb-md-5">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="fw-bold text-white mb-0">

                        <i class="bi bi-cart3 me-2"
                            style="color:#34d399;"></i>

                        Item Penjualan

                    </h5>

                </div>


                <div class="table-responsive">

                    <table class="table table-pro align-middle">

                        <thead>

                            <tr>

                                <th>
                                    Produk
                                </th>

                                <th class="text-center"
                                    style="width:150px;">

                                    Harga

                                </th>

                                <th class="text-center"
                                    style="width:120px;">

                                    Qty

                                </th>

                                <th class="text-end"
                                    style="width:180px;">

                                    Subtotal

                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($penjualan->itemPenjualan as $item)

                                <tr>

                                    {{-- PRODUK --}}
                                    <td>

                                        <div class="fw-bold">

                                            {{ $item->produk->nama ?? 'Produk tidak ditemukan' }}

                                        </div>

                                    </td>


                                    {{-- HARGA --}}
                                    <td class="text-center">

                                        Rp
                                        {{ number_format(
                                            $item->harga_satuan,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>


                                    {{-- QTY --}}
                                    <td>

                                        <input
                                            type="number"
                                            name="items[{{ $item->id }}][qty]"
                                            value="{{ old(
                                                'items.' . $item->id . '.qty',
                                                $item->kuantitas
                                            ) }}"
                                            min="1"
                                            class="form-control form-control-dark text-center"
                                            required
                                        >

                                    </td>


                                    {{-- SUBTOTAL --}}
                                    <td class="text-end fw-bold"
                                        style="color:#34d399;">

                                        Rp

                                        <span class="subtotal"
                                            data-harga="{{ $item->harga_satuan }}">

                                            {{ number_format(
                                                $item->harga_satuan * $item->kuantitas,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4"
                                        class="text-center py-5"
                                        style="color:#94a3b8;">

                                        <i class="bi bi-cart-x fs-1 d-block mb-2"></i>

                                        Tidak ada item penjualan.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- TOTAL --}}
                <div class="row justify-content-end mt-4">

                    <div class="col-12 col-md-5">

                        <div class="summary-box">

                            <div class="d-flex justify-content-between align-items-center">

                                <span style="color:#94a3b8;">
                                    Total Pembayaran
                                </span>

                                <span
                                    id="totalPembayaran"
                                    class="total-value"
                                >

                                    Rp
                                    {{ number_format(
                                        $penjualan->total_pembayaran,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- BUTTON --}}
            <div
                class="d-flex flex-column flex-md-row justify-content-end gap-2 p-4 p-md-5 pt-0"
            >

                <a
                    href="{{ route('penjualan.index') }}"
                    class="btn-back text-center"
                >

                    <i class="bi bi-arrow-left me-1"></i>

                    Kembali

                </a>


                <button
                    type="submit"
                    class="btn-save"
                >

                    <i class="bi bi-check-circle-fill me-1"></i>

                    Simpan Perubahan

                </button>

            </div>

        </div>

    </form>

</div>


{{-- JAVASCRIPT --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const qtyInputs = document.querySelectorAll(
        'input[name^="items"][name$="[qty]"]'
    );

    const totalElement =
        document.getElementById('totalPembayaran');


    function formatRupiah(number) {

        return new Intl.NumberFormat(
            'id-ID'
        ).format(number);

    }


    function hitungTotal() {

        let total = 0;


        qtyInputs.forEach(function (input) {

            const row =
                input.closest('tr');

            if (!row) {
                return;
            }


            const harga =
                parseFloat(
                    row.querySelector('.subtotal')
                        ?.dataset.harga || 0
                );


            const qty =
                parseInt(
                    input.value || 0
                );


            const subtotal =
                harga * qty;


            const subtotalElement =
                row.querySelector('.subtotal');


            if (subtotalElement) {

                subtotalElement.innerText =
                    formatRupiah(subtotal);

            }


            total += subtotal;

        });


        totalElement.innerText =
            'Rp ' + formatRupiah(total);

    }


    qtyInputs.forEach(function (input) {

        input.addEventListener(
            'input',
            hitungTotal
        );

    });


    hitungTotal();

});

</script>

@endsection