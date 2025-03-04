@extends('sidebar')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body pt-3 pb-3 pe-3 border-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Vote Saya</h5>
            <div class="header_menu">
                <a href="/tambahvote" type="button" class="btn btn-success" style="font-size: 14px"><i class="bi bi-plus"></i>
                    Tambah Vote
                </a>
            </div>
        </div>
    </div>
</div>

<div class="text-end mt-4 ">
    <button class="btn btn-outline-secondary btn-sm" id="SortButton">
        <i class="bi bi-arrow-down-up"></i> Urutkan
    </button>
    <button class="btn btn-outline-secondary btn-sm" id="filterButton">
        <i class="bi bi-sliders"></i> Filter
    </button>
    <div class="dropdown-menu dropdown-menu-end" id="filterDropdown">
        <a class="dropdown-item filter-option" href="#" data-value="berjalan">Berjalan</a>
        <a class="dropdown-item filter-option" href="#" data-value="selesai">Selesai</a>
    </div>
</div>

<script>
    $(document).ready(function() {
        let sortOrder = "desc";
        let selectedFilter = "";

        function fetchVotes() {
            $.ajax({
                url: "/vote_saya",
                type: "GET",
                data: {
                    sort: sortOrder,
                    filter: selectedFilter,
                },
                dataType: "json",
                success: function(response) {
                    let votesHtml = "";
                    let voteList = $(".row");

                    voteList.empty();

                    if (response.vote && response.vote.length > 0) {
                        response.vote.forEach(function(item) {
                            votesHtml += `
                            <div class="col-md-4">
                                <a href="{{ url('detail_vote_') }}${item.slug}" class="text-decoration-none">
                                    <div class="card mt-3 border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold fs-6">${item.title}</h5>
                                            <p class="card-text" style="font-size: 14px">${item.description}</p>
                                            <div class="row">
                                                <div class="col">
                                                    <text class="card-text" style="font-size: 14px">Dibuat pada ${new Date(item.created_at).toLocaleDateString()}</text>
                                                    <button class="btn btn-outline-secondary btn-sm float-end">
                                                        <i class="bi bi-share"></i> Bagikan
                                                    </button>
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

        $("#SortButton").click(function() {
            sortOrder = sortOrder === "desc" ? "asc" : "desc";
            fetchVotes();
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
            fetchVotes();
        });
    });
</script>

<div class="row">
    @if ($vote->isEmpty())
    <div class="text">
        <p>Belum ada vote</p>
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
                            <text class="card-text" style="font-size: 14px">Dibuat pada {{ $item->created_at->format('d M Y') }}</text>
                            <button href="#" class="btn btn-outline-secondary btn-sm float-end">
                                <i class="bi bi-share"></i> Bagikan
                            </button>
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