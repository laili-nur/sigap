<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('book'); ?>">Buku</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">Form</a>
            </li>
        </ol>
    </nav>
</header>
<pre><?php print_r($input); ?></pre>
<div class="page-section">
    <?= validation_errors() ?>
    <div class="row">
        <div class="col-md-6">
            <section class="card">
                <div class="card-body">
                    <?= form_open_multipart($form_action, 'novalidate id="form_book"'); ?>
                    <fieldset>
                        <legend>Form Buku</legend>
                        <?= isset($input->book_id) ? form_hidden('book_id', $input->book_id) : ''; ?>
                        <div class="form-group">
                            <label for="from_outside">Asal Buku
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('from_outside', [0 => 'Buku UGM Press', 1 => 'Buku dari luar'], $input->from_outside, 'id="from_outside" class="form-control custom-select d-block"'); ?>
                            <?= form_error('from_outside'); ?>
                        </div>
                        <hr>
                        <div
                            class="form-group"
                            id="draft-id-wrapper"
                        >
                            <label for="category">Draft
                                <abbr title="Required">*</abbr>
                            </label>
                            <?php if ($input->draft_id == '' or $this->uri->segment(2) == 'add') : ?>
                                <!-- jika draft id kosong -->
                                <?= form_dropdown('draft_id', get_dropdown_list_draft_final(), $input->draft_id, 'id="draft_id" class="form-control custom-select d-block"'); ?>
                                <small class="form-text text-muted">Hanya draft berstatus FINAL yang dapat
                                    dipilih</small>
                                <?= form_error('draft_id'); ?>
                            <?php else : ?>
                                <!-- jika draft id tidak kosong -->
                                <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                                <p class="font-weight-bold"><a href="<?= base_url('draft/view/' . $input->draft_id); ?>"><?= konversiID('draft', 'draft_id', $input->draft_id)->draft_title; ?></a>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="book_code">Kode Buku</label>
                            <?= form_input('book_code', $input->book_code, 'class="form-control" id="book_code"'); ?>
                            <?= form_error('book_code'); ?>
                        </div>
                        <div class="form-group">
                            <label for="book_title">Judul Buku
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('book_title', $input->book_title, 'class="form-control" id="book_title"'); ?>
                            <?= form_error('book_title'); ?>
                        </div>
                        <div class="form-group">
                            <label for="book_edition">Edisi Buku</label>
                            <?= form_input('book_edition', $input->book_edition, 'class="form-control" id="book_edition" '); ?>
                            <?= form_error('book_edition'); ?>
                        </div>
                        <div class="form-group">
                            <label for="book_pages">Jumlah Halaman</label>
                            <?= form_input([
                                'name'  => "book_pages",
                                'class' => 'form-control',
                                'id'    => "book_pages",
                                'value' => $input->book_pages,
                                'type' => 'number'
                            ]);
                            ?>
                            <?= form_error('book_pages'); ?>
                        </div>
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <?= form_input('isbn', $input->isbn, 'class="form-control" id="isbn"'); ?>
                            <?= form_error('isbn'); ?>
                        </div>
                        <div class="form-group">
                            <label for="eisbn">eISBN</label>
                            <?= form_input('eisbn', $input->eisbn, 'class="form-control" id="eisbn"'); ?>
                            <?= form_error('eisbn'); ?>
                        </div>
                        <div class="form-group">
                            <label for="published_date">Tanggal Terbit</label>
                            <?= form_input('published_date', $input->published_date, 'class="form-control mydate" id="published_date"'); ?>
                            <?= form_error('published_date'); ?>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <?= form_input([
                                'name'  => "harga",
                                'class' => 'form-control',
                                'id'    => "harga",
                                'value' => $input->harga,
                                'type' => 'number'
                            ]);
                            ?>
                            <?= form_error('harga'); ?>
                        </div>
                        <div class="form-group">
                            <label for="book_file">
                                File Buku
                            </label>
                            <?php if ($input->book_file) : ?>
                                <div class="alert alert-info">
                                    <div class="d-flex justify-content-between align-items-center">File buku yang tersimpan
                                        <a
                                            href="<?= base_url("book/download_file/bookfile/$input->book_file"); ?>"
                                            class="btn btn-success btn-sm my-2 uploaded-file"
                                        ><i class="fa fa-download"></i> Download</a>
                                    </div>
                                    <hr>
                                    <div>
                                        <?= form_checkbox('delete_book', true, false, 'id="delete-book"'); ?>
                                        <label
                                            class="form-check-label"
                                            for="delete-book"
                                        >
                                            <span class="text-danger">Hapus buku</span>
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div id="upload-file-form">
                                <div class="custom-file">
                                    <?= form_upload('book_file', '', 'class="custom-file-input" id="book_file"'); ?>
                                    <label
                                        class="custom-file-label"
                                        for="book_file"
                                    >Pilih file</label>
                                </div>
                                <small class="form-text text-muted">Hanya menerima file bertype : <?= get_allowed_file_types('book_file')['to_text']; ?></small>
                                <?= file_form_error('book_file', '<p class="text-danger">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="book_file_link">Link File Buku</label>
                            <?= form_input('book_file_link', $input->book_file_link, 'class="form-control" id="book_file_link"'); ?>
                            <?= form_error('book_file_link'); ?>
                        </div>
                        <div class="form-group">
                            <label for="book_notes">Keterangan Buku</label>
                            <?= form_textarea('book_notes', $input->book_notes, 'class="form-control" id="book_notes"'); ?>
                            <?= form_error('book_notes'); ?>
                        </div>
                    </fieldset>
                    <hr>
                    <div class="form-actions">
                        <button
                            id="btn-submit"
                            class="btn btn-primary ml-auto"
                            type="submit"
                            value="Submit"
                        >Submit</button>
                    </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // populate judul ketika pilih draft
    $('#draft_id').on('change', function() {
        const data = $("#draft_id option:selected").text();
        $('#book_title').val(data);
    })

    // hide onchange
    $('#from_outside').on('change', function() {
        var fromOutside = $('#from_outside option:selected').val();

        if (fromOutside == 0) {
            $("#draft-id-wrapper").show();
            $('#from_outside').val() = 0;
        } else {
            $("#draft-id-wrapper").hide();
            $('#from_outside').val() = 1;
            $('#draft_id').val() = 'test';
        }
    });

    // hide on refresh
    var fromOutside = $('#from_outside option:selected').val();

    if (fromOutside == 0) {
        $("#draft-id-wrapper").show();
        $('#from_outside').val() = 0;
    } else {
        $("#draft-id-wrapper").hide();
        $('#from_outside').val() = 1;
        $('#draft_id').val() = 'test';
    }

    // fix summernote validate error
    jQuery.validator.setDefaults({
        // This will ignore all hidden elements alongside `contenteditable` elements
        // that have no `name` attribute
        ignore: ":hidden, [contenteditable='true']:not([name])"
    });

    loadValidateSetting();

    $("#form_book").validate({
            rules: {
                draft_id: "crequired",
                book_file_link: "curl",
                book_title: {
                    crequired: true,
                    cminlength: 5,
                },
                book_file: {
                    extension: "<?= get_allowed_file_types('book_file')['types']; ?>",
                },
            },
            errorElement: "span",
            errorPlacement: validateErrorPlacement,
        },
        validateSelect2()
    );

    $("#draft_id").select2({
        placeholder: '-- Pilih --',
        allowClear: true
    });

    $('#book_notes').summernote(summernoteConfig)

    $('#delete-book').change(function() {
        if (this.checked) {
            $('#upload-file-form').hide()
        } else {
            $('#upload-file-form').show()
        }
    })
});
</script>
