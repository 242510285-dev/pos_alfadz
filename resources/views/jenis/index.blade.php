@extends('layouts.app')

@section('title', 'Jenis Produk')

@section('content')

@include('layouts.navbar')

<style>
    body {
        background: #080d19;
        color: #f8fafc;
    }

    .jenis-page {
        padding: 35px 0;
    }

    .jenis-container {
        max-width: 1135px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .page-header {
        margin-bottom: 28px;
    }

    .page-title {
        font-size: 30px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #ffffff;
        font-size: 28px;
    }

    .page-subtitle {
        color: #94a3b8;
        font-size: 15px;
        margin: 0;
    }

    .jenis-card {
        background: #111827;
        border: 1px solid #263247;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .20);
    }

    .jenis-toolbar {
        padding: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        border-bottom: 1px solid #263247;
    }

    .search-form {
        display: flex;
        width: 430px;
        max-width: 100%;
    }

    .search-input {
        flex: 1;
        height: 42px;
        background: #0f172a;
        border: 1px solid #334155;
        border-right: none;
        border-radius: 7px 0 0 7px;
        color: #ffffff;
        padding: 0 13px;
        outline: none;
        font-size: 14px;
    }

    .search-input::placeholder {
        color: #64748b;
    }

    .search-input:focus {
        border-color: #6366f1;
    }

    .btn-search {
        height: 42px;
        min-width: 72px;
        border: none;
        border-radius: 0 7px 7px 0;
        background: #6366f1;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .btn-search:hover {
        background: #4f46e5;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        height: 42px;
        padding: 0 17px;
        background: #6366f1;
        color: #ffffff;
        border-radius: 7px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        transition: .2s;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #4f46e5;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .jenis-table {
        width: 100%;
        border-collapse: collapse;
    }

    .jenis-table thead {
        background: #0f172a;
    }

    .jenis-table th {
        padding: 15px 18px;
        color: #94a3b8;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        text-align: left;
        border-bottom: 1px solid #334155;
        white-space: nowrap;
    }

    .jenis-table td {
        padding: 15px 18px;
        color: #cbd5e1;
        font-size: 14px;
        border-bottom: 1px solid rgba(51, 65, 85, .55);
    }

    .jenis-table tbody tr {
        transition: .2s;
    }

    .jenis-table tbody tr:hover {
        background: rgba(30, 41, 59, .45);
    }

    .jenis-table th:first-child,
    .jenis-table td:first-child {
        width: 60px;
    }

    .jenis-table th:last-child,
    .jenis-table td:last-child {
        width: 180px;
    }

    .nama-jenis {
        color: #f8fafc;
        font-weight: 700;
    }

    .deskripsi {
        color: #94a3b8;
    }

    .input-user {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #cbd5e1;
        font-weight: 600;
        white-space: nowrap;
    }

    .input-user i {
        color: #6366f1;
        font-size: 15px;
    }

    .input-user.unknown {
        color: #64748b;
        font-weight: 500;
    }

    .empty-state {
        padding: 65px 20px;
        text-align: center;
        background: #172033;
    }

    .empty-icon {
        width: 55px;
        height: 55px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 42px;
    }

    .empty-title {
        color: #94a3b8;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .empty-text {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .pagination-wrapper {
        padding: 15px 18px;
        background: #111827;
    }

    .pagination-wrapper nav {
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 768px) {
        .jenis-page {
            padding: 25px 0;
        }

        .page-title {
            font-size: 24px;
        }

        .jenis-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-form {
            width: 100%;
        }

        .btn-add {
            width: 100%;
        }

        .jenis-table th,
        .jenis-table td {
            padding: 12px;
        }
    }
</style>

<div class="jenis-page">
    <div class="jenis-container">

        <div class="page-header">
            <h1 class="page-title">
                <i class="bi bi-tags-fill"></i>
                Jenis Produk
            </h1>

            <p class="page-subtitle">
                Kelola jenis atau kategori produk pada sistem POS.
            </p>
        </div>

        <div class="jenis-card">

            <div class="jenis-toolbar">

                <form action="{{ route('jenis.index') }}"
                      method="GET"
                      class="search-form">

                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari jenis produk..."
                        value="{{ request('search') }}"
                    >

                    <button type="submit" class="btn-search">
                        <i class="bi bi-search"></i>
                        Cari
                    </button>
                </form>

                <a href="{{ route('jenis.create') }}" class="btn-add">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Jenis
                </a>

            </div>

            <div class="table-wrapper">

                <table class="jenis-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Jenis</th>
                            <th>Deskripsi</th>
                            <th>Diinput Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($jenis as $item)

                            <tr>

                                <td>
                                    {{ $jenis->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <span class="nama-jenis">
                                        {{ $item->nama_jenis }}
                                    </span>
                                </td>

                                <td>
                                    <span class="deskripsi">
                                        {{ $item->deskripsi ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    @if ($item->user)

                                        <span class="input-user">
                                            <i class="bi bi-person-circle"></i>
                                            {{ $item->user->name }}
                                        </span>

                                    @else

                                        <span class="input-user unknown">
                                            <i class="bi bi-person-x"></i>
                                            Tidak diketahui
                                        </span>

                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <a
                                            href="{{ route('jenis.edit', $item->id) }}"
                                            class="btn btn-sm btn-warning"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('jenis.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis ini?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                            >
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="5"
                                    style="padding: 0; border-bottom: none;"
                                >

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            <i class="bi bi-tags"></i>
                                        </div>

                                        <div class="empty-title">
                                            Belum ada jenis produk
                                        </div>

                                        <p class="empty-text">
                                            Silakan tambahkan jenis produk baru.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if ($jenis->hasPages())

                <div class="pagination-wrapper">
                    {{ $jenis->links() }}
                </div>

            @endif

        </div>

    </div>
</div>

@endsection