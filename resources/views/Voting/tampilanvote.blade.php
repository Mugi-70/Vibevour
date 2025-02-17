<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Tampilan Vote</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins';
        }

        .line {
            height: 1px;
            background-color: black;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 600px; width: 100%;">

            <div class="container">
                <h3 class="fw-medium">Judul</h3>
                <p class="text-muted">Vote di buat pada dd/mm/yyyy</p>
            </div>  

            <div class="line"></div>

            <div class="container">
                <p class="text-secondary">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eveniet dignissimos laborum velit facilis, et dolorum architecto impedit aspernatur voluptatibus, assumenda saepe cupiditate! Dolor nihil voluptatem quam, illo consectetur ipsam accusamus?
                </p>

                <div class="container">
                    <h6 class="mt-4">Pertanyaan</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="voteOption" id="option1">
                        <label class="form-check-label text-muted" for="option1">Pilihan 1</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="voteOption" id="option2">
                        <label class="form-check-label text-muted" for="option2">Pilihan 2</label>
                    </div>
                </div>

                <p class="text-muted mt-4">Vote di tutup pada dd/mm/yyyy --:--</p>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary btn-sm">Vote</button>
                        <div class="btn btn-success btn-sm">Hasil</div>
                    </div>
                    <div class="col">
                        <button class="btn btn-outline-secondary btn-sm float-end">&#128279; Bagikan</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>