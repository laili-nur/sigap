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
                        <legend>Form Order Cetak</legend>
                        <?= isset($input->print_order_id) ? form_hidden('print_order_id', $input->print_order_id) : ''; ?>

                        <div class="form-group">
                            <label for="print-mode">
                                Mode Cetak
                            </label>
                            <?= form_dropdown('print_mode', ['book' => 'Buku', 'nonbook' => 'Non Buku'], $input->print_mode, 'id="print-mode" class="form-control custom-select d-block"'); ?>
                            <?= form_error('print_mode'); ?>
                        </div>

                        <div
                            class="form-group"
                            id="book-id-wrapper"
                        >
                            <label for="book-id">
                                <?= $this->lang->line('form_book_title'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('book_id', get_dropdown_listBook('book', ['book_id', 'book_title']), $input->book_id, 'id="book-id" class="form-control custom-select d-block"'); ?>

                            <?= form_error('book_id'); ?>
                        </div>
                        <!-- <div
                            class="alert alert-info"
                            id="reprint-notice"
                            style="display:none"
                        >
                            Kategori cetak : <span id="category-text"></span>
                        </div> -->

                        <!-- <div class="form-group">
                            <label for="category">
                                <?= $this->lang->line('form_print_order_category'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('category', get_print_order_category(), $input->category, 'id="category" class="form-control custom-select d-block" disabled'); ?>
                            <?= form_error('category'); ?>
                        </div> -->

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
                            <?php
                            $form_total = array(
                                'type'  => 'number',
                                'name'  => 'total',
                                'id'    => 'total',
                                'value' => $input->total,
                                'class' => 'form-control'
                            );
                            ?>
                            <?= form_input($form_total); ?>
                            <?= form_error('total'); ?>
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
                            <label for="print-order-file"><?= $this->lang->line('form_print_order_file'); ?></label>
                            <div class="custom-file">
                                <?= form_upload('print_order_file', '', 'class="custom-file-input" id="print-order-file"'); ?>
                                <label
                                    class="custom-file-label"
                                    for="print-order-file"
                                >Pilih file</label>
                            </div>
                            <small class="form-text text-muted">Menerima tipe file :
                                <?= get_allowed_file_types('print_order_file')['to_text']; ?></small>
                            <small class="text-danger"><?= $this->session->flashdata('print_order_file_no_data'); ?></small>
                            <?= file_form_error('print_order_file', '<p class="small text-danger">', '</p>'); ?>
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
    // $("#form-print-order").validate({
    //         rules: {
    //             book_id: "crequired",
    //             name: "crequired",
    //             category: "crequired",
    //             order_number: "crequired",
    //             order_code: "crequired",
    //             type: "crequired",
    //             priority: "crequired",
    //             total: {
    //                 crequired: true,
    //                 cnumber: true
    //             },
    //             paper_content: "crequired",
    //             paper_cover: "crequired",
    //             paper_size: "crequired",
    //         },
    //         errorElement: "span",
    //         errorPlacement: validateErrorPlacement,
    //     },
    //     validateSelect2()
    // );

    handleCategoryChange($('#print-mode').val())

    $('#print-mode').change(function(e) {
        handleCategoryChange(e.target.value)
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

    // $('#book-id').change(function(e) {
    //     const bookId = e.target.value
    //     if (!bookId) return

    //     $.ajax({
    //         type: "GET",
    //         url: "<?= base_url('print_order/api_check_book/'); ?>" + bookId,
    //         datatype: "JSON",
    //         success: function(res) {
    //             console.log(res);
    //             $('#category').val(res.data)

    //             $('#reprint-notice').show()

    //             $('#category-text').html(res.data)

    //             // if (res.data == 'reprint') {
    //             //     $('#reprint-notice').show()
    //             // } else {
    //             //     $('#reprint-notice').hide()
    //             // }
    //         },
    //         error: function(err) {
    //             console.log(err);
    //         },
    //     });
    // })
})
</script>
