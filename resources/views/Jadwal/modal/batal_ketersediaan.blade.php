<!-- Modal -->
<div class="modal fade" id="cancelAvailability" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="modalLabel">Konfirmasi Pembatalan</h5>
            </div>
            <div class="modal-body text-center">
                <p class="mb-3 fs-5">Apakah Anda membatalkan kehadiran anda pada jadwal ini?</p>

                <div class="p-3 rounded bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong><i class="bi bi-calendar-event me-2"></i> Tanggal:</strong>
                        <input type="text" id="selectedDate" class="form-control mb-2" placeholder=" tanggal" hidden>
                        <span id="selectedDateLabel" class=" fw-semibold"></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <strong><i class="bi bi-clock me-2"></i> Waktu:</strong>
                        <input type="text" id="selectedTime" class="form-control" placeholder=" waktu" hidden>
                        <span id="selectedTimeLabel" class=" fw-semibold"></span>
                    </div>

                    {{-- <input type="hidden" id="grupId"> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="confirmCancel">
                    <i class="bi bi-check-circle me-1"></i> Konfirmasi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notifikasi -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="batalHadir" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"> berhasil membatalkan kehadiran
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
