<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('print_order'); ?>">Order Cetak</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">Form</a>
            </li>
        </ol>
    </nav>
</header>

<div class="page-section">
    <div class="row">
        <div class="col-md-8">
            <section class="card">
                <div class="card-body">
                    <?= form_open_multipart($form_action, 'novalidate="" id="form_print_order"'); ?>
                    <fielsdet>
                        <legend>Form Edit Order Cetak</legend>
                        <?= isset($input->print_order_id) ? form_hidden('print_order_id', $input->print_order_id) : ''; ?>
                        <div class="form-group">
                            <label for="book_id">
                                <?= $this->lang->line('form_book_title'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('book_id', get_dropdown_listBook('book', ['book_id', 'book_title']), $input->book_id, 'id="book_id" class="form-control custom-select d-block"'); ?>
                            <?= form_error('book_id'); ?>
                        </div>

                        <div class="form-group">
                            <label for="category">
                                <?= $this->lang->line('form_print_order_category'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('category', $input->category, 'class="form-control" id="category"'); ?>
                            <?= form_error('category'); ?>
                        </div>

                        <div class="form-group">
                            <label for="order_number">
                                <?= $this->lang->line('form_print_order_number'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('order_number', $input->order_number, 'class="form-control" id="order_number"'); ?>
                            <?= form_error('order_number'); ?>
                        </div>

                        <div class="form-group">
                            <label for="order_code">
                                <?= $this->lang->line('form_print_order_code'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('order_code', $input->order_code, 'class="form-control" id="order_code"'); ?>
                            <?= form_error('order_code'); ?>
                        </div>

                        <div class="form-group">
                            <label
                                for="type"
                                class="d-block"
                            >
                                <?= $this->lang->line('form_print_order_type'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <div
                                class="btn-group btn-group-toggle"
                                data-toggle="buttons"
                            >
                                <label class="btn btn-secondary <?= ($input->type == 'pod') ? 'active' : ''; ?>">
                                    <?= form_radio(
                                        'type',
                                        'pod',
                                        isset($input->type) && ($input->type == 'pod') ? true : false,
                                        'class="custom-control-input"'
                                    ); ?>
                                    POD</label>

                                <label class="btn btn-secondary <?= ($input->type == 'offset') ? 'active' : ''; ?>">
                                    <?= form_radio(
                                        'type',
                                        'offset',
                                        isset($input->type) && ($input->type == 'offset') ? true : false,
                                        'class="custom-control-input"'
                                    ); ?>
                                    Offset</label>
                            </div>
                            <?= form_error('type'); ?>
                        </div>

                        <div class="form-group">
                            <label for="priority">
                                <?= $this->lang->line('form_print_order_priority'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <select
                                class="custom-select"
                                name="priority"
                                id="priority"
                            >
                                <?php foreach (get_print_order_priority() as $key => $value) : ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach ?>
                            </select>
                            <?= form_error('priority'); ?>
                        </div>

                        <div class="form-group">
                            <label for="total">
                                <?= $this->lang->line('form_print_order_total'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('total', $input->total, 'class="form-control" id="total"'); ?>
                            <?= form_error('total'); ?>
                        </div>

                        <div class="form-group">
                            <label for="paper_content">
                                <?= $this->lang->line('form_print_order_paper_content'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('paper_content', $input->paper_content, 'class="form-control" id="paper_content"'); ?>
                            <?= form_error('paper_content'); ?>
                        </div>

                        <div class="form-group">
                            <label for="paper_cover">
                                <?= $this->lang->line('form_print_order_paper_cover'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('paper_cover', $input->paper_cover, 'class="form-control" id="paper_cover"'); ?>
                            <?= form_error('paper_cover'); ?>
                        </div>

                        <div class="form-group">
                            <label for="paper_size">
                                <?= $this->lang->line('form_print_order_paper_size'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('paper_size', $input->paper_size, 'class="form-control" id="paper_size"'); ?>
                            <?= form_error('paper_size'); ?>
                        </div>

                        <div class="form-group">
                            <label for="print_order_file"> <?= $this->lang->line('form_print_order_file'); ?></label>
                            <?php if ($input->print_order_file) : ?>
                                <div class="alert alert-info">
                                    <div class="d-flex justify-content-between align-items-center">File order cetak yang tersimpan
                                        <a
                                            href="<?= base_url("print_order/download_file/printorderfile/$input->print_order_file"); ?>"
                                            class="btn btn-success btn-sm my-2 uploaded-file"
                                        ><i class="fa fa-download"></i> Download</a>
                                    </div>
                                    <hr>
                                    <div>
                                        <?= form_checkbox('delete_file', true, false, 'id="delete-file"'); ?>
                                        <label
                                            class="form-check-label"
                                            for="delete-file"
                                        >
                                            <span class="text-danger">Hapus file</span>
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div id="upload-file-form">
                                <div class="custom-file">
                                    <?= form_upload('print_order_file', '', 'class="custom-file-input"'); ?>
                                    <label
                                        class="custom-file-label"
                                        for="print_order_file"
                                    >Pilih file</label>
                                    <div class="invalid-feedback">Field is required</div>
                                </div>
                                <small class="form-text text-muted">Hanya menerima file bertype : <?= get_allowed_file_types('print_order_file')['to_text']; ?></small>
                                <?= file_form_error('print_order_file', '<p class="text-danger">', '</p>'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="entry_date">
                                <?= $this->lang->line('form_print_order_start_date'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('entry_date', $input->entry_date, 'class="form-control dates"'); ?>
                            <?= form_error('entry_date'); ?>
                        </div>

                        <div class="form-group">
                            <label for="finish_date"><?= $this->lang->line('form_print_order_finish_date'); ?></label>
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
                                <?= form_input('finish_date', $input->finish_date, 'class="form-control dates"'); ?>
                                <?= form_error('finish_date'); ?>
                            </div>
                        </div>

                        <hr>
                        <h5 class="card-title">Pracetak</h5>
                        <div class="form-group">
                            <label>Status Pracetak</label>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio('is_preprint', 1, isset($input->is_preprint) && ($input->is_preprint == 1) ? true : false); ?> <i class="fa fa-check text-success"></i> Sudah selesai pracetak
                                </label>
                            </div>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio('is_preprint', 0, isset($input->is_preprint) && ($input->is_preprint == 0) ? true : false); ?> <i class="fa fa-times text-danger"></i> Belum selesai pracetak
                                </label>
                            </div>
                            <?= form_error('is_preprint'); ?>
                        </div>
                        <div class="form-group">
                            <label for="preprint_start_date">Tanggal Mulai Pracetak
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
                                <?= form_input('preprint_start_date', $input->preprint_start_date, 'class="form-control dates"'); ?>
                                <?= form_error('preprint_start_date'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="preprint_end_date">Tanggal Selesai Pracetak
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
                                <?= form_input('preprint_end_date', $input->preprint_end_date, 'class="form-control dates" '); ?>
                                <?= form_error('preprint_end_date'); ?>
                            </div>
                        </div>

                        <hr>
                        <h5 class="card-title">Cetak</h5>
                        <div class="form-group">
                            <label>Status Cetak</label>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio('is_print', 1, isset($input->is_print) && ($input->is_print == 1) ? true : false); ?> <i class="fa fa-check text-success"></i> Sudah selesai cetak
                                </label>
                            </div>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio('is_print', 0, isset($input->is_print) && ($input->is_print == 0) ? true : false); ?> <i class="fa fa-times text-danger"></i> Belum selesai cetak
                                </label>
                            </div>
                            <?= form_error('is_print'); ?>
                        </div>
                        <div class="form-group">
                            <label for="print_start_date">Tanggal Mulai Cetak
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
                                <?= form_input('print_start_date', $input->print_start_date, 'class="form-control dates"'); ?>
                                <?= form_error('print_start_date'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="print_end_date">Tanggal Selesai Cetak
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
                                <?= form_input('print_end_date', $input->print_end_date, 'class="form-control dates" '); ?>
                                <?= form_error('print_end_date'); ?>
                            </div>
                        </div>

                        <hr>
                        <h5 class="card-title">Jilid</h5>
                        <div class="form-group">
                            <label>Status Jilid</label>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio('is_postprint', 1, isset($input->is_postprint) && ($input->is_postprint == 1) ? true : false); ?> <i class="fa fa-check text-success"></i> Sudah selesai jilid
                                </label>
                            </div>
                            <div class="mb-1">
                                <label>
                                    <?= form_radio('is_postprint', 0, isset($input->is_postprint) && ($input->is_postprint == 0) ? true : false); ?> <i class="fa fa-times text-danger"></i> Belum selesai jilid
                                </label>
                            </div>
                            <?= form_error('is_postprint'); ?>
                        </div>
                        <div class="form-group">
                            <label for="postprint_start_date">Tanggal Mulai Jilid
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
                                <?= form_input('postprint_start_date', $input->postprint_start_date, 'class="form-control dates"'); ?>
                                <?= form_error('postprint_start_date'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postprint_end_date">Tanggal Selesai Jilid
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
                                <?= form_input('postprint_end_date', $input->postprint_end_date, 'class="form-control dates" '); ?>
                                <?= form_error('postprint_end_date'); ?>
                            </div>
                        </div>

                        </fieldset>
                        <hr>
                        <div class="form-actions">
                            <button
                                class="btn btn-primary ml-auto"
                                type="submit"
                                value="Submit"
                                id="btn-submit"
                            >Submit</button>
                        </div>
                        <?= form_close(); ?>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#book_id").select2({
        placeholder: '-- Pilih --',
        dropdownParent: $('#app-main')
    });

    loadValidateSetting();
    $("#form_print_order").validate({
            rules: {
                book_id: "crequired",
                category: "crequired",
                order_code: "crequired",
                order_number: "crequired",
                type: "crequired",
                priority: "crequired",
                total: {
                    crequired: true,
                    cnumber: true
                },
                paper_content: "crequired",
                paper_cover: "crequired",
                paper_size: "crequired",
            },
            errorElement: "span",
            errorPlacement: validateErrorPlacement,
        },
        validateSelect2()
    );

    $('.dates').flatpickr({
        disableMobile: true,
        altInput: true,
        altFormat: 'j F Y H:i:S',
        dateFormat: 'Y-m-d H:i:S',
        minDate: "2000-01-01",
        enableTime: true
    });

    $('#delete-file').change(function() {
        if (this.checked) {
            $('#upload-file-form').hide()
        } else {
            $('#upload-file-form').show()
        }
    })
})
</script>
