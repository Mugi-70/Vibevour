<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tampilan Vote</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .line {
            height: 1px;
            background-color: black;
            width: 100%;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100 p-3">
        <div class="card shadow p-4 w-100" style="max-width: 600px;">
            <div id="vote-content">
                <h3 class="fw-medium" id="vote-title">Loading...</h3>
                <p class="text-muted" id="vote-date"></p>

                <div class="line"></div>

                <p class="text-secondary" id="vote-description"></p>

                <div id="questions-container"></div>

                <p class="text-muted mt-4">Vote ditutup pada <span id="vote-end"></span></p>

                <div class="row">
                    <div class="col">
                        <button id="submitVote" class="btn btn-primary btn-sm">Vote</button>
                        <a href="#" id="voteResults" class="btn btn-success btn-sm">Hasil</a>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-outline-secondary btn-sm" onclick="copyLink()">&#128279; Bagikan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            let voteSlug = "{{ $slug }}";

            $.ajax({
                url: "/vote/" + voteSlug + "/data", 
                type: "GET",
                success: function(response) {
                    $("#vote-title").text(response.vote.title);
                    $("#vote-date").text("Vote dibuat pada " + response.vote.created_at);
                    $("#vote-description").text(response.vote.description);
                    $("#vote-end").text(response.vote.end_date ?? "-");
                    $("#voteResults").attr("href", "/vote/" + voteSlug + "/results");

                    let questionsHtml = "";

                    if (response.vote.questions.length > 0) {
                        response.vote.questions.forEach(question => {
                            questionsHtml += `<h6 class="mt-4">${question.question}</h6>`;
                            question.options.forEach(option => {
                                questionsHtml += `
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="voteOption[${question.id}]" value="${option.id}" id="option${option.id}">
                                        <label class="form-check-label text-muted" for="option${option.id}">${option.option}</label>
                                    </div>`;
                            });
                        });
                    } else {
                        questionsHtml = "<p class='text-muted'>Tidak ada pertanyaan untuk voting ini.</p>";
                    }

                    $("#questions-container").html(questionsHtml);
                },
                error: function(error) {
                    console.log("Error fetching vote data:", error);
                }
            });

            $("#submitVote").click(function() {
                let selectedOptions = {}; 

                $("input[type=radio]:checked").each(function() {
                    selectedOptions[$(this).attr("name")] = $(this).val();
                });

                if (Object.keys(selectedOptions).length === 0) {
                    alert("Pilih setidaknya satu opsi sebelum voting!");
                    return;
                }

                $.ajax({
                    url: "/vote/" + voteSlug + "/submit",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", 
                        votes: selectedOptions
                    },
                    success: function(response) {
                        alert("Vote berhasil disimpan!");
                        window.location.href = "/vote/" + voteSlug + "/results";
                    },
                    error: function(error) {
                        console.log("Error submitting vote:", error);
                        alert("Terjadi kesalahan saat mengirim vote.");
                    }
                });
            });
        });

        function copyLink() {
            var dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = window.location.href;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
            alert("Link telah disalin!");
        }
    </script>
</body>

</html>