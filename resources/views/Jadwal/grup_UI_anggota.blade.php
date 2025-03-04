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
        <div class="card shadow-sm w-100" style=" border:none">
            <div class="card-body">
                <div class="position-absolute top-0 end-0 p-2 d-block d-md-none">
                    <button class="btn btn-outline-dark border-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#daftar_anggota"
                                style="color: blue">
                                <i class="bi bi-people"></i> Daftar Anggota
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#edit_grup"
                                style="color: #fec007">
                                <i class="bi bi-pencil"></i> Edit Grup
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete_grup">
                                <i class="bi bi-trash"></i> Hapus Grup
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="row w-100">
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
                    <div class="col-md-7" style="border-left: 1px solid #ddd">
                        <div class="card shadow-sm p-3 border-0">
                            <!-- Tanggal -->
                            <div class="mb-2">
                                <div class="fw-bold">
                                    <i class="bi bi-calendar me-1"></i> Tanggal
                                </div>
                                <div class="ps-4">
                                    1 Jan 2025
                                    <strong>s.d.</strong>
                                    3 Jan 2025
                                </div>
                            </div>

                            <!-- Waktu -->
                            <div class="mb-2">
                                <div class="fw-bold">
                                    <i class="bi bi-clock-history me-1"></i> Jam
                                </div>
                                <div class="ps-4">
                                    {{ $wtku_mulai }} <strong>s.d.</strong> {{ $wtku_selesai }}
                                </div>
                            </div>

                            <!-- Durasi -->
                            <div class="mb-2">
                                <div class="fw-bold">
                                    <i class="bi bi-clock me-1"></i> Durasi
                                </div>
                                <div class="ps-4">
                                    {{-- {{ $durasi }} --}}
                                    {{ str_replace('minutes', 'menit', $durasi) }}

                                </div>
                            </div>

                            <hr>

                            <!-- Deskripsi -->
                            <strong>Deskripsi</strong>
                            <div class="card p-2 bg-light border-0">
                                {{ $desk }}
                            </div>
                        </div>
                    </div>

                    <!-- Tombol untuk Desktop di Sebelah Kanan Berbaris ke Bawah -->
                    <div class="col-md-2 d-none d-md-flex flex-column align-items-start gap-2">
                        <button class="btn btn-secondary w-100" data-bs-toggle="offcanvas" data-bs-target="#daftar_anggota"
                            aria-controls="offcanvasRight">
                            <i class="bi bi-people"></i> Daftar Anggota
                        </button>
                        <button class="btn btn-warning w-100" data-bs-toggle="offcanvas" data-bs-target="#edit_grup"
                            aria-controls="offcanvasRight">
                            <i class="bi bi-pencil"></i> Edit Grup
                        </button>
                        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#delete_grup">
                            <i class="bi bi-trash"></i> Hapus Grup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Kalender --}}
        <div class="card shadow-sm w-100 mt-5" style=" border:none">
            <div class="header-kalender d-flex justify-content-between">
                <h4 class="p-3"><i class="bi bi-clipboard"></i> Jam/Tanggal</h4>
                <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Klik pada kolom kosong sesuai tanggal dan waktu untuk menambahkan aktivitas.">
                    <h4>
                        <i class="bi bi-info-circle"></i>
                    </h4>
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive" style="max-width: 100%;">
                    <table class="table table-bordered"
                        style="min-width: 600px; border-top: transparent !important; border-left: transparent !important;">
                        <tr>
                            <td style="width: 5em; position: sticky; left: 0; background: white; z-index: 2;"></td>
                            @foreach ($times as $ts)
                                <td style="height: 80px; text-align: center; vertical-align: middle;">{{ $ts }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td
                                style="width: 10em; vertical-align: middle; position: sticky; left: 0; background: white; z-index: 2;">
                                1 Jan 2025
                            </td>
                            <td class="item"
                                style="height: 50px; max-width:20px; cursor: pointer; color: #6c747e; vertical-align: middle; text-align: center;">
                                <i class="lebel bi bi-plus-circle" style="font-size: 18px; color: #007bff;"></i>
                            </td>
                            <td class="item2" style="height:  cursor: pointer;">
                                <button class="bjadwal btn btn-primary custom w-100 h-100" data-bs-toggle="offcanvas"
                                    data-bs-target="#jadwal2">
                                    <div class="d-flex flex-column text-center">
                                        <div class="title">Pembelian Rumah</div>
                                        <div class="subtitle d-flex align-items-center">
                                            <i class="bi bi-person icon me-2"></i>
                                            <p class="m-0">1 Anggota</p>
                                        </div>
                                    </div>
                                </button>
                            </td>
                            <td class="" style="">
                                <div class="schedule-content d-flex flex-column p-2 d-none">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <p class="m-0 fw-bold">+2 anggota</p>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#availability_member">lihat</button>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#scheduleModal">Buat Pertemuan</button>
                                </div>
                            </td>
                            <td class="item"
                                style="height: 50px; max-width:20px; cursor: pointer; color: #6c747e; vertical-align: middle; text-align: center;">
                                <i class="lebel bi bi-plus-circle" style="font-size: 18px; color: #007bff;"></i>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>




    {{-- modal --}}
    @include('Jadwal.modal.keluar_grup')
    @include('Jadwal.modal.ketersediaan')
    @include('Jadwal.modal.hapus_grup')
    @include('Jadwal.modal.buat_jadwal')
    @include('Jadwal.modal.anggota_free')
    {{-- modal --}}

    {{-- offcanvas --}}
    @include('Jadwal.off_canvas.edit_grup')
    {{-- @include('jadwal.off_canvas.daftar_anggota') --}}
    @include('jadwal.off_canvas.jadwal2')
    {{-- offcanvas --}}


    <script>
        /* memunculkan modal dengan klik fungsi */
        $(".item").click(function() {
            openModal($(this))
        })
        /* memunculkan modal dengan klik fungsi */



        /* membuka modal saat kolom di klik */
        let selectedCell;

        function openModal(cell) {
            selectedCell = cell;

            // mengambil data tanggal & waktu
            let tanggal = cell.attr("data-tanggal");
            let waktu = cell.attr("data-waktu");

            // memanggil tanggal & waktu ke modal
            $("#selectedDate").text(tanggal);
            $("#selectedTime").text(waktu);

            // menampikan modal
            $("#availability").modal("show");
        }
        /* membuka modal */



        function saveSchedule() {
            // let anggota = $("#loggedInUser").text().trim(); // Ambil nama anggota yang login

            if (selectedCell) {
                // Periksa apakah elemen sudah ada
                let existingContent = selectedCell.find(".schedule-content");

                if (existingContent.length === 0) {
                    $(document).ready(function() {
                        $(".lebel").hide();
                    });
                    // Jika belum ada, buat elemen baru
                    let content = $(`
                <div class="schedule-content d-flex flex-column w-100 h-100 p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="m-0 fw-bold">Notaris</p>
                        <i class="bi bi-check-square fs-4"></i>
                    </div>
                </div>
            `);
                    selectedCell.append(content);
                } else {
                    // Jika sudah ada, tambahkan nama anggota baru di bawahnya
                    let newEntry = $(`
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <p class="m-0 fw-bold">Pembeli</p>
                    <i class="bi bi-check-square fs-4"></i>
                </div>
            `);
                    existingContent.append(newEntry); // Tambahkan nama baru ke dalam div yang sudah ada
                }
            }

            // Menutup modal setelah menyimpan
            $("#availability").modal("hide");
        }



        /* tooltips */
        $(document).ready(function() {
            $('.btn').tooltip();
        });
        /* tooltips */



        $(document).ready(function() {
            $(".delete-meet").click(function() {
                $(".bjadwal").remove();

                // tutup modal pembatalan jadwal
                $("#cancel").modal("hide");

                // tutup offcanvas jadwal
                $("#jadwal").offcanvas("hide");

                // Hapus backdrop
                $(".modal-backdrop").remove();

                // Pastikan body tidak terkunci
                $("body").removeClass("modal-open").css("overflow", "");

                // Reset elemen offcanvas agar bisa ditampilkan lagi
                setTimeout(function() {
                    $("#jadwal").removeClass("show").attr("aria-hidden", "true");
                    $(".offcanvas-backdrop").remove();
                }, 500);
            });

            // Ketika tombol yang memunculkan offcanvas diklik lagi
            // $("[data-bs-target='#jadwal']").click(function() {
            //     setTimeout(function() {
            //         $("#jadwal").addClass("show");
            //     }, 100);
            // });
        });



        $(document).ready(function() {
            $(".hadiri").click(function() {
                let subtitle = $(".bjadwal .subtitle p"); // ambil tag p
                let jumlahAnggota = parseInt(subtitle.text()) || 1; // Ambil angka dari teks

                jumlahAnggota++; // Tambah jumlah anggota

                $("#hadiri").remove();
                $(".modal-backdrop").remove();
                $(".hu").hide();
                $(".box-item").removeClass("d-none");

                // Perbarui teks
                subtitle.text(jumlahAnggota + " Anggota");
            });
            // $(document).on("click", ".bjadwal", function() {
            //     $(".hu").show();
            // });
        });
    </script>
    @include('Jadwal.off_canvas.jadwal')
@endsection
