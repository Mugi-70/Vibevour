@extends('Jadwal.sidebar')

@section('content')
    <div class="header">
        <h2>Grup</h2>
        <button type="button" class="create btn btn-primary">+ Buat Grup </button>
    </div>
    <div class="line"></div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-4">
        @foreach ($grup as $item)
            <a href="/grup_UI" style="text-decoration:none">
                <div class="card mt-3 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold fs-6">nama</h5>
                        <p class="card-text" style="font-size: 14px">Some quick example text to build on the card title and
                            make
                            up the bulk of the card's content.</p>
                        <button href="#" class="btn btn-outline-primary float-end"><i
                                class="bi bi-share"></i></button>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
