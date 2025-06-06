<!-- Modal -->
<div class="modal fade" id="history-{{ $jadwal->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {{-- <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <div class="modal-body">
                <button type="button" class="btn-close float-end d-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>

                <div class="row">
                    <!-- Kiri -->
                    <div class="col-md-3 text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-people-fill fs-1"></i>
                            <h5 class="fw-bold mt-2" id="modal-judul">{{ $jadwal->judul }}</h5>
                        </div>
                    </div>

                    <!-- Kanan -->
                    <div class="col-md-9" style="border-left: 1px solid #ddd">
                        <div class="jp">
                            <p style="font-weight: bold; font-size: 20px">Jadwal Pelaksanaan</p>
                            <p id="" class="ms-3">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }},
                                {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->translatedFormat('H:i') }}
                            </p>
                        </div>
                        <div class="note d-none">
                            <p style="font-weight: bold; font-size: 20px">Catatan</p>
                            <div class="card p-1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </div>
                        </div>
                        <div class="created d-none">
                            <p style="font-weight: bold; font-size: 20px">Dibuat Oleh</p>
                            <div class="box-item d-flex align-items-center">
                                <div class="avatar-search">p</div>
                                <div class="nama-user mt-2">
                                    <h6>Penjual</h6>
                                </div>
                            </div>
                        </div>
                        <div class="member">
                            <p style="font-weight: bold; font-size: 20px">Anggota</p>
                            @if ($jadwal->peserta->isNotEmpty())
                                @foreach ($jadwal->peserta as $anggota)
                                    <p class="ms-3">{{ $anggota->user->name }}</p>
                                    <hr>
                                @endforeach
                            @else
                                <p class="ms-3 text-muted">Tidak ada anggota.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
