@extends('layouts.app')

@section('title', 'Transaksi Baru - Kasir POS')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-main: #090d16;
        --card-bg: #1e293b;
        --card-border: rgba(255,255,255,.08);
        --accent-indigo: #6366f1;
        --accent-emerald: #10b981;
    }

    body {
        background-color: var(--bg-main) !important;
        color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans',system-ui,-apple-system,sans-serif;
    }

    .card-pro {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border);
        border-radius: 1.25rem;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,.4);
    }

    .card-header-pro {
        background: #0f172a !important;
        border-bottom: 1px solid rgba(255,255,255,.08) !important;
        padding: 1rem 1.25rem;
        border-radius: 1.25rem 1.25rem 0 0;
    }

    .product-card {
        background: #0f172a;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 1rem;
        padding: 1rem;
        transition: .2s;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-card:hover {
        border-color: #6366f1;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(99,102,241,.3);
    }

    .product-img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: .75rem;
        margin-bottom: .75rem;
    }

    .form-control-dark,
    .form-select-dark {
        background-color: #0f172a !important;
        border: 1px solid rgba(255,255,255,.1) !important;
        color: #f8fafc !important;
        border-radius: .75rem !important;
        padding: .65rem 1rem;
    }

    .form-control-dark:focus,
    .form-select-dark:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 .25rem rgba(99,102,241,.25) !important;
    }

    #metodePembayaran {
        background-color: #0f172a !important;
        color: #fff !important;
        border: 1px solid rgba(255,255,255,.15) !important;
        border-radius: .75rem !important;
        padding: .75rem 1rem;
    }

    #metodePembayaran option {
        background: #1e293b !important;
        color: #fff !important;
    }

    .table-cart {
        color: #f1f5f9 !important;
        margin-bottom: 0;
    }

    .table-cart th {
        background: #0f172a !important;
        color: #94a3b8 !important;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255,255,255,.08) !important;
        padding: .75rem;
    }

    .table-cart td {
        border-bottom: 1px solid rgba(255,255,255,.05) !important;
        padding: .75rem;
        vertical-align: middle;
    }

    .btn-checkout {
        background: linear-gradient(135deg,#10b981 0%,#059669 100%);
        color: #fff;
        font-weight: 700;
        border-radius: .75rem;
        padding: .85rem;
        border: none;
        box-shadow: 0 4px 14px rgba(16,185,129,.4);
        width: 100%;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        color: #fff;
    }

    .btn-checkout:disabled {
        opacity: .45;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-back-pro {
        background: rgba(148,163,184,.15);
        color: #cbd5e1;
        border: 1px solid rgba(255,255,255,.1);
        font-weight: 600;
        border-radius: .75rem;
        padding: .65rem 1.25rem;
        text-decoration: none;
    }

    .btn-back-pro:hover {
        background: rgba(148,163,184,.25);
        color: #fff;
    }

    .modal-dark {
        background: #1e293b !important;
        color: #f8fafc !important;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 1.25rem;
    }

    .modal-dark .modal-header {
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .modal-dark .modal-footer {
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .payment-box {
        background: rgba(16,185,129,.1);
        border: 1px solid rgba(16,185,129,.2);
        border-radius: .75rem;
    }

    .change-box {
        background: rgba(99,102,241,.1);
        border: 1px solid rgba(99,102,241,.25);
        border-radius: .75rem;
    }

    .change-box.error {
        background: rgba(239,68,68,.1);
        border-color: rgba(239,68,68,.3);
    }

    .input-group-text-dark {
        background: #1e293b !important;
        color: #94a3b8 !important;
        border: 1px solid rgba(255,255,255,.1) !important;
        border-right: none !important;
    }

    #uangDibayar {
        border-left: none !important;
    }

    /* Membuat tulisan "Masukkan uang pembayaran" menjadi putih */
    #uangDibayar::placeholder {
        color: #ffffff !important;
        opacity: 1 !important;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-black text-white mb-1" style="font-size:1.75rem;">
                <i class="bi bi-calculator me-2" style="color:#818cf8;"></i>
                Kasir Transaksi
            </h1>

            <p class="mb-0 small" style="color:#94a3b8;">
                Pilih produk untuk ditambahkan ke keranjang belanja.
            </p>
        </div>

        <a href="{{ route('penjualan.index') }}" class="btn btn-back-pro">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Riwayat
        </a>
    </div>

    <form action="{{ route('penjualan.store') }}" method="POST" id="formKasir">
        @csrf

        <div class="row g-4">

            {{-- PRODUK --}}
            <div class="col-12 col-lg-7 col-xl-8">

                <div class="card card-pro p-3 mb-4">
                    <div class="input-group">

                        <span class="input-group-text border-0"
                              style="background:#0f172a;color:#94a3b8;border-radius:.75rem 0 0 .75rem;">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text"
                               id="searchProduk"
                               class="form-control form-control-dark border-start-0"
                               placeholder="Cari nama produk..."
                               style="border-radius:0 .75rem .75rem 0 !important;">
                    </div>
                </div>

                <div class="row g-3" id="daftarProduk">

                    @forelse($produks as $item)

                        <div class="col-6 col-md-4 col-xl-3 item-produk-wrapper"
                             data-nama="{{ strtolower($item->nama) }}">

                            <div class="product-card"
                                 onclick="addToCart({{ $item->id }}, '{{ addslashes($item->nama) }}', {{ $item->harga_jual }}, {{ $item->stok }})">

                                <div>

                                    @if($item->foto)
                                        <img src="{{ asset('storage/'.$item->foto) }}"
                                             alt="{{ $item->nama }}"
                                             class="product-img">
                                    @else
                                        <div class="product-img d-flex align-items-center justify-content-center bg-slate-800 text-slate-500">
                                            <i class="bi bi-image fs-2"></i>
                                        </div>
                                    @endif

                                    <h6 class="fw-bold text-white mb-1 text-truncate"
                                        title="{{ $item->nama }}">
                                        {{ $item->nama }}
                                    </h6>

                                    <div class="small mb-2" style="color:#94a3b8;">
                                        Stok:
                                        <span class="fw-bold text-white">
                                            {{ $item->stok }}
                                        </span>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-secondary border-opacity-10">

                                    <span class="fw-bold font-monospace" style="color:#34d399;">
                                        Rp {{ number_format($item->harga_jual,0,',','.') }}
                                    </span>

                                    <button type="button"
                                            class="btn btn-sm rounded-circle"
                                            style="background:#6366f1;color:white;">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12 text-center py-5" style="color:#94a3b8;">
                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                            Belum ada data produk berstok yang tersedia.
                        </div>

                    @endforelse

                </div>
            </div>


            {{-- KERANJANG --}}
            <div class="col-12 col-lg-5 col-xl-4">

                <div class="card card-pro">

                    <div class="card-header-pro d-flex justify-content-between align-items-center">

                        <h6 class="fw-bold text-white mb-0">
                            <i class="bi bi-cart3 me-2" style="color:#38bdf8;"></i>
                            Keranjang Belanja
                        </h6>

                        <button type="button"
                                class="btn btn-sm text-danger p-0"
                                onclick="clearCart()">
                            <i class="bi bi-trash"></i>
                            Kosongkan
                        </button>

                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive"
                             style="max-height:300px;overflow-y:auto;">

                            <table class="table table-cart align-middle">

                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center" style="width:80px;">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                        <th style="width:40px;"></th>
                                    </tr>
                                </thead>

                                <tbody id="cartTableBody">

                                    <tr>
                                        <td colspan="4"
                                            class="text-center py-4 small"
                                            style="color:#94a3b8;">
                                            Keranjang masih kosong.<br>
                                            Klik produk di sebelah kiri.
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{-- PEMBAYARAN --}}
                    <div class="card-footer p-4"
                         style="background:#0f172a;border-top:1px solid rgba(255,255,255,.08);">

                        <div class="mb-3">

                            <label class="form-label fw-bold small" style="color:#cbd5e1;">
                                Metode Pembayaran
                            </label>

                            <select name="metode_pembayaran"
                                    id="metodePembayaran"
                                    class="form-select form-select-dark"
                                    required>

                                <option value="QRIS">QRIS</option>
                                <option value="CASH">CASH / TUNAI</option>

                            </select>

                        </div>


                        {{-- UANG DIBAYAR --}}
                        <div id="boxUangDibayar" class="mb-3" style="display:none;">

                            <label class="form-label fw-bold small" style="color:#cbd5e1;">
                                Uang Dibayar
                            </label>

                            <div class="input-group">

                                <span class="input-group-text input-group-text-dark">
                                    Rp
                                </span>

                                <input type="number"
                                       id="uangDibayar"
                                       name="uang_dibayar"
                                       class="form-control form-control-dark"
                                       placeholder="Masukkan uang pembayaran"
                                       min="0"
                                       step="1"
                                       autocomplete="off">

                            </div>

                            <small id="pesanUang"
                                   class="d-block mt-2"></small>

                        </div>


                        {{-- TOTAL --}}
                        <div class="payment-box p-3 mb-3">

                            <div class="small" style="color:#94a3b8;">
                                Total Pembayaran
                            </div>

                            <div class="fs-2 font-monospace fw-black"
                                 style="color:#34d399;"
                                 id="displayTotal">
                                Rp 0
                            </div>

                        </div>


                        {{-- KEMBALIAN --}}
                        <div id="boxKembalian"
                             class="change-box p-3 mb-3"
                             style="display:none;">

                            <div class="small" style="color:#94a3b8;">
                                Kembalian
                            </div>

                            <div id="displayKembalian"
                                 class="fs-3 font-monospace fw-black"
                                 style="color:#818cf8;">
                                Rp 0
                            </div>

                            <input type="hidden"
                                   name="kembalian"
                                   id="inputKembalian"
                                   value="0">

                        </div>


                        <button type="button"
                                class="btn btn-checkout fw-bold d-flex align-items-center justify-content-center gap-2"
                                id="btnSubmit"
                                onclick="handleCheckout()"
                                disabled>

                            <i class="bi bi-check-circle-fill"></i>
                            Selesaikan Transaksi

                        </button>

                    </div>

                </div>
            </div>

        </div>
    </form>
</div>


{{-- MODAL QRIS --}}
<div class="modal fade"
     id="modalQris"
     tabindex="-1"
     aria-hidden="true"
     data-bs-backdrop="static">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content modal-dark text-center">

            <div class="modal-header justify-content-center">

                <h5 class="modal-title fw-bold text-white">
                    <i class="bi bi-qr-code-scan me-2" style="color:#818cf8;"></i>
                    Pembayaran QRIS
                </h5>

            </div>

            <div class="modal-body p-4">

                <p class="mb-2 small" style="color:#cbd5e1;">
                    Pindai kode QR di bawah ini menggunakan aplikasi
                    M-Banking atau E-Wallet.
                </p>

                <div class="bg-dark p-2 rounded mb-3 border border-secondary border-opacity-25">

                    <span class="small d-block" style="color:#94a3b8;">
                        Total tagihan:
                    </span>

                    <span class="fs-3 fw-bold font-monospace"
                          style="color:#34d399;"
                          id="qrisTotalDisplay">
                        Rp 0
                    </span>

                </div>

                <div class="bg-white p-3 rounded-4 d-inline-block shadow-lg my-2">

                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=QRIS_DEMO_POS"
                         alt="QRIS Code"
                         class="img-fluid"
                         style="max-width:220px;">

                </div>

                <div class="mt-3">

                    <span class="badge px-3 py-2 rounded-pill small"
                          style="background:rgba(16,185,129,.15);color:#34d399;">

                        <i class="bi bi-clock me-1"></i>
                        Menunggu Konfirmasi Pembayaran

                    </span>

                </div>

            </div>

            <div class="modal-footer d-flex gap-2">

                <button type="button"
                        class="btn btn-outline-secondary btn-sm rounded-3 flex-fill"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="button"
                        class="btn btn-checkout btn-sm rounded-3 flex-fill"
                        onclick="submitFormDirectly()">

                    <i class="bi bi-check2-circle me-1"></i>
                    Konfirmasi & Simpan

                </button>

            </div>

        </div>

    </div>

</div>


<script>
    let cart = [];
    let currentGrandTotal = 0;

    const metode = document.getElementById('metodePembayaran');
    const uang = document.getElementById('uangDibayar');
    const boxUang = document.getElementById('boxUangDibayar');
    const boxKembalian = document.getElementById('boxKembalian');
    const displayKembalian = document.getElementById('displayKembalian');
    const inputKembalian = document.getElementById('inputKembalian');
    const pesanUang = document.getElementById('pesanUang');
    const btnSubmit = document.getElementById('btnSubmit');

    const rupiah = n => 'Rp ' + Number(n || 0).toLocaleString('id-ID');


    // SEARCH
    document.getElementById('searchProduk').addEventListener('input', function () {
        const q = this.value.toLowerCase();

        document.querySelectorAll('.item-produk-wrapper').forEach(item => {
            item.style.display =
                item.dataset.nama.includes(q) ? 'block' : 'none';
        });
    });


    // CART
    function addToCart(id, nama, harga, stok) {
        const item = cart.find(i => i.id === id);

        if (item) {
            if (item.qty < stok) item.qty++;
            else alert('Jumlah melebihi stok yang tersedia!');
        } else {
            cart.push({
                id,
                nama,
                harga: Number(harga),
                stok: Number(stok),
                qty: 1
            });
        }

        renderCart();
    }

    function updateQty(id, qty) {
        const item = cart.find(i => i.id === id);
        qty = parseInt(qty) || 0;

        if (!item) return;

        if (qty > item.stok) {
            alert('Jumlah melebihi stok tersedia!');
            item.qty = item.stok;
        } else if (qty <= 0) {
            removeFromCart(id);
            return;
        } else {
            item.qty = qty;
        }

        renderCart();
    }

    function removeFromCart(id) {
        cart = cart.filter(i => i.id !== id);
        renderCart();
    }

    function clearCart() {
        cart = [];
        renderCart();
    }


    // RENDER CART
    function renderCart() {
        const tbody = document.getElementById('cartTableBody');
        tbody.innerHTML = '';

        if (!cart.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 small" style="color:#94a3b8;">
                        Keranjang masih kosong.<br>
                        Klik produk di sebelah kiri.
                    </td>
                </tr>`;
            currentGrandTotal = 0;
            document.getElementById('displayTotal').innerText = 'Rp 0';
            btnSubmit.disabled = true;
            hitungKembalian();
            return;
        }

        let total = 0;

        cart.forEach((item, index) => {
            const subtotal = item.harga * item.qty;
            total += subtotal;

            tbody.innerHTML += `
                <tr>
                    <td>
                        <span class="fw-semibold text-white d-block text-truncate" style="max-width:120px;">
                            ${item.nama}
                        </span>

                        <small style="color:#94a3b8;">
                            @ Rp ${item.harga.toLocaleString('id-ID')}
                        </small>

                        <input type="hidden"
                               name="items[${index}][produk_id]"
                               value="${item.id}">

                        <input type="hidden"
                               name="items[${index}][harga]"
                               value="${item.harga}">
                    </td>

                    <td class="text-center">
                        <input type="number"
                               name="items[${index}][qty]"
                               class="form-control form-control-sm form-control-dark text-center px-1"
                               value="${item.qty}"
                               min="1"
                               max="${item.stok}"
                               onchange="updateQty(${item.id},this.value)">
                    </td>

                    <td class="text-end font-monospace fw-bold" style="color:#34d399;">
                        ${rupiah(subtotal)}
                    </td>

                    <td class="text-center">
                        <button type="button"
                                class="btn btn-sm text-danger p-0"
                                onclick="removeFromCart(${item.id})">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </td>
                </tr>`;
        });

        currentGrandTotal = total;
        document.getElementById('displayTotal').innerText = rupiah(total);

        if (metode.value === 'CASH') hitungKembalian();
        else btnSubmit.disabled = false;
    }


    // PEMBAYARAN
    function updatePaymentMethod() {
        if (metode.value === 'CASH') {
            boxUang.style.display = 'block';
            boxKembalian.style.display = 'block';
            hitungKembalian();
        } else {
            boxUang.style.display = 'none';
            boxKembalian.style.display = 'none';
            uang.value = '';
            inputKembalian.value = 0;
            displayKembalian.innerText = 'Rp 0';
            pesanUang.innerText = '';
            btnSubmit.disabled = cart.length === 0;
        }
    }

    function hitungKembalian() {
        if (metode.value !== 'CASH') return;

        const dibayar = Number(uang.value) || 0;
        const total = Number(currentGrandTotal) || 0;

        if (!total || !dibayar) {
            displayKembalian.innerText = 'Rp 0';
            inputKembalian.value = 0;
            pesanUang.innerText = total ? 'Masukkan jumlah uang pembayaran.' : '';
            pesanUang.style.color = '#fbbf24';
            btnSubmit.disabled = true;
            boxKembalian.classList.remove('error');
            return;
        }

        if (dibayar < total) {
            const kurang = total - dibayar;

            displayKembalian.innerText = 'Rp 0';
            inputKembalian.value = 0;
            pesanUang.innerText = 'Uang kurang ' + rupiah(kurang);
            pesanUang.style.color = '#f87171';
            boxKembalian.classList.add('error');
            displayKembalian.style.color = '#f87171';
            btnSubmit.disabled = true;
            return;
        }

        const kembalian = dibayar - total;

        displayKembalian.innerText = rupiah(kembalian);
        inputKembalian.value = kembalian;
        pesanUang.innerText = 'Pembayaran sudah cukup.';
        pesanUang.style.color = '#34d399';
        displayKembalian.style.color = '#818cf8';
        boxKembalian.classList.remove('error');
        btnSubmit.disabled = false;
    }


    metode.addEventListener('change', updatePaymentMethod);
    uang.addEventListener('input', hitungKembalian);


    // CHECKOUT
    function handleCheckout() {
        if (!cart.length) {
            alert('Keranjang masih kosong.');
            return;
        }

        if (metode.value === 'CASH') {
            const dibayar = Number(uang.value) || 0;

            if (!dibayar) {
                alert('Silakan masukkan uang pembayaran terlebih dahulu.');
                uang.focus();
                return;
            }

            if (dibayar < currentGrandTotal) {
                alert('Uang pembayaran kurang ' +
                    rupiah(currentGrandTotal - dibayar));
                uang.focus();
                return;
            }

            hitungKembalian();
            submitFormDirectly();
            return;
        }

        document.getElementById('qrisTotalDisplay').innerText =
            rupiah(currentGrandTotal);

        new bootstrap.Modal(
            document.getElementById('modalQris')
        ).show();
    }


    function submitFormDirectly() {
        if (!cart.length) {
            alert('Keranjang masih kosong.');
            return;
        }

        document.getElementById('formKasir').submit();
    }

    updatePaymentMethod();
</script>

@endsection