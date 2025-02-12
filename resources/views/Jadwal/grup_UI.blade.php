@extends('Jadwal.sidebar')

@section('content')
    <div class="row">
        <div class="card shadow col-10 me-3" style="border-radius: 28px; border:none">
            <div class="card-body">
                <div class="row align-items-center w-100">
                    <!-- Kiri -->
                    <div class="col-md-3 text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-people-fill fs-1"></i>
                            <h5 class="fw-bold mt-2">Jual-Beli</h5>
                            <button class="btn btn-outline-danger mt-2">
                                <i class="bi bi-box-arrow-left"></i> Keluar Grup
                            </button>
                        </div>
                    </div>

                    <!-- Kanan -->
                    <div class="col-md-9" style="border-left: 1px solid #ddd">
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
        <div class="row col-2 p-2">
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                aria-controls="offcanvasRight" style="height: 40px; font-size:14px">
                <i class="bi bi-people"></i> Daftar Anggota
            </button>
            @include('jadwal.off_canvas.daftar_anggota')
            <button class="btn btn-outline-secondary" style="height: 40px; font-size:14px">
                <i class="bi bi-share"></i> Bagikan
            </button>
            <button class="btn btn-warning" style="height: 40px; font-size:14px">
                <i class="bi bi-pencil"></i> Edit Grup
            </button>
            <button class="btn btn-danger" style="height: 40px; font-size:14px">
                <i class="bi bi-trash"></i> Hapus Grup
            </button>
        </div>
    </div>

    <div class="card shadow mt-5 p-3" style="border-radius: 28px; border:none">
        <div class="header-kalender d-flex justify-content-between">
            <h4><i class="bi bi-clipboard"></i> Jam/Tanggal</h4>
            <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title=" Klik pada kolom kosong sesuai tanggal dan waktu untuk menambahkan aktivitas.">
                <h4>
                    <i class="bi bi-info-circle"></i>
                </h4>
            </button>
        </div>
        <div class="card-body d-flex">
            <ul class="list-unstyled mt-5">
                <li class="mb-5">
                    Senin 1 Januari 2025
                </li>
                <li class="mb-5">
                    Selasa 1 Januari 2025
                </li>
                <li class="mb-5">
                    Rabu 1 Januari 2025
                </li>
                <li class="mb-5">
                    Senin 1 Januari 2025
                </li>
            </ul>
            <table class="table table-bordered">
                <thead class="table" style="text-align: center; border-top: transparent !important;">
                    <tr>
                        <td>07:00 - 07:30</td>
                        <td>07:30 - 08:00</td>
                        <td>08:00 - 08:30</td>
                        <td>08:30 - 09:00</td>
                        <td>09:00 - 09:30</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                    </tr>
                    <tr>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                    </tr>
                    <tr>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                    </tr>
                    <tr>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                        <td onclick="openModal(this)" style="height: 80px"></td>
                    </tr>
                </tbody>
                @include('Jadwal.modal.buat_jadwal')
            </table>
        </div>
    </div>

    <script>
        let selectedCell;

        function openModal(cell) {
            selectedCell = cell;
            document.getElementById("scheduleInput").value = cell.innerHTML;
            let scheduleModal = new bootstrap.Modal(document.getElementById("scheduleModal"));
            scheduleModal.show();
        }

        function saveSchedule() {
            let text = document.getElementById("scheduleInput").value;
            if (selectedCell) {
                selectedCell.innerHTML = text;
            }
            let scheduleModal = bootstrap.Modal.getInstance(document.getElementById("scheduleModal"));
            scheduleModal.hide();
        }

        /* tooltips */
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
        /* tooltips */
    </script>
@endsection
