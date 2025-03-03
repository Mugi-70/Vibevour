@extends('Jadwal.sidebar')

@section('header')
    <div class="card border-0 shadow-sm">
        <div class="card-body pt-3 pb-3 pe-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn me-2" id="toggleSidebar">
                        <i class="bi bi-list"></i> <!-- Ikon Menu -->
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
    <div class="row">
        <!-- Example single danger button -->
        <div class="text-end">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-sliders me-1"></i>Filter
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
        </div>

        @foreach ($grup as $item)
            <div class="col-md-4">
                <a href="{{ route('grup.detail', ['id' => $item->id_grup]) }}" style="text-decoration:none">
                    <div class="card mt-3 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold fs-6">{{ $item->nama_grup }}</h5>
                            <p class="card-text" style="font-size: 14px">{{ $item->deskripsi }}</p>

                            <!-- Wrapper Flex untuk Tanggal & Tombol -->
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-muted" style="font-size: 14px;">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }} s.d
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                                </p>

                                <button type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-share me-1"></i>Bagikan
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="d-flex align-items-center justify-content-center d-none" style="min-height: 70vh">
        <p class="text-muted">Kamu Belum Mempunyai Grup</p>
    </div>
@endsection
