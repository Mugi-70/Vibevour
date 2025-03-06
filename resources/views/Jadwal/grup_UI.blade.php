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
    <div class="row position-relative">
        <div class="card shadow-sm w-100" style=" border:none; ">
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
                                <button class="btn btn-outline-danger mt-2" data-bs-toggle="modal"
                                    data-bs-target="#leave_grup">
                                    <i class="bi bi-trash"></i> Hapus Grup
                                </button>
                            @elseif ($role === 'anggota')
                                <button class="btn btn-outline-danger mt-2" data-bs-toggle="modal"
                                    data-bs-target="#leave_grup">
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
                        @unless ($role == 'admin')
                            <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#delete_grup"
                                id="hapus_grup{{ $grup->id_grup }}">
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
                                    {{ \Carbon\Carbon::parse($t)->translatedFormat('d M Y') }}
                                </td>
                                @foreach ($waktu_list as $ts)
                                    @php
                                        $jadwals = App\Models\Ketersediaan::where('tanggal', $t)
                                            ->where('waktu', $ts)
                                            ->get();
                                    @endphp

                                    <td class="item" data-tanggal="{{ $t }}"
                                        data-waktu="{{ $ts }}" data-role="{{ $role }}"
                                        style="height: 50px; max-width:20px; cursor: pointer; color: #6c747e; vertical-align: middle; text-align: center;">

                                        @if ($jadwals->isNotEmpty())
                                            <div class="schedule-content d-flex flex-column w-100 h-100 p-2">
                                                @foreach ($jadwals as $jadwal)
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="m-0 fw-bold">
                                                            {{ $jadwal->user->name ?? 'Tidak Diketahui' }}</p>
                                                        <i class="bi bi-check-square fs-4"></i>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
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
        {{-- modal --}}

        {{-- offcanvas --}}
        @include('Jadwal.off_canvas.edit_grup')
        @include('jadwal.off_canvas.daftar_anggota')
        {{-- offcanvas --}}
    </div>


    <script>
        /* fungsi memunculkan modal dengan klik */
        $(".item").click(function() {
            openModal($(this))
        })

        /* membuka modal saat kolom di klik */
        function openModal(cell) {
            selectedCell = $(cell);

            // Mengambil data tanggal, waktu, dan role dari atribut data
            let tanggal = selectedCell.data("tanggal");
            let waktu = selectedCell.data("waktu");
            let role = selectedCell.data("role");

            // Menampilkan tanggal & waktu di modal
            $("#selectedDate").val(tanggal);
            $("#selectedTime").val(waktu);

            $("#selectedDate").text(tanggal);
            $("#selectedTime").text(waktu);

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

        /* saving jadwal */
        // function saveSchedule() {
        //     let text = $("#scheduleInput").val(); // Ambil input dari modal
        //     let role = selectedCell.data("role"); // Ambil role dari cell yang diklik

        //     if (selectedCell) {
        //         // Cek apakah cell sudah memiliki elemen
        //         let existingButton = selectedCell.find("button");
        //         let existingContent = selectedCell.find(".schedule-content");

        //         $(document).ready(function() {
        //             $(".lebel").hide();
        //         });

        //         if (role === "admin") {
        //             // Jika admin, gunakan tombol jadwal
        //             if (existingButton.length === 0) {
        //                 let button = $(`
    //         <button class="bjadwal btn btn-primary custom w-100 h-100"
    //             data-bs-toggle="offcanvas"
    //             data-bs-target="#jadwal">
    //             <div class="d-flex flex-column text-center">
    //                 <div class="title">${text || "Lihat"}</div>
    //                 <div class="subtitle d-flex align-items-center">
    //                     <i class="bi bi-person icon me-2"></i>
    //                     <p class="m-0">1 Anggota</p>
    //                 </div>
    //             </div>
    //         </button>
    //     `);
        //                 button.click(function(event) {
        //                     event.stopPropagation(); // Mencegah modal terbuka saat tombol diklik
        //                 });
        //                 selectedCell.append(button);
        //             } else {
        //                 existingButton.html(`
    //         <div class="d-flex flex-column text-center">
    //             <div class="title">${text || "Lihat"}</div>
    //             <div class="subtitle d-flex align-items-center">
    //                 <i class="bi bi-person icon me-2"></i>
    //                 <p class="m-0">1 Anggota</p>
    //             </div>
    //         </div>
    //     `);
        //             }
        //         } else {
        //             // Jika anggota, tampilkan schedule-content
        //             if (existingContent.length === 0) {
        //                 let content = $(`
    //         <div class="schedule-content d-flex flex-column w-100 h-100 p-2">
    //             <div class="d-flex justify-content-between align-items-center">
    //                 <p class="m-0 fw-bold">${text || "Notaris"}</p>
    //                 <i class="bi bi-check-square fs-4"></i>
    //             </div>
    //         </div>
    //     `);
        //                 selectedCell.append(content);
        //             } else {
        //                 existingContent.html(`
    //         <div class="d-flex justify-content-between align-items-center">
    //             <p class="m-0 fw-bold">${text || "Notaris"}</p>
    //             <i class="bi bi-check-square fs-4"></i>
    //         </div>
    //     `);
        //             }
        //         }
        //     }

        //     // Tutup modal
        //     $("#scheduleModal").modal("hide");
        //     $("#availability").modal("hide");
        // }

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

                $(".lebel").show();

                // Reset elemen offcanvas agar bisa ditampilkan lagi
                setTimeout(function() {
                    $("#jadwal").removeClass("show").attr("aria-hidden", "true");
                    $(".offcanvas-backdrop").remove();
                }, 500);
            });

        });

        //kkonfirmasi anggota untuk memberi jadwal
        $(document).on("click", "#confirmAvailability", function() {
            let userId = 2;
            let grup_id = 1;
            let tanggal = $("#selectedDate").text(); // Gunakan `.text()` 
            let waktu = $("#selectedTime").text();

            // Pilih elemen yang diklik sebelumnya
            let cell = $(".item[data-tanggal='" + tanggal + "'][data-waktu='" + waktu + "']");

            // Debugging untuk memastikan nilai benar
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
                    // elemen yang sesuai dengan tanggal dan waktu
                    let cell = $(".item[data-tanggal='" + tanggal + "'][data-waktu='" + waktu + "']");

                    // Update tampilan tanpa reload
                    cell.html(`
        <div class="schedule-content d-flex flex-column w-100 h-100 p-2">
            ${userListHTML}
        </div>
        `);
                    // **Tutup modal setelah berhasil menyimpan**
                    $("#availability").modal("hide");
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
    </script>
    @include('Jadwal.off_canvas.jadwal')
@endsection
