@extends('sidebar')

@section('content')
    <div class="header" style="margin-top: 5%;">
        <h3>Vote Saya</h3>
        <div class="header_menu">
            <button class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-sliders"></i> Filter
            </button>
            <a href="/tambahvote" type="button" class="create btn "><i class="bi bi-plus"></i>
                Tambah Vote
            </a>
        </div>
    </div>
    <div class="line"></div>

    <div class="text">
        <p>Belum ada vote</p>
    </div>
@endsection