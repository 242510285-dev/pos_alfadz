@extends('layouts.app')

@section('title', 'Manajemen Users')

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
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
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
        color: #475569 !important;
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
        border: none;
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

    
    .no-action {
        color: #475569;
        font-size: 1.2rem;
        font-weight: 700;
    }

    
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .role-admin {
        background: rgba(99, 102, 241, 0.2);
        color: #818cf8;
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    .role-kasir {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
</style>


<div class="container py-5">

    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        <div>
            <h1 class="fw-black text-white mb-1"
                style="font-size: 2rem; letter-spacing: -0.02em;">
                Manajemen Users
            </h1>

            <p class="mb-0 small"
               style="color: #94a3b8;">
                Kelola daftar pengguna, peranan (role), dan hak akses sistem.
            </p>
        </div>

        <div>
            <a href="{{ route('admin.users.create') }}"
               class="btn btn-create-pro d-inline-flex align-items-center gap-2">

                <i class="bi bi-person-plus-fill fs-6"></i>
                Tambah User Baru

            </a>
        </div>

    </div>


    
    <div class="row mb-4">

        <div class="col-12 col-md-6 col-lg-5">

            <form action="{{ route('admin.users') }}" method="GET">

                <div class="input-group">

                    <input
                        type="text"
                        name="search"
                        class="form-control input-search-dark"
                        placeholder="Search username or email..."
                        value="{{ request('search') }}"
                    >

                    <button
                        class="btn btn-search-dark"
                        type="submit">

                        <i class="bi bi-search me-1"></i>
                        Search

                    </button>

                </div>

            </form>

        </div>

    </div>


    
    <div class="card card-pro">

        <div class="table-responsive">

            <table class="table table-pro align-middle">

                <thead>

                    <tr>

                        <th class="text-center" style="width: 60px;">
                            #
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Email
                        </th>

                        <th class="text-center">
                            Role
                        </th>

                        <th class="text-center" style="width: 180px;">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @php
                        $listUsers = $users ?? $user ?? [];
                    @endphp


                    @forelse ($listUsers as $index => $item)

                        @php
                            /*
                             * Ambil nama role.
                             *
                             * Bisa berasal dari:
                             * $item->role->name
                             * atau
                             * $item->role
                             */
                            $roleName = strtolower(
                                $item->role->name
                                ?? $item->role
                                ?? 'kasir'
                            );
                        @endphp


                        <tr>

                            {{-- NOMOR --}}
                            <td class="text-center fw-medium"
                                style="color: #64748b;">

                                {{ method_exists($listUsers, 'firstItem')
                                    ? $listUsers->firstItem() + $index
                                    : $index + 1
                                }}

                            </td>


                            {{-- NAME --}}
                            <td class="fw-semibold text-white">

                                <i class="bi bi-person-circle me-2"
                                   style="color: #818cf8;"></i>

                                {{ $item->name }}

                            </td>


                            {{-- EMAIL --}}
                            <td class="font-monospace small"
                                style="color: #cbd5e1;">

                                {{ $item->email }}

                            </td>


                            {{-- ROLE --}}
                            <td class="text-center">

                                @if($roleName === 'admin')

                                    <span class="role-badge role-admin">

                                        <i class="bi bi-shield-lock-fill"></i>

                                        Admin

                                    </span>

                                @else

                                    <span class="role-badge role-kasir">

                                        <i class="bi bi-person-badge-fill"></i>

                                        Kasir

                                    </span>

                                @endif

                            </td>


                            
                            <td class="text-center">

                                @if($roleName === 'kasir')

                                    <div class="d-flex justify-content-center gap-1">

                                        
                                        <a
                                            href="{{ route('admin.users.edit', $item->id) }}"
                                            class="btn btn-action btn-action-warning"
                                            title="Edit">

                                            <i class="bi bi-pencil-square"></i>

                                            Edit

                                        </a>


                                        
                                        <form
                                            action="{{ route('admin.users.destroy', $item->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user kasir ini?')">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-action btn-action-danger"
                                                title="Hapus User">

                                                <i class="bi bi-trash-fill"></i>

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                @else

                                    
                                    <span class="no-action">
                                        —
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center py-5"
                                style="color: #94a3b8;">

                                <i
                                    class="bi bi-people fs-1 d-block mb-2"
                                    style="color: #475569;">
                                </i>

                                Belum ada data user.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        
        @if(
            is_object($listUsers)
            && method_exists($listUsers, 'hasPages')
            && $listUsers->hasPages()
        )

            <div
                class="card-footer bg-transparent border-top border-secondary border-opacity-10 d-flex justify-content-center py-3">

                {{ $listUsers->links() }}

            </div>

        @endif

    </div>

</div>

@endsection