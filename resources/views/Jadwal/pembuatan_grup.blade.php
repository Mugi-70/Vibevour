@extends('Jadwal.sidebar')

@section('header')
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body pt-3 pb-3 pe-3 border-0">
            <div class="d-flex align-items-center">
                <button class="btn me-2" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0">Pembuatan Grup</h5>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ route('coba_bikin') }}" method="POST">
        @csrf
        <div class="card p-3 justify-content-center" style="overflow: hidden; max-width: 100%;">

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
                    <select id="searchAjax" class="form-select" style="width: 100%; height: 100%">
                    </select>
                    <!-- Tombol di Bawah Saat Mobile -->
                    <button type="button"
                        class="btnTambah btn btn-outline-secondary btn-sm mt-2 mt-md-0 align-self-md-end d-none">
                        <i class="bi bi-person-plus"></i>
                    </button>
                </div>
                <label for="anggotalist" class="form-label mt-1">Daftar Anggota :</label>
                <div class="card" id="anggotaList" style="height: auto; padding: 5px;">
                    <p id="emptyMessage" style="text-align: center; color: gray;">Belum menambahkan anggota</p>
                </div>

            </div>


            @include('Jadwal.modal.tambah_anggota')

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
                                placeholder="dd/mm/yy" required>
                        </div>
                    </div>

                    <div class="col-1 text-center align-self-center">s.d</div>

                    <!-- Tanggal Selesai (tanpa ikon) -->
                    <div class="col-5">
                        <input type="text" class="form-control" id="tanggalSelesai" name="tanggal_selesai"
                            placeholder="dd/mm/yy" required>
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


    <script>
        //mengecek isi card daftar anggota
        $(document).ready(function() {
            function checkEmptyMessage() {
                if ($('#anggotaList .anggota-item').length === 0) {
                    $('#emptyMessage').show();
                } else {
                    $('#emptyMessage').hide();
                }
            }

            //cari anggota
            $('#searchAjax').select2({
                placeholder: "Cari anggota",
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
                    processResults: function(data) {
                        return {
                            results: data.items.map(item => ({
                                id: item.id,
                                text: item.text,
                                // description: "Mengundang Anggota",
                                email: item.email,
                                icon: item.text.charAt(0).toUpperCase()
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
                    <div style="width: 30px; height: 30px; background-color: red; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; margin-right: 10px;">
                        ${data.icon}
                    </div>
                    <div>
                        <div style="font-weight: bold;">${data.text}</div>
                        <div style="color: gray; font-size: 12px;">${data.email}</div>
                    </div>
                </div>
            `);
                },
            });

            $('#searchAjax').on('select2:select', function(e) {
                var data = e.params.data;
                var anggotaList = $('#anggotaList');

                if ($(`#anggota-${data.id}`).length === 0) {
                    var anggotaItem = $(`
                <div id="anggota-${data.id}" class="anggota-item" style="display: flex; align-items: center; margin-bottom: 10px; padding: 8px; background-color: #f8f9fa; border-radius: 8px;">
                    <div style="width: 30px; height: 30px; background-color: red; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; margin-right: 10px;">
                        ${data.icon}
                    </div>
                    <div style="flex-grow: 1;">
                        <div style="font-weight: bold;">${data.text}</div>
                        <div style="color: gray; font-size: 12px;">${data.email}</div>
                    </div>
                    <button class="remove-anggota" data-id="${data.id}" style="background: none; border: none; color: red; font-size: 24px; cursor: pointer;">&times;</button>
                </div>
            `);

                    anggotaList.append(anggotaItem);
                    checkEmptyMessage();
                }

                // Kosongkan input setelah memilih
                $(this).val(null).trigger('change');
            });

            // Hapus anggota dari daftar
            $(document).on('click', '.remove-anggota', function() {
                var anggotaId = $(this).data('id');
                $(`#anggota-${anggotaId}`).remove();
                checkEmptyMessage();
            });

            // Cek awal jika belum ada anggota
            checkEmptyMessage();
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
    </script>
@endsection
