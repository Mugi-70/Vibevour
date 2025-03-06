<style>
    /* Jangan sembunyikan elemen yang divalidasi */
    #email {
        display: block;
    }
</style>

<div class="modal fade" id="inviteForm" aria-hidden="false" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="modalanggotaLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0">
                {{-- <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <h5 class="modal-title text-center" id="modalanggotaLabel">Undang anggota ke grup anda lewat email </h5>
                {{-- <div class="input-group flex-nowrap mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                </div> --}}
                <form id="inviteForm">
                    {{-- <label for="email" class="form-label">Masukkan Email</label> --}}
                    <div class="input-group flex-nowrap mt-3">
                        <span class="input-group-text">
                            <i class="bi bi-envelope-fill"></i>
                        </span>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Masukkan email disini" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <button type="button" id="sendInvitation" class="btn btn-success">Kirim Undangan</button>
            </div>
        </div>
    </div>
</div>
