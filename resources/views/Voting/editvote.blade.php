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
    <form id="voteForm" method="POST" action="{{ route('vote.update', ['slug' => $vote->slug]) }}">
        @csrf
        @method('PUT')
        <div class="card p-4">
            <h4>Detail</h4>
            <hr class="my-3" style="height: 2px; background-color: black;">
            <h5>Judul</h5>
            <input type="text" class="form-control mb-3" name="title" id="vote_title" value="{{ $vote->title }}" required>
            <h5>Deskripsi</h5>
            <textarea class="form-control mb-3" rows="3" name="description" id="vote_description" required>{{ trim($vote->description) }}</textarea>
        </div>

        <div id="questionContainer">
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
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-check form-switch mb-2">
                                <label class="form-check-label" for="protectVote">Lindungi voting dengan kode</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="protectVote" name="is_protected" {{ $vote->code ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" id="randomCode" name="access_code" class="form-control mb-2 {{ $vote->code ? '' : 'd-none' }}" value="{{ $vote->code }}" readonly>
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
                                <input class="form-check-input" type="checkbox" id="includeName" name="require_name" {{ $vote->name ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-1 d-flex">
                    <div class="vr"></div>
                </div>

                <div class="col-md-5">
                    <label for="datetimePicker" class="form-label">Tutup vote pada</label>
                    <div class="mb-2 input-group">
                        <input type="text" class="form-control" id="datetimePicker" name="close_date"
                            placeholder="Pilih Tanggal & Jam" value="{{ $vote->close_date }}" required>
                        <span class="input-group-text">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                    </div>

                    <div>
                        <label for="voteVisibility" class="form-label">Tampilan hasil vote</label>
                        <select class="form-select" id="voteVisibility" name="visibility" required>
                            <option value="private" {{ $vote->result_visibility == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="public" {{ $vote->result_visibility == 'public' ? 'selected' : '' }}>Public</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-3">
            <a href="{{ route('vote.show', ['slug' => $vote->slug]) }}" class="btn btn-secondary m-1">
                <i class="bi bi-chevron-left"></i>Kembali
            </a>
            <button type="submit" class="btn btn-success m-1">
                <i class="bi bi-save"></i> Simpan Vote
            </button>
        </div>
    </form>

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
</div>

<script>
    $(document).ready(function() {
        let questionCounter = 0;

        //Tanggal
        flatpickr("#datetimePicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today"
        });

        //Kode vote
        $('#protectVote').on('change', function() {
            let textbox = $('#randomCode');
            if ($(this).is(':checked')) {
                textbox.val(textbox.val() || generateRandomCode()).removeClass('d-none');
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

        //Pilihan
        function createChoiceElement(questionId, text = '', image = '') {
            const $choicesContainer = $(`#choices_${questionId}`);
            const choiceCount = $choicesContainer.find('.choice-group').length + 1;

            const choiceId = `choice_${questionId}_${choiceCount}`;
            const $choice = $(`
            <div class="choice-group" id="${choiceId}">
                <div class="row mb-2 align-items-center choice-item">
                    <div class="col-auto">
                        <span class="choice-number fw-bold"></span>
                    </div>
                    <div class="col">
                        <input type="text" 
                            class="form-control" 
                            placeholder="Pilihan"
                            name="choices[${questionId}][]"
                            id="input_${choiceId}"
                            value="${text}"
                            required>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-danger remove-choice-btn">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-primary d-flex align-items-center open-upload-modal" 
                                style="text-decoration: none;"
                                data-bs-toggle="modal" 
                                data-bs-target="#uploadFotoModal" 
                                data-target="img_${choiceId}">
                            <i class="bi bi-image me-2"></i> Tambah Gambar
                        </button>
                    </div>
                </div>
                <div class="mb-2 position-relative image-container ${!image ? 'd-none' : ''}">
                    <img id="img_${choiceId}" src="${image}" class="img-thumbnail" style="width: 70%; height: 20%;">
                    <input type="hidden" 
                        name="choice_images[${questionId}][]" 
                        id="image_input_${choiceId}"
                        value="${image}">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image-btn">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        `);

            return $choice;
        }

        //Pertanyaan
        function createQuestionCard(questionData = null) {
            questionCounter++;
            const questionId = questionData ? `question_${questionCounter}_${questionData.id}` : `question_${questionCounter}`;
            const questionText = questionData ? questionData.question : '';

            const $card = $(`
            <div class="card p-4 mt-3 position-relative card-question" id="${questionId}" ${questionData ? 'data-question-id="'+questionData.id+'"' : ''}>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2 delete-question-btn"></button>
                <h4>Daftar Pertanyaan ${questionCounter}</h4>
                <hr class="my-3" style="height: 2px; background-color: black;">
                <h5>Pertanyaan</h5>
                <textarea class="form-control mb-3" 
                        rows="3" 
                        placeholder="Masukkan pertanyaan"
                        name="questions[${questionId}]"
                        id="question_text_${questionId}"
                        required>${questionText}</textarea>
                <h5>Pilihan</h5>
                <div class="choices" id="choices_${questionId}"></div>
                <div class="text-start mt-2">
                    <button type="button" class="btn btn-primary add-choice-btn" 
                            style="text-decoration: none;" 
                            data-question-id="${questionId}">
                        <i class="bi bi-plus-circle"></i> Tambah Pilihan
                    </button>
                </div>
            </div>
        `);

            const $choicesContainer = $card.find('.choices');

            if (questionData && questionData.options && questionData.options.length > 0) {
                questionData.options.forEach(option => {
                    $choicesContainer.append(createChoiceElement(questionId, option.option, option.image));
                });
            } else {
                $choicesContainer.append(createChoiceElement(questionId));
                $choicesContainer.append(createChoiceElement(questionId));
            }

            $("#questionContainer").append($card);
            updateDeleteButtons();
            updateChoiceNumbers($choicesContainer);

            $card.find(".add-choice-btn").on('click', function(e) {
                e.preventDefault();
                const questionId = $(this).data('question-id');
                const $choices = $(`#choices_${questionId}`);
                $choices.append(createChoiceElement(questionId));
                updateChoiceNumbers($choices);
            });

            return $card;
        }

        function resequenceQuestions() {
            questionCounter = 0;
            $('.card-question').each(function(index) {
                questionCounter++;
                const originalId = $(this).attr('id');
                const questionDbId = $(this).data('question-id') || null;
                const newId = questionDbId ? `question_${questionCounter}_${questionDbId}` : `question_${questionCounter}`;

                $(this).attr('id', newId);
                $(this).find('textarea')
                    .attr('name', `questions[${newId}]`)
                    .attr('id', `question_text_${newId}`);

                $(this).find('h4').text(`Daftar Pertanyaan ${questionCounter}`);

                const $choicesContainer = $(this).find('.choices');
                $choicesContainer.attr('id', `choices_${newId}`);

                $choicesContainer.find('.choice-group').each(function(choiceIndex) {
                    const choiceNumber = choiceIndex + 1;
                    const newChoiceId = `choice_${newId}_${choiceNumber}`;
                    $(this).attr('id', newChoiceId);

                    $(this).find('input[type="text"]')
                        .attr('name', `choices[${newId}][]`)
                        .attr('id', `input_${newChoiceId}`);

                    $(this).find('input[type="hidden"]')
                        .attr('name', `choice_images[${newId}][]`)
                        .attr('id', `image_input_${newChoiceId}`);

                    $(this).find('img').attr('id', `img_${newChoiceId}`);
                    $(this).find('.open-upload-modal').attr('data-target', `img_${newChoiceId}`);
                });

                $(this).find('.add-choice-btn').attr('data-question-id', newId);
            });
        }

        function updateChoiceNumbers($choicesContainer) {
            $choicesContainer.find('.choice-item').each(function(index) {
                $(this).find('.choice-number').text(`${index + 1}.`);
                $(this).find('input[type="text"]').attr('placeholder', `Pilihan ${index + 1}`);
            });
            updateDeleteChoiceButtons($choicesContainer);
        }

        function updateDeleteChoiceButtons($choicesContainer) {
            const $choices = $choicesContainer.find('.choice-item');
            const $deleteButtons = $choicesContainer.find('.remove-choice-btn');
            $deleteButtons.toggle($choices.length > 2);
        }

        function updateDeleteButtons() {
            const $questionCards = $(".card-question");
            $questionCards.each(function() {
                const $deleteBtn = $(this).find(".delete-question-btn");
                $deleteBtn.toggle($questionCards.length > 1);
            });
        }

        let currentImageTarget = null;
        let currentImageInput = null;

        //Gambar
        const $uploadContainer = $("#uploadContainer");
        const $uploadInput = $("#uploadInput");
        const $previewImage = $("#previewImage");
        const $uploadIcon = $("#uploadIcon");
        const $uploadText = $("#uploadText");
        const $uploadHint = $("#uploadHint");

        $uploadContainer.on('click', function(e) {
            e.preventDefault();
            $uploadInput.click();
        });

        $uploadInput.on('change', function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 3 * 1024 * 1024) {
                    alert('File terlalu besar. Maksimal ukuran file adalah 3MB.');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    $previewImage
                        .attr('src', e.target.result)
                        .removeClass('d-none');

                    $uploadIcon.hide();
                    $uploadText.hide();
                    $uploadHint.hide();
                };
                reader.readAsDataURL(file);
            }
        });

        $('#uploadFotoModal').on('hidden.bs.modal', function() {
            $uploadInput.val('');
            $previewImage
                .attr('src', '')
                .addClass('d-none');
            $uploadIcon.show();
            $uploadText.show();
            $uploadHint.show();
        });

        $(document).on('click', '.open-upload-modal', function() {
            currentImageTarget = $("#" + $(this).data("target"));
            const $imageInput = $("#image_input_" + $(this).data("target").replace('img_', ''));
            currentImageInput = $imageInput;
        });

        $(document).on('click', '#confirmUpload', function() {
            if (currentImageTarget && $previewImage.attr('src')) {
                currentImageTarget
                    .attr('src', $previewImage.attr('src'))
                    .closest(".image-container")
                    .removeClass('d-none');
                currentImageInput.val($previewImage.attr('src'));
            }
        });

        $(document).on('click', '.remove-image-btn', function(e) {
            e.stopPropagation();
            const $container = $(this).closest('.image-container');
            $container.addClass('d-none');
            $container.find('img').attr('src', '');
            $container.find('input[type="hidden"]').val('');
        });

        $(document).on('click', '.remove-choice-btn', function() {
            const $choiceGroup = $(this).closest('.choice-group');
            const $choicesContainer = $choiceGroup.closest('.choices');
            const totalChoices = $choicesContainer.find('.choice-group').length;

            if (totalChoices > 2) {
                $choiceGroup.remove();

                const questionId = $choicesContainer.closest('.card-question').attr('id');
                $choicesContainer.find('.choice-group').each(function(choiceIndex) {
                    const choiceNumber = choiceIndex + 1;
                    const newChoiceId = `choice_${questionId}_${choiceNumber}`;
                    const oldId = $(this).attr('id');

                    $(this).attr('id', newChoiceId);
                    $(this).find('input[type="text"]')
                        .attr('name', `choices[${questionId}][]`)
                        .attr('id', `input_${newChoiceId}`);

                    $(this).find('input[type="hidden"]')
                        .attr('name', `choice_images[${questionId}][]`)
                        .attr('id', `image_input_${newChoiceId}`);

                    $(this).find('img').attr('id', `img_${newChoiceId}`);
                    $(this).find('.open-upload-modal').attr('data-target', `img_${newChoiceId}`);
                });

                updateChoiceNumbers($choicesContainer);
                updateDeleteChoiceButtons($choicesContainer);
            }
        });

        $(document).on('click', '.delete-question-btn', function() {
            const $questionCard = $(this).closest(".card-question");
            const questionDbId = $questionCard.data('question-id');

            if (questionDbId) {
                $('#voteForm').append(`<input type="hidden" name="deleted_questions[]" value="${questionDbId}">`);
            }

            $questionCard.remove();
            resequenceQuestions();
            updateDeleteButtons();
        });

        $("#voteForm").on('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            if (!$('#vote_title').val().trim()) {
                errorMessage += 'Judul voting harus diisi.\n';
                isValid = false;
            }

            if (!$('#vote_description').val().trim()) {
                errorMessage += 'Deskripsi voting harus diisi.\n';
                isValid = false;
            }

            $('.card-question').each(function() {
                const questionId = $(this).attr('id');
                const questionText = $(`#question_text_${questionId}`).val().trim();

                if (!questionText) {
                    errorMessage += 'Semua pertanyaan harus diisi.\n';
                    isValid = false;
                    return false;
                }

                let hasEmptyChoice = false;
                $(this).find('input[type="text"]').each(function() {
                    if (!$(this).val().trim()) {
                        hasEmptyChoice = true;
                        return false;
                    }
                });

                if (hasEmptyChoice) {
                    errorMessage += `Semua pilihan untuk pertanyaan harus diisi.\n`;
                    isValid = false;
                    return false;
                }
            });

            if (!isValid) {
                alert(errorMessage);
                e.preventDefault();
                return false;
            }

            if ($('#protectVote').is(':checked')) {
                $('#randomCode').prop('disabled', false);
            }

            return true;
        });

        $("#addQuestionBtn").on('click', function() {
            createQuestionCard();
        });

        const voteData = {
            !!json_encode($vote) !!
        };

        if (voteData.questions && voteData.questions.length > 0) {
            voteData.questions.forEach(question => {
                createQuestionCard(question);
            });
        } else {
            createQuestionCard();
        }

        console.log('Vote data:', voteData);
        console.log('Questions:', voteData.questions);
    });
</script>
@endsection