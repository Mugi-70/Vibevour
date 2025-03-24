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
        <h5 class="offcanvas-title" id="offcanvasRightLabel"><i class="bi bi-pencil me-2"></i><strong>Edit
                Grup</strong>
        </h5>
        <button type="button" class="btn-close d-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ url('/edit/grup', $grup->id_grup) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="nm-grup">
                <label for="" class="form-label fw-bold">Nama Grup</label>
                <input type="text" class="form-control" name="nama_grup" value="{{ $nama_grup }}">
            </div>
            <hr>
            <div class="anggota">
                <h6 class="label-anggota">
                    <label for="" class="form-label fw-bold">Anggota</label>
                    <select id="searchAjax" name="anggota[]" multiple="multiple" class="form-select"
                        style="width: 100%; height: 100%">
                    </select>
                    <input type="hidden" name="email" id="selectedEmail">
                </h6>
                @foreach ($grup->anggota as $item)
                    <div class="box-item-1 d-flex align-items-center mt-3" {{-- id="anggotaList" --}}
                        data-user-id="{{ $item->id_anggota_grup }}">
                        <div class="avatar-search">p</div>
                        <div class="nama-user mt-2">
                            <h6>{{ $item->user->name }}</h6>
                        </div>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#delete_member"
                            data-user-id="{{ $item->id_anggota_grup }}"
                            class="delete btn btn-outline-danger h-25 ms-auto"
                            style="font-size: 14px; border-radius: 50%">
                            X
                        </button>
                    </div>
                @endforeach
                {{-- <div class="card" id="anggotaList" style="height: auto; padding: 5px;">
                    <p id="emptyMessage" style="text-align: center; color: gray;">Belum menambahkan anggota</p>
                </div> --}}
            </div>
            <hr>
            <div class="durasi">
                <label for="durasi" class="form-label fw-bold">Durasi</label>
                <div class="select-wrapper">
                    <i class="bi bi-clock"></i>
                    <select class="form-select" id="durasi" name="durasi" onchange="handleSelectChange(this)">
                        <option value="15 minutes" {{ $grup->durasi == '15 minutes' ? 'selected' : '' }}>15 menit
                        </option>
                        <option value="30 minutes" {{ $grup->durasi == '30 minutes' ? 'selected' : '' }}>30 menit
                        </option>
                        <option value="45 minutes" {{ $grup->durasi == '45 minutes' ? 'selected' : '' }}>45 menit
                        </option>
                        <option value="60 minutes" {{ $grup->durasi == '60 minutes' ? 'selected' : '' }}>60 menit
                        </option>
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
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="desk"
                        style="height: 100px">{{ $desk }}</textarea>
                    <label for="floatingTextarea2">Isi Disini</label>
                </div>
            </div>
    </div>
    <div class="card h-25 justify-content-center align-items-center border-0 bg-transparent border-top">
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
@include('Jadwal.modal.anggota_hapus')


