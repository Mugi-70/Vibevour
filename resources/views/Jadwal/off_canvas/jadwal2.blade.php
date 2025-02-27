<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="jadwal2" aria-labelledby="offcanvasRightLabel"
    data-bs-backdrop="false" style="background-color: #F0F3F8">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel"><strong>Judul</strong>
        </h5>
        <button type="button" class="btn-close d-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="tanggal">
            <h5><strong>Tanggal Pertemuan</strong></h5>
            <div class="tanggal-1 d-flex">
                <i class="bi bi-calendar"></i>
                <p class="ms-2">Januari 2025</p>
            </div>
        </div>
        <hr>
        <div class="wktu">
            <h5><strong>Waktu Pertemuan</strong></h5>
            <h6 class="d-flex"><i class="bi bi-dot"></i>
                <p>Waktu Mulai</p>
            </h6>
            <h6 class="ms-4 d-flex">
                <i class="bi bi-clock-history me-2"></i>
                <p>07:00</p>
            </h6>
            <h6 class="d-flex"><i class="bi bi-dot"></i>
                <p>Waktu Selesai</p>
            </h6>
            <h6 class="ms-4 d-flex">
                <i class="bi bi-clock-history me-2"></i>
                <p>07:30</p>
            </h6>
        </div>
        <hr>
        <div class="durasi">
            <h5><strong>Durasi</strong></h5>
            <h6 class="d-flex">
                <i class="bi bi-clock-history me-2"></i>
                <p>30 menit</p>
            </h6>
        </div>
        <hr>
        <div class="present">
            <h5><strong>Dihadiri Oleh :</strong></h5>
            {{-- @foreach ($hadir as $h) --}}
            <div class="box-item d-flex">
                <div class="avatar-search">p</div>
                <div class="nama-user mt-1">
                    <h6>Penjual</h6>
                    <p style="margin-top: -10px">Penjual@gmail.com</p>
                </div>
            </div>
            <div class="box-item d-flex d-none">
                <div class="avatar-search">p</div>
                <div class="nama-user mt-1">
                    <h6>Notaris</h6>
                    <p style="margin-top: -10px">Notaris@gmail.com</p>
                </div>
            </div>
            {{-- @endforeach --}}
        </div>
    </div>
    <div class="card h-25 d-flex flex-row align-items-center justify-content-center p-1"
        style="background-color: #F0F3F8; border-radius: 0px">
        <button type="button" class="btn btn-secondary m-1" data-bs-dismiss="offcanvas"
            style="font-size: 14px">Tutup</button>
        <button type="button" class="hu btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#hadiri"
            style="font-size: 14px">Setujui Jadwal <i class="bi bi-clipboard-check"></i></button>
    </div>
</div>
@include('Jadwal.modal.batal_jadwal')
@include('Jadwal.modal.hadiri_jadwal')

<script></script>
