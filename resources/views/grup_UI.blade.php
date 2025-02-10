@extends('sidebar')

@section('content')
    <div class="d-flex align-items-start">
        <div class="card-grup shadow p-3">
            <div class="row align-items-center">
                <!-- Bagian Kiri -->
                <div class="col-md-5 text-center">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-people-fill fs-1"></i>
                        <h5 class="fw-bold mt-2">Jual-Beli</h5>
                        <button class="btn btn-outline-danger mt-2">
                            <i class="bi bi-box-arrow-left"></i> Keluar Grup
                        </button>
                    </div>
                </div>

                <div class="col-md-1 d-flex justify-content-center">
                    <div class="vertical"></div>
                </div>

                <!-- Bagian Kanan -->
                <div class="col-md-6">
                    <ul class="list-unstyled" style="width: 100%">
                        <li class="mb-2">
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
                </div>
            </div>
        </div>


        <!-- tombol -->
        <div class="d-flex flex-column ms-3">
            <button class="btn btn-primary mb-2">
                <i class="bi bi-people"></i> Daftar Anggota
            </button>
            <button class="btn btn-outline-secondary mb-2">
                <i class="bi bi-share"></i> Bagikan
            </button>
            <button class="btn btn-warning mb-2">
                <i class="bi bi-pencil"></i> Edit Grup
            </button>
            <button class="btn btn-danger">
                <i class="bi bi-trash"></i> Hapus Grup
            </button>
        </div>
    </div>

    <div class="card_form mt-5"></div>
@endsection
