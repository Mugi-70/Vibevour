<style>
    .input-group .input-group-text,
    .input-group select {
        height: 100%;
        align-items: center;
    }
</style>

<div class="modal fade" id="modalanggota" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalanggotaLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0">
                {{-- <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <h5 class="modal-title text-center" id="modalanggotaLabel">Tambahkan anggota ke dalam grup Anda</h5>
                <div class="input-group flex-nowrap mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <select id="searchAjax" class="form-control" style="width: 100%; height: 100%">
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-primary">Tambahkan Ke grup</button>
            </div>
        </div>
    </div>
</div>

<script></script>
{{-- <div id="searchResults" class="dropdown-menu d-flex flex-column show w-100 position-relative">
                        <div class="box-item d-flex">
                            <div class="avatar-search">p</div>
                            <div class="nama-user mt-1">
                                <h6>Notaris</h6>
                                <p style="margin-top: -10px">Notaris@gmail.com</p>
                            </div>
                        </div>

                        <div class="box-item d-flex">
                            <div class="avatar-search">p</div>
                            <div class="nama-user mt-1">
                                <h6>Notaris</h6>
                                <p style="margin-top: -10px">Notaris@gmail.com</p>
                            </div>
                        </div>

                        <div class="box-item d-flex">
                            <div class="avatar-search">p</div>
                            <div class="nama-user mt-1">
                                <h6>Notaris</h6>
                                <p style="margin-top: -10px">Notaris@gmail.com</p>
                            </div>
                        </div>

                    </div> --}}
