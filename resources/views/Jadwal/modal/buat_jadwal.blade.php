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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Membuat Jadwal Pertemuan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                <p id="selectedDate">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="bi bi-clock-history"></i>
                                <strong>Jam</strong>
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <p id="selectedTime"></p>
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
                            <td>
                                {{ $durasi }}
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <label for="scheduleInput">Catatan:</label>
                    <input type="text" id="scheduleInput" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveSchedule()">Buat Pertemuan</button>
                </div>
            </div>
        </div>
    </div>
