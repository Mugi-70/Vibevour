@extends('sidebar')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body pt-3 pb-3 pe-3 border-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><button class="btn d-lg-none" id="toggleSidebar" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                    <i class="bi bi-list"></i> </button> Vote Saya</h5>
            <div class="header_menu">
                <a href="/tambahvote" class="btn btn-success" style="font-size: 14px">
                    <i class="bi bi-plus"></i> Tambah Vote
                </a>
            </div>
        </div>
    </div>
</div>

<div class="text-end mt-4">
    <div class="btn-group">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="sortButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-arrow-down-up"></i> Urutkan
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item sort-option" href="#" data-value="a-z">A-Z</a></li>
            <li><a class="dropdown-item sort-option" href="#" data-value="z-a">Z-A</a></li>
            <li><a class="dropdown-item sort-option" href="#" data-value="terbaru">Terbaru</a></li>
            <li><a class="dropdown-item sort-option" href="#" data-value="terlama">Terlama</a></li>
        </ul>
    </div>
    <button class="btn btn-outline-secondary btn-sm" id="filterButton">
        <i class="bi bi-sliders"></i> Filter
    </button>
    <div class="dropdown-menu dropdown-menu-end" id="filterDropdown">
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#dateSortModal">Berdasarkan Tanggal</a></li>
        <a class="dropdown-item filter-option" href="#" data-value="berjalan">Berjalan</a>
        <a class="dropdown-item filter-option" href="#" data-value="selesai">Selesai</a>
    </div>
</div>

<div class="modal fade" id="dateSortModal" tabindex="-1" aria-labelledby="dateSortModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateSortModalLabel">Pilih Rentang Tanggal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="startDate" class="form-label">Tanggal Awal</label>
                <input type="date" id="startDate" class="form-control">
                <label for="endDate" class="form-label mt-2">Tanggal Akhir</label>
                <input type="date" id="endDate" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="applyDateSort">Terapkan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let sortOrder = "";
        let selectedFilter = "";
        let startDate = "";
        let endDate = "";

        function fetchVotes() {
            $.ajax({
                url: "/vote_saya",
                type: "GET",
                data: {
                    sort: sortOrder,
                    filter: selectedFilter,
                    start_date: startDate,
                    end_date: endDate
                },
                dataType: "json",
                success: function(response) {
                    let votesHtml = "";
                    let voteList = $(".row");
                    voteList.empty();

                    if (response.vote && response.vote.length > 0) {
                        response.vote.sort((a, b) => {
                            if (sortOrder === "a-z") return a.title.localeCompare(b.title);
                            if (sortOrder === "z-a") return b.title.localeCompare(a.title);
                            return 0;
                        });

                        response.vote.forEach(function(item) {
                            if (!item || !item.created_at) return;
                            let createdAt = new Date(item.created_at);
                            let formattedDate = ("0" + createdAt.getDate()).slice(-2) + "/" +
                                ("0" + (createdAt.getMonth() + 1)).slice(-2) + "/" +
                                createdAt.getFullYear();
                            votesHtml += `
                                <div class="col-md-4">
                                    <a href="{{ url('detail_vote_') }}${item.slug}" class="text-decoration-none">
                                        <div class="card mt-3 border-0 shadow-sm">
                                            <div class="card-body">
                                                <h5 class="card-title fw-bold fs-6">${item.title}</h5>
                                                <p class="card-text" style="font-size: 14px">${item.description}</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <text class="card-text" style="font-size: 14px">Dibuat pada ${formattedDate}</text>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `;
                        });
                    } else {
                        votesHtml = "<p class='text-center'>Belum ada vote</p>";
                        votesHtml = `<div class="text">
                                        <p class="text-center">Belum ada vote</p>
                                    </div>`;
                    }

                    voteList.html(votesHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching votes:", error);
                    alert("Terjadi kesalahan saat mengambil data.");
                }
            });
        }

        fetchVotes();

        $(".sort-option").click(function(e) {
            e.preventDefault();
            sortOrder = $(this).data("value");

            startDate = "";
            endDate = "";
            $("#startDate").val("");
            $("#endDate").val("");

            $("#dateSortModal").modal("hide");

            fetchVotes();
        });

        $("#applyDateSort").click(function() {
            startDate = $("#startDate").val();
            endDate = $("#endDate").val();
            let isValid = true;

            $("#startDateError, #endDateError, #dateRangeError").hide();

            if (!startDate) {
                $("#startDateError").show();
                isValid = false;
            }

            if (!endDate) {
                $("#endDateError").show();
                isValid = false;
            }

            if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                $("#dateRangeError").show();
                isValid = false;
            }

            if (isValid) {
                $("#dateSortModal").modal("hide");
                fetchVotes();
            }
        });

        $("#filterButton").click(function(event) {
            let button = $(this);
            let dropdown = $("#filterDropdown");

            let offset = button.offset();
            dropdown.css({
                display: 'block',
                position: 'absolute',
                top: offset.top + button.outerHeight(),
                right: $(window).width() - (offset.left + button.outerWidth()),
                zIndex: 1000
            });
        });

        $(document).click(function(event) {
            if (!$(event.target).closest('#filterButton, #filterDropdown').length) {
                $("#filterDropdown").hide();
            }
        });

        $(".filter-option").click(function(e) {
            e.preventDefault();
            selectedFilter = $(this).data("value");
            $("#filterDropdown").hide();

            startDate = "";
            endDate = "";
            $("#startDate").val("");
            $("#endDate").val("");

            $("#filterDropdown").hide();
            fetchVotes();
        });

        $("#dateSortModal").on("hidden.bs.modal", function() {
            $("#startDate").val("");
            $("#endDate").val("");
        });
    });
</script>

<div class="row">
    @if ($vote->isEmpty())
    <div class="text">
        <p class="text-center">Belum ada vote</p>
    </div>
    @else
    @foreach ($vote as $item)
    <div class="col-md-4">
        <a href="{{ route('vote.show', ['slug' => $item->slug]) }}" class="text-decoration-none">
            <div class="card mt-3 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold fs-6">{{ $item->title }}</h5>
                    <p class="card-text" style="font-size: 14px">{{ $item->description }}</p>
                    <div class="row">
                        <div class="col">
                            <text class="card-text" style="font-size: 14px">Dibuat pada {{ $item->created_at->format('d/m/Y') }}</text>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
    @endif
</div>

@endsection