<script>
    $(document).ready(function() {


        $('#searchAjax').select2({
            placeholder: "Cari anggota",
            minimumInputLength: 3,
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
                    let results = data.items.map(item => ({
                        id: item.id,
                        text: item.text,
                        email: item.email || "", // Pastikan email ada
                        icon: item.text ? item.text.charAt(0).toUpperCase() : "?",
                        isInvite: false
                    }));

                    // Jika pengguna mengetik email baru yang tidak ditemukan
                    if (results.length === 0 && params.term.includes('@')) {
                        results.push({
                            id: 'invite',
                            text: params.term, // Menampilkan email yang diketik
                            email: params.term, // Mengirim email ke backend
                            isInvite: true
                        });
                    }

                    return {
                        results
                    };
                }
            },

            templateResult: function(data) {
                if (!data.id) {
                    return data.text;
                }

                let icon = data.icon ? data.icon : "?";
                let email = data.email ? data.email : "Email tidak tersedia";

                return $(`
                <div style="display: flex; align-items: center;">
                    <div style="width: 30px; height: 30px; background-color: red; color: white; 
                                display: flex; align-items: center; justify-content: center; 
                                border-radius: 50%; font-weight: bold; margin-right: 10px;">
                        ${icon}
                    </div>
                    <div>
                        <div style="font-weight: bold;">${data.text}</div>
                        <div style="color: gray; font-size: 12px;">${email}</div>
                    </div>
                </div>
            `);
            }

        });

        // checkEmptyMessage();

        //onchange
        $('#searchAjax').on('select2:select', function(e) {
            var data = e.params.data;
            var anggotaList = $('#anggotaList');

            let selectedData = e.params.data;
            if (selectedData.isInvite) {
                $('#selectedEmail').val(selectedData.email);
            }

            if ($(`#anggota-${data.id}`).length === 0) {
                var icon = data.icon ? data.icon : '?';
                var emailText = data.email ? data.email : 'Email tidak tersedia';

                var anggotaItem = $(`
            <div id="anggota-${data.id}" class="box-item-1 d-flex align-items-center mt-3"
                data-user-id="${data.id}">
                <div class="avatar-search">${icon}</div>
                <div class="nama-user mt-2">
                    <h6>${data.text}</h6>
                    <p class="text-muted" style="margin: 0; font-size: 12px;">${emailText}</p>
                </div>
                <button type="button" class="delete btn btn-outline-danger h-25 ms-auto"
                    style="font-size: 14px; border-radius: 50%" data-id="${data.id}">
                    X
                </button>
            </div>
            `);

                anggotaList.append(anggotaItem);

                // Kirim data ke server
                $.ajax({
                    url: '/edit/grup/' + id,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        anggota: [{
                            id: data.id,
                            nama: data.text,
                            email: data.isInvite ? data.text : data.email,
                            isInvite: data.isInvite ? 1 : 0
                        }]
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr) {
                        showToast("Gagal menambahkan anggota!", "danger");
                    }
                });
            }
        });


        $(document).on('click', '.remove-anggota', function() {
            var anggotaId = $(this).data('id');

            $(`#anggota-${anggotaId}`).remove();

            var selectedValues = $('#searchAjax').val() || [];
            selectedValues = selectedValues.filter(value => value !== anggotaId.toString());
            $('#searchAjax').val(selectedValues).trigger('change');

            // checkEmptyMessage();
        });

        // checkEmptyMessage();
    });

    $(document).ready(function() {
        let selectedIDUser = null;

        // Simpan ID Grup saat tombol "Hapus" ditekan
        $(document).on("click", ".delete", function() {
            selectedIDUser = $(this).data("user-id");
            console.log("ID user yang dipilih:", selectedIDUser);

            // Simpan ID dalam modal 
            $("#delete_member").attr("data-id", selectedIDUser);
        });

        // Ambil ID dari modal dan kirim lewat AJAX saat "Konfirmasi Hapus" 
        $(document).on("click", ".hapus_member", function() {
            let idUser = $("#delete_member").attr("data-id");
            console.log("ID Grup yang akan dihapus:", idUser);

            if (!idUser) {
                alert("Terjadi kesalahan! ID Grup tidak ditemukan.");
                return;
            }

            $.ajax({
                type: 'POST',
                url: "/hapus_member/" + idUser,
                data: {
                    id: idUser
                },
                success: function(response) {
                    // alert("anggota berhasil dihapus!");
                    // location.reload(); // Refresh halaman setelah berhasil
                    $("#delete_member").modal("hide");
                    var toast = new bootstrap.Toast(document.getElementById(
                        "hapusMember"));
                    toast.show();

                    $(".box-item-1[data-user-id='" + idUser + "']").remove();
                },
                error: function(xhr) {
                    alert("Gagal menghapus anggota. Silakan coba lagi.");
                }
            });
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
