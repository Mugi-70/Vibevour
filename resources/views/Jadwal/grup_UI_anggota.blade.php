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
                <div class="position-absolute top-0 end-0 p-2 d-block d-md-none">
                    <button class="btn btn-outline-dark border-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#daftar_anggota">
                                <i class="bi bi-people"></i> Daftar Anggota
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#edit_grup">
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

                <div class="row  w-100">
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

        <!-- Tombol untuk Desktop -->
        <div class="tombol-kanan d-none d-md-flex flex-column gap-2">
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#daftar_anggota"
                aria-controls="offcanvasRight">
                <i class="bi bi-people"></i> Daftar Anggota
            </button>
            <button class="btn btn-outline-dark" hidden>
                <i class="bi bi-share"></i> Bagikan
            </button>
            <button class="btn btn-warning" data-bs-toggle="offcanvas" data-bs-target="#edit_grup"
                aria-controls="offcanvasRight">
                <i class="bi bi-pencil"></i> Edit Grup
            </button>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_grup">
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
                    {{-- waktu --}}
                    @foreach ($times as $ts)
                        <td style="height: 80px; text-align:center; vertical-align:middle">{{ $ts }}</td>
                    @endforeach
                </tr>
                {{-- tanggal --}}
                {{-- @foreach ($tgl as $t) --}}
                <tr>
                    <td style="width: 10em; vertical-align: middle;">
                        {{-- {{ $t }} --}}1 Januari 2025
                    </td>
                    {{-- @foreach ($times as $ts) --}}
                    <td class="item" data-tanggal="" data-waktu=""
                        style="height: 100px; max-width:20px; cursor: pointer;">
                    </td>
                    <td class="item2" data-tanggal="" data-waktu=""
                        style="height: 100px; max-width:20px; cursor: pointer;">
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
                    <td class="item"></td>
                    <td class="item"></td>
                    {{-- @endforeach --}}
                </tr>
                <tr>
                    <td style="width: 10em; vertical-align: middle;">
                        2 Januari 2025
                    </td>
                    <td class="item"></td>
                    <td style="height: 100px; max-width:20px; cursor: pointer">
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
                    <td class="item"></td>
                    <td class="item"></td>
                </tr>
                <tr>
                    <td style="width: 10em; vertical-align: middle;">
                        3 Januari 2025
                    </td>
                    <td style="height: 100px; max-width:20px; cursor: pointer"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                {{-- @endforeach --}}
            </table>
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
    @include('jadwal.off_canvas.daftar_anggota')
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
