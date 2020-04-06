<?php
$category_type = [
   '1' => 'Hibah Buku Karya',
   '2' => 'Hibah Reguler',
   '3' => 'Cetak Ulang',
];
?>

<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item ">
                <a href="<?= base_url('category'); ?>">Kategori</a>
            <li class="breadcrumb-item active">
                <a class="text-muted">Form</a>
            </li>
            </li>
        </ol>
    </nav>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-md-6">
            <section class="card">
                <div class="card-body">
                    <?= form_open($form_action, 'novalidate="" id="form_category"'); ?>
                    <fieldset>
                        <legend>Form Kategori</legend>
                        <?= isset($input->category_id) ? form_hidden('category_id', $input->category_id) : ''; ?>

                        <div class="form-group">
                            <label for="category_name">
                                <?= $this->lang->line('form_category_name'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('category_name', $input->category_name, 'class="form-control" id="category_name" autofocus'); ?>
                            <?= form_error('category_name'); ?>
                        </div>

                        <div class="form-group">
                            <label for="category_type">
                                <?= $this->lang->line('form_category_type'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('category_type', $category_type, $input->category_type, 'id="category_type" class="form-control custom-select d-block"'); ?>
                            <?= form_error('category_type'); ?>
                        </div>

                        <div class="form-group">
                            <label for="category_year">
                                <?= $this->lang->line('form_category_year'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('category_year', $input->category_year, 'class="form-control" id="category_year"'); ?>
                            <?= form_error('category_year'); ?>
                        </div>

                        <div class="form-group">
                            <label for="date_open">
                                <?= $this->lang->line('form_category_date_open'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('date_open', $input->date_open, 'class="form-control" id="date_open" '); ?>
                            <?= form_error('date_open'); ?>
                        </div>

                        <div class="form-group">
                            <label for="date_close">
                                <?= $this->lang->line('form_category_date_close'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('date_close', $input->date_close, 'class="form-control" id="date_close" '); ?>
                            <?= form_error('date_close'); ?>
                        </div>

                        <div class="form-group">
                            <label for="category_note">
                                <?= $this->lang->line('form_category_note'); ?>
                            </label>
                            <?= form_textarea('category_note', $input->category_note, 'class="form-control"'); ?>
                            <?= form_error('category_note'); ?>
                        </div>

                        <div class="form-group">
                            <label>
                                <?= $this->lang->line('form_category_status'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <?= form_radio('category_status', 'y', isset($input->category_status) && ($input->category_status == 'y') ? true : false, ' class="custom-control-input" id="category_status1"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="category_status1"
                                    >Aktif</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('category_status', 'n', isset($input->category_status) && ($input->category_status == 'n') ? true : false, 'class="custom-control-input" id="category_status2"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="category_status2"
                                    >Tidak aktif</label>
                                </div>
                                <?= form_error('category_status'); ?>
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <div class="form-actions">
                        <button
                            class="btn btn-primary ml-auto"
                            type="submit"
                        >Submit data</button>
                    </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#date_open').flatpickr({
        disableMobile: true,
        dateFormat: 'Y-m-d',
    });

    $('#date_close').flatpickr({
        disableMobile: true,
        dateFormat: 'Y-m-d',
    });

    $.validator.addMethod("endDate", function(value, element) {
        var startDate = $('#date_open').val();
        return Date.parse(startDate) <= Date.parse(value) || value == "";
    }, "<?= $this->lang->line('form_category_error_date_invalid'); ?>");

    loadValidateSetting();

    $("#form_category").validate({
            rules: {
                category_name: {
                    crequired: true,
                    alphanum: true,
                },
                category_year: {
                    crequired: true,
                    crange: [1900, 2100],
                },
                date_open: {
                    crequired: true,
                    date: true
                },
                date_close: {
                    crequired: true,
                    date: true,
                    endDate: true
                },
                category_status: 'crequired'
            },
            errorElement: "div",
            errorPlacement: validateErrorPlacement
        },
        validateSelect2()
    );
})
</script>
