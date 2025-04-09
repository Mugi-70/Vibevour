@extends('Jadwal.sidebar')

@section('header')
    <div class="card border-0 shadow-sm">
        <div class="card-body pt-3 pb-3 pe-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn me-2 d-lg-none" id="toggleSidebar" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileSidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <h5 class="mb-0">Grup</h5>
                </div>
                <a href="/pembuatan_grup" type="button" class="btn btn-success" style="font-size: 14px"><i
                        class="bi bi-plus me-1"></i>Buat Grup</a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Toast Notifikasi -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div id="toastNotification" class="toast align-items-center text-white bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    <!-- Pesan akan diisi melalui JavaScript -->
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="hapusGrup" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"> berhasil
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <!-- Toast Notifikasi -->
    <!-- Content -->
    <div class="row">
        <!-- button -->
        <div class="col-md-4 offset-md-8 text-end">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-sliders me-1"></i>Filter
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('coba', ['filter' => 'bulan_ini']) }}">Bulan Ini</a></li>
                <li><a class="dropdown-item" href="{{ route('coba', ['filter' => 'bulan_lalu']) }}">Bulan Lalu</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('coba') }}">Semua</a></li>
            </ul>
        </div>

        @if ($grup2->isEmpty())
            <div class="d-flex align-items-center justify-content-center" style="min-height: 70vh">
                <p class="text-muted">Kamu Belum Mempunyai Grup</p>
            </div>
        @else
            @foreach ($grup2 as $item)
                <div class="col-md-4">
                    <a href="{{ route('grup.detail', ['id' => $item->grup->id_grup]) }}" style="text-decoration:none">
                        <div class="card mt-3 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold fs-6">{{ $item->grup->nama_grup }}</h5>
                                <p class="card-text text-truncate" style="font-size: 14px; max-width: 150px">
                                    {{ $item->grup->deskripsi }}
                                </p>

                                <div class="d-flex flex-nowrap justify-content-between align-items-center">
                                    <p class="mb-0 text-muted" style="font-size: 14px;">
                                        {{ \Carbon\Carbon::parse($item->grup->tanggal_mulai)->translatedFormat('d M Y') }}
                                        s.d
                                        {{ \Carbon\Carbon::parse($item->grup->tanggal_selesai)->translatedFormat('d M Y') }}
                                    </p>

                                    <button type="button" class="btn btn-sm btn-outline-secondary d-none">
                                        <i class="bi bi-share me-1"></i>
                                        <span class="d-none d-sm-inline">Bagikan</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
    </div>
    @endif
    <!-- Content -->
@endsection
