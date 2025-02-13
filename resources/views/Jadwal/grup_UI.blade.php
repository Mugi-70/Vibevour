@extends('Jadwal.sidebar')

@section('header')
    <div class="title d-flex">
        <h3 class="mt-3" style="font-weight: bold">Grup</h3>
        <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
            title="Halaman Grup Jual-Beli"><i class="bi bi-question-circle"></i></button>
    </div>
@endsection

@section('content')
    <div class="row position-relative">
        <div class="card shadow col-10 me-3" style="border-radius: 28px; border:none">
            <div class="card-body">
                <div class="row align-items-center w-100">
                    <!-- Kiri -->
                    <div class="col-md-3 text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-people-fill fs-1"></i>
                            <h5 class="fw-bold mt-2">{{ $nama_grup }}</h5>
                            <button class="btn btn-outline-danger mt-2">
                                <i class="bi bi-box-arrow-left"></i> Keluar Grup
                            </button>
                        </div>
                    </div>

                    <!-- Kanan -->
                    <div class="col-md-9" style="border-left: 1px solid #ddd">

                        <table class="table table-borderless">
                            <tr>
                                <td style="width: 7em">
                                    <i class="bi bi-calendar"></i>
                                    <strong>Tanggal</strong>
                                </td>
                                <td style="width: 1em">
                                    :
                                </td>
                                <td>
                                    {{ $tnggl }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="bi bi-clock-history"></i>
                                    <strong>Jam</strong>
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $wtku }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="bi bi-clock-history"></i>
                                    <strong>Durasi</strong>
                                </td>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $durasi }}
                                </td>
                            </tr>
                        </table>
                        <strong>Deskripsi</strong>
                        <div class="card p-1">
                            {{ $desk }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- tombol -->
        <div class="tombol-kanan d-flex flex-column gap-2">
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                aria-controls="offcanvasRight" style="height: 40px; font-size:14px">
                <i class="bi bi-people"></i> Daftar Anggota
            </button>
            @include('jadwal.off_canvas.daftar_anggota')
            <button class="btn btn-outline-dark" style="height: 40px; font-size:14px">
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
            <table class="table table-bordered"
                style=" border-top: transparent !important; border-left:transparent !important;">
                <tr>
                    <td></td>
                    {{-- wktu --}}
                    @foreach ($times as $ts)
                        <td style="height: 80px; text-align:center; vertical-align:middle">{{ $ts }}</td>
                    @endforeach
                </tr>
                @foreach ($tgl as $t)
                    <tr>
                        <td style="width: 11em; vertical-align: middle">
                            {{ $t }}
                        </td>
                        @foreach ($times as $ts)
                            <td onclick="openModal(this)" style="height: 100px">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
            @include('Jadwal.modal.buat_jadwal')

            {{-- <table class="table table-bordered">
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
                </tbody>
            </table> --}}
        </div>
    </div>

    <script>
        let selectedCell;

        function openModal(cell) {
            console.log("Modal dibuka!", cell);
            selectedCell = cell;
            document.getElementById("scheduleModal").value = cell.innerHTML;
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
