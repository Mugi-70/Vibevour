@extends('Jadwal.sidebar')

@section('header')
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body pt-3 pb-3 pe-3 border-0">
            <div class="d-flex align-items-center">
                <button class="btn me-2 d-lg-none" id="toggleSidebar" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0">Pembuatan Grup</h5>
                <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Halaman Grup">
                    <i class="bi bi-question-circle"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="inviteToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    <!-- Pesan sukses akan masuk sini -->
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <form action="{{ route('coba_bikin') }}" method="POST">
        @csrf
        <div class="card shadow-sm border-0 p-3 justify-content-center" style="overflow: hidden; max-width: 100%;">

            <div class="mb-4">
                <label for="namaGrup" class="form-label fw-bold">Nama Grup</label>
                <input type="text" class="form-control" id="namaGrup" name="nama_grup" placeholder="Masukkan Nama Grup"
                    required>
            </div>

            <!-- Anggota -->
            <div class="mb-4 flex-column flex-md-row align-items-md-center">
                <label for="anggota" class="form-label fw-bold">Anggota</label>
                <div class="col d-flex">
                    {{-- <div class="card" id="anggotaList" style="height: 40px; padding: 10px; flex-wrap: wrap;">
                    </div> --}}
                    <select id="searchAjax" name="anggota[]" multiple="multiple" class="form-select"
                        style="width: 100%; height: 100%">
                    </select>
                </div>
                <label for="anggotalist" class="form-label mt-1">Daftar Anggota :</label>
                <button class="btn btn-primary" id="openModalButton" type="button" data-bs-toggle="modal"
                    data-bs-target="#inviteForm">
                    Undang via Email
                </button>

                <div class="card" id="anggotaList" style="height: auto; padding: 5px;">
                    <p id="emptyMessage" style="text-align: center; color: gray;">Belum menambahkan anggota</p>
                </div>

            </div>
            <!-- Durasi dan Waktu -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="durasi" class="form-label fw-bold">Durasi</label>
                    <div class="input-group">
                        <select class="form-select" id="durasi" name="durasi" required>
                            <option value="15 minutes">15 menit</option>
                            <option value="30 minutes">30 menit</option>
                            <option value="45 minutes">45 menit</option>
                            <option value="60 minutes">60 menit</option>
                        </select>
                        <span class="input-group-text">
                            <i class="bi bi-clock"></i>
                        </span>
                    </div>
                    <small class="text-muted"><i class="bi bi-question-circle"></i> Atur lama waktu jadwal di
                        sini.</small>
                </div>

                <!-- Waktu -->
                <div class="col-md-6">
                    <label for="waktu" class="form-label fw-bold">Waktu</label>
                    <div class="d-flex">
                        {{-- mulai --}}
                        <div class="col-5">
                            <div class="input-group flex-nowrap">
                                <input type="text" class="form-control" id="waktuMulai" name="waktu_mulai"
                                    placeholder="01:00" value="">
                                <span class="input-group-text">
                                    <i class="bi bi-clock"></i>
                                </span>
                            </div>
                        </div>
                        <span class="col-1 align-self-center mx-2">s.d.</span>
                        {{-- selesai --}}
                        <div class="col-5">
                            <div class="input-group flex-nowrap">
                                <input type="text" class="form-control" id="waktuSelesai" name="waktu_selesai"
                                    placeholder="23:00">
                                <span class="input-group-text">
                                    <i class="bi bi-clock"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted"><i class="bi bi-question-circle"></i> Tentukan waktu operasional jadwal
                        grup.</small>
                </div>
            </div>
            {{-- <div class="position-relative w-100 mb-2 mb-md-0 me-md-2">
                        <input type="text" class="form-control" id="tanggalMulai" name="tanggal_mulai" required>
                        <i class="bi bi-calendar position-absolute top-50 end-0 translate-middle-y me-2"></i>
                    </div> --}}
            <!-- Tanggal -->
            <div class="mb-4">
                <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                <div class="row gx-2">
                    <!-- Tanggal Mulai (dengan ikon di kiri) -->
                    <div class="col-6">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text">
                                <i class="bi bi-calendar"></i>
                            </span>
                            <input type="text" class="form-control" id="tanggalMulai" name="tanggal_mulai"
                                placeholder="dd/mm/yy">
                        </div>
                    </div>

                    <div class="col-1 text-center align-self-center">s.d</div>

                    <!-- Tanggal Selesai (tanpa ikon) -->
                    <div class="col-5">
                        <input type="text" class="form-control" id="tanggalSelesai" name="tanggal_selesai"
                            placeholder="dd/mm/yy">
                    </div>
                </div>

                <small class="text-muted d-block mt-1">
                    <i class="bi bi-question-circle"></i>
                    Tentukan rentang tanggal untuk kegiatan grup.
                </small>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi" placeholder="Masukkan deskripsi"></textarea>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-1">
                <a href="/grup" class="btn btn-secondary m-1">
                    <i class="bi bi-chevron-compact-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success m-1" style="border:none">
                    <i class="bi bi-save me-2"></i> Simpan Grup
                </button>
            </div>

    </form>

    @include('Jadwal.modal.tambah_anggota')


    <script>
        $('#inviteForm').on('hidden.bs.modal', function() {
            // Pindahkan fokus ke tombol yang membuka modal
            $('#openModalButton').focus();
        });

        $(document).ready(function() {
            $('#inviteForm').submit(function(e) {
                e.preventDefault();

                var email = $('#email').val();
                if (email === "") {
                    alert("Email harus diisi!");
                    return;
                }

                $.ajax({
                    url: '/undang',
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        email: email
                    },
                    success: function(response) {
                        // Tampilkan pesan di dalam toast
                        $('#toastMessage').text(response.message);

                        // Tampilkan toast Bootstrap
                        var inviteToast = new bootstrap.Toast($('#inviteToast'));
                        inviteToast.show();

                        // Tutup modal setelah sukses
                        $('#inviteModal').modal('hide');

                        // Reset input
                        $('#email').val('');
                    },
                    error: function(xhr) {
                        $('#toastMessage').text('Gagal mengirim undangan: ' + xhr.responseJSON
                            .message);
                        var inviteToast = new bootstrap.Toast($('#inviteToast'));
                        inviteToast.show();
                    }
                });
            });
        });


        $(document).ready(function() {
            $("#sendInvitation").click(function() {
                let email = $("#emailInput").val();

                if (email === "") {
                    alert("Email harus diisi!");
                    return;
                }

                $("#inviteForm").submit(); // Kirim hanya form modal
            });
        });


        /* tanggal */
        let startDatePicker = flatpickr("#tanggalMulai", {
            dateFormat: "d-m-Y",
            minDate: "today",
            onChange: function(selectedDates, dateStr) {
                endDatePicker.set("minDate", dateStr);
            }
        });

        let endDatePicker = flatpickr("#tanggalSelesai", {
            dateFormat: "d-m-Y",
            minDate: "today",
        });
        /* tanggal */

        /* waktu */
        let startPicker = flatpickr("#waktuMulai", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            onChange: function(selectedDates, dateStr) {
                endPicker.set("minTime", dateStr);
            }
        });

        let endPicker = flatpickr("#waktuSelesai", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        /* waktu */

        //mengecek isi card daftar anggota
        $(document).ready(function() {
            function checkEmptyMessage() {
                if ($('#anggotaList .anggota-item').length > 0) {
                    $('#emptyMessage').remove(); // Hapus elemen dari DOM
                } else {
                    if ($('#emptyMessage').length === 0) {
                        $('#anggotaList').append(
                            '<p id="emptyMessage" class="text-muted">Belum menambahkan anggota</p>');
                    }
                }
            }

            $('#searchAjax').select2({
                placeholder: "Cari anggota",
                tags: true,
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: '/cari',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data, params) {
                        if (data.items.length === 0) {
                            return {
                                results: [{
                                    id: 'invite',
                                    text: params.term,
                                    email: '',
                                    isInvite: true
                                }]
                            };
                        }

                        return {
                            results: data.items.map(item => ({
                                id: item.id,
                                text: item.text,
                                email: item.email,
                                icon: item.text ? item.text.charAt(0).toUpperCase() : "?"
                            }))
                        };
                    }
                },
                templateResult: function(data) {
                    if (!data.id) {
                        return data.text;
                    }

                    return $(`
                <div style="display: flex; align-items: center;">
                    <div style="width: 30px; height: 30px; background-color: red; color: white; 
                                display: flex; align-items: center; justify-content: center; 
                                border-radius: 50%; font-weight: bold; margin-right: 10px;">
                        ${data.icon}
                    </div>
                    <div>
                        <div style="font-weight: bold;">${data.text}</div>
                        <div style="color: gray; font-size: 12px;">${data.email}</div>
                    </div>
                </div>
            `);
                }

            });

            checkEmptyMessage();

            $('#searchAjax').on('select2:select', function(e) {
                var data = e.params.data;
                var anggotaList = $('#anggotaList');

                if ($(`#anggota-${data.id}`).length === 0) {
                    var icon = data.icon ? data.icon : '?';
                    var emailText = data.email ? data.email : 'Email tidak tersedia';

                    var anggotaItem = $(`
                <div id="anggota-${data.id}" class="anggota-item" 
                     style="display: flex; align-items: center; margin-bottom: 10px; 
                            padding: 8px; background-color: #f8f9fa; border-radius: 8px;">
                    <div style="width: 30px; height: 30px; background-color: red; color: white; 
                                display: flex; align-items: center; justify-content: center; 
                                border-radius: 50%; font-weight: bold; margin-right: 10px;">
                        ${icon}
                    </div>
                    <div style="flex-grow: 1;">
                        <div style="font-weight: bold;">${data.text}</div>
                        <div style="color: gray; font-size: 12px;">${emailText}</div>
                    </div>
                    <button class="remove-anggota" data-id="${data.id}" 
                            style="background: none; border: none; color: red; font-size: 24px; cursor: pointer;">&times;</button>
                </div>
            `);

                    anggotaList.append(anggotaItem);
                }
            });

            $(document).on('click', '.remove-anggota', function() {
                var anggotaId = $(this).data('id');

                $(`#anggota-${anggotaId}`).remove();

                var selectedValues = $('#searchAjax').val() || [];
                selectedValues = selectedValues.filter(value => value !== anggotaId.toString());
                $('#searchAjax').val(selectedValues).trigger('change');

                checkEmptyMessage();
            });

            checkEmptyMessage();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection
