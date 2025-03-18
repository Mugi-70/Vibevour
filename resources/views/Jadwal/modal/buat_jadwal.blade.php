    <style>
        .modal-body .table td,
        .modal-body .table th {
            padding: 0;
            /* Menghilangkan padding */
            border: none;
            /* Opsional: Menghilangkan border jika tidak dibutuhkan */
        }
    </style>

    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Membuat Jadwal</h4>
                    <button type="button" class="btn-close d-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="grupId">
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 6.5em">
                                <i class="bi bi-calendar"></i>
                                <strong>Tanggal</strong>
                            </td>
                            <td style="width: 1em">
                                :
                            </td>
                            <td>
                                <p id="selectedDateText">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="bi bi-clock-history"></i>
                                <strong>Waktu</strong>
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <p id="selectedTimeText"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="bi bi-clock-history"></i>
                                <strong>Durasi</strong>
                            </td>
                            <td>
                                :
                            </td>
                            <td class="d-flex">
                                <p id="selectDur"></p>
                                {{ str_replace('minutes', 'menit', $durasi) }}
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <label for="scheduleInput">Judul :</label>
                    <input type="text" id="scheduleInput" class="form-control" name="judul">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmSchedule">Buat Jadwal</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Toast Notifikasi -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="jadwalDibuat" class="toast align-items-center text-bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Jadwal berhasil dibuat
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
