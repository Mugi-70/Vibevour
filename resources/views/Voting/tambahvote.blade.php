    @extends('sidebar')

    @section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body border-0 pb-3 pe-3 pt-3">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Vote</h5>
            </div>
        </div>
    </div>

    <div class="container mt-4">

        <form id="voteForm" method="POST" action="{{ route('vote.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card p-4">
                <h4>Detail</h4>
                <hr class="my-3" style="height: 2px; background-color: black;">
                <h5>Judul</h5>
                <input type="text" class="form-control mb-3" name="title" id="vote_title" required>
                <h5>Deskripsi</h5>

                <textarea class="form-control mb-3" rows="3" name="description" id="vote_description" required></textarea>
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
                        <div>
                            <label for="protectVote" class="form-label">Kode vote</label>
                            <div class="form-control form-switch mb-2">
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="protectVote">Lindungi voting dengan kode</label>
                                    <input class="form-check-input" type="checkbox" id="protectVote" name="is_protected">
                                </div>
                            </div>
                        </div>
                        <input type="text" id="randomCode" name="access_code" class="d-none form-control mb-2" readonly>
                        <label class="form-label" for="includeName">Nonaktifkan anonymous</label>
                        <div class="form-control form-switch">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="includeName">Sertakan nama untuk mengisi</label>
                                <input class="form-check-input" type="checkbox" id="includeName" name="require_name">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-1 d-flex">
                        <div class="vr"></div>
                    </div>

                    <div class="col-md-5">
                        <label for="openDate" class="form-label">Buka vote pada</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="openDate" name="open_date"
                                placeholder="Pilih Tanggal & Jam" required>
                            <span class="input-group-text">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                        </div>
                        <label for="closeDate" class="form-label">Tutup vote pada</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="closeDate" name="close_date"
                                placeholder="Pilih Tanggal & Jam" required>
                            <span class="input-group-text">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                        </div>
                        <div>
                            <label for="voteVisibility" class="form-label">Tampilan hasil vote</label>
                            <select class="form-select" id="voteVisibility" name="visibility" required>
                                <option value="private">Private</option>
                                <option value="public">Public</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <a href="/vote_saya" class="btn btn-secondary m-1">
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
                        <div id="uploadContainer" class="d-flex flex-column align-items-center border justify-content-center p-4 rounded"
                            style="border-style: dashed; cursor: pointer; width: 100%; height: 200px;">
                            <i id="uploadIcon" class="bi bi-upload" style="font-size: 2rem;"></i>
                            <p id="uploadText">Klik untuk upload foto</p>
                            <p id="uploadHint" class="text-muted">JPG, PNG, Max 3MB</p>
                            <img id="previewImage" src="" class="d-none" style="max-width: 100%; height: auto;">
                        </div>
                        <!-- <input type="file" class="d-none" id="uploadInput" accept="image/png, image/jpeg"> -->
                        <input type="file" name="choice_images" id="uploadInput" class="d-none">
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
            let openDateInput = flatpickr("#openDate", {
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                time_24hr: true,
                minDate: "today",
                onChange: function(selectedDates) {
                    if (selectedDates.length > 0) {
                        let minCloseDate = new Date(selectedDates[0]);
                        minCloseDate.setHours(minCloseDate.getHours() + 1);

                        closeDateInput.set("minDate", minCloseDate);
                        closeDateInput.setDate(minCloseDate);
                    }
                }
            });

            let closeDateInput = flatpickr("#closeDate", {
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                time_24hr: true,
                minDate: "today"
            });

            $(document).ready(function() {
                if ($("#openDate").val()) {
                    openDateInput.setDate($("#openDate").val());

                    if (openDateInput.selectedDates.length > 0) {
                        let minCloseDate = new Date(openDateInput.selectedDates[0]);
                        minCloseDate.setHours(minCloseDate.getHours() + 1);

                        closeDateInput.set("minDate", minCloseDate);
                        closeDateInput.setDate(minCloseDate);
                    }
                }
            });


            // flatpickr("#openDate", {
            //     enableTime: true,
            //     dateFormat: "d-m-Y H:i",
            //     time_24hr: true,
            //     minDate: "today"
            // });

            // flatpickr("#closeDate", {
            //     enableTime: true,
            //     dateFormat: "d-m-Y H:i",
            //     time_24hr: true,
            //     minDate: "today"
            // });  

            //Kode vote
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

            //Pilihan
            let choiceCounters = {};

            function createChoiceElement(questionId) {

                if (!choiceCounters[questionId]) {
                    choiceCounters[questionId] = 0;
                }

                choiceCounters[questionId]++;

                const choiceId = `choice_${questionId}_${choiceCounters[questionId]}`;
                // const $choicesContainer = $(`#choices_${questionId}`);
                // const choiceCount = $choicesContainer.find('.choice-group').length + 1;
                // const choiceId = `choice_${questionId}_${choiceCount}`;

                return $(`
                <div class="choice-group" id="${choiceId}">
                    <div class="row align-items-center choice-item mb-2">
                        <div class="col-auto">
                            <span class="choice-number fw-bold"></span>
                        </div>
                        <div class="col">
                            <input type="text" 
                                class="form-control" 
                                placeholder="Pilihan"
                                name="choices[${questionId}][]"
                                id="input_${choiceId}"
                                required>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-danger remove-choice-btn">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="d-flex btn btn-outline-primary align-items-center open-upload-modal" 
                                    style="text-decoration: none;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#uploadFotoModal" 
                                    data-target="img_${choiceId}">
                                <i class="bi bi-image me-2"></i> Tambah Gambar
                            </button>
                        </div>
                    </div>
                    <div class="d-none position-relative image-container mb-2">
                        <img id="img_${choiceId}" src="" class="img-thumbnail" style="width: 70%; height: 20%;">
                        <input type="file" 
                            name="choice_images[${questionId}][]" 
                            id="actual_image_input_${choiceId}"
                            class="d-none">
                        <input type="hidden" 
                            name="choice_image_data[${questionId}][]" 
                            id="image_input_${choiceId}">
                        <button type="button" class="btn btn-danger btn-sm position-absolute end-0 remove-image-btn top-0">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            `);
            }

            //Pertanyaan
            function createQuestionCard() {
                questionCounter++;
                const questionId = `question_${questionCounter}`;
                choiceCounters[questionId] = 0;
                const $card = $(`
                    <div class="card card-question p-4 position-relative mt-3" id="${questionId}">
                        <button type="button" class="btn-close m-2 position-absolute delete-question-btn end-0 top-0"></button>
                        <h4>Daftar Pertanyaan ${questionCounter}</h4>
                        <hr class="my-3" style="height: 2px; background-color: black;">
                        <h5>Pertanyaan</h5>
                        <textarea class="form-control mb-3" 
                                rows="3" 
                                placeholder="Masukkan pertanyaan"
                                name="questions[${questionId}]"
                                id="question_text_${questionId}"
                                required></textarea>
                        
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="multiple_${questionId}" name="is_multiple[${questionId}]">
                                    <label class="form-check-label" for="multiple_${questionId}">Izinkan pilih banyak</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="required_${questionId}" name="is_required[${questionId}]">
                                    <label class="form-check-label" for="required_${questionId}">Wajib diisi</label>
                                </div>
                        
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

                $choicesContainer.append(createChoiceElement(questionId));
                $choicesContainer.append(createChoiceElement(questionId));

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
                    const newId = `question_${questionCounter}`;
                    const oldId = $(this).attr('id');

                    $(this).attr('id', newId);
                    $(this).find('textarea')
                        .attr('name', `questions[${newId}]`)
                        .attr('id', `question_text_${newId}`);

                    $(this).find(`input[type="checkbox"][id^="multiple_"]`)
                        .attr('name', `is_multiple[${newId}]`)
                        .attr('id', `multiple_${newId}`);
                    $(this).find(`label[for^="multiple_"]`)
                        .attr('for', `multiple_${newId}`);

                    $(this).find(`input[type="checkbox"][id^="required_"]`)
                        .attr('name', `is_required[${newId}]`)
                        .attr('id', `required_${newId}`);
                    $(this).find(`label[for^="required_"]`)
                        .attr('for', `required_${newId}`);

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
                console.log('click');
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

            function transferFileToInput(file, targetInputId) {
                const input = document.getElementById(targetInputId);
                if (!input) return;

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
            }

            $('#confirmUpload').on('click', function() {
                if (currentImageTarget && $uploadInput[0].files[0]) {
                    const file = $uploadInput[0].files[0];
                    const reader = new FileReader();

                    const inputId = "actual_" + currentImageInput.attr('id').replace('image_input_', 'image_input_');

                    reader.onload = function(e) {
                        currentImageTarget
                            .attr('src', e.target.result)
                            .closest(".image-container")
                            .removeClass('d-none');

                        transferFileToInput(file, inputId);
                    };
                    reader.readAsDataURL(file);
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
                $(this).closest(".card-question").remove();
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

            createQuestionCard();
        });
    </script>
    @endsection