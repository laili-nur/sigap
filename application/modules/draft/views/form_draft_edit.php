<?php
$draft_status_code = array_merge(range(0, 14), range(17, 19), [99]);

$draft_status_options = array_map(function ($draft_status) {
    return  draft_status_to_text($draft_status);
}, $draft_status_code)
?>
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('draft'); ?>">Draft</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">Form</a>
            </li>
        </ol>
    </nav>
</header>
<?php echo validation_errors() ?>
<div class="page-section">
    <div class="row">
        <div class="col-12">
            <section class="card">
                <div class="card-body">
                    <?= form_open_multipart($form_action, 'novalidate="" id="formdraftedit"'); ?>
                    <fieldset>
                        <legend>Edit Draft</legend>
                        <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                        <div class="alert alert-danger">
                            <strong>Perhatian</strong>
                            <p class="mb-0">1. Halaman ini digunakan untuk mengedit tanggal secara manual, namun pastikan sudah
                                melakukan proses step-by-step dari halaman <a href="<?= base_url("draft/view/$input->draft_id"); ?>">view draft</a>.</p>
                            <p class="mb-0">2. Halaman ini juga digunakan untuk mereset progress draft, dengan cara
                                menyesuaikan status draft, dan hapus tanggal masing-masing.</p>
                        </div>
                        <div class="form-group">
                            <label for="draft_title">Judul
                                <abbr title="Required">*</abbr>
                            </label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('draft_title', $input->draft_title, 'class="form-control" id="draft_title"'); ?>
                            </div>
                            <?= form_error('draft_title'); ?>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('category_id', get_dropdown_list('category', ['category_id', 'category_name']), $input->category_id, 'id="category" class="form-control custom-select d-block"'); ?>
                            <?= form_error('category_id'); ?>
                        </div>
                        <div class="form-group">
                            <label for="theme_id">Tema
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('theme_id', get_dropdown_list('theme', ['theme_id', 'theme_name']), $input->theme_id, 'id="theme" class="form-control custom-select d-block"'); ?>
                            <?= form_error('theme_id'); ?>
                        </div>
                        <div class="form-group">
                            <label for="draft_file">File Draft</label>
                            <?php if ($input->draft_file) : ?>
                                <div class="alert alert-info">
                                    <div class="d-flex justify-content-between align-items-center">File draft yang tersimpan
                                        <a
                                            href="<?= base_url("draft/download_file/draftfile/$input->draft_file"); ?>"
                                            class="btn btn-success btn-sm my-2 uploaded-file"
                                        ><i class="fa fa-download"></i> Download</a>
                                    </div>
                                    <hr>
                                    <div>
                                        <?= form_checkbox('delete_draft', true, false, 'id="delete-draft"'); ?>
                                        <label
                                            class="form-check-label"
                                            for="delete-draft"
                                        >
                                            <span class="text-danger">Hapus draft</span>
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div id="upload-file-form">
                                <div class="custom-file">
                                    <?= form_upload('draft_file', '', 'class="custom-file-input"'); ?>
                                    <label
                                        class="custom-file-label"
                                        for="draft_file"
                                    >Pilih file</label>
                                    <div class="invalid-feedback">Field is required</div>
                                </div>
                                <small class="form-text text-muted">Hanya menerima file bertype : <?= get_allowed_file_types('draft_file')['to_text']; ?></small>
                                <?= file_form_error('draft_file', '<p class="text-danger">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="draft_file_link">Link File Draft</label>
                            <?= form_input('draft_file_link', $input->draft_file_link, 'class="form-control" id="draft_file_link"'); ?>
                            <?= form_error('draft_file_link'); ?>
                        </div>
                        <div class="form-group">
                            <label for="draft_pages">Jumlah Halaman</label>
                            <?= form_input('draft_pages', $input->draft_pages, 'class="form-control" id="draft_pages"'); ?>
                            <?= form_error('draft_pages'); ?>
                        </div>
                        <div class="form-group">
                            <label for="entry_date">Tanggal Masuk
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('entry_date', $input->entry_date, 'class="form-control dates" '); ?>
                            <?= form_error('entry_date'); ?>
                        </div>
                        <div class="form-group">
                            <label for="finish_date">Tanggal Selesai</label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('finish_date', $input->finish_date, 'class="form-control dates" '); ?>
                                <?= form_error('finish_date'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                Tipe Naskah
                                <abbr title="Required">*</abbr>
                            </label>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <?= form_radio('is_reprint', 'y', isset($input->is_reprint) && ($input->is_reprint == 'y') ? true : false, ' class="custom-control-input" id="is_reprint_true"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="is_reprint_true"
                                    >Cetak ulang</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('is_reprint', 'n', isset($input->is_reprint) && ($input->is_reprint == 'n') ? true : false, 'class="custom-control-input" id="is_reprint_false"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="is_reprint_false"
                                    >Naskah baru</label>
                                </div>
                                <?= form_error('is_reprint'); ?>
                            </div>
                            <div class="form-group">
                                <label for="draft_status">Progress</label>
                                <?= form_dropdown('draft_status', $draft_status_options, $input->draft_status, 'id="draft_status" class="form-control custom-select d-block"'); ?>
                            </div>
                            <div class="form-group">
                                <label for="draft_notes">Catatan draft</label>
                                <?= form_textarea('draft_notes', $input->draft_notes, 'class="form-control" id="draft_notes"'); ?>
                            </div>
                        </div>
                        <hr>

                        <h5 class="card-title">Review</h5>
                        <div class="form-group">
                            <label>Status Review</label>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio(
                                        'is_review',
                                        'y',
                                        isset($input->is_review) && ($input->is_review == 'y') ? true : false
                                    ); ?> <i class="fa fa-check text-success"></i> Sudah Review
                                </label>
                            </div>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio(
                                        'is_review',
                                        'n',
                                        isset($input->is_review) && ($input->is_review == 'n') ? true : false
                                    ); ?> <i class="fa fa-times text-danger"></i> Belum Review
                                </label>
                            </div>
                            <?= form_error('is_review'); ?>
                        </div>
                        <div class="form-group">
                            <label for="review_start_date">Tanggal Mulai Review
                            </label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('review_start_date', $input->review_start_date, 'class="form-control dates"'); ?>
                                <?= form_error('review_start_date'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="review_end_date">Tanggal Selesai Review
                            </label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('review_end_date', $input->review_end_date, 'class="form-control dates" '); ?>
                                <?= form_error('review_end_date'); ?>
                            </div>
                        </div>
                        <hr>
                        <h5 class="card-title">Edit</h5>
                        <div class="form-group">
                            <label>Status Edit</label>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio(
                                        'is_edit',
                                        'y',
                                        isset($input->is_edit) && ($input->is_edit == 'y') ? true : false
                                    ); ?><i class="fa fa-check text-success"></i> Sudah Edit
                                </label>
                            </div>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio(
                                        'is_edit',
                                        'n',
                                        isset($input->is_edit) && ($input->is_edit == 'n') ? true : false
                                    ); ?><i class="fa fa-times text-danger"></i> Belum Edit
                                </label>
                            </div>
                            <?= form_error('is_edit'); ?>
                        </div>
                        <div class="form-group">
                            <label for="edit_start_date">Tanggal Mulai edit
                            </label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('edit_start_date', $input->edit_start_date, 'class="form-control dates" '); ?>
                                <?= form_error('edit_start_date'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_end_date">Tanggal Selesai Edit
                            </label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('edit_end_date', $input->edit_end_date, 'class="form-control dates" '); ?>
                                <?= form_error('edit_end_date'); ?>
                            </div>
                        </div>
                        <hr>
                        <h5 class="card-title">Layout</h5>
                        <div class="form-group">
                            <label>Status Layout</label>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio(
                                        'is_layout',
                                        'y',
                                        isset($input->is_layout) && ($input->is_layout == 'y') ? true : false
                                    ); ?><i class="fa fa-check text-success"></i> Sudah Layout
                                </label>
                            </div>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio(
                                        'is_layout',
                                        'n',
                                        isset($input->is_layout) && ($input->is_layout == 'n') ? true : false
                                    ); ?><i class="fa fa-times text-danger"></i> Belum Layout
                                </label>
                            </div>
                            <?= form_error('is_layout'); ?>
                        </div>
                        <div class="form-group">
                            <label for="layout_start_date">Tanggal Mulai layout
                            </label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('layout_start_date', $input->layout_start_date, 'class="form-control dates" '); ?>
                                <?= form_error('layout_start_date'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="layout_end_date">Tanggal Selesai layout
                            </label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('layout_end_date', $input->layout_end_date, 'class="form-control dates" '); ?>
                                <?= form_error('layout_end_date'); ?>
                            </div>
                        </div>
                        <hr>
                        <h5 class="card-title">Proofread</h5>
                        <div class="form-group">
                            <label>Status Proofread</label>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio(
                                        'is_proofread',
                                        'y',
                                        isset($input->is_proofread) && ($input->is_proofread == 'y') ? true : false
                                    ); ?><i class="fa fa-check text-success"></i> Sudah Proofread
                                </label>
                            </div>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio(
                                        'is_proofread',
                                        'n',
                                        isset($input->is_proofread) && ($input->is_proofread == 'n') ? true : false
                                    ); ?><i class="fa fa-times text-danger"></i> Belum Proofread
                                </label>
                            </div>
                            <?= form_error('is_proofread'); ?>
                        </div>
                        <div class="form-group">
                            <label for="proofread_start_date">Tanggal Mulai proofread
                            </label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('proofread_start_date', $input->proofread_start_date, 'class="form-control dates"  '); ?>
                                <?= form_error('proofread_start_date'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="proofread_end_date">Tanggal Selesai proofread
                            </label>
                            <div class="has-clearable">
                                <button
                                    type="button"
                                    class="close"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </button>
                                <?= form_input('proofread_end_date', $input->proofread_end_date, 'class="form-control dates"  '); ?>
                                <?= form_error('proofread_end_date'); ?>
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <div class="form-actions">
                        <a
                            href="<?= base_url("draft/view/$input->draft_id") ?>"
                            class="btn btn-light ml-auto mr-2"
                        >Kembali</a>
                        <button
                            class="btn btn-primary"
                            type="submit"
                        >Submit</button>
                    </div>
                    <?php form_close(); ?>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadValidateSetting();
    $("#formdraftedit").validate({
            rules: {
                category_id: "crequired",
                theme_id: "crequired",
                draft_title: {
                    crequired: true,
                    cminlength: 5,
                },
                draft_file: {
                    extension: "<?= get_allowed_file_types('draft_file')['types']; ?>",
                },
                draft_file_link: "curl"
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: validateErrorPlacement,
        },
        validateSelect2()
    );

    $('.dates').flatpickr({
        disableMobile: true,
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d',
        minDate: "2000-01-01",
    });

    $("#category,#theme,#draft_status").select2({
        placeholder: '- Pilih -',
        dropdownParent: $('#app-main')
    });

    $(`#draft_notes`).summernote(summernoteConfig)

    $('#delete-draft').change(function() {
        if (this.checked) {
            $('#upload-file-form').hide()
        } else {
            $('#upload-file-form').show()
        }
    })
});
</script>
