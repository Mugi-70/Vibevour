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
        <form action="{{ url('/edit/grup/') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="nm-grup">
                <label for="" class="form-label fw-bold">Nama Grup</label>
                <input type="text" class="form-control" name="nama_grup"
                    style="background-color: transparent; border: 1px solid" value="{{ $nama_grup }}">
            </div>
            <hr>
            <div class="anggota">
                <h6 class="label-anggota d-flex justify-content-between">
                    <label for="" class="form-label fw-bold">Anggota</label>
                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                        data-bs-target="#modalanggota" style="font-size: 14px">+ Anggota</button>
                </h6>
                <div class="box-item-1 d-flex align-items-center mt-3">
                    <div class="avatar-search">p</div>
                    <div class="nama-user mt-2">
                        <h6>Penjual</h6>
                    </div>
                    <button type="button" class="delete btn btn-outline-danger h-25 ms-auto"
                        style="font-size: 14px; border-radius: 50%">
                        X
                    </button>
                </div>
                <div class="box-item d-flex align-items-center mt-3">
                    <div class="avatar-search">p</div>
                    <div class="nama-user mt-2">
                        <h6>Notaris</h6>
                    </div>
                    <button type="button" class="delete btn btn-outline-danger h-25 ms-auto"
                        style="font-size: 14px; border-radius: 50%">
                        X
                    </button>
                </div>
                <div class="box-item d-flex align-items-center mt-3">
                    <div class="avatar-search">p</div>
                    <div class="nama-user mt-2">
                        <h6>Pembeli</h6>
                    </div>
                    <button type="button" class="delete btn btn-outline-danger h-25 ms-auto"
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
                    <select class="form-select" id="durasi" name="durasi" onchange="handleSelectChange(this)"
                        style="background-color: transparent; border: 1px solid">
                        <option value="15 menit">15 menit</option>
                        <option value="30 menit">30 menit</option>
                        <option value="45 menit">45 menit</option>
                        <option value="60 menit">60 menit</option>
                    </select>
                </div>
            </div>

            <hr>

            <div class="time">
                <label for="waktu" class="form-label fw-bold">Jam</label>
                <div class="d-flex">
                    {{-- mulai --}}
                    <div class="waktu-mulai position-relative">
                        <div class="input-group">
                            <input type="text" class="form-control" id="waktuMulai" name="waktu_mulai"
                                placeholder="01:00" style="background-color: transparent; border: 1px solid "
                                value="{{ $wtku_mulai }}">
                            <span class="input-group-text" style="background-color: transparent; border: 1px solid ">
                                <i class="bi bi-clock"></i>
                            </span>
                        </div>
                    </div>
                    <span class="align-self-center m-sm-1">s.d.</span>
                    {{-- selesai --}}
                    <div class="waktu-selesai position-relative">
                        <div class="input-group">
                            <input type="text" class="form-control ms-2" id="waktuSelesai" name="waktu_selesai"
                                placeholder="12:00" style="background-color: transparent; border: 1px solid"
                                value="{{ $wtku_selesai }}">
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
                            <input type="text" class="form-control" id="tanggalMulai" name="tanggal_mulai"
                                placeholder="dd/mm/yy" style="background-color: transparent; border: 1px solid"
                                value="{{ $tnggl_mulai }}">
                            <i class="bi bi-calendar position-absolute top-50 end-0 translate-middle-y me-2"></i>
                        </div>

                        <span class="align-self-center me-2">s.d.</span>

                        <!-- Tanggal Selesai -->
                        <div class="position-relative">
                            <input type="text" class="form-control" id="tanggalSelesai" name="tanggal_selesai"
                                placeholder="dd/mm/yy" style="background-color: transparent; border: 1px solid"
                                value="{{ $tnggl_selesai }}">
                            <i class="bi bi-calendar position-absolute top-50 end-0 translate-middle-y me-2"></i>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                <textarea style="border-radius: 10px; background-color:transparent" name="deskripsi">{{ $desk }}</textarea>
            </div>
    </div>
    <div class="card h-25 justify-content-center align-items-center"
        style="background-color: #F0F3F8; border-radius: 0px">
        <div class="b-grup d-flex">
            <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="offcanvas"
                style="font-size: 14px">Batal</button>
            <button type="submit" class="btn btn-primary m-2" style="font-size: 14px">Simpan Perubahan</button>
        </div>
        </form>
    </div>
</div>
@include('Jadwal.modal.batal_jadwal')
@include('Jadwal.modal.tambah_anggota')


<script>
    $(document).ready(function() {
        $(".delete").click(function() {
            $("div").remove(".box-item-1");
        })
    })

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
</script>
