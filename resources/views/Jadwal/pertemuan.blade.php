@extends('Jadwal.sidebar')

@section('header')
    <div class="card border-0 shadow-sm mb-1">
        <div class="card-body pt-3 pb-3 pe-3 border-0">
            <div class="d-flex align-items-center">
                <!-- Tombol Toggle Sidebar di Kiri -->
                <button class="btn me-2 d-lg-none" id="toggleSidebar" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                    <i class="bi bi-list"></i>
                </button>

                <h4 class="mt-3" style="font-weight: bold">Pertemuan</h4>

                <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Halaman Grup ">
                    <i class="bi bi-question-circle"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card_meet">
        <div class="tab-meet d-flex flex-row gap-1 m-2 justify-content-between">
            <ul class="nav nav-underline" style="margin-left: 25px">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Riwayat</a>
                </li>
                <li class="nav-item" hidden>
                    <a class="nav-link" aria-current="page" href="#">Link</a>
                </li>
            </ul>
            <button class="filter-meet btn btn-dark m-1" type="submit"><i class="bi bi-sliders m-1"></i>Filter</button>
        </div>
        <div class="line-meet"></div>
        @foreach ($jadwals as $jadwal)
            <div class="card-riwayat m-3">
                <div class="card-body d-flex m-2">
                    <div class="avatar">P</div>
                    <div class="judul-pertemuan m-2 mt-2">
                        <h4>{{ $jadwal->jadwal->judul }}</h4>
                    </div>
                    <button type="button" class="detail btn btn-outline-dark ms-auto mt-1" style="height: 40px"
                        data-bs-toggle="modal" data-bs-target="#history " data-id="{{ $jadwal->id }}">Detail</button>
                    @include('Jadwal.modal.detail_pertemuan')
                </div>
            </div>
        @endforeach
    </div>
@endsection

<script>
    $(document).ready(function() {
        $('.detail').click(function() {
            var jadwalId = $(this).data('id');

            $.ajax({
                url: '/pertemuan/' + jadwalId,
                type: 'GET',
                success: function(data) {
                    console.log(data); // Debugging

                    $('#history .modal-title').text(data.nama_jadwal);
                    $('#history .jp p:nth-child(2)').text(data.tanggal + ' ' + data
                        .waktu_mulai + ' s.d. ' + data.waktu_selesai);
                    $('#history .note .card').text(data.catatan);
                    $('#history .created h6').text(data.pembuat.nama);

                    var anggotaHtml = '';
                    data.anggota.forEach(function(item) {
                        anggotaHtml += '<p class="ms-3">' + item.nama + '</p> <
                        hr > ';
                    });

                    $('#history .member').html(
                        '<p style="font-weight: bold; font-size: 20px">Anggota</p>' +
                        anggotaHtml);
                },
                error: function() {
                    alert('Gagal mengambil data jadwal.');
                }
            });
        });
    });
</script>
