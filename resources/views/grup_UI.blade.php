@extends('sidebar')

@section('content')
    <div class="row">
        <div class="card shadow col-9">
            <div class="card-body">

                <div class="row align-items-center w-100">
                    <!-- Kiri -->
                    <div class="col-md-3 text-center">
                        <div class="d-flex flex-column align-items-center" style="border-right: 1px solid;">
                            <i class="bi bi-people-fill fs-1"></i>
                            <h5 class="fw-bold mt-2">Jual-Beli</h5>
                            <button class="btn btn-outline-danger mt-2">
                                <i class="bi bi-box-arrow-left"></i> Keluar Grup
                            </button>
                        </div>
                    </div>

                    {{-- <div class="col-md-1">
                        <div class="vr h-100"></div>
                    </div> --}}

                    <!-- Kanan -->
                    <div class="col-md-9">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="bi bi-calendar"></i>
                                <strong>Tanggal:</strong> 01 Januari 2025 - 07 Januari 2025
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-clock"></i>
                                <strong>Jam:</strong> 07:00 AM s.d. 09:30 AM
                            </li>
                            <li>
                                <i class="bi bi-clock-history"></i>
                                <strong>Durasi:</strong> 30 menit
                            </li>
                        </ul>
                        <label for="">Deskripsi</label>
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
        </div>


        <!-- tombol -->
        <div class="col-3">
            <button class="btn btn-primary mb-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                aria-controls="offcanvasRight" style="font-size:15px">
                <i class="bi bi-people"></i> Daftar Anggota
            </button>
            @include('off_canvas.daftar_anggota')
            <button class="btn btn-outline-secondary mb-2" style="font-size:15px">
                <i class="bi bi-share"></i> Bagikan
            </button>
            <button class="btn btn-warning mb-2" style="font-size:15px">
                <i class="bi bi-pencil"></i> Edit Grup
            </button>
            <button class="btn btn-danger" style="font-size:15px">
                <i class="bi bi-trash"></i> Hapus Grup
            </button>
        </div>
    </div>

    <div class="card_form mt-5"></div>
@endsection
