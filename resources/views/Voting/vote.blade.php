@extends('sidebar')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body pt-3 pb-3 pe-3 border-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Vote Saya</h5>
            <div class="header_menu">
                <button class="btn btn-outline-secondary btn-sm" id="filterButton">
                    <i class="bi bi-sliders"></i> Filter
                </button>
                <div class="dropdown-menu" id="filterDropdown">
                    <a class="dropdown-item filter-option" href="#" data-value="tanggal_dibuat">Tanggal Dibuat</a>
                    <a class="dropdown-item filter-option" href="#" data-value="berjalan">Berjalan</a>
                    <a class="dropdown-item filter-option" href="#" data-value="selesai">Selesai</a>
                </div>
                <a href="/tambahvote" type="button" class="btn btn-success" style="font-size: 14px"><i class="bi bi-plus"></i>
                    Tambah Vote
                </a>
                <script>
                    $(document).ready(function() {
                        $("#filterButton").click(function() {
                            $("#filterDropdown").toggle();
                        });

                        $(".filter-option").click(function(e) {
                            e.preventDefault();
                            let selectedFilter = $(this).data("value");

                            $.ajax({
                                url: "filter.php",
                                type: "POST",
                                data: {
                                    filter: selectedFilter
                                },
                                success: function(response) {
                                    alert("Filter diterapkan: " + selectedFilter);
                                },
                                error: function() {
                                    alert("Terjadi kesalahan saat menerapkan filter.");
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach ($vote as $item)
    <div class="col-md-4">
            <div class="card mt-3 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold fs-6">{{ $item->title }}</h5>
                    <p class="card-text" style="font-size: 14px">{{ $item->description }}</p>
                    
                    <button href="#" class="btn btn-outline-primary float-end"><i
                    class="bi bi-share"></i></button>
                </div>
            </div>
    </div>
    @endforeach

</div>
<div class="text">
    <p>Belum ada vote</p>
</div>
@endsection