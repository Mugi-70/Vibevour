@extends('Jadwal.sidebar')

@section('content')
    <div class="container">
        <div class="header">
            <h2>Pembuatan Grup</h2>
        </div>
        <div class="line"></div>

        <div class="card_form">
            <form>
                <div class="mb-3">
                    <label for="namaGrup" class="form-label fw-bold">Nama Grup</label>
                    <input type="text" class="form-control" id="namaGrup" placeholder="Masukkan Nama Grup">
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
                            <select class="form-select" id="durasi" onchange="handleSelectChange(this)">
                                <option value="15 menit">15 menit</option>
                                <option value="30 menit">30 menit</option>
                                <option value="45 menit">45 menit</option>
                                <option value="60 menit">60 menit</option>
                                <option value="Kustomisasi">Kustomisasi</option>
                            </select>
                            <span class="input-group-text">
                                <i class="bi bi-clock"></i>
                            </span>
                        </div>

                        <!-- Elemen tambahan untuk Kustomisasi -->
                        <div id="kustomGrup" class="hide d-flex mt-2">
                            <input type="number" id="kustom" name="popup" class="form-control me-2" placeholder=""
                                min="1">
                            <select name="satuan" class="form-select">
                                <option value="menit">Menit</option>
                                <option value="jam">Jam</option>
                            </select>
                        </div>

                        <small class="text-muted"><i class="bi bi-question-circle"></i> Atur lama waktu kegiatan di
                            sini.</small>
                    </div>
                    <div class="col-md-6">
                        <label for="waktu" class="form-label fw-bold">Waktu</label>
                        <div class="d-flex">
                            <div class="waktu-mulai position-relative">
                                <div class="input-group">
                                    <input type="time" class="form-control" id="waktuMulai" placeholder="01:00">
                                    <span class="input-group-text">
                                        <i class="bi bi-clock"></i>
                                    </span>
                                </div>
                            </div>
                            <span class="align-self-center m-sm-1">s.d.</span>
                            <div class="waktu-selesai position-relative">
                                <div class="input-group">
                                    <input type="time" class="form-control ms-2" id="waktuSelesai" placeholder="12:00">
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
                        <div class="position-relative me-2">
                            <input type="text" class="form-control" id="tanggalMulai" placeholder="dd/mm/yy"
                                style="width: 30rem">
                            <i class="bi bi-calendar position-absolute top-50 end-0 translate-middle-y me-2"></i>
                        </div>

                        <span class="align-self-center me-2">s.d.</span>

                        <!-- Tanggal Selesai -->
                        <div class="position-relative">
                            <input type="text" class="form-control" id="tanggalSelesai" placeholder="dd/mm/yy"
                                style="width: 30rem">
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
                    <textarea class="form-control" id="deskripsi" rows="3" placeholder="Masukkan deskripsi kegiatan"></textarea>
                </div>
            </form>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="/grup" type="button" class="btn btn-secondary m-1">Kembali<i
                    class="bi bi-chevron-compact-right"></i></a>
            <a href="/ready_grup" type="submit" class="btn btn-success m-1" style="border:none">Simpan
                Group <i class="bi bi-save"></i>
            </a>
        </div>
    </div>

    <script>
        document.getElementById("kustom").addEventListener("keyup", function() {
            value = this.value;
            if (value < 0) {
                this.value = 0;
            }
        });

        function handleSelectChange(selectElement) {
            const kustomGrup = document.getElementById("kustomGrup");

            if (selectElement.value === "Kustomisasi") {
                kustomGrup.classList.remove("hide");
                kustomGrup.classList.add("show");
            } else {
                kustomGrup.classList.remove("show");
                kustomGrup.classList.add("hide");
            }
        }

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
