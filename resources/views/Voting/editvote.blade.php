@extends('sidebar')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body pt-3 pb-3 pe-3 border-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Vote {{ $vote->title }}</h5>
        </div>
    </div>
</div>

<div class="container mt-4">
    <form action="{{ route('vote.update', $vote->slug) }}" method="POST" enctype="multipart/form-data" id="updateVoteForm">
        @csrf
        @method('PUT')
        <div class="card p-4">
            <h4>Detail</h4>
            <hr class="my-3" style="height: 2px; background-color: black;">
            <h5>Judul</h5>
            <input type="text" class="form-control mb-3" name="title" id="vote_title" value="{{ $vote->title }}" required>
            <h5>Deskripsi</h5>
            <textarea class="form-control mb-3" rows="3" name="description" id="vote_description" required>{{ $vote->description }}</textarea>
        </div>

        <div id="questionsContainer">
            @foreach($vote->questions as $index => $question)
            <div class="card p-3 mt-3 question-card" data-index="{{ $index }}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>Pertanyaan {{ $index + 1 }}</h4>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-question" data-question-id="{{ $question->id }}">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                <textarea class="form-control mb-3" name="questions[{{ $index }}][text]" required>{{ $question->question }}</textarea>

                <div class="optionsContainer">
                    @foreach($question->options as $optIndex => $option)
                    <div class="row mb-2 align-items-center choice-item">
                        <div class="col">
                            <input type="hidden" name="questions[{{ $index }}][options][{{ $optIndex }}][id]" value="{{ $option->id }}">
                            <input type="text" class="form-control me-2" name="questions[{{ $index }}][options][{{ $optIndex }}][text]" value="{{ $option->option }}" required>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-danger remove-option">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="col-auto">
                            <button type="button"
                                class="btn btn-outline-primary d-flex align-items-center open-upload-modal"
                                data-bs-toggle="modal"
                                data-bs-target="#uploadFotoModal"
                                data-target="img_{{ $option->id }}">
                                <i class="bi bi-image me-2"></i> Tambah Gambar
                            </button>
                        </div>
                    </div>
                    <div class="mb-2 position-relative image-container {{ $option->image ? '' : 'd-none' }}">
                        <img id="img_{{ $option->id }}"
                            src="{{ $option->image ? asset($option->image) : '' }}"
                            class="img-thumbnail"
                            style="width: 70%; height: auto;">

                        <input type="hidden"
                            name="choice_images[{{ $question->id }}][]"
                            id="image_input_{{ $option->id }}"
                            value="{{ $option->image }}">

                        <button type="button"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image-btn"
                            data-option-id="{{ $option->id }}">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <div class="text-start mt-2">
                    <button type="button" class="btn btn-primary add-option" style="text-decoration: none;">
                        <i class="bi bi-plus-circle"></i> Tambah Pilihan
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-primary" id="addQuestionBtn">
                <i class="bi bi-plus-circle"></i> Tambah Pertanyaan
            </button>
        </div>

        <div class="card p-4 mt-3">
            <h4>Pengaturan</h4>
            <hr style="height: 2px; background-color: black;">
            <div class="row">
                <div class="col-md-5">
                    <div>
                        <label for="voteVisibility" class="form-label">Tampilan hasil vote</label>
                        <select class="form-select" id="voteVisibility" name="visibility" required>
                            <option value="private" {{ $vote->visibility == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="public" {{ $vote->visibility == 'public' ? 'selected' : '' }}>Public</option>
                        </select>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="form-check form-switch mb-2">
                                <label class="form-check-label" for="protectVote">Lindungi voting dengan kode</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="protectVote" name="is_protected"
                                    {{ $vote->is_protected ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" id="randomCode" name="access_code" class="form-control mb-2 
                                    {{ $vote->is_protected ? '' : 'd-none' }}"
                                    value="{{ $vote->access_code ?? '' }}" readonly>
                            </div>
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
                                <input class="form-check-input" type="checkbox" id="includeName" name="require_name" readonly
                                    {{ $vote->require_name ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-1 d-flex">
                    <div class="vr"></div>
                </div>

                <div class="col-md-5">
                    <label for="datetimePicker" class="form-label">Buka vote pada</label>
                    <div class="mb-2 input-group">
                        <input type="text" class="form-control" id="datetimePicker" name="open_date"
                            value="{{ $vote->open_date ? \Carbon\Carbon::parse($vote->open_date)->format('Y-m-d H:i') : '' }}"
                            placeholder="Pilih Tanggal & Jam" required>
                        <span class="input-group-text">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                    </div>
                    <label for="datetimePicker" class="form-label">Tutup vote pada</label>
                    <div class="mb-2 input-group">
                        <input type="text" class="form-control" id="datetimePicker" name="close_date"
                            value="{{ $vote->close_date ? \Carbon\Carbon::parse($vote->close_date)->format('Y-m-d H:i') : '' }}"
                            placeholder="Pilih Tanggal & Jam" required>
                        <span class="input-group-text">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                    </div>


                </div>
            </div>
        </div>
        <div class="text-end mt-3">
            <a href="{{ route('vote.show', ['slug' => $vote->slug]) }}" class="btn btn-secondary m-1">
                <i class="bi bi-chevron-left"></i>Kembali
            </a>
            <button type="button" class="btn btn-success m-1" data-bs-toggle="modal" data-bs-target="#confirmUpdateModal">
                <i class="bi bi-save"></i> Simpan Perubahan
            </button>
        </div>

        <div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUpdateLabel">Konfirmasi Perubahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menyimpan perubahan ini?
                            Setelah disimpan, hasil vote ini akan di reset
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="confirmUpdateButton">Ya, Simpan</button>
                    </div>
                </div>
            </div>
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
    </form>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Peringatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="errorModalContent">
                Setiap pertanyaan harus memiliki minimal 2 opsi.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Tanggal
        flatpickr("#datetimePicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today"
        });

        // Kode vote
        $('#protectVote').on('change', function() {
            let textbox = $('#randomCode');
            if ($(this).is(':checked')) {
                textbox.val(generateRandomCode()).removeClass('d-none');
            } else {
                textbox.addClass('d-none').val('');
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

        //Pertanyaan
        let questionCount = $('.question-card').length;

        function updateQuestionNumbers() {
            $('.question-card').each(function(index) {
                $(this).data('index', index);
                $(this).find('h4:first').text('Pertanyaan ' + (index + 1));
                $(this).find('input[name^="questions"][name$="[id]"]').attr('name', 'questions[' + index + '][id]');
                $(this).find('textarea[name^="questions"][name$="[text]"]').attr('name', 'questions[' + index + '][text]');

                // Update option indices
                $(this).find('.optionsContainer .row').each(function(optIndex) {
                    $(this).find('input[name$="[id]"]').attr('name', 'questions[' + index + '][options][' + optIndex + '][id]');
                    $(this).find('input[name$="[text]"]').attr('name', 'questions[' + index + '][options][' + optIndex + '][text]');
                });
            });
        }

        $('#addQuestionBtn').click(function() {
            let newQuestionHtml = `
            <div class="card p-3 mt-3 question-card" data-index="${questionCount}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>Pertanyaan ${questionCount + 1}</h4>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-question">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <input type="hidden" name="questions[${questionCount}][id]" value="">
                <textarea class="form-control mb-3" name="questions[${questionCount}][text]" required></textarea>

                <div class="optionsContainer">
                    <!-- Option 1 -->
                    <div class="row mb-2 align-items-center choice-item">
                        <div class="col">
                            <input type="hidden" name="questions[${questionCount}][options][0][id]" value="">
                            <input type="text" class="form-control me-2" name="questions[${questionCount}][options][0][text]" placeholder="Opsi 1" required>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-danger remove-option">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-primary d-flex align-items-center open-upload-modal"
                                data-bs-toggle="modal" data-bs-target="#uploadFotoModal">
                                <i class="bi bi-image me-2"></i> Tambah Gambar
                            </button>
                        </div>
                    </div>
                    
                    <!-- Option 2 -->
                    <div class="row mb-2 align-items-center choice-item">
                        <div class="col">
                            <input type="hidden" name="questions[${questionCount}][options][1][id]" value="">
                            <input type="text" class="form-control me-2" name="questions[${questionCount}][options][1][text]" placeholder="Opsi 2" required>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-danger remove-option">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-primary d-flex align-items-center open-upload-modal"
                                data-bs-toggle="modal" data-bs-target="#uploadFotoModal">
                                <i class="bi bi-image me-2"></i> Tambah Gambar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="text-start mt-2">
                    <button type="button" class="btn btn-primary add-option">
                        <i class="bi bi-plus-circle"></i> Tambah Pilihan
                    </button>
                </div>
            </div>
        `;

            $('#questionsContainer').append(newQuestionHtml);
            questionCount++;
        });

        $(document).on("click", ".remove-question", function() {
            $(this).closest('.question-card').remove();
            updateQuestionNumbers();
            questionCount = $('.question-card').length;
        });

        $(document).on("click", ".remove-option", function() {
            const questionCard = $(this).closest('.question-card');
            const optionsContainer = questionCard.find(".optionsContainer");

            if (optionsContainer.children(".row").length <= 2) {
                $("#errorModalContent").text("Setiap pertanyaan harus memiliki minimal 2 opsi.");
                new bootstrap.Modal(document.getElementById('errorModal')).show();
                return;
            }

            $(this).closest('.row').remove();

            let optionIndex = 0;
            let questionIndex = questionCard.data('index');

            optionsContainer.find('.row').each(function() {
                $(this).find('input[name$="[id]"]').attr('name', 'questions[' + questionIndex + '][options][' + optionIndex + '][id]');
                $(this).find('input[name$="[text]"]').attr('name', 'questions[' + questionIndex + '][options][' + optionIndex + '][text]');
                optionIndex++;
            });
        });

        $(document).on("click", ".add-option", function() {
            let questionCard = $(this).closest('.question-card');
            let optionsContainer = questionCard.find(".optionsContainer");
            let questionIndex = questionCard.data("index");
            let optionIndex = optionsContainer.children(".row").length;

            let newOption = `
            <div class="row mb-2 align-items-center">
                <div class="col">
                    <input type="hidden" name="questions[${questionIndex}][options][${optionIndex}][id]" value="">
                    <input type="text" class="form-control me-2" name="questions[${questionIndex}][options][${optionIndex}][text]" placeholder="Opsi ${optionIndex + 1}" required>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-outline-danger remove-option">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center open-upload-modal"
                        data-bs-toggle="modal"
                        data-bs-target="#uploadFotoModal">
                        <i class="bi bi-image me-2"></i> Tambah Gambar
                    </button>
                </div>
            </div>
        `;

            optionsContainer.append(newOption);
        });

        let currentImageTarget, currentImageInput;

        $(document).on("click", ".open-upload-modal", function() {
            let targetId = $(this).data("target") || "new_image_" + Math.random().toString(36).substring(7);
            $(this).data("target", targetId);

            let parentRow = $(this).closest('.row');
            let imageContainer = parentRow.next('.image-container');

            if (imageContainer.length === 0) {
                imageContainer = $(`
                <div class="mb-2 position-relative image-container d-none">
                    <img id="${targetId}" class="img-thumbnail" style="width: 70%; height: auto;">
                    <input type="hidden" class="image-input" id="image_input_${targetId}">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image-btn" data-option-id="${targetId}">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            `);
                parentRow.after(imageContainer);
            }

            currentImageTarget = $("#" + targetId);
            currentImageInput = $("#image_input_" + targetId);
        });

        $("#uploadContainer").on("click", function() {
            $("#uploadInput").click();
        });

        $("#uploadInput").on("change", function() {
            const file = this.files[0];

            if (file) {
                if (file.size > 3 * 1024 * 1024) {
                    alert("Ukuran file terlalu besar. Maksimal 3MB.");
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    $("#previewImage").attr("src", e.target.result).removeClass("d-none");
                    $("#uploadIcon, #uploadText, #uploadHint").hide();
                };
                reader.readAsDataURL(file);
            }
        });

        $("#confirmUpload").on("click", function() {
            if (currentImageTarget && $("#previewImage").attr("src")) {
                currentImageTarget
                    .attr("src", $("#previewImage").attr("src"))
                    .closest(".image-container")
                    .removeClass("d-none");

                currentImageInput.val($("#previewImage").attr("src"));
            }
        });

        $("#uploadFotoModal").on("hidden.bs.modal", function() {
            $("#uploadInput").val("");
            $("#previewImage").attr("src", "").addClass("d-none");
            $("#uploadIcon, #uploadText, #uploadHint").show();
        });

        $(document).on("click", ".remove-image-btn", function() {
            const imageContainer = $(this).closest(".image-container");
            imageContainer.addClass("d-none");
            imageContainer.find("img").attr("src", "");
            imageContainer.find("input").val("");
        });

        $('#updateVoteForm').on('submit', function(e) {
            let isValid = true;
            let errorMessage = "";

            if ($('.question-card').length === 0) {
                isValid = false;
                errorMessage = "Vote harus memiliki minimal satu pertanyaan.";
            }

            $('.question-card').each(function(index) {
                const optionCount = $(this).find('.optionsContainer .row').length;
                if (optionCount < 2) {
                    isValid = false;
                    errorMessage = "Pertanyaan " + (index + 1) + " harus memiliki minimal 2 opsi.";
                    return false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                $("#errorModalContent").text(errorMessage);
                new bootstrap.Modal(document.getElementById('errorModal')).show();
                return false;
            }

            return true;
        });

        $('#confirmUpdateButton').click(function() {});
    });
</script>
@endsection