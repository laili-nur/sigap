<?php
$worksheet_status_options = [
    0 => 'Menunggu Desk Screening',
    1 => 'Diterima',
    2 => 'Ditolak',
]; ?>
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('worksheet'); ?>">Lembar kerja</a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Form</a>
            </li>
        </ol>
    </nav>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-md-6">
            <section class="card">
                <div class="card-body">
                    <?= form_open($form_action, 'novalidate="" id="form-worksheet"'); ?>
                    <fieldset>
                        <legend>Form Lembar Kerja</legend>
                        <?= isset($input->worksheet_id) ? form_hidden('worksheet_id', $input->worksheet_id) : ''; ?>
                        <div class="form-group">
                            <label for="draft_title">
                                <?= $this->lang->line('form_draft_title'); ?>
                            </label>
                            <p class="font-weight-bold">
                                <a href="<?= base_url('draft/view/' . $input->draft_id); ?>"><?= $draft->draft_title; ?></a>
                            </p>
                            <?= ($draft->draft_file) ? '<a data-toggle="tooltip" data-placement="right" title="' . $draft->draft_file . '" class="btn btn-success btn-xs m-0" href="' . base_url('draftfile/' . $draft->draft_file) . '"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                            <?= ($draft->draft_file_link) ? '<a data-toggle="tooltip" data-placement="right" title="' . $draft->draft_file_link . '" class="btn btn-success btn-xs m-0" href="' . $draft->draft_file_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                        </div>
                        <hr class="my-2">
                        <div class="form-group">
                            <label for="worksheet_num">
                                <?= $this->lang->line('form_worksheet_num'); ?>
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
                                <?= form_input('worksheet_num', $input->worksheet_num, 'class="form-control" id="worksheet_num"'); ?>
                            </div>
                            <?= form_error('worksheet_num'); ?>
                        </div>
                        <div class="form-group">
                            <label for="worksheet_notes">
                                <?= $this->lang->line('form_worksheet_notes'); ?>
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
                                <?= form_textarea('worksheet_notes', $input->worksheet_notes, 'class="form-control" id="worksheet_notes"'); ?>
                            </div>
                            <?= form_error('worksheet_notes'); ?>
                        </div>
                        <div class="form-group">
                            <label>
                                <?= $this->lang->line('form_worksheet_is_revise'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <div class="custom-control custom-radio mb-1">
                                <?= form_radio('is_revise', 'y', isset($input->is_revise) && ($input->is_revise == 'y') ? true : false, ' class="custom-control-input" id="revisi"'); ?>
                                <label
                                    class="custom-control-label"
                                    for="revisi"
                                >Revisi</label>
                            </div>
                            <div class="custom-control custom-radio mb-1">
                                <?= form_radio('is_revise', 'n', isset($input->is_revise) && ($input->is_revise == 'n') ? true : false, ' class="custom-control-input" id="tidakrevisi"'); ?>
                                <label
                                    class="custom-control-label"
                                    for="tidakrevisi"
                                >Tidak Revisi</label>
                            </div>
                            <?= form_error('is_revise'); ?>
                        </div>

                        <div class="form-group">
                            <label>
                                <?= $this->lang->line('form_worksheet_status'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?php foreach ($worksheet_status_options as $key => $val) : ?>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('worksheet_status', $key, isset($input->worksheet_status) && ($input->worksheet_status == $key) ? true : false, ' class="custom-control-input" id="' . $val . '"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="<?= $val; ?>"
                                    ><?= $val; ?></label>
                                </div>
                            <?php endforeach; ?>
                            <?= form_error('worksheet_status'); ?>
                        </div>
                        <div class="form-group">
                            <label for="worksheet_deadline">
                                <?= $this->lang->line('form_worksheet_deadline'); ?>
                            </label>
                            <?= form_input('worksheet_deadline', $input->worksheet_deadline, 'class="form-control dates" id="worksheet_deadline"'); ?>
                            <?= form_error('worksheet_deadline'); ?>
                        </div>
                        <div class="form-group">
                            <label for="worksheet_end_date">
                                <?= $this->lang->line('form_worksheet_end_date'); ?>
                            </label>
                            <?= form_input('worksheet_end_date', $input->worksheet_end_date, 'class="form-control dates" id="worksheet_end_date"'); ?>
                            <?= form_error('worksheet_end_date'); ?>
                        </div>
                    </fieldset>
                    <hr>
                    <div class="text-muted">Diperbarui
                        <?= $input->worksheet_pic ? 'oleh ' . "<strong>$input->worksheet_pic</strong>" : ''; ?>
                        <?= $input->worksheet_ts ? 'pada ' . "<strong>$input->worksheet_ts</strong>" : ''; ?>
                    </div>
                    <div class="form-actions">
                        <button
                            class="btn btn-primary ml-auto"
                            type="submit"
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
    loadValidateSetting();
    $("#form-worksheet").validate({
            rules: {
                worksheet_num: "crequired",
                is_revise: "crequired",
                worksheet_status: "crequired",
            },
            errorElement: "span",
            errorPlacement: validateErrorPlacement
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

    $(`#worksheet_notes`).summernote(summernoteConfig)
});
</script>
