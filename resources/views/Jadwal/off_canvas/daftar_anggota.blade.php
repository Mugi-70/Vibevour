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
        <div class="input-group flex-nowrap shadow-sm mb-3">
            <span class="input-group-text" style="background-color: #ffffff;">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="searchAnggota" class="form-control" placeholder="Cari...">
        </div>

        <div id="noResults" class="text-center text-muted mt-4" style="display: none;">
            <i class="bi bi-exclamation-circle me-1"></i> Tidak ada anggota yang cocok.
        </div>

        <div id="listAnggota">
            @foreach ($grup->anggota as $item)
                <div class="box-item d-flex mt-3 anggota-item align-items-center">
                    <div class="avatar-search">
                        <div class="rounded-circle text-white text-center fw-bold"
                            style="background-color: red; width: 40px; height: 40px; line-height: 40px;">
                            {{ strtoupper(substr($item->user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="nama-user ms-3 anggota-text">
                        <h6 class="mb-0 fw-bold">{{ strtolower($item->user->name) }}</h6>
                        <p class="text-muted mb-0">{{ strtolower($item->user->email) }}</p>
                    </div>
                    @if ($item->role == 'admin')
                        <span class="badge text-bg-dark ms-5">Admin</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    const searchInput = document.getElementById('searchAnggota');
    const noResults = document.getElementById('noResults');

    if (!searchInput.dataset.listenerAttached) {
        searchInput.dataset.listenerAttached = true;

        searchInput.addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let anggotaItems = document.querySelectorAll('.anggota-item');
            let found = 0;

            anggotaItems.forEach(function(item) {
                let name = item.querySelector('.anggota-text h6')?.textContent.toLowerCase() ?? '';
                let email = item.querySelector('.anggota-text p')?.textContent.toLowerCase() ?? '';
                let combinedText = name + ' ' + email;

                if (combinedText.includes(filter)) {
                    item.style.setProperty('display', 'flex', 'important');
                    found++;
                } else {
                    item.style.setProperty('display', 'none', 'important');
                }
            });

            // Tampilkan pesan jika tidak ditemukan
            if (found === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });
    }
</script>
