@extends('sidebar')

@section('content')
    <div class="container">
        <div class="header">
            <h2>Grup</h2>
            <button type="button" class="create btn btn-primary">+ Buat Grup </button>
        </div>
        <div class="line"></div>

        <div class="grup">
            <div class="card-ikon">
                <div class="card-body">
                    <h5 class="card-title">Jual-Beli</h5>
                </div>
                <div class="card_footer d-flex justify-content-end m-2">
                    <button type="button" class="share btn btn-primary fw-bold m-1" style="color: #000000"><i
                            class="bi bi-share-fill m-1" style="color: #000000"></i>
                        Bagikan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
