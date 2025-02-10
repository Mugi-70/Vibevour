@extends('sidebar')

@section('content')
    <div class="header">
        <h2>Pertemuan</h2>
    </div>
    <div class="line"></div>

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
            <button class="filter-meet btn btn-outline-dark m-1" type="submit"><i
                    class="bi bi-sliders m-1"></i>Filter</button>
        </div>
        <div class="line-meet"></div>
        <div class="card-riwayat m-3">
            <div class="card-body d-flex m-2">
                <div class="avatar">P</div>
                <div class="judul-pertemuan m-2 mt-2">
                    <h4>Pembelian rumah</h4>
                </div>
                <button type="button" class="btn btn-outline-dark ms-auto mt-1" style="height: 40px" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Detail</button>
                @include('modal.detail_pertemuan')
            </div>
        </div>
    </div>
@endsection
