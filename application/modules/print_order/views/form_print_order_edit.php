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
                    <?= form_open_multipart($form_action, 'novalidate="" id="form-print-order"'); ?>
                    <fielsdet>
                        <legend>Form Edit Order Cetak</legend>
                        <?= isset($input->print_order_id) ? form_hidden('print_order_id', $input->print_order_id) : ''; ?>
                        <div class="form-group">
                            <label for="category">
                                <?= $this->lang->line('form_print_order_category'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('category', get_print_order_category(), $input->category, 'id="category" class="form-control custom-select d-block"'); ?>
                            <?= form_error('category'); ?>
                        </div>

                        <div
                            class="form-group"
                            id="book-id-wrapper"
                        >
                            <label for="book-id">
                                <?= $this->lang->line('form_book_title'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('book_id', get_dropdown_list_book(), $input->book_id, 'id="book-id" class="form-control custom-select d-block"'); ?>
                            <?= form_error('book_id'); ?>
                        </div>

                        <div
                            id="book-info"
                            style="display:none"
                        >
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td width="175px"> Judul Buku </td>
                                            <td><a
                                                    href=""
                                                    id="info-book-title"
                                                ></a></td>
                                        </tr>
                                        <tr>
                                            <td width="175px"> Halaman Buku </td>
                                            <td id="info-book-pages"></td>
                                        </tr>
                                        <tr>
                                            <td width="175px"> ISBN </td>
                                            <td id="info-isbn"></td>
                                        </tr>
                                        <tr>
                                            <td width="175px"> File Buku </td>
                                            <td>
                                                <a
                                                    data-toggle="tooltip"
                                                    data-placement="right"
                                                    title=""
                                                    class="btn btn-success btn-xs my-0"
                                                    target="_blank"
                                                    href=""
                                                    id="info-book-file-link"
                                                ><i class="fa fa-external-link-alt"></i> File Buku</a>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td width="175px"> Nomor Hak Cipta </td>
                                            <td id="info-nomor-hak-cipta"></td>
                                        </tr>
                                        <tr>
                                            <td width="175px"> File Hak Cipta </td>
                                            <td>
                                                <a
                                                    data-toggle="tooltip"
                                                    data-placement="right"
                                                    title=""
                                                    class="btn btn-success btn-xs my-0"
                                                    target="_blank"
                                                    href=""
                                                    id="info-file-hak-cipta-link"
                                                ><i class="fa fa-external-link-alt"></i> File Hak Cipta</a>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="deadline_date">
                                Deadline Percetakan
                            </label>
                            <?= form_input('deadline_date', $input->deadline_date, 'class="form-control dates"'); ?>
                            <?= form_error('deadline_date'); ?>
                        </div>

                        <div
                            class="form-group"
                            id="name-wrapper"
                        >
                            <label for="name">
                                <?= $this->lang->line('form_print_order_name'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('name', $input->name, 'class="form-control" id="name"'); ?>
                            <?= form_error('name'); ?>
                        </div>

                        <div class="form-group">
                            <label for="print-order-notes">
                                <?= $this->lang->line('form_print_order_notes'); ?>
                                <!-- <abbr title="Required">*</abbr> -->
                            </label>
                            <?= form_textarea('print_order_notes', $input->print_order_notes, 'class="form-control" id="print-order-notes"'); ?>
                            <?= form_error('print_order_notes'); ?>
                        </div>

                        <div class="form-group">
                            <label for="order-number">
                                <?= $this->lang->line('form_print_order_number'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('order_number', $input->order_number, 'class="form-control" id="order-number"'); ?>
                            <?= form_error('order_number'); ?>
                        </div>

                        <div class="form-group">
                            <label for="order-code">
                                <?= $this->lang->line('form_print_order_code'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('order_code', $input->order_code, 'class="form-control" id="order-code"'); ?>
                            <?= form_error('order_code'); ?>
                        </div>

                        <div class="form-group">
                            <label for="type">
                                <?= $this->lang->line('form_print_order_type'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('type', ['pod' => 'POD', 'offset' => 'Offset'], $input->type, 'id="type" class="form-control custom-select d-block"'); ?>
                            <?= form_error('type'); ?>
                        </div>


                        <div class="form-group">
                            <label for="paper-divider">
                                Faktor Pembagi Kertas
                            </label>
                            <?php
                            $form_paper_divider = array(
                                'type'  => 'number',
                                'name'  => 'paper_divider',
                                'id'    => 'paper_divider',
                                'value' => $input->paper_divider,
                                'class' => 'form-control',
                                'min'   => '1'
                            );
                            ?>
                            <?= form_input($form_paper_divider); ?>
                            <?= form_error('paper_divider'); ?>
                        </div>

                        <div class="form-group">
                            <label for="total">
                                <?= $this->lang->line('form_print_order_total'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?php
                            $form_total = array(
                                'type'  => 'number',
                                'name'  => 'total',
                                'id'    => 'total',
                                'value' => $input->total,
                                'class' => 'form-control',
                                'min'   => '0'
                            );
                            ?>
                            <?= form_input($form_total); ?>
                            <?= form_error('total'); ?>
                        </div>

                        <div class="form-group">
                            <label for="paper-estimation">
                                Jumlah Kertas Yang Dibutuhkan (Halaman x Exemplar / Faktor Pembagi)
                            </label>
                            <?php
                            $form_paper_estimation = array(
                                'type'  => 'number',
                                'name'  => 'paper_estimation',
                                'id'    => 'paper_estimation',
                                'value' => $input->paper_estimation,
                                'class' => 'form-control',
                                'min'   => '1'
                            );
                            ?>
                            <?= form_input($form_paper_estimation); ?>
                            <?= form_error('paper_estimation'); ?>
                        </div>

                        <div class="form-group">
                            <label for="total-print">
                                Jumlah Cetak
                                <abbr title="Required">*</abbr>
                            </label>
                            <?php
                            $form_total_print = array(
                                'type'  => 'number',
                                'name'  => 'total_print',
                                'id'    => 'total_print',
                                'value' => $input->total_print,
                                'class' => 'form-control',
                                'min'   => '0'
                            );
                            ?>
                            <?= form_input($form_total_print); ?>
                            <?= form_error('total_print'); ?>
                        </div>

                        <div class="form-group">
                            <label for="total-postprint">
                                Jumlah Jilid
                                <abbr title="Required">*</abbr>
                            </label>
                            <?php
                            $form_total_postprint = array(
                                'type'  => 'number',
                                'name'  => 'total_postprint',
                                'id'    => 'total_postprint',
                                'value' => $input->total_postprint,
                                'class' => 'form-control',
                                'min'   => '0'
                            );
                            ?>
                            <?= form_input($form_total_postprint); ?>
                            <?= form_error('total_postprint'); ?>
                        </div>

                        <div
                            id="info-paper-required"
                            style="display:none"
                        >
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td width="175px"> Halaman Buku </td>
                                            <td id="paper-required-book-pages"></td>
                                        </tr>
                                        <tr>
                                            <td width="175px"> Jumlah Kertas Yang Dibutuhkan </td>
                                            <td id="paper-required-td"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                        </div>

                        <div class="form-group">
                            <label for="paper-content">
                                <?= $this->lang->line('form_print_order_paper_content'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('paper_content', $input->paper_content, 'class="form-control" id="paper-content"'); ?>
                            <?= form_error('paper_content'); ?>
                        </div>

                        <div class="form-group">
                            <label for="paper-cover">
                                <?= $this->lang->line('form_print_order_paper_cover'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('paper_cover', $input->paper_cover, 'class="form-control" id="paper-cover"'); ?>
                            <?= form_error('paper_cover'); ?>
                        </div>

                        <div class="form-group">
                            <label for="paper-size">
                                <?= $this->lang->line('form_print_order_paper_size'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('paper_size', $input->paper_size, 'class="form-control" id="paper-size"'); ?>
                            <?= form_error('paper_size'); ?>
                        </div>

                        <div class="form-group">
                            <label for="location-binding">
                                Lokasi Jilid
                            </label>
                            <?= form_dropdown('location_binding', ['inside' => 'Di Dalam', 'outside' => 'Di Luar', 'partial' => 'Parsial'], $input->location_binding, 'id="location-binding" class="form-control custom-select d-block"'); ?>
                            <?= form_error('location_binding'); ?>
                        </div>

                        <div
                            class="form-group"
                            style="display:none"
                            id="location-binding-outside-wrapper"
                        >
                            <label for="location-binding-outside">
                                Lokasi Jilid Di Luar
                            </label>
                            <?= form_input('location_binding_outside', $input->location_binding_outside, 'class="form-control" id="location-binding-outside"'); ?>
                            <?= form_error('location_binding_outside'); ?>
                        </div>

                        <div class="form-group">
                            <label for="location-laminate">
                                Lokasi Laminasi
                            </label>
                            <?= form_dropdown('location_laminate', ['inside' => 'Di Dalam', 'outside' => 'Di Luar', 'partial' => 'Parsial'], $input->location_laminate, 'id="location-laminate" class="form-control custom-select d-block"'); ?>
                            <?= form_error('location_laminate'); ?>
                        </div>

                        <div
                            class="form-group"
                            style="display:none"
                            id="location-laminate-outside-wrapper"
                        >
                            <label for="location-laminate-outside">
                                Lokasi Laminasi Di Luar
                            </label>
                            <?= form_input('location_laminate_outside', $input->location_laminate_outside, 'class="form-control" id="location-laminate-outside"'); ?>
                            <?= form_error('location_laminate_outside'); ?>
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
                                <small class="text-danger"><?= $this->session->flashdata('print_order_file_no_data'); ?></small>
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

                        <div class="form-group">
                            <label for="print-order-notes">
                                Catatan Tambahan
                            </label>
                            <?= form_textarea([
                                'name'  => "additional_notes",
                                'class' => 'form-control',
                                'id'    => "additional-notes",
                                'rows'  => '6',
                                'value' => $input->additional_notes
                            ]); ?>
                            <?= form_error('print_order_notes'); ?>
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
    $("#book-id").select2({
        placeholder: '-- Pilih --',
        dropdownParent: $('#app-main')
    });

    loadValidateSetting();
    $("#form-print-order").validate({
            rules: {
                book_id: "crequired",
                name: "crequired",
                category: "crequired",
                order_number: "crequired",
                order_code: "crequired",
                type: "crequired",
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

    handleCategoryChange($('#category').val())

    $('#category').change(function(e) {
        const category = e.target.value
        handleCategoryChange(category)
    })

    function handleCategoryChange(category) {
        if (category === 'nonbook') {
            $('#book-id-wrapper').hide()
            $('#name-wrapper').show()
        } else {
            $('#book-id-wrapper').show()
            $('#name-wrapper').hide()
        }
    }

    $('.dates').flatpickr({
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d'
    });

    $('#delete-file').change(function() {
        if (this.checked) {
            $('#upload-file-form').hide()
        } else {
            $('#upload-file-form').show()
        }
    })

    $('#book-id').change(function(e) {
        const bookId = e.target.value
        console.log(bookId)

        $.ajax({
            type: "GET",
            url: "<?= base_url('print_order/api_get_book/'); ?>" + bookId,
            datatype: "JSON",
            success: function(res) {
                console.log(res);
                $('#book-info').show()
                $('#info-book-title').html(res.data.book_title)
                $('#info-book-title').attr("href", "<?= base_url('book/view/'); ?>" + bookId)
                $('#info-book-pages').html(res.data.book_pages)
                $('#info-isbn').html(res.data.isbn)
                $('#info-book-file-link').attr("href", "" + res.data.book_file_link)
                $('#info-book-file-link').attr("title", "" + res.data.book_title)
                $('#total').change(function(e) {
                    calculate_total(e, res)
                })
                calculate_total(e, res)
            },
            error: function(err) {
                console.log(err);
            },
        });
    })

    function calculate_total(e, res) {
        const total = e.target.value
        console.log(total)
        $('#info-paper-required').show()
        if (res.data.book_pages) {
            $('#paper-required-td').html(res.data.book_pages * total)
        } else {
            $('#paper-required-td').html(`
            Buku belum memiliki jumlah halaman, silahkan ubah data buku : <a
                title="${res.data.book_title}"
                class="btn btn-success btn-xs my-0"
                target="_blank"
                href="<?= base_url('book/edit/') ?>${res.data.book_id}"
                id="paper-required-a"
            ><i class="fa fa-edit"></i> File Buku</a>
                                                `);
        }

        if (res.data.book_pages) {
            $('#paper-required-book-pages').html(res.data.book_pages)
        } else {
            $('#paper-required-book-pages').html('-')
        }
    }

    $('#location-binding').change(function(e) {
        if ($('#location-binding').val() != 'inside') {
            $('#location-binding-outside-wrapper').show();
        } else {
            $('#location-binding-outside').val('');
            $('#location-binding-outside-wrapper').hide();
        }
    })

    $('#location-laminate').change(function(e) {
        if ($('#location-laminate').val() != 'inside') {
            $('#location-laminate-outside-wrapper').show();
        } else {
            $('#location-laminate-outside').val('');
            $('#location-laminate-outside-wrapper').hide();
        }
    })
})
</script>
