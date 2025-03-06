<!-- Modal -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
{{-- <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script> --}}

<div class="modal fade" aria-hidden="false" id="availability" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Ketersediaan</strong></h1>
                <button type="button" class="btn-close d-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    Apakah Anda bisa menghadiri pada jadwal ini?
                </center>
                <label for="tanggal">Tanggal :</label>
                <input type="text" id="selectedDate" class="form-control mb-2" placeholder=" tanggal" hidden>
                <label for="tanggal">Waktu :</label>
                <input type="text" id="selectedTime" class="form-control" placeholder=" waktu" hidden>
                <input type="hidden" id="grupId">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="confirmAvailability">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Inisialisasi Flatpickr
    $("#selectedDate").flatpickr({
        enableTime: false,
        noCalendar: false,
        dateFormat: "d-m-Y",
        static: true // Mencegah perubahan langsung
    });

    $("#selectedTime").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
</script>
