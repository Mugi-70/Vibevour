@extends('sidebar')

@section('content')
    <div class="container">
        <div class="header">
            <h2>Grup</h2>
            <a href=""></a>
            <a href="/pembuatan_grup" type="button" class="create btn btn-primary">+ Buat Grup </a>
        </div>
        <div class="line"></div>

        <div class="navbar">
            <form>
                <div class="mb-3">
                    <label for="namaGrup" class="form-label fw-bold">Nama Grup</label>
                    <input type="text" class="form-control" id="namaGrup" style="width: 60rem"
                        placeholder="Masukkan Nama Grup">
                </div>

                <!-- Anggota -->
                <div class="mb-3 d-flex align-items-center">
                    <div class="flex-grow-1 me-2">
                        <label for="anggota" class="form-label fw-bold">Anggota</label>
                        <input type="text" class="form-control" id="anggota" placeholder="Masukkan Anggota">
                    </div>
                    <button type="button" class="btn btn-secondary align-self-end">
                        <i class="bi bi-person-plus"></i> Anggota
                    </button>
                </div>

                <!-- Durasi dan Waktu -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="durasi" class="form-label fw-bold">Durasi</label>
                        <div class="input-group">
                            <select class="form-select" id="durasi">
                                <option value="15 menit">15 menit <i class="bi bi-check2"></i></option>
                                <option value="30 menit">30 menit</option>
                                <option value="45 menit">45 menit</option>
                                <option value="60 menit">60 menit</option>
                                <option value="Kustomisasi">Kustomisasi</option>
                            </select>
                            <span class="input-group-text">
                                <i class="bi bi-clock"></i>
                            </span>
                        </div>
                        <small class="text-muted"><i class="bi bi-question-circle"></i> Atur lama waktu kegiatan di
                            sini.</small>
                    </div>
                    <div class="col-md-6">
                        <label for="waktu" class="form-label fw-bold">Waktu</label>
                        <div class="d-flex">
                            <input type="time" class="form-control me-2" id="waktuMulai">
                            <span class="align-self-center">s.d.</span>
                            <input type="time" class="form-control ms-2" id="waktuSelesai">
                        </div>
                        <small class="text-muted"><i class="bi bi-question-circle"></i> Tentukan waktu operasional kegiatan
                            grup.</small>
                    </div>
                </div>

                <!-- Tanggal -->
                <div class="mb-3">
                    <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                    <div class="d-flex">
                        <input type="date" class="form-control me-2" id="tanggalMulai">
                        <span class="align-self-center">s.d.</span>
                        <input type="date" class="form-control ms-2" id="tanggalSelesai">
                    </div>
                    <small class="text-muted"><i class="bi bi-question-circle"></i> Tentukan rentang tanggal untuk kegiatan
                        grup, misalnya dari 1 Januari hingga 3 Januari 2025.</small>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" rows="3" placeholder="Masukkan deskripsi kegiatan"></textarea>
                </div>
            </form>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="/grup" type="button" class="btn btn-danger m-1">Kembali</a>
            <a href="/ready_grup" type="submit" class="btn btn-primary m-1">Buat Group</a>
        </div>
    </div>
@endsection
