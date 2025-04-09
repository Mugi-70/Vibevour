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
                    <h5 class="mb-0">Pertemuan</h5>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="tab-meet d-flex flex-wrap gap-1 m-2 justify-content-between">
            <ul class="nav nav-underline" style="margin-left: 25px">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Riwayat</a>
                </li>
                <li class="nav-item" hidden>
                    <a class="nav-link" aria-current="page" href="#">Link</a>
                </li>
            </ul>
            <button class="filter-meet btn btn-secondary m-1 d-none" type="submit">
                <i class="bi bi-sliders m-1"></i>Filter
            </button>
        </div>

        @foreach ($jadwals as $jadwal)
            <div class="line-meet"></div>
            <div class="m-2">
                <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!-- Avatar & Judul -->
                    <div class="d-flex align-items-center text-center text-md-start w-100">
                        <div class="avatar me-2"
                            style="width: 40px; height: 40px; background-color: #6c5ce7; border-radius: 50%;">
                        </div>
                        <h6 class="fw-bold text-truncate m-0" style="max-width: 150px;">
                            <strong>{{ $jadwal->judul }}</strong>
                        </h6>
                    </div>

                    <!-- Tanggal & Waktu -->
                    <div class="text-center w-100 my-2 my-md-0">
                        <h6 class="fw-bold m-0">
                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }}
                        </h6>
                        <span class="text-muted" style="font-size: 14px;">
                            {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->translatedFormat('H:i') }}
                        </span>
                    </div>

                    <!-- Tombol Detail -->
                    <div class="text-md-end w-100 text-center text-md-start">
                        <button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#history-{{ $jadwal->id }}">
                            <i class="bi bi-display"></i> Detail
                        </button>
                    </div>
                </div>
            </div>






            @include('Jadwal.modal.detail_pertemuan')
        @endforeach
    </div>
@endsection
