@extends('Jadwal.sidebar')

@section('header')
    {{-- <div class="title d-flex">
        <h3 class="mt-3" style="font-weight: bold">Grup</h3>
        <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
            title="Halaman Grup {{ $grup->nama_grup }}"><i class="bi bi-question-circle"></i></button>
    </div> --}}
    <div class="card border-0 shadow-sm mb-1">
        <div class="card-body pt-3 pb-3 pe-3 border-0">
            <div class="d-flex align-items-center">
                <!-- Tombol Toggle Sidebar di Kiri -->
                <button class="btn me-2" id="toggleSidebar">
                    <i class="bi bi-list"></i> <!-- Ikon Menu -->
                </button>

                <h4 class="mt-3" style="font-weight: bold">Grup</h4>

                <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Halaman Grup {{ $grup->nama_grup }}">
                    <i class="bi bi-question-circle"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row position-relative">
        <div class="card shadow w-100" style=" border:none; ">
            <div class="card-body">
                <div class="position-absolute top-0 end-0 p-1 d-md-none">
                    <button class="btn btn-outline-dark border-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button class="dropdown-item text-secondary" data-bs-toggle="offcanvas"
                                data-bs-target="#daftar_anggota" style="">
                                <i class="bi bi-people"></i> Daftar Anggota
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-warning" data-bs-toggle="offcanvas"
                                data-bs-target="#edit_grup" style="">
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
                    <div class="col-md-7 px-3 py-2">
                        <div class="card shadow-sm p-3 border-0">
                            <!-- Tanggal -->
                            <div class="mb-2">
                                <div class="fw-bold">
                                    <i class="bi bi-calendar me-1"></i> Tanggal
                                </div>
                                <div class="ps-4">
                                    {{ $tnggl_mulai }} <strong>s.d.</strong> {{ $tnggl_selesai }}
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
                        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#delete_grup"
                            id="hapus_grup{{ $grup->id_grup }}">
                            <i class="bi bi-trash"></i> Hapus Grup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- kalender --}}
        <div class="card shadow w-100 mt-5" style=" border:none;">
            <div class="header-kalender d-flex justify-content-between">
                <h4 class="p-3"><i class="bi bi-clipboard"></i> Jam/Tanggal</h4>
                <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title=" Klik pada kolom kosong sesuai tanggal dan waktu untuk menambahkan jadwal.">
                    <h4>
                        <i class="bi bi-info-circle"></i>
                    </h4>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-width: 100%; width:100%">
                    <table class="table table-bordered"
                        style="min-width: 600px; border-top: transparent !important; border-left: transparent !important;">
                        <tr>
                            <td style="width: 6em; vertical-align: middle; left: 0; position: sticky; z-index: 2">
                            </td>
                            {{-- waktu --}}
                            @foreach ($waktu_list as $ts)
                                <td style="height: 80px;  position: sticky; text-align:center; vertical-align:middle">
                                    {{ $ts }}
                                </td>
                            @endforeach
                        </tr>
                        {{-- tanggal --}}
                        @foreach ($tanggal_list as $t)
                            <tr>
                                <td class="tanggal-list"
                                    style="vertical-align: middle; left: 0; position: sticky; z-index: 2">
                                    {{ $t }}
                                </td>
                                @foreach ($waktu_list as $ts)
                                    <td class="item" data-tanggal="{{ $t }}"
                                        data-waktu="{{ $ts }}"
                                        style="height: 50px; max-width:20px; cursor: pointer;  color: #6c747e; vertical-align: middle;">
                                        <p class="lebel" style="font-size: 100%">+Jadwal</p>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>




    {{-- modal --}}
    @include('Jadwal.modal.keluar_grup')
    @include('Jadwal.modal.buat_jadwal')
    @include('Jadwal.modal.hapus_grup')
    @include('Jadwal.modal.anggota_free')
    {{-- modal --}}

    {{-- offcanvas --}}
    @include('Jadwal.off_canvas.edit_grup')
    @include('jadwal.off_canvas.daftar_anggota')
    {{-- offcanvas --}}


    <script>
        $(document).on('click', '.hapus_grup', function() {
            var id = $(this).attr('id');

            $.ajax({
                type: 'delete',
                url: "/hapus_grup/${id}",
                data: {
                    id: id
                },
            });
        });


        // function setDeleteFormAction(id) {
        //     let form = document.getElementById('deleteGrupForm');
        //     form.action = "/hapus" + "/grup" + /id;
        // }

        /* fungsi memunculkan modal dengan klik */
        $(".item").click(function() {
            openModal($(this))
        })
        /* fungsi memunculkan modal dengan klik */

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
            $("#scheduleModal").modal("show");
        }
        /* membuka modal */

        /* saving jadwal */
        function saveSchedule() {
            let text = $("#scheduleInput").val();

            if (selectedCell) {
                // cek apakah tombol sudah ada dalam cell
                let existingButton = selectedCell.find("button");
                $(document).ready(function() {
                    $(".lebel").hide();
                });

                if (existingButton.length === 0) {
                    //  <div class="schedule-content d-flex flex-column w-100 h-100 p-2">
                    // <div class="d-flex justify-content-between align-items-center mb-1">
                    // <p class="m-0 fw-bold">+2 anggota</p>
                    // <button type="button" class="btn btn-warning"  data-bs-toggle="modal" data-bs-target="#availability_member">lihat</button>
                    // </div>
                    // <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#scheduleModal">Buat Pertemuan</button>
                    // </div>

                    // jika belum ada tombol yang dibuat, buat tombol baru
                    let button = $(`
                    <button class="bjadwal btn btn-primary custom w-100 h-100"
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

                $("#lebel").show();

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
            $(document).on("click", ".bjadwal", function() {
                $(".hu").show();
            });
        });
    </script>
    @include('Jadwal.off_canvas.jadwal')
@endsection
