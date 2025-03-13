<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="jadwal" aria-labelledby="offcanvasRightLabel"
    data-bs-backdrop="false" style="background-color: #F0F3F8">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id=""><strong id="judul"></strong>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="tanggal">
            <h5><strong>Tanggal Jadwal</strong></h5>
            <div class="tanggal-1 d-flex">
                <i class="bi bi-calendar"></i>
                <p class="ms-2">Januari 2025</p>
            </div>
        </div>
        <hr>
        <div class="wktu">
            <h5><strong>Waktu Jadwal</strong></h5>
            {{-- <h6 class="d-flex"><i class="bi bi-dot"></i>
                <p>Waktu Mulai</p>
            </h6> --}}
            <h6 class="d-flex">
                <i class="bi bi-clock-history me-2"></i>
                <p class="waktu-mulai">07:00</p>
            </h6>
        </div>
        <hr>
        <div class="durasi">
            <h5><strong>Durasi</strong></h5>
            <h6 class="d-flex">
                <i class="bi bi-clock-history me-2"></i>
                <p class=""></p>
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
            {{-- @endforeach --}}
        </div>
    </div>
    <div class="card h-25 d-flex flex-row align-items-center justify-content-center p-1"
        style="background-color: #F0F3F8; border-radius: 0px">
        @if ($role === 'admin')
            <button type="button" class="btn btn-danger w-50 m-1" style="font-size: 14px" data-bs-toggle="modal"
                data-bs-target="#cancel"><i class="bi bi-trash3"></i> Batalkan Jadwal</button>
        @else
            <button type="button" class="btn btn-primary w-50 m-1" style="font-size: 14px" data-bs-toggle="modal"
                data-bs-target="#cancel"><i class="bi bi-clipboard-check"></i> Hadiri Jadwal</button>
        @endif
    </div>
</div>
@include('Jadwal.modal.batal_jadwal')
@include('Jadwal.modal.hadiri_jadwal')

<script></script>
