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
        <button type="button" class="btn-close d-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ url('/edit/grup/') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="nm-grup">
                <label for="" class="form-label fw-bold">Nama Grup</label>
                <input type="text" class="form-control" name="nama_grup" value="{{ $nama_grup }}">
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
                    <select class="form-select" id="durasi" name="durasi" onchange="handleSelectChange(this)">
                        <option value="15 menit">15 menit</option>
                        <option value="30 menit">30 menit</option>
                        <option value="45 menit">45 menit</option>
                        <option value="60 menit">60 menit</option>
                    </select>
                </div>
            </div>

            <hr>
            {{-- waktu --}}
            <div class="time">
                <label for="waktu" class="form-label fw-bold">Waktu</label>
                <div class="row gx-2">
                    {{-- mulai --}}
                    <div class="col-5">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" id="waktuMulai" name="waktu_mulai"
                                placeholder="01:00" value="{{ $wtku_mulai }}">
                            <span class="input-group-text">
                                <i class="bi bi-clock"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-2 text-center align-self-center">s.d.</div>
                    {{-- selesai --}}
                    <div class="col-5">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" id="waktuSelesai" name="waktu_selesai"
                                placeholder="12:00" value="{{ $wtku_selesai }}">
                            <span class="input-group-text">
                                <i class="bi bi-clock"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            {{-- tanggal --}}
            <div class="tanggal">
                <div class="mb-3">
                    <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                    <div class="row gx-2">
                        <!-- Tanggal Mulai -->
                        <div class="col-5">
                            <div class="input-group flex-nowrap">
                                <input type="text" class="form-control" id="tanggalMulai" name="tanggal_mulai"
                                    placeholder="dd/mm/yy" value="{{ $tnggl_mulai }}" required>
                                <span class="input-group-text">`
                                    <i class="bi bi-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-2 text-center align-self-center">s.d.</div>

                        <!-- Tanggal Selesai -->
                        <div class="col-5">
                            <div class="input-group flex-nowrap">
                                <input type="text" class="form-control" id="tanggalSelesai"
                                    name="tanggal_selesai" placeholder="dd/mm/yy" value="{{ $tnggl_selesai }}"
                                    required>
                                <span class="input-group-text">
                                    <i class="bi bi-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">{{ $desk }}</textarea>
                    <label for="floatingTextarea2">Isi Disini</label>
                </div>
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
