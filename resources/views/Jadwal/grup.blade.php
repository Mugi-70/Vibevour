@extends('Jadwal.sidebar')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body pt-3 pb-3 pe-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Grup</h5>
                <a href="/pembuatan_grup" type="button" class="btn btn-success" style="font-size: 14px"><i class="bi bi-plus me-1"></i>Buat Grup</a>
            </div>
        </div>
    </div>
    <div class="row">
        @for ($i = 0; $i < 5; $i++)
        <div class="col-md-4">
            <a href="/grup_UI" style="text-decoration:none">
            <div class="card mt-3 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold fs-6">Grup {{ $i+1 }}</h5>
                    <p class="card-text" style="font-size: 14px">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <button href="#" class="btn btn-outline-primary float-end"><i class="bi bi-share"></i></button>
                </div>
            </div>
        </a>
        </div>
        @endfor
        
    </div>
    {{-- <div class="d-flex align-items-center justify-content-center" style="min-height: 70vh">
        <p class="text-muted">Kamu Belum Mempunyai Grup</p>
    </div> --}}
@endsection
