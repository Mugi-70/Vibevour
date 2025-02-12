@extends('Jadwal.sidebar')

@section('content')
    <div class="header">
        <h2>Grup</h2>
        <button type="button" class="create btn btn-primary">+ Buat Grup </button>
    </div>
    <div class="line"></div>

    <div class="grup">
        <div class="card" style="width: 30%; height: 200px; background-color:#E8F4FF;">
            <div class="card-body">
                <h5 class="card-title">Jual-Beli</h5>
            </div>
            <div class="card-footer d-flex justify-content-end m-2" style="border-top:none; background-color:transparent">
                <button type="button" class="share btn btn-primary fw-bold m-1" style="color: #000000"><i
                        class="bi bi-share-fill m-1" style="color: #000000"></i>
                    Bagikan
                </button>
            </div>
        </div>
    </div>
@endsection
