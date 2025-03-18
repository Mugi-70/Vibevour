<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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


        .card-body h5 {
            font-size: 30px;
            font-weight: bold;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="header p-lg-3">
        <div class=" card border-0 shadow-sm">
            <div class="card-body pt-3 pb-3 pe-3 border-0">
                <div class=" d-flex justify-content-between align-items-center">
                    <h3 class="fw-medium" id="vote-title1">Loading...</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-center align-items-center  p-3">
        <div class="card shadow p-4 w-100" style="max-width: 1200px;">
            <div id="vote-content">
                <h3 class="fw-medium" id="vote-title">Loading...</h3>
                <p class="text-muted" id="vote-date"></p>

                <div class="line"></div>

                <p class="text-secondary" id="vote-description">Deskripsi</p>

                <div id="questions-container" class="m-3"></div>

                <div class="m-3" id="nameContainer" style="display: none;">
                    <label for="voterName" class="form-label">Nama Anda:</label>
                    <input type="text" class="form-control" id="voterName" placeholder="Masukkan nama Anda">
                    <div class="invalid-feedback" id="nameFeedback">
                        Nama wajib diisi.
                    </div>
                </div>

                <p class="text-muted mt-4"><span id="vote-end"></span></p>

                <div class="row">
                    <div class="col">
                        <a href="javascript:void(0);" class="btn btn-secondary btn-sm back-vote-btn" data-slug="{{ $vote->slug }}" style="color: white">
                            <i class="bi bi-chevron-left"></i> Back
                        </a>
                        <script>
                            $(document).ready(function() {
                                $(".back-vote-btn").on("click", function() {
                                    var slug = $(this).data("slug");
                                    window.location.href = "/detail_vote_" + slug;
                                });
                            });
                        </script>
                        <button id="submitVote" class="btn btn-primary btn-sm"><i class="bi bi-check-square"></i> Vote</button>
                        <a href="#" id="voteResults" class="btn btn-success btn-sm"><i class="bi bi-card-checklist"></i> Hasil</a>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-outline-secondary btn-sm" onclick="copyLink()"><i class="bi bi-share"></i> Bagikan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            let voteSlug = "{{ $slug }}";
            let accessModal;

            function checkAccessProtection() {
                $.ajax({
                    url: "/vote_" + voteSlug + "/check-protection",
                    type: "GET",
                    success: function(response) {
                        if (response.is_protected) {
                            accessModal = new bootstrap.Modal(document.getElementById('accessCodeModal'));
                            accessModal.show();
                        } else {
                            loadVoteData();
                        }
                    },
                    error: function(error) {
                        console.log("Error checking vote protection:", error);
                        loadVoteData();
                    }
                });
            }

            function loadVoteData() {
                $.ajax({
                    url: "/vote_" + voteSlug + "/data",
                    type: "GET",
                    success: function(response) {
                        console.log(response);
                        $("#vote-title1").text("Vote " + response.vote.title);
                        $("#vote-title").text(response.vote.title);
                        $("#vote-date").text("Vote dibuat pada " + response.vote.created_at);
                        $("#vote-description").text(response.vote.description);
                        $("#vote-end").text("Vote berakhir pada " + response.vote.close_date);
                        $("#voteResults").attr("href", "/vote/" + voteSlug + "/results");

                        if (response.vote.require_name) {
                            $("#nameContainer").show();
                        } else {
                            $("#nameContainer").hide();
                        }

                        let questionsHtml = "";

                        if (response.vote.questions.length > 0) {
                            response.vote.questions.forEach((question, index) => {
                                questionsHtml += `<h6 class="mt-4">${question.question} ${question.required ? '<span class="text-danger">*</span>' : ''}</h6>`;

                                if (question.type === "multiple") {
                                    question.options.forEach(option => {
                                        questionsHtml += `
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="voteOption[${question.id}][]" value="${option.id}" id="option${option.id}">
                                        <label class="form-check-label text-muted" for="option${option.id}">${option.option}</label>
                                    </div>`;
                                    });
                                } else {
                                    question.options.forEach(option => {
                                        questionsHtml += `
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="voteOption[${question.id}]" value="${option.id}" id="option${option.id}">
                                        <label class="form-check-label text-muted" for="option${option.id}">${option.option}</label>
                                    </div>`;
                                    });
                                }


                                if (index !== response.vote.questions.length - 1) {
                                    questionsHtml += `<hr class="hr my-3">`;
                                }
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
            }


            $("#submitAccessCode").click(function() {
                let accessCode = $("#accessCodeInput").val().trim();

                if (accessCode.length !== 6) {
                    $("#accessCodeInput").addClass("is-invalid");
                    $("#accessCodeFeedback").text("Kode akses harus 6 digit.");
                    return;
                }

                $.ajax({
                    url: "/vote_" + voteSlug + "/verify-access",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        access_code: accessCode
                    },
                    success: function(response) {
                        if (response.valid) {
                            accessModal.hide();
                            loadVoteData();
                        } else {
                            $("#accessCodeInput").addClass("is-invalid");
                            $("#accessCodeFeedback").text("Kode akses tidak valid. Silakan coba lagi.");
                        }
                    },
                    error: function(error) {
                        console.log("Error verifying access code:", error);
                        $("#accessCodeInput").addClass("is-invalid");
                        $("#accessCodeFeedback").text("Terjadi kesalahan. Silakan coba lagi.");
                    }
                });
            });

            $("#accessCodeInput").on("input", function() {
                $(this).removeClass("is-invalid");
            });

            checkAccessProtection();

            $("#submitVote").click(function() {
                let selectedOptions = {};
                let voterName = $("#voterName").val().trim();
                let requiresName = $("#nameContainer").is(":visible");
                let isValid = true;

                $("input[type=checkbox]:checked").each(function() {
                    let name = $(this).attr("name").replace("voteOption[", "").replace("][]", "").replace("]", "");
                    if (!selectedOptions[name]) {
                        selectedOptions[name] = [];
                    }
                    selectedOptions[name].push($(this).val());
                });

                $(".form-check-input").each(function() {
                    let questionId = $(this).attr("name").replace("voteOption[", "").replace("][]", "").replace("]", "");
                    let isRequired = $(this).closest(".form-check").prev("h6").find(".text-danger").length > 0;

                    if (isRequired && (!selectedOptions[questionId] || selectedOptions[questionId].length === 0)) {
                        isValid = false;
                    }
                });

                if (requiresName && voterName === "") {
                    $("#voterName").addClass("is-invalid");
                    $("#nameFeedback").text("Nama wajib diisi.");
                    isValid = false;
                } else {
                    $("#voterName").removeClass("is-invalid");
                }

                if (!isValid) {
                    alert("Harap lengkapi semua pertanyaan yang wajib diisi!");
                    return;
                }

                $.ajax({
                    url: "/vote_" + voteSlug + "/submit",
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        votes: selectedOptions,
                        name: voterName
                    },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.status === 403) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert("Terjadi kesalahan saat mengirim vote.");
                        }
                    }
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

        });
    </script>
    <div class="modal fade" id="accessCodeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="accessCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accessCodeModalLabel">Kode Akses Dibutuhkan</h5>
                </div>
                <div class="modal-body">
                    <p>Vote ini memerlukan kode akses untuk melanjutkan.</p>
                    <div class="form-group">
                        <label for="accessCodeInput" class="form-label">Masukkan kode akses:</label>
                        <input type="text" class="form-control" id="accessCodeInput" maxlength="6" placeholder="Masukkan 6 digit kode">
                        <div class="invalid-feedback" id="accessCodeFeedback">
                            Kode akses tidak valid. Silakan coba lagi.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitAccessCode"><i class="bi bi-shield-check"></i> Verifikasi</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>