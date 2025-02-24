@extends('Jadwal.sidebar')

@section('content')
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body pt-3 pb-3 pe-3 border-0">
            <div class="d-flex justify-content-center align-items-center">
                <h5 class="mb-0">Pembuatan Grup</h5>
            </div>
        </div>
    </div>

    <form action="{{ route('coba_bikin') }}" method="POST">
        @csrf
        <div class="card p-3 justify-content-center" style="overflow: hidden; max-width: 100%;">

            <div class="mb-3">
                <label for="namaGrup" class="form-label fw-bold">Nama Grup</label>
                <input type="text" class="form-control" id="namaGrup" name="nama_grup" placeholder="Masukkan Nama Grup">
            </div>

            <!-- Anggota -->
            <div class="mb-3 d-flex align-items-center">
                <div class="flex-grow-1 me-2">
                    <label for="anggota" class="form-label fw-bold">Anggota</label>
                    <div class="anggota-grup">
                        <p>Anggota</p>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-secondary align-self-end" data-bs-toggle="modal"
                    data-bs-target="#modalanggota">
                    <i class="bi bi-person-plus"></i> Anggota
                </button>
                @include('Jadwal.modal.tambah_anggota')
            </div>

            <!-- Durasi dan Waktu -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="durasi" class="form-label fw-bold">Durasi</label>
                    <div class="input-group">
                        <select class="form-select" id="durasi" name="durasi" onchange="handleSelectChange(this)">
                            <option value="15 minutes">15 menit</option>
                            <option value="30 minutes">30 menit</option>
                            <option value="45 minutes">45 menit</option>
                            <option value="60 minutes">60 menit</option>
                        </select>
                        <span class="input-group-text">
                            <i class="bi bi-clock"></i>
                        </span>
                    </div>

                    <small class="text-muted"><i class="bi bi-question-circle"></i>
                        Atur lama waktu kegiatan disini.
                    </small>
                </div>
                {{-- waktu --}}
                <div class="col-md-6">
                    <label for="waktu" class="form-label fw-bold">Waktu</label>
                    <div class="d-flex">
                        <div class="waktu-mulai position-relative">
                            <div class="input-group flex-nowrap">
                                <input type="text" class="form-control" id="waktuMulai" name="waktu_mulai"
                                    placeholder="01:00">
                                <span class="input-group-text">
                                    <i class="bi bi-clock"></i>
                                </span>
                            </div>
                        </div>
                        <span class="align-self-center m-sm-1">s.d.</span>
                        <div class="waktu-selesai position-relative">
                            <div class="input-group flex-nowrap">
                                <input type="time" class="form-control ms-2" id="waktuSelesai" name="waktu_selesai"
                                    placeholder="12:00">
                                <span class="input-group-text">
                                    <i class="bi bi-clock"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted"><i class="bi bi-question-circle"></i> Tentukan waktu operasional kegiatan
                        grup.</small>
                </div>
            </div>

            <!-- Tanggal -->
            <div class="mb-3">
                <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                <div class="d-flex align-items-center">
                    <!-- Tanggal Mulai -->
                    <div class="position-relative me-2 flex-grow-1">
                        <input type="text" class="form-control" id="tanggalMulai" name="tanggal_mulai"
                            placeholder="dd/mm/yy">
                        <i class="bi bi-calendar position-absolute top-50 end-0 translate-middle-y me-2"></i>
                    </div>

                    <span class="align-self-center me-2">s.d.</span>

                    <!-- Tanggal Selesai -->
                    <div class="position-relative flex-grow-1">
                        <input type="text" class="form-control" id="tanggalSelesai" name="tanggal_selesai"
                            placeholder="dd/mm/yy">
                        <i class="bi bi-calendar position-absolute top-50 end-0 translate-middle-y me-2"></i>
                    </div>
                </div>

                <small class="text-muted d-block mt-1">
                    <i class="bi bi-question-circle"></i>
                    Tentukan rentang tanggal untuk kegiatan grup, misalnya dari 1 Januari hingga 3 Januari 2025.
                </small>
            </div>


            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi" placeholder="Masukkan deskripsi kegiatan"></textarea>
            </div>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="/grup" type="button" class="btn btn-secondary m-1">Kembali<i
                    class="bi bi-chevron-compact-right"></i></a>
            <button type="submit" class="btn btn-success m-1" style="border:none">Simpan
                Group <i class="bi bi-save"></i>
            </button>
    </form>

    </div>

    <script>
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
