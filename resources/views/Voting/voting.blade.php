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
    <div class="p-lg-3 header">
        <div class="card border-0 shadow-sm">
            <div class="card-body border-0 pb-3 pe-3 pt-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="fw-medium" id="vote-title1">Loading...</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-flex align-items-center justify-content-center p-3">
        <div class="card p-4 shadow w-100" style="max-width: 1200px;">
            <div id="vote-content">
                <h3 class="fw-medium" id="vote-title">Loading...</h3>
                <p class="text-muted" id="vote-date"></p>

                <div class="line"></div>

                <p class="text-secondary" id="vote-description">Deskripsi</p>

                <div id="questions-container" class="m-3"></div>

                <div class="m-3" id="nameContainer" style="display: none;">
                    <label for="voterName" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="voterName" placeholder="Masukkan nama Anda">
                    <div class="invalid-feedback" id="nameFeedback">
                        Nama wajib diisi.
                    </div>
                </div>

                <p class="text-muted mt-4"><span id="vote-end"></span></p>

                <div class="row">
                    <div class="col">
                        <a href="javascript:void(0);" class="btn btn-secondary btn-sm back-vote-btn" data-slug="{{ $vote->slug }}" style="color: white">
                            <i class="bi bi-chevron-left"></i> Kembali
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
                        <a href="javascript:void(0);" class="btn btn-sm btn-success result-vote-btn" data-slug="{{ $vote->slug }}">
                            <i class="bi bi-card-checklist"></i> Hasil
                        </a>
                        <script>
                            $(document).ready(function() {
                                $(".result-vote-btn").on("click", function() {
                                    var slug = $(this).data("slug");
                                    window.location.href = "/result_vote_" + slug;
                                });
                            });
                        </script>
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
                        console.log("Protection check:", response);
                        if (response.is_protected) {
                            $.ajax({
                                url: "/vote_" + voteSlug + "/check-session",
                                type: "GET",
                                success: function(sessionResponse) {
                                    if (sessionResponse.verified) {
                                        loadVoteData();
                                    } else {
                                        accessModal = new bootstrap.Modal(document.getElementById('accessCodeModal'));
                                        accessModal.show();
                                    }
                                },
                                error: function() {
                                    accessModal = new bootstrap.Modal(document.getElementById('accessCodeModal'));
                                    accessModal.show();
                                }
                            });
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
                        let currentDate = new Date();
                        let openDate = new Date(response.vote.open_date);
                        let closeDate = new Date(response.vote.close_date);


                        if (response.vote.result_visibility === 'private') {
                            $(".result-vote-btn").hide();
                        }

                        if (currentDate < openDate) {
                            $("#voteNotStartedModal").modal('show');
                            $("#vote-content").hide();
                            return;
                        }

                        if (currentDate > closeDate) {
                            $("#voteClosedModal").modal('show');
                            $("#vote-content").hide();
                            return;
                        }

                        console.log(response);
                        $("#vote-title1").text("Vote " + response.vote.title);
                        $("#vote-title").text(response.vote.title);
                        $("#vote-date").text("Vote dibuat pada " + response.vote.created_at);
                        $("#vote-description").text(response.vote.description);
                        $("#vote-end").text("Vote berakhir pada " + response.vote.close_date);

                        if (response.vote.require_name) {
                            $("#nameContainer").show();
                        } else {
                            $("#nameContainer").hide();
                        }

                        let questionsHtml = "";

                        if (response.vote.questions.length > 0) {
                            response.vote.questions.forEach((question, index) => {
                                questionsHtml += `<h6 class="mt-4">${question.question} ${question.required ? '<span class="text-danger">*</span>' : ''}</h6>`;

                                question.options.forEach(option => {
                                    questionsHtml += `
                                <div class="form-check">
                                    <input class="form-check-input" type="${question.type === 'multiple' ? 'checkbox' : 'radio'}" 
                                        name="voteOption[${question.id}]${question.type === 'multiple' ? '[]' : ''}" 
                                        value="${option.id}" id="option${option.id}">
                                    <label class="d-flex flex-column align-items-start form-check-label text-muted" for="option${option.id}">
                                    ${option.option}
                                    ${option.image ? `<img src="${option.image}" alt="Option Image" class="img-thumbnail mt-2" style="width: 1000px; object-fit: cover;">` : ''}
                                </label>
                                </div>`;
                                });

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
                        console.log("Access verification:", response);

                        if (response.valid) {
                            accessModal.hide();
                            loadVoteData();
                        } else {
                            $("#accessCodeInput").addClass("is-invalid");
                            $("#accessCodeFeedback").text("Kode akses tidak valid. Silakan coba lagi.");
                        }
                    },
                    error: function(error) {
                        console.error("Access verification error:", error);
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

                $("input[type=checkbox]:checked, input[type=radio]:checked").each(function() {
                    let name = $(this).attr("name").replace("voteOption[", "").replace("][]", "").replace("]", "");
                    if (!selectedOptions[name]) {
                        selectedOptions[name] = [];
                    }
                    selectedOptions[name].push($(this).val());
                });

                $("h6").each(function() {
                    let questionId = $(this).next(".form-check").find("input").attr("name");
                    if (questionId) {
                        questionId = questionId.replace("voteOption[", "").replace("]", "");
                        let isRequired = $(this).find(".text-danger").length > 0;

                        if (isRequired && (!selectedOptions[questionId] || selectedOptions[questionId].length === 0)) {
                            isValid = false;
                        }
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
                        name: voterName,
                    },
                    success: function(response) {
                        if (response.has_voted) {
                            $("#alreadyVotedModal").modal("show");
                        } else {
                            $("#successVoteModal").modal("show");
                        }
                    },
                    error: function(xhr) {
                        $("#errorVoteModal").modal("show");
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

<div class="modal fade" id="voteNotStartedModal" tabindex="-1" aria-labelledby="voteNotStartedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voteNotStartedModalLabel">Vote Belum Dimulai</h5>
            </div>
            <div class="modal-body">
                <p>Vote ini belum dibuka. Silakan kembali pada tanggal dan jam yang ditentukan.</p>
            </div>
            <div class="modal-footer">
                <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="voteClosedModal" tabindex="-1" aria-labelledby="voteClosedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voteClosedModalLabel">Vote Telah Ditutup</h5>
            </div>
            <div class="modal-body">
                <p>Vote ini sudah ditutup. Anda tidak dapat lagi melakukan vote.</p>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-success result-vote-btn" data-slug="{{ $vote->slug }}">
                    <i class="bi bi-card-checklist"></i> Hasil
                </a>
                <script>
                    $(document).ready(function() {
                        $(".result-vote-btn").on("click", function() {
                            var slug = $(this).data("slug");
                            window.location.href = "/result_vote_" + slug;
                        });
                    });
                </script>
                <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successVoteModal" tabindex="-1" aria-labelledby="successVoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successVoteModalLabel">Vote Berhasil</h5>
            </div>
            <div class="modal-body">
                <p>Terima kasih! Suara Anda telah berhasil dikirim.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorVoteModal" tabindex="-1" aria-labelledby="errorVoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorVoteModalLabel">Terjadi Kesalahan</h5>
            </div>
            <div class="modal-body">
                <p>Maaf, terjadi kesalahan saat mengirim vote Anda. Silakan coba lagi nanti.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alreadyVotedModal" tabindex="-1" aria-labelledby="alreadyVotedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-warning">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="alreadyVotedModalLabel">Anda Sudah Vote</h5>
            </div>
            <div class="modal-body">
                <p>Anda telah melakukan vote sebelumnya. Setiap orang hanya bisa vote satu kali.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="javascript:void(0);" class="btn btn-success result-vote-btn" data-slug="{{ $vote->slug }}">
                    <i class="bi bi-card-checklist"></i> Hasil
                </a>
                <script>
                    $(document).ready(function() {
                        $(".result-vote-btn").on("click", function() {
                            var slug = $(this).data("slug");
                            window.location.href = "/result_vote_" + slug;
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

</html>