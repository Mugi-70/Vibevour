<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="daftar_anggota" aria-labelledby="offcanvasRightLabel"
    data-bs-backdrop="false" style="background-color: #F0F3F8">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel"><i class="bi bi-people-fill me-2"></i><strong>Daftar
                Anggota ({{ $totalAnggota }})
            </strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr>
    <div class="offcanvas-body">
        <div class="input-group flex-nowrap shadow-sm">
            <span class="input-group-text" style="background-color: #ffffff;">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" class="form-control" placeholder="Cari..." style="">
        </div>
        @foreach ($grup->anggota as $item)
            <div class="box-item d-flex mt-3">
                <div class="avatar-search">p</div>
                <div class="nama-user mt-1">
                    <h6>{{ $item->user->name }}</h6>
                    <p style="margin-top: -10px;">{{ $item->user->email }}
                        @if ($item->role == 'admin')
                            <span class="badge rounded-pill text-bg-dark ms-5">{{ $item->role }}</span>
                        @endif
                        <span class="badge rounded-pill text-bg-dark ms-5 d-none">{{ $item->role }}</span>
                    </p>
                </div>
            </div>
        @endforeach
        {{-- <div class="box-item d-flex">
            <div class="avatar-search">p</div>
            <div class="nama-user mt-1">
                <h6>Notaris</h6>
                <p style="margin-top: -10px">Notaris@gmail.com</p>
            </div>
        </div>
        <div class="box-item d-flex">
            <div class="avatar-search">p</div>
            <div class="nama-user mt-1">
                <h6>Pembeli</h6>
                <p style="margin-top: -10px">Pembeli@gmail.com</p>
            </div>
        </div> --}}
    </div>
</div>
