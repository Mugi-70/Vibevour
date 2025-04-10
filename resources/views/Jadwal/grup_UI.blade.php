@extends('Jadwal.sidebar')

@section('header')
    <div class="card border-0 shadow-sm mb-1">
        <div class="card-body pt-3 pb-3 pe-3 border-0">
            <div class="d-flex align-items-center">
                <!-- Tombol Toggle Sidebar di Kiri -->
                <button class="btn me-2 d-lg-none" id="toggleSidebar" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                    <i class="bi bi-list"></i>
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
    <div id="toastNotification"
        class="toast align-items-center text-white bg-danger border-0 position-fixed top-0 end-0 p-3" role="alert"
        aria-live="assertive" aria-atomic="true" data-bs-delay="3000" style="z-index: 999">
        <div class="d-flex">
            <div class="toast-body" id="toastpemberitahuan">
                <!-- Pesan akan diisi oleh JavaScript -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>

    <div class="row position-relative">
        <div class="card shadow-sm w-100" style=" border:none; ">
            <div class="card-body ps-5">
                {{-- tammpilan mobile --}}
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
                        @if ($role === 'admin')
                            <li>
                                <button class="edit dropdown-item text-warning" data-bs-toggle="offcanvas"
                                    data-jadwal-ada="{{ $jadwalAda ? 'true' : 'false' }}" data-bs-target="#edit_grup"
                                    aria-controls="offcanvasRight" style="">
                                    <i class="bi bi-pencil"></i> Edit Grup
                                </button>
                            </li>
                        @endif
                        @unless ($role == 'admin')
                            <li>
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete_grup">
                                    <i class="bi bi-trash"></i> Hapus Grup
                                </button>
                            </li>
                        </ul>
                    @endunless
                </div>

                <div class="row w-100">
                    <!-- Kiri -->
                    <div class="col-md-3 text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-people-fill fs-1"></i>
                            <h5 class="fw-bold mt-2">{{ $nama_grup }}</h5>
                            @if ($role === 'admin')
                                <button class="hapus btn btn-outline-danger mt-2" data-bs-toggle="modal"
                                    data-bs-target="#delete_grup" data-grup-id="{{ $grup->id_grup }}"
                                    data-grup-id="{{ $grup->id_grup }}">
                                    <i class="bi bi-trash"></i> Hapus Grup
                                </button>
                            @elseif ($role === 'anggota')
                                <button class="leave btn btn-outline-danger mt-2" data-bs-toggle="modal"
                                    data-bs-target="#leave_grup" data-grup-id="{{ $grup->id_grup }}">
                                    <i class="bi bi-box-arrow-left"></i> Keluar Grup
                                </button>
                            @endif
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
                                    {{ \Carbon\Carbon::parse($tnggl_mulai)->translatedFormat('d M Y') }}
                                    <strong>s.d.</strong>
                                    {{ \Carbon\Carbon::parse($tnggl_selesai)->translatedFormat('d M Y') }}
                                </div>
                            </div>

                            <!-- Waktu -->
                            <div class="mb-2">
                                <div class="fw-bold">
                                    <i class="bi bi-clock-history me-1"></i> Waktu
                                </div>
                                <div class="ps-4">
                                    {{ \Carbon\Carbon::parse($wtku_mulai)->translatedFormat('H:i') }}
                                    <strong>s.d.</strong>
                                    {{ \Carbon\Carbon::parse($wtku_selesai)->translatedFormat('H:i') }}
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
                                <!-- Teks yang bisa diklik -->
                                <p id="textPreview" class="text-truncate m-0"
                                    style="max-width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; cursor: pointer;"
                                    title="Klik untuk melihat selengkapnya">
                                    {{ $desk }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol untuk Desktop di Sebelah Kanan Berbaris ke Bawah -->
                    <div class="col-md-2 d-none d-md-flex flex-column align-items-start gap-2">
                        <button class="btn btn-secondary w-100" data-bs-toggle="offcanvas" data-bs-target="#daftar_anggota"
                            aria-controls="offcanvasRight" style="font-size: 15px">
                            <i class="bi bi-people"></i> Daftar Anggota
                        </button>
                        @if ($role === 'admin')
                            <button class="edit btn btn-warning w-100" data-bs-toggle="offcanvas"
                                data-bs-target="#edit_grup" aria-controls="offcanvasRight"
                                data-jadwal-ada="{{ $jadwalAda ? 'true' : 'false' }}">
                                <i class="bi bi-pencil"></i> Edit Grup
                            </button>
                        @endif
                        @unless ($role == 'admin')
                            <button class="btn btn-danger w-100 d-none" data-bs-toggle="modal" data-bs-target="#delete_grup"
                                id="hapus_grup">
                                <i class="bi bi-trash"></i> Hapus Grup
                            </button>
                        @endunless

                    </div>
                </div>
            </div>
        </div>

        {{-- kalender --}}
        <div class="card shadow-sm w-100 mt-5" style=" border:none;">
            <div class="header-kalender d-flex justify-content-between">
                <h4 class="p-3"><i class="bi bi-clipboard"></i> Waktu/Tanggal</h4>
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
                            <td style="width: 6em; vertical-align: middle; left: 0; position: sticky; z-index: 2"></td>
                            {{-- waktu --}}
                            @foreach ($waktu_list as $ts)
                                <td style="height: 80px; position: sticky; text-align:center; vertical-align:middle">
                                    {{ $ts }}
                                </td>
                            @endforeach
                        </tr>
                        {{-- tanggal --}}
                        @foreach ($tanggal_list as $t)
                            <tr>
                                <td class="tanggal-list"
                                    style="vertical-align: middle; left: 0; position: sticky; z-index: 2">
                                    {{ \Carbon\Carbon::parse($t)->translatedFormat('d M Y') }}
                                </td>
                                @foreach ($waktu_list as $ts)
                                    @php
                                        // Ambil jadwal yang sudah tersimpan
                                        $jadwal = App\Models\JadwalPertemuan::where('tanggal', $t)
                                            ->where('waktu_mulai', $ts)
                                            ->where('grup_id', $grup->id_grup)
                                            ->first();

                                        // Ambil anggota yang bersedia dari tabel ketersediaan
                                        $anggotaYangTersedia = App\Models\Ketersediaan::where('tanggal', $t)
                                            ->where('waktu', $ts)
                                            ->where('grup_id', $grup->id_grup)
                                            ->get();

                                        $userTersedia = $anggotaYangTersedia->contains('user_id', 1);

                                        // Cek apakah jadwal sudah ada di grup lain
                                        $jadwalDiGrupLain = App\Models\JadwalPertemuan::where('tanggal', $t)
                                            ->where('waktu_mulai', $ts)
                                            ->where('grup_id', '!=', $grup->id_grup)
                                            ->exists();

                                        // Jika jadwal sudah ada di grup lain
                                        $disabledClass = $jadwalDiGrupLain ? 'bg-black-300 pointer-events-none' : '';

                                        $maxTampil = 1; // jumlah nama yang ditampilkan
                                        $totalAnggotaKetersediaan = count($anggotaYangTersedia);
                                    @endphp

                                    <td class="item {{ $disabledClass }}" data-tanggal="{{ $t }}"
                                        data-waktu="{{ $ts }}" data-role="{{ $role }}"
                                        data-grup-id="{{ $grup->id_grup }}" data-durasi="{{ $grup->durasi }}"
                                        style="height: 50px; max-width:20px; min-height: 100px; height: 100px; cursor: pointer; color: #6c747e; vertical-align: middle; text-align: center;">

                                        @if ($jadwal)
                                            <!-- Jika jadwal sudah ada, tampilkan tombol -->
                                            <button class="bjadwal btn btn-sm btn-primary custom w-100"
                                                data-bs-toggle="offcanvas" data-bs-target="#jadwal"
                                                data-jadwal-id="{{ $jadwal->id ?? '' }}"
                                                data-grup-id="{{ $grup->id_grup }}"
                                                data-judul="{{ $jadwal->judul ?? '' }}"
                                                data-tanggal="{{ $jadwal->tanggal ?? '' }}"
                                                data-waktu-mulai="{{ $jadwal->waktu_mulai ?? '' }}"
                                                data-durasi="{{ $jadwal->durasi ?? '' }}"
                                                data-user-tersedia="{{ $userTersedia ? '1' : '0' }}">
                                                <div class="d-flex flex-column text-center">
                                                    <div class="title">{{ $jadwal->judul }}</div>
                                                    <div class="subtitle d-flex align-items-center">
                                                        <i class="bi bi-person icon me-2"></i>
                                                        <p class="m-0">{{ $anggotaYangTersedia->count() }} Anggota</p>
                                                    </div>
                                                </div>
                                            </button>
                                        @elseif ($jadwalDiGrupLain)
                                            <!-- Jika sudah ada jadwal di grup lain -->
                                            <div class="text-muted" style="font-size: 14px; color:aqua">Sudah ada jadwal
                                            </div>
                                        @elseif ($anggotaYangTersedia->isNotEmpty())
                                            <!-- Jika tidak ada jadwal, tapi ada anggota yang bersedia -->
                                            <div class="schedule-content d-flex flex-column w-100 h-100 p-2">
                                                @foreach ($anggotaYangTersedia->take($maxTampil) as $anggota)
                                                    <div
                                                        class="anggota-d d-flex justify-content-between align-items-center">
                                                        <p class="m-0 fw-bold anggota-hadir"
                                                            data-user-id="{{ $anggota->user->id ?? '' }}"
                                                            data-tanggal="{{ $t }}"
                                                            data-waktu="{{ $ts }}">
                                                            {{ $anggota->user->name ?? '' }}
                                                        </p>
                                                        <i class="bi bi-check-square fs-4"></i>
                                                    </div>
                                                @endforeach
                                                @if ($totalAnggotaKetersediaan > $maxTampil)
                                                    <p class="m-0 text-muted">
                                                        +{{ $totalAnggotaKetersediaan - $maxTampil }} anggota
                                                    </p>
                                                @endif
                                            </div>
                                        @else
                                            <!-- Jika tidak ada jadwal maupun anggota yang bersedia, tampilkan ikon tambah -->
                                            <i class="lebel bi bi-plus-circle"
                                                style="font-size: 18px; color: #007bff;"></i>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
        {{-- modal --}}
        @include('Jadwal.modal.keluar_grup')
        @include('Jadwal.modal.buat_jadwal')
        @include('Jadwal.modal.hapus_grup')
        @include('Jadwal.modal.anggota_free')
        @include('Jadwal.modal.ketersediaan')
        @include('Jadwal.modal.batal_ketersediaan')
        {{-- modal --}}

        {{-- offcanvas --}}
        @include('Jadwal.off_canvas.edit_grup')
        @include('jadwal.off_canvas.daftar_anggota')
        {{-- offcanvas --}}
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="toastJadwalAda" class="toast align-items-center text-white bg-warning border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-info-circle"></i> Sudah ada jadwal di grup, Tidak dapat mengedit durasi, tanggal &
                        waktu
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>


        </div>
    </div>
    @if (session('toast_warning'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('toast_warning') }}", "warning");
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $("#textPreview").click(function() {
                var teks = $(this);
                if (teks.hasClass("text-truncate")) {
                    // Expand
                    teks.removeClass("text-truncate")
                        .css({
                            "white-space": "normal",
                            "overflow": "visible",
                            "text-overflow": "unset"
                        })
                        .attr("title", "Klik untuk sembunyikan");
                } else {
                    // Collapse
                    teks.addClass("text-truncate")
                        .css({
                            "white-space": "nowrap",
                            "overflow": "hidden",
                            "text-overflow": "ellipsis"
                        })
                        .attr("title", "Klik untuk melihat selengkapnya");
                }
            });
        });

        //anggota keluar grup
        $(document).ready(function() {
            let groupId;

            // Saat tombol "Keluar dari Grup" diklik, simpan ID grup
            $('button[data-bs-target="#leave_grup"]').click(function() {
                groupId = $(this).data('grup-id');
            });

            // Saat tombol "Keluar" di modal diklik
            $('#confirmLeaveBtn').click(function() {
                $.ajax({
                    url: '/grup/' + groupId + '/keluar',
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        window.location.href = "/grup"
                    },
                    error: function(xhr) {
                        alert("Gagal keluar dari grup.");
                    }
                });
            });
        });

        //validasi jika jadwal ada maka tidak bisa edit
        $(document).ready(function() {
            $(".edit").click(function(event) {
                let jadwalAda = $(this).data("jadwal-ada");

                if (jadwalAda) {
                    event.preventDefault(); // Mencegah offcanvas muncul
                    let toastEl = new bootstrap.Toast($("#toastJadwalAda")[0]);
                    toastEl.show();
                }
            });
        });


        //hapus grup
        $(document).ready(function() {
            let selectedIDG = null;

            // Simpan ID Grup saat tombol "Hapus" ditekan
            $(document).on("click", ".hapus", function() {
                selectedIDG = $(this).data("grup-id");
                console.log("ID Grup yang dipilih:", selectedIDG);

                // Simpan ID dalam modal 
                $("#delete_grup").attr("data-id", selectedIDG);
            });

            // "Konfirmasi Hapus grup" 
            $(document).on("click", ".hapus_grup", function() {
                let idGrup = $("#delete_grup").attr("data-id");
                console.log("ID Grup yang akan dihapus:", idGrup); // Debugging

                if (!idGrup) {
                    alert("Terjadi kesalahan! ID Grup tidak ditemukan.");
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "/hapus_grup/" + idGrup,
                    data: {
                        id: idGrup
                    },
                    success: function(response) {
                        // alert("Grup berhasil dihapus!");
                        // location.reload();
                        window.location.href = "/grup"
                        var toast = new bootstrap.Toast(document.getElementById(
                            "hapusGrup"));
                        toast.show();
                    },
                    error: function(xhr) {
                        alert("Gagal menghapus grup. Silakan coba lagi.");
                    }
                });
            });
        });

        function showToast(message) {
            $("#toastpemberitahuan").text(message);
            $("#toastNotification").toast("show");
        }

        //batal kehadiran anggota
        $(document).ready(function() {
            // Saat user mengklik namanya di dalam daftar kehadiran
            $(document).on("click", ".anggota-hadir", function(event) {
                event.stopPropagation(); // Hindari modal lain muncul

                let userId = $(this).data("user-id");
                let tanggal = $(this).data("tanggal");
                let waktu = $(this).data("waktu");

                $("#selectedDate").val(tanggal);
                $("#selectedTime").val(waktu);

                console.log("User ID:", userId);
                console.log("Tanggal:", tanggal);
                console.log("Waktu:", waktu);

                if (userId == 1) { // nanti diganti dengan user yang login
                    $("#cancelAvailability").modal("show");
                    $("#selectedDateLabel").text(tanggal);
                    $("#selectedTimeLabel").text(waktu);
                    $("#cancelUserId").val(userId);
                }
            });

            // Saat tombol "Konfirmasi" ditekan
            $("#confirmCancel").click(function() {
                let userId = 1;
                // let userId = $("#cancelUserId").val();
                let tanggal = $("#selectedDate").val();
                let waktu = $("#selectedTime").val();

                console.log(userId)
                console.log(tanggal)
                console.log(waktu)

                $.ajax({
                    type: "POST",
                    url: "/batalAvai",
                    data: {
                        user_id: userId,
                        tanggal: tanggal,
                        waktu: waktu
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $("#cancelAvailability").modal("hide");
                        // $(".anggota-d").remove();
                        $(".lebel").show();
                        var toast = new bootstrap.Toast(document.getElementById(
                            "batalHadir"));
                        toast.show();
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Gagal membatalkan kehadiran. Silakan coba lagi.");
                    }
                });
            });
        });

        /* fungsi memunculkan modal dengan klik */
        $(".item").click(function() {
            openModal($(this))
        })

        let selected_tanggal;
        let selected_waktu;
        let selected_durasi;

        /* membuka modal saat kolom di klik */
        function openModal(cell) {
            selectedCell = $(cell);

            // Cek apakah kolom memiliki keterangan "Sudah ada jadwal"
            if (selectedCell.text().trim() === "Sudah ada jadwal") {
                console.log("Anda sudah mempunyai jadwal pada tanggal dan waktu ini.");
                showToast("Anda sudah mempunyai jadwal pada tanggal dan waktu ini.");

                return; // Hentikan eksekusi fungsi
            }

            // Mengambil data tanggal, waktu, dan role dari atribut data
            let tanggal = selectedCell.data("tanggal");
            let waktu = selectedCell.data("waktu");
            let role = selectedCell.data("role");
            let idgrup = selectedCell.data("grup-id");
            let durasi = selectedCell.data("durasi");
            selected_tanggal = tanggal;
            selected_waktu = waktu;
            selected_durasi = durasi;

            // Cek apakah user sudah menyediakan kehadiran
            let userTersedia = selectedCell.find(".anggota-hadir[data-user-id='1']").length > 0;

            if (userTersedia) {
                console.log("User sudah hadir, tidak menampilkan modal penyediaan ");
                return; // Hentikan fungsi jika user sudah hadir
            }

            console.log("Tanggal:", tanggal);
            console.log("Waktu:", waktu);
            console.log("Role:", role);
            console.log("idgrup:", idgrup);
            console.log("durasi:", durasi);

            // Menampilkan tanggal & waktu di modal
            $("#selectedDate").val(tanggal);
            $("#selectedTime").val(waktu);

            $("#selectedDate22").text(tanggal);
            $("#selectedTime22").text(waktu);

            $("#selectedDate21").text(tanggal);
            $("#selectedTime21").text(waktu);

            // Menampilkan modal sesuai role
            if (role === "admin") {
                $("#scheduleModal").modal("show"); // Modal untuk Admin
            } else if (role === "anggota") {
                $("#availability").modal("show"); // Modal untuk Anggota
            } else {
                alert("Role tidak dikenali!");
            }
        }

        /* membuka modal */


        /* tooltips */
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip('dispose').tooltip();
        });

        /* tooltips */

        //menghapus jadwal
        $(document).ready(function() {
            let selectedJadwalId = null;

            // Saat tombol jadwal diklik, simpan ID jadwal ke modal
            $(".bjadwal").click(function() {
                selectedJadwalId = $(this).data("jadwal-id");
                console.log("Jadwal ID terpilih:", selectedJadwalId);
            });

            // Saat tombol hapus di modal diklik
            $(".delete-meet").click(function() {
                if (!selectedJadwalId) {
                    alert("Jadwal tidak ditemukan!");
                    return;
                }

                $.ajax({
                    url: "/jadwal/" + selectedJadwalId,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        console.log("Response:", response);
                        if (response.success) {
                            // Hapus tombol jadwal dari tampilan
                            $(".bjadwal[data-jadwal-id='" + selectedJadwalId + "']").remove();

                            // Tutup modal dan offcanvas
                            $("#cancel").modal("hide");
                            $("#jadwal").offcanvas("hide");

                            // Hapus backdrop modal jika masih ada
                            $(".modal-backdrop").remove();
                            $("body").removeClass("modal-open").css("overflow", "");
                            location.reload();
                            var toast = new bootstrap.Toast(document.getElementById(
                                "successToast"));
                            toast.show();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Terjadi kesalahan saat menghapus jadwal.");
                    }
                });
            });
        });

        // offcanvas di buka    
        $(document).ready(function() {
            $(".bjadwal").on("click", function(event) {
                event.stopPropagation(); // Mencegah modal utama terbuka
            });
        });

        //pembuatan jadwal
        $(document).on("click", "#confirmSchedule", function() {
            let tanggal = $("#selectedDate").val();
            let waktu = $("#selectedTime").val();
            let durasi = $("#selectDur").val();

            // Cari elemen <td> yang sesuai dengan tanggal & waktu
            let selectedCell = $(".item[data-tanggal='" + tanggal + "'][data-waktu='" + waktu + "']");

            // console.log("Selected Cell: ", selectedCell);

            // Ambil grup_id 
            let grup_id = selectedCell.data("grup-id");

            if (!grup_id) {
                alert("Grup id tidak ada.");
                return;
            }

            $.ajax({
                url: "/saveSchedules",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    grup_id: grup_id,
                    tanggal: tanggal,
                    waktu: waktu,
                    durasi: selected_durasi,
                    judul: $("#scheduleInput").val(),
                },
                success: function(response) {
                    // console.log("Response dari server:", response);

                    if (!response || !response.anggota) {
                        console.error("Response tidak memiliki properti 'anggota'.");
                        return;
                    }

                    // Ambil judul dan jumlah anggota yang sudah tersedia
                    let judul = $("#scheduleInput").val();
                    let anggotaCount = response.anggota.length;

                    // Ubah tampilan menjadi tombol
                    setTimeout(() => {
                        selectedCell.empty().append(`
            <button class="bjadwal btn btn-primary custom w-100 h-100"
            data-bs-toggle="offcanvas"
            data-bs-target="#jadwal">
            <div class="d-flex flex-column text-center">
            <div class="title text-wrap">${judul}</div>
            <div class="subtitle d-flex align-items-center justify-content-center gap-1 flex-wrap">
            <i class="bi bi-person icon me-1"></i>
            <p class="m-0">${anggotaCount} Anggota</p>
            </div>
            </div>
            </button>

            `);
                    }, 500);
                    setTimeout(() => {
                        $("#scheduleModal").modal("hide");
                    }, 500);
                    location.reload();
                    var toast = new bootstrap.Toast(document.getElementById(
                        "jadwalDibuat"));
                    toast.show();
                },
                error: function(xhr) {
                    alert("Terjadi kesalahan saat menyimpan jadwal.");
                }
            });

        });

        //konfirmasi anggota untuk memberi jadwal
        $(document).on("click", "#confirmAvailability", function() {
            let userId = 3;
            let grup_id = selectedCell.data("grup-id");
            let tanggal = $("#selectedDate").val();
            let waktu = $("#selectedTime").val();

            // data waktu dan tanggal yang dipilih
            let cell = $(".item[data-tanggal='" + tanggal + "'][data-waktu='" + waktu + "']");

            console.log("Tanggal yang dikirim:", tanggal);
            console.log("Waktu yang dikirim:", waktu);

            $.ajax({
                url: "/schedules",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    user_id: userId,
                    grup_id: grup_id,
                    tanggal: tanggal,
                    waktu: waktu,
                },
                success: function(response) {
                    console.log("Response dari server:", response);

                    let userListHTML = response.users.map(user => `
                <div class="d-flex justify-content-between align-items-center">
                    <p class="m-0 fw-bold">${user}</p>
                    <i class="bi bi-check-square fs-4"></i>
                </div>
                `).join('');
                    // data sesuai dengan tanggal dan waktu
                    let cell = $(".item[data-tanggal='" + tanggal + "'][data-waktu='" + waktu + "']");

                    // Update tampilan 
                    cell.html(`
                <div class="schedule-content d-flex flex-column w-100 h-100 p-2">
                ${userListHTML}
                </div>
                `);
                    // Tutup modal 
                    $("#availability").modal("hide");
                    location.reload();
                    var toast = new bootstrap.Toast(document.getElementById("sediaAnggota"));
                    toast.show();
                },

                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert("Terjadi kesalahan, coba lagi.");
                }
            });
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //detail jadwal
        $(document).ready(function() {
            let selectedJadwalId = null;
            let selectedGrupId = null;
            let selectedTanggal = null;
            let selectedWaktuMulai = null;

            $(".bjadwal").on("click", function() {
                event.stopPropagation();

                selectedJadwalId = $(this).data("jadwal-id");
                selectedGrupId = $(this).data("grup-id");
                selectedTanggal = $(this).data("tanggal");
                selectedWaktuMulai = $(this).data("waktu-mulai");

                console.log("Jadwal ID :", selectedJadwalId);
                console.log("Grup ID :", selectedGrupId);
                // Ambil data dari atribut tombol
                let jadwalId = $(this).data("jadwal-id");
                let judul = $(this).data("judul");
                let tanggal = $(this).data("tanggal");
                let waktuMulai = $(this).data("waktu-mulai");
                let durasi = $(this).data("durasi");

                console.log(tanggal);
                console.log(waktuMulai);

                if (!jadwalId) {
                    console.error("Jadwal ID tidak ditemukan");
                    return;
                }

                // Format Tanggal DD-MM-YYYY
                let formattedTanggal = formatTanggal(tanggal);

                // Format Waktu HH:MM
                let formattedWaktuMulai = formatWaktu(waktuMulai);

                // Format Durasi menjadi menit
                let formattedDurasi = formatDurasi(durasi);

                // Masukkan data ke dalam Offcanvas
                $("#judul").text(judul);
                $(".tanggal-1 p").text(formattedTanggal);
                $(".wktu .waktu-mulai").text(formattedWaktuMulai);
                $(".durasi p").text(formattedDurasi);

                // Kosongkan daftar sebelum menambahkan yang baru
                let hadirList = $(".present");
                // hadirList.html("<h5><strong>Dihadiri Oleh:</strong></h5>");

                // untuk mendapatkan daftar anggota yang hadir
                $.ajax({
                    url: `/jadwal/${jadwalId}/anggota`,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let anggotaList = "";
                        data.anggota.forEach(anggota => {
                            anggotaList += `<div class="box-item d-flex">
                                    <div class="avatar-search">${anggota.name.charAt(0)}</div>
                                    <div class="nama-user mt-1">
                                        <h6>${anggota.name}</h6>
                                        <p style="margin-top: -10px">${anggota.email}</p>
                                    </div>
                                </div>`;
                        });

                        $(".present").html(anggotaList);

                        // Cek apakah user sudah hadir
                        if (!data.sudahHadir) {
                            $("#hadiri-jadwal").show();
                        } else {
                            $("#hadiri-jadwal").hide();
                        }

                        $("#jadwal").offcanvas("show");
                    },
                });
            });

            // Saat tombol "Konfirmasi Hadir" ditekan kirim data ke backend
            $("#konfirmasiHadir").click(function() {
                console.log("jdawl", selectedJadwalId);
                console.log("grup", selectedGrupId);
                if (!selectedJadwalId) {
                    alert("Jadwal ID tidak valid!");
                    return;
                }

                $.ajax({
                    url: "/hadiri-jadwal",
                    method: "POST",
                    data: {
                        jadwal_id: selectedJadwalId,
                        grup_id: selectedGrupId,
                        tanggal: selectedTanggal,
                        waktu_mulai: selectedWaktuMulai,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#konfirmasi-modal").hide();
                        $("#jadwal").offcanvas("hide");
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Gagal menghadiri jadwal!");
                        console.error(xhr.responseText);
                    }
                });
            });

            // memformat tanggal ke format DD-MM-YYYY
            function formatTanggal(tanggal) {
                if (!tanggal) return "-";

                let options = {
                    day: "numeric",
                    month: "long",
                    year: "numeric"
                };
                return new Date(tanggal).toLocaleDateString("id-ID", options);
            }

            // memformat waktu ke format HH:MM
            function formatWaktu(waktu) {
                if (!waktu) return "-";
                return waktu.substring(0, 5);
            }

            // menampilkan durasi dalam menit
            function formatDurasi(durasi) {
                if (!durasi) return "-";
                let angkaDurasi = durasi.match(/\d+/);
                return angkaDurasi ? `${angkaDurasi[0]} Menit` : "-";
            }

        });
    </script>
    @include('Jadwal.off_canvas.jadwal')
@endsection
