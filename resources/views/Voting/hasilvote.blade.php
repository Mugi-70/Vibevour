@extends('sidebar')
@section('content'  )
<div class="container d-flex justify-content-center align-items-center min-vh-100 p-3">
    <div class="card shadow p-4 w-100" style="max-width: 800px;">
        <div class="row">
            <div class="col-lg-8">
                <h4 class="fw-bold">Judul</h4>
                <p class="text-muted">Vote dibuat pada dd/mm/yyyy</p>
                <div class="line"></div>
                <p class="text-secondary">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione laboriosam animi quaerat doloremque explicabo libero rerum tempora magni expedita.
                </p>
                <h5 class="my-4">Pertanyaan</h5>
                <div class="row mb-2">
                    <div class="col-8">Pilihan 1</div>
                    <div class="col-4 text-end">100% (1 Vote)</div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" style="width: 100%"></div>
                </div>
                <div class="row mb-2">
                    <div class="col-8">Pilihan 2</div>
                    <div class="col-4 text-end">0% (0 Vote)</div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-secondary" style="width: 0%"></div>
                </div>
                <p class="mt-3 fw-bold">Total vote: 1</p>
            </div>
            <div class="col-lg-4 d-flex justify-content-center align-items-center">
                <canvas id="pieChart" style="max-width: 250px;"></canvas>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <p class="text-muted">Vote ditutup pada dd/mm/yyyy --:--</p>
            </div>
            <div class="col text-end">
                <button class="btn btn-outline-secondary btn-sm">&#128279; Bagikan</button>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pilihan 1', 'Pilihan 2'],
            datasets: [{
                data: [1, 0],
                backgroundColor: ['#198754', '#d3d3d3'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>

@endsection