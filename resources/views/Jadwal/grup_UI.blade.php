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
                            <button class="btn btn-outline-danger mt-2" data-bs-toggle="modal" data-bs-target="#leave_grup">
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
                                    {{ $tnggl_mulai }} <strong>s.d.</strong> {{ $tnggl_selesai }}
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
                                    {{ $wtku_mulai }} <strong>s.d.</strong> {{ $wtku_selesai }}
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
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#daftar_anggota"
                aria-controls="offcanvasRight" style="height: 40px; font-size:14px">
                <i class="bi bi-people"></i> Daftar Anggota
            </button>
            <button class="btn btn-outline-dark" style="height: 40px; font-size:14px" hidden>
                <i class="bi bi-share"></i> Bagikan
            </button>
            <button class="btn btn-warning" style="height: 40px; font-size:14px" data-bs-toggle="offcanvas"
                data-bs-target="#edit_grup" aria-controls="offcanvasRight">
                <i class="bi bi-pencil"></i> Edit Grup
            </button>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_grup"
                style="height: 40px; font-size:14px">
                <i class="bi bi-trash"></i> Hapus Grup
            </button>
        </div>
        <!-- tombol -->
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
                    {{-- waktu --}}
                    @foreach ($times as $ts)
                        <td style="height: 80px; text-align:center; vertical-align:middle">{{ $ts }}</td>
                    @endforeach
                </tr>
                {{-- tanggal --}}
                @foreach ($tgl as $t)
                    <tr>
                        <td style="width: 10em; vertical-align: middle;">
                            {{ $t }}
                        </td>
                        @foreach ($times as $ts)
                            <td class="item" data-tanggal="{{ $t }}" data-waktu="{{ $ts }}"
                                style="height: 100px; max-width:20px; cursor: pointer;">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    {{-- modal --}}
    @include('Jadwal.modal.keluar_grup')
    @include('Jadwal.modal.buat_jadwal')
    @include('Jadwal.modal.hapus_grup')
    {{-- modal --}}

    {{-- offcanvas --}}
    @include('Jadwal.off_canvas.edit_grup')
    @include('jadwal.off_canvas.daftar_anggota')
    {{-- offcanvas --}}


    <script>
        $(".item").click(function() {
            openModal($(this))
        })


        /* membuka modal */
        let selectedCell;

        function openModal(cell) {
            console.log("Modal dibuka!", cell);
            selectedCell = cell;

            // mengambil data tanggal & waktu
            let tanggal = cell.attr("data-tanggal");
            let waktu = cell.attr("data-waktu");

            // memanggil tanggal & waktu ke modal
            $("#selectedDate").text(tanggal);
            $("#selectedTime").text(waktu);

            // menampikan modal
            $("#scheduleModal").modal("show");
        }
        /* membuka modal */

        /* saving jadwal */
        function saveSchedule() {
            let text = $("#scheduleInput").val();

            if (selectedCell) {
                // cek apakah tombol sudah ada dalam cell
                let existingButton = selectedCell.find("button");

                if (existingButton.length === 0) {
                    // jika belum ada tombol yang dibuat, buat tombol baru
                    let button = $(`
                <button class="btn btn-primary custom w-100 h-100"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#jadwal">
                    <div class="d-flex flex-column text-center">
                        <div class="title">${text || "Lihat"}</div>
                        <div class="subtitle d-flex align-items-center">
                            <i class="bi bi-person icon me-2"></i>
                            <p class="m-0">1 Anggota</p>
                        </div>
                    </div>
                </button>
            `);
                    // mencegah modal terbuka saat klik tombol
                    button.click(function(event) {
                        event.stopPropagation();
                    });

                    // tambahkan tombol ke dalam cell
                    selectedCell.append(button);
                } else {
                    // jika tombol sudah ada, ubah isinya
                    existingButton.html(`
                <div class="d-flex flex-column text-center">
                    <div class="title">${text || "Lihat"}</div>
                    <div class="subtitle d-flex align-items-center">
                        <i class="bi bi-person icon me-2"></i>
                        <p class="m-0">1 Anggota</p>
                    </div>
                </div>
            `);
                }
            }

            // menutup modal
            $("#scheduleModal").modal("hide");
        }
        /* saving jadwal */

        /* tooltips */
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
        /* tooltips */
    </script>
    @include('Jadwal.off_canvas.jadwal')
@endsection
