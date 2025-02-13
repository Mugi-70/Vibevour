@extends('sidebar')

@section('content')
<div class="header" style="margin-top: 5%;">
    <h3>Tambah Vote</h3>
</div>
<div class="line"></div>


<div class="container mt-4">
    <div class="card p-4">
        <h4>Info</h4>
        <hr class="my-3" style="height: 2px; background-color: black;">
        <h5>Judul</h5>
        <input type="text" class="form-control mb-3">
        <h5>Deskripsi</h5>
        <textarea class="form-control mb-3" rows="3"></textarea>
    </div>

    <div id="questionContainer">

    </div>
    <div class="text-end mt-3">
        <button class="btn btn-primary" id="addQuestionBtn">
            <i class="bi bi-plus"></i> Tambah Pertanyaan
        </button>
    </div>


    <div class="modal fade" id="uploadFotoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="uploadContainer" class="border rounded p-4 d-flex flex-column align-items-center justify-content-center"
                        style="border-style: dashed; cursor: pointer; width: 100%; height: 200px;">
                        <i id="uploadIcon" class="bi bi-upload" style="font-size: 2rem;"></i>
                        <p id="uploadText">Klik untuk upload foto</p>
                        <p id="uploadHint" class="text-muted">JPG, PNG, Max 3MB</p>
                        <img id="previewImage" src="" class="d-none" style="max-width: 100%; height: auto;">
                        <input type="file" class="d-none" id="uploadInput" accept="image/png, image/jpeg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmUpload" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOMContentLoaded");
            const uploadContainer = document.getElementById("uploadContainer");
            const uploadInput = document.getElementById("uploadInput");
            const previewImage = document.getElementById("previewImage");
            const uploadIcon = document.getElementById("uploadIcon");
            const uploadText = document.getElementById("uploadText");
            const uploadHint = document.getElementById("uploadHint");

            uploadInput.onchange = function() {
                const file = uploadInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove("d-none");

                        uploadIcon.style.display = "none";
                        uploadText.style.display = "none";
                        uploadHint.style.display = "none";
                    };
                    reader.readAsDataURL(file);
                }
            };
        });

        document.addEventListener("DOMContentLoaded", function() {
            const uploadInput = document.getElementById("uploadInput");
            const previewImage = document.getElementById("previewImage");
            const uploadIcon = document.getElementById("uploadIcon");
            const uploadText = document.getElementById("uploadText");
            const uploadHint = document.getElementById("uploadHint");

            const modalElement = document.getElementById("uploadFotoModal");
            modalElement.addEventListener("hidden.bs.modal", function() {
                uploadInput.value = "";
                previewImage.src = "";
                previewImage.classList.add("d-none");

                uploadIcon.style.display = "block";
                uploadText.style.display = "block";
                uploadHint.style.display = "block";
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            const questionContainer = document.getElementById("questionContainer");
            const addQuestionBtn = document.getElementById("addQuestionBtn");
            let currentImageTarget = null;

            function createQuestionCard() {
                const card = document.createElement("div");
                card.classList.add("card", "p-4", "mt-3", "position-relative", "card-question");

                card.innerHTML = `
                    <button class="btn-close position-absolute top-0 end-0 m-2 delete-question-btn"></button>
                    <h4>Daftar Pertanyaan</h4>
                    <hr class="my-3" style="height: 2px; background-color: black;">
                    <h5>Pertanyaan</h5>
                    <textarea class="form-control mb-3" rows="3" placeholder="Masukkan pertanyaan"></textarea>

                    <h5>Pilihan</h5>
                    <div class="choices">
                        ${createChoiceElement()}
                        ${createChoiceElement()}
                    </div>

                    <div class="text-start">
                        <button class="btn btn-link add-choice-btn" style="text-decoration: none;">Tambah Pilihan +</button>
                    </div>
                `;

                questionContainer.appendChild(card);
                updateDeleteButtons();

                card.querySelector(".add-choice-btn").addEventListener("click", function(e) {
                    e.preventDefault();
                    card.querySelector(".choices").insertAdjacentHTML("beforeend", createChoiceElement());
                });
            }

            function createChoiceElement() {
                const choiceId = "img_" + Date.now();
                return `
                    <div class="row mb-2 align-items-center choice-item">
                        <div class="col">
                            <input type="text" class="form-control" >
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-danger remove-choice-btn">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="col-auto">
                            <label class="btn btn-primary d-flex align-items-center open-upload-modal" data-bs-toggle="modal" data-bs-target="#uploadFotoModal" data-target="${choiceId}">
                                <i class="bi bi-image me-2"></i> Tambah Gambar
                            </label>
                        </div>
                    </div>
                    <div class=" mb-2 position-relative image-container d-none">
                        <img id="${choiceId}" src="" class="img-thumbnail" style="width: 70%; height: 20%;">
                        <button class="btn btn-danger btn-md position-absolute top-0 end-0 remove-image-btn" <i class="bi bi-x-lg"></i>>
                        </button>
                    </div>
                `;
            }

            function updateDeleteButtons() {
                const questionCards = document.querySelectorAll(".card-question");
                questionCards.forEach((card) => {
                    const deleteBtn = card.querySelector(".delete-question-btn");
                    if (questionCards.length > 1) {
                        deleteBtn.classList.remove("d-none");
                    } else {
                        deleteBtn.classList.add("d-none");
                    }
                });
            }

            addQuestionBtn.addEventListener("click", createQuestionCard);

            questionContainer.addEventListener("click", function(e) {
                if (e.target.classList.contains("remove-choice-btn")) {
                    const choiceItem = e.target.closest(".choice-item");
                    if (choiceItem) {
                        const imageContainer = choiceItem.nextElementSibling;
                        if (imageContainer && imageContainer.classList.contains("image-container")) {
                            imageContainer.remove();
                        }
                        choiceItem.remove();
                    }
                }

                if (e.target.classList.contains("delete-question-btn")) {
                    e.target.closest(".card-question").remove();
                    updateDeleteButtons();
                }

                if (e.target.closest(".open-upload-modal")) {
                    const btn = e.target.closest(".open-upload-modal");
                    currentImageTarget = document.getElementById(btn.getAttribute("data-target"));
                }

                if (e.target.classList.contains("remove-image-btn")) {
                    const imgContainer = e.target.closest(".image-container");
                    if (imgContainer) imgContainer.classList.add("d-none");
                }
            });

            const uploadInput = document.getElementById("uploadInput");
            const previewImage = document.getElementById("previewImage");

            document.getElementById("uploadContainer").addEventListener("click", function() {
                uploadInput.click();
            });

            uploadInput.addEventListener("change", function() {
                const file = uploadInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove("d-none");
                    };
                    reader.readAsDataURL(file);
                }
            });

            document.getElementById("confirmUpload").addEventListener("click", function() {
                if (currentImageTarget && uploadInput.files.length > 0) {
                    currentImageTarget.src = previewImage.src;
                    currentImageTarget.closest(".image-container").classList.remove("d-none");
                }
            });

            document.getElementById("uploadFotoModal").addEventListener("hidden.bs.modal", function() {
                uploadInput.value = "";
                previewImage.src = "";
                previewImage.classList.add("d-none");
            });

            createQuestionCard();
        });
    </script>

    <div class="card p-4 mt-3">
        <h4>Pengaturan</h4>
        <hr style="height: 2px; background-color: black; width: 100%; margin: 20px 0;">
        <div class="row ">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-check form-switch mb-2">
                            <label class="form-check-label" for="protectVote">Lindungi voting dengan kode</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="protectVote">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" id="randomCode" class="form-control mt-2 d-none" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="includeName">Sertakan nama untuk mengisi</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="includeName">
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.getElementById('protectVote').addEventListener('change', function() {
                    let textbox = document.getElementById('randomCode');

                    if (this.checked) {
                        textbox.value = generateRandomCode();
                        textbox.classList.remove('d-none');
                    } else {
                        textbox.classList.add('d-none');
                    }
                });

                function generateRandomCode() {
                    let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    let code = '';
                    for (let i = 0; i < 6; i++) {
                        code += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    return code;
                }
            </script>

            <div class="col-md-2"></div>



            <div class="col-md-5">
                <div class="mb-2 input-group">
                    <input type="text" class="form-control" id="datetimePicker" placeholder="Pilih Tanggal & Jam">
                    <span class="input-group-text">
                        <i class="bi bi-calendar-event"></i>
                    </span>
                </div>

                <script>
                    flatpickr("#datetimePicker", {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        time_24hr: true,
                        minDate: "today",
                        onReady: function(selectedDates, dateStr, instance) {
                            let now = new Date();
                            instance.set("minDate", now);
                        }
                    });
                </script>
                <!-- <div class="mb-2">
                    <label for="voteCloseDate" class="form-label">Tutup vote pada</label>
                    <input type="datetime-local" class="form-control" id="voteCloseDate">
                    <div id="error-message" class="text-danger mt-1 d-none">Tanggal dan waktu harus di masa depan!</div>
                </div> -->

                <!--<script>
                    function setMinDateTime() {
                        let now = new Date();
                        let year = now.getFullYear();
                        let month = String(now.getMonth() + 1).padStart(2, '0');
                        let day = String(now.getDate()).padStart(2, '0');
                        let hours = String(now.getHours()).padStart(2, '0');
                        let minutes = String(now.getMinutes()).padStart(2, '0');

                        let minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

                        document.getElementById("voteCloseDate").setAttribute("min", minDateTime);
                    }

                    document.getElementById("voteCloseDate").addEventListener("input", function() {
                        let selectedDate = new Date(this.value);
                        let now = new Date();
                        let errorMessage = document.getElementById("error-message");

                        if (selectedDate < now) {
                            this.value = "";
                            errorMessage.classList.remove("d-none");
                        } else {
                            errorMessage.classList.add("d-none");
                        }
                    });

                    setMinDateTime();
                </script> -->

                <div>

                    <label for="voteVisibility" class="form-label">Tampilan hasil vote</label>
                    <select class="form-select" id="voteVisibility">
                        <option>Private</option>
                        <option>Public</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="text-end mt-3">
        <a href="/vote" type="button" class="btn btn-secondary m-1">Kembali<i
                class="bi bi-chevron-compact-right"></i></a>
        <a href="/ready_grup" type="submit" class="btn btn-success m-1" style="border:none">Simpan
            Vote <i class="bi bi-save"></i>
        </a>
    </div>
</div>
@endsection