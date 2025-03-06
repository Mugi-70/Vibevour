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
        <h4 class="fw-bold">{{ $vote->title }}</h4>
        <p class="text-muted">Vote dibuat pada {{ $vote->created_at->format('d/m/Y') }}</p>
        <p class="text-secondary">
            {{ $vote->description }}
        </p>
        <div class="line"></div>

        <h5 class="my-4">Daftar Pertanyaan</h5>
        @foreach ($vote->questions as $index => $question)
        <div class="row ">
            <div class="col-md-6">
                <p class="fw-bold">{{ $question->question }}</p>

                @php
                $totalVotes = $question->options->sum(fn($option) => $option->results->count());
                $colors = ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FF1493', '#39FF14', '#00FFFF', '#FFD700'];
                $colorIndex = 0;
                @endphp

                @foreach ($question->options as $option)
                @php
                $voteCount = optional($option->results)->count() ?? 0;
                $percentage = $totalVotes > 0 ? round(($voteCount / $totalVotes) * 100, 2) : 0;
                $barColor = $colors[$colorIndex % count($colors)];
                $colorIndex++;
                @endphp

                <div class="row mb-2">
                    <div class="col-6">{{ $option->option }}</div>
                    <div class="col-6 text-end">{{ $percentage }}% ({{ $voteCount }} Vote)</div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar" style="width: {{ $percentage }}%; background-color: {{ $barColor }};"></div>
                </div>
                @endforeach

                <p class="mt-3 fw-bold">Total vote untuk pertanyaan ini: {{ $totalVotes }}</p>
            </div>

            <div class="col-md-6">
                <h5 class="my-4">Hasil Voting</h5>
                <canvas id="pieChart-{{ $index }}" style="max-width: 100%; max-height: 300px;"></canvas>
            </div>
        </div>

        @if (!$loop->last)
        <hr class="my-4 line">
        @endif
        @endforeach

        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "{{ route('vote.show', $vote->slug) }}/chart-data",
                    method: "GET",
                    success: function(data) {
                        if (data.length > 0) {
                            let defaultColor = '#D3D3D3';
                            let colors = ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FF1493', '#39FF14', '#00FFFF', '#FFD700'];

                            data.forEach((question, index) => {
                                let ctx = document.getElementById(`pieChart-${index}`).getContext('2d');

                                let labels = [];
                                let counts = [];
                                let chartColors = [];

                                question.options.forEach((option, optionIndex) => {
                                    labels.push(option.label);
                                    counts.push(option.count);
                                });

                                let totalVotes = counts.reduce((a, b) => a + b, 0);

                                if (totalVotes === 0) {
                                    labels = ["Belum ada yang melakukan voting"];
                                    counts = [1];
                                    chartColors = [defaultColor];
                                } else {
                                    chartColors = colors.slice(0, labels.length);
                                }

                                new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            data: counts,
                                            backgroundColor: chartColors,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                    }
                                });
                            });
                        }
                    },
                    error: function(error) {
                        console.log("Error fetching chart data: ", error);
                    }
                });
            });
        </script>

        <div class="row">
            <p class="mt-3 fw-bold">Total orang yang sudah melakukan vote: {{ $vote->questions->flatMap->options->flatMap->results->count() }}</p>
            @if ($vote->access_code != null)
            <p>Kode akses untuk vote ini adalah: {{ $vote->access_code }}</p>
            @endif
            <div class="col-md-9 mt-3">
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
    <div class="modal-dialog">
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