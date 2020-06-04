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
                            <label for="order_number">Nomor Cetak</label>
                            <?= form_input('order_number', $input->order_number, 'class="form-control" id="order_number"'); ?>
                            <?= form_error('order_number'); ?>
                        </div>

                        <div class="form-group">
                            <label for="copies">Jumlah Copy</label>
                            <?= form_input('copies', $input->copies, 'class="form-control" id="copies"'); ?>
                            <?= form_error('copies'); ?>
                        </div>

                        <div class="form-group">
                            <label for="content_paper">Kertas Isi</label>
                            <?= form_input('content_paper', $input->content_paper, 'class="form-control" id="content_paper"'); ?>
                            <?= form_error('content_paper'); ?>
                        </div>

                        <div class="form-group">
                            <label for="cover_paper">Kertas Cover</label>
                            <?= form_input('cover_paper', $input->cover_paper, 'class="form-control" id="cover_paper"'); ?>
                            <?= form_error('cover_paper'); ?>
                        </div>

                        <div class="form-group">
                            <label for="size">Ukuran</label>
                            <?= form_input('size', $input->size, 'class="form-control" id="size"'); ?>
                            <?= form_error('size'); ?>
                        </div>

                        <div class="form-group">
                            <label
                                for="type"
                                class="d-block"
                            >Tipe Cetak</label>
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
                            <label for="priority">Prioritas</label>
                            <?= form_input('priority', $input->priority, 'class="form-control" id="priority"'); ?>
                            <?= form_error('priority'); ?>
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
})
</script>
