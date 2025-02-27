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
        <div class="line"></div>
        <p class="text-secondary">
            {{ $vote->description }}
        </p>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">

                </div>
                <h5 class="my-4"> Daftar Pertanyaan</h5>

                @foreach ($vote->questions as $question)
                <p class="fw-bold">{{ $question->question }}</p>

                @php
                $totalVotes = $question->options->sum(fn($option) => $option->results->count());
                $colors = ['#198754', '#d3d3d3', '#FF6384', '#36A2EB', '#FFCE56'];
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
                    <div class="col-8">{{ $option->option }}</div>
                    <div class="col-4 text-end">{{ $percentage }}% ({{ $voteCount }} Vote)</div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar" style="width: {{ $percentage }}%; background-color: {{ $barColor }};"></div>
                </div>
                @endforeach
                @endforeach

                <p class="mt-3 fw-bold">Total vote: {{ $vote->questions->flatMap->options->flatMap->results->count() }}</p>
            </div>

            <div class="col-lg-2">

            </div>
            <div class="col-lg-4">
                <h5 class="my-4">Hasil Voting</h5>
                <canvas id="pieChart" style="max-width: 400px; max-height: 300px"></canvas>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                    $(document).ready(function() {
                        $.ajax({
                            url: "{{ route('vote.show', $vote->slug) }}/chart-data",
                            method: "GET",
                            success: function(data) {
                                if (data.length >= 0) {
                                    const ctx = document.getElementById('pieChart').getContext('2d');

                                    let labels = [];
                                    let counts = [];
                                    let colors = ['#198754', '#d3d3d3', '#FF6384', '#36A2EB', '#FFCE56'];

                                    data.forEach((question, index) => {
                                        question.options.forEach((option, optionIndex) => {
                                            labels.push(option.label);
                                            counts.push(option.count);
                                        });
                                    });

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
                                            maintainAspectRatio: false
                                        }
                                    });
                                }
                            },
                            error: function(error) {
                                console.log("Error fetching chart data: ", error);
                            }
                        });
                    });
                </script>
            </div>
            <div class="row">
                <div class="col">
                    <a href="{{ route('vote.show', $vote->slug) }}/edit" class="btn btn-warning btn-sm" style="color: white"> <i class="bi bi-pencil"></i> Edit</a>
                    <a href="{{ route('vote.destroy', $vote->slug) }}/delete" class="btn btn-danger btn-sm"> <i class="bi bi-trash"></i> Hapus</a>
                    <!-- <a href="" class="btn btn-primary btn-sm">Lakukan Vote</a> -->
                </div>
                <div class="col text-end">
                    <button href="#" class="btn btn-outline-secondary btn-sm float-end">
                        <i class="bi bi-share"></i> Bagikan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection