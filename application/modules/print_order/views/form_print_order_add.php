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
                        <legend>Form Order Cetak</legend>
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
                            <label for="print_order_file"><?= $this->lang->line('form_print_order_file'); ?></label>
                            <div class="custom-file">
                                <?= form_upload('print_order_file', '', 'class="custom-file-input"'); ?>
                                <label
                                    class="custom-file-label"
                                    for="print_order_file"
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
    $("#book_id").select2({
        placeholder: '-- Pilih --',
        dropdownParent: $('#app-main')
    });

    loadValidateSetting();
    $("#form_print_order").validate({
            rules: {
                book_id: "crequired",
                category: "crequired",
                order_number: "crequired",
                order_code: "crequired",
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
})
</script>
