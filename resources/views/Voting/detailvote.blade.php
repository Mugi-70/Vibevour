@extends('sidebar')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body pt-3 pb-3 pe-3 border-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Vote</h5>
        </div>
    </div>
</div>

<div class="container p-3">
    <div class="card shadow p-4">
        <h4 class="fw-bold" id="vote-title"></h4>
        <p class="text-muted" id="vote-date"></p>
        <p class="text-secondary" id="vote-description"></p>
        <div class="line"></div>

        <h5 class="my-4">Daftar Pertanyaan</h5>
        <div id="question-list"></div>

        <script>
            $(document).ready(function() {
                let slug = "{{ $vote->slug }}";
                let url = `/detail_vote_${slug}/data`;

                $.ajax({
                    url: url,
                    method: "GET",
                    success: function(response) {
                        $("#vote-title").text(response.title);
                        $("#vote-date").text("Vote dibuat pada " + new Date(response.created_at).toLocaleDateString("id-ID"));
                        $("#vote-description").text(response.description);

                        let questionsHtml = "";

                        response.questions.forEach((question, index) => {
                            let totalVotes = question.options.reduce((acc, option) => acc + option.results.length, 0);
                            let colorIndex = 0;
                            let colors = ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];

                            let optionsHtml = question.options.map(option => {
                                let voteCount = option.results.length;
                                let percentage = totalVotes > 0 ? Math.round((voteCount / totalVotes) * 100) : 0;
                                let barColor = colors[colorIndex % colors.length];
                                colorIndex++;

                                return `
                            <div class="row mb-2">
                                <div class="col-6">${option.option}</div>
                                <div class="col-6 text-end">${percentage}% (${voteCount} Vote)</div>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar" style="width: ${percentage}%; background-color: ${barColor};"></div>
                            </div>
                        `;
                            }).join('');

                            questionsHtml += `
                        <div class="row">
                            <div class="col-md-6">
                                <p class="fw-bold">${question.question}</p>
                                ${optionsHtml}
                                <p class="mt-3 fw-bold">Total vote untuk pertanyaan ini: ${totalVotes}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="my-4">Hasil Voting</h5>
                                <canvas id="pieChart-${index}" style="max-width: 100%; max-height: 300px;"></canvas>
                            </div>
                        </div>
                        <hr class="my-4">
                    `;
                        });

                        $("#question-list").html(questionsHtml);
                        loadChartData(slug);
                    },
                    error: function(error) {
                        console.log("Error fetching vote data: ", error);
                    }
                });


                function loadChartData(slug) {
                    $.ajax({
                        url: `/detail_vote_${slug}/chart-data`,
                        method: "GET",
                        success: function(data) {
                            let colors = ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];

                            if (data.length > 0) {
                                data.forEach((question, index) => {
                                    let ctx = document.getElementById(`pieChart-${index}`).getContext('2d');

                                    let labels = question.options.map(option => option.label);
                                    let counts = question.options.map(option => option.count);

                                    if (counts.every(count => count === 0)) {
                                        labels = ["Belum ada yang melakukan voting"];
                                        counts = [1];
                                        colors = ['#D3D3D3'];
                                    }

                                    new Chart(ctx, {
                                        type: 'pie',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                data: counts,
                                                backgroundColor: colors.slice(0, labels.length),
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                        }
                                    });
                                });
                            } else {
                                console.log("Data chart kosong.");
                            }
                        },
                        error: function(error) {
                            console.log("Error fetching chart data: ", error);
                        }
                    });
                }
            });
        </script>

        <div class="row">
            <p class="mt-3 fw-bold"><span id="total-votes">Loading...</span></p>
            <p id="access-code-container" style="display: none;"><span id="access-code"></span></p>
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: "{{ route('vote.show', $vote->slug) }}/vote-summary",
                        method: "GET",
                        success: function(data) {
                            $("#total-votes").text("Total orang yang sudah melakukan vote: " + data.totalVotes);

                            if (data.accessCode) {
                                $("#access-code").text("Kode akses untuk vote ini adalah: " + (data.accessCode));
                                $("#access-code-container").show();
                            }
                        },
                        error: function(error) {
                            console.log("Error fetching vote summary: ", error);
                            $("#total-votes").text("Gagal memuat data.");
                        }
                    });
                });
            </script>
            <div class="col-md-9 mt-3 ">
                <a href="/vote_saya" class="btn btn-secondary btn-sm"><i class="bi bi-chevron-left"></i>Kembali </a>
                <a href="javascript:void(0);" class="btn btn-warning btn-sm edit-vote-btn" data-slug="{{ $vote->slug }}" style="color: white">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <script>
                    $(document).ready(function() {
                        $(".edit-vote-btn").on("click", function() {
                            var slug = $(this).data("slug");
                            window.location.href = "/edit_vote_" + slug;
                        });
                    });
                </script>
                <button class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $vote->slug }}">
                    <i class="bi bi-trash"></i> Hapus
                </button>
                <a href="javascript:void(0);" class="btn btn-primary btn-sm vote-btn" data-slug="{{ $vote->slug }}" style="color: white">
                    <i class="bi bi-check-square"></i> Vote
                </a>
                <script>
                    $(document).ready(function() {
                        $(".vote-btn").on("click", function() {
                            var slug = $(this).data("slug");
                            window.location.href = "/vote_" + slug;
                        });
                    });
                </script>
            </div>
            <div class="col-md-3 text-end mt-3">
                <button href="#" class="btn btn-outline-secondary btn-sm float-end">
                    <i class="bi bi-share"></i> Bagikan
                </button>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus vote ini?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".delete-btn").click(function() {
            var slug = $(this).data("id");
            $("#deleteForm").attr("action", "/hapus_vote_" + slug);
        });
    });
</script>
@endsection