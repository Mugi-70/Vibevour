<style>
    .select-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .select-wrapper i {
        position: absolute;
        left: 10px;
        font-size: 18px;
        color: #000;
    }

    .select-wrapper select {
        padding-left: 35px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }
</style>

<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="edit_grup" aria-labelledby="offcanvasRightLabel"
    data-bs-backdrop="false" style="background-color: #F0F3F8">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel"><i class="bi bi-pencil me-2"></i><strong>Edit Grup</strong>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="nm-grup">
            <h5><strong>Nama Grup</strong></h5>
            <input type="text" class="form-control" style="background-color: transparent; border: 1px solid">
        </div>
        <hr>
        <div class="anggota">
            <h5 class="label-anggota d-flex justify-content-between">
                <strong>Anggota</strong>
                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                    data-bs-target="#modalanggota" style="font-size: 14px">+ Anggota</button>
            </h5>
            <div class="box-item d-flex align-items-center mt-3">
                <div class="avatar-search">p</div>
                <div class="nama-user mt-2">
                    <h6>Penjual</h6>
                </div>
                <button type="button" class="btn btn-outline-danger h-25 ms-auto"
                    style="font-size: 14px; border-radius: 50%">
                    X
                </button>
            </div>
            <div class="box-item d-flex align-items-center mt-3">
                <div class="avatar-search">p</div>
                <div class="nama-user mt-2">
                    <h6>Notaris</h6>
                </div>
                <button type="button" class="btn btn-outline-danger h-25 ms-auto"
                    style="font-size: 14px; border-radius: 50%">
                    X
                </button>
            </div>
            <div class="box-item d-flex align-items-center mt-3">
                <div class="avatar-search">p</div>
                <div class="nama-user mt-2">
                    <h6>Pembeli</h6>
                </div>
                <button type="button" class="btn btn-outline-danger h-25 ms-auto"
                    style="font-size: 14px; border-radius: 50%">
                    X
                </button>
            </div>
        </div>
        <hr>
        <div class="durasi">
            <label for="durasi" class="form-label fw-bold">Durasi</label>
            <div class="select-wrapper">
                <i class="bi bi-clock"></i>
                <select class="form-select" id="durasi" onchange="handleSelectChange(this)"
                    style="background-color: transparent; border: 1px solid ">
                    <option value="15 menit">15 menit</option>
                    <option value="30 menit">30 menit</option>
                    <option value="45 menit">45 menit</option>
                    <option value="60 menit">60 menit</option>
                    <option value="Kustomisasi">Kustomisasi</option>
                </select>
            </div>

            <!-- Elemen tambahan untuk Kustomisasi -->
            <div id="kustomGrup" class="hide d-flex mt-2">
                <input type="number" id="kustom" name="popup" class="form-control me-2" placeholder=""
                    min="1">
                <select name="satuan" class="form-select" style="background-color: transparent; border: 1px solid ">
                    <option value="menit">Menit</option>
                    <option value="jam">Jam</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="time">
            <label for="waktu" class="form-label fw-bold">Waktu</label>
            <div class="d-flex">
                <div class="waktu-mulai position-relative">
                    <div class="input-group">
                        <input type="text" class="form-control" id="waktuMulai" placeholder="01:00"
                            style="background-color: transparent; border: 1px solid ">
                        <span class="input-group-text" style="background-color: transparent; border: 1px solid ">
                            <i class="bi bi-clock"></i>
                        </span>
                    </div>
                </div>
                <span class="align-self-center m-sm-1">s.d.</span>
                <div class="waktu-selesai position-relative">
                    <div class="input-group">
                        <input type="text" class="form-control ms-2" id="waktuSelesai" placeholder="12:00"
                            style="background-color: transparent; border: 1px solid ">
                        <span class="input-group-text" style="background-color: transparent; border: 1px solid ">
                            <i class="bi bi-clock"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="tanggal">
            <div class="mb-3">
                <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                <div class="d-flex align-items-center">
                    <!-- Tanggal Mulai -->
                    <div class="position-relative me-2">
                        <input type="text" class="form-control" id="tanggalMulai" placeholder="dd/mm/yy"
                            style="background-color: transparent; border: 1px solid ">
                        <i class="bi bi-calendar position-absolute top-50 end-0 translate-middle-y me-2"></i>
                    </div>

                    <span class="align-self-center me-2">s.d.</span>

                    <!-- Tanggal Selesai -->
                    <div class="position-relative">
                        <input type="text" class="form-control" id="tanggalSelesai" placeholder="dd/mm/yy"
                            style="background-color: transparent; border: 1px solid ">
                        <i class="bi bi-calendar position-absolute top-50 end-0 translate-middle-y me-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card h-25 justify-content-center align-items-center"
        style="background-color: #F0F3F8; border-radius: 0px">
        <div class="b-grup d-flex">
            <button type="button" class="btn btn-secondary m-2" style="font-size: 14px">Batal</button>
            <button type="button" class="btn btn-primary m-2" style="font-size: 14px">Simpan Perubahan</button>
        </div>
    </div>
</div>
@include('Jadwal.modal.batal_jadwal')
@include('Jadwal.modal.tambah_anggota')


<script>
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
</script>
