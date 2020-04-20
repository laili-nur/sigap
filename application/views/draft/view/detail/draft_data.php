<?php $level = check_level(); ?>

<div
    id="draft-data-wrapper"
    class="tab-pane fade active show"
>
    <div id="draft-data">
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0 nowrap">
                <tbody>
                    <tr>
                        <td width="200px"> Judul Draft </td>
                        <td><strong>
                                <?= $input->draft_title; ?></strong> </td>
                    </tr>
                    <tr>
                        <td width="200px"> Kategori </td>
                        <td>
                            <?= isset($input->category_id) ? konversiID('category', 'category_id', $input->category_id)->category_name : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"> Tema </td>
                        <td>
                            <?= isset($input->theme_id) ? konversiID('theme', 'theme_id', $input->theme_id)->theme_name : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"> File Draft </td>
                        <td>
                            <?= ($input->draft_file) ? '<a data-toggle="tooltip" data-placement="right" title="' . $input->draft_file . '" class="btn btn-success btn-xs m-0" href="' . base_url('draft/download_file/draftfile/' . $input->draft_file) . '" target="_blank"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                            <?= ($input->draft_file_link) ? '<a data-toggle="tooltip" data-placement="right" title="' . $input->draft_file_link . '" class="btn btn-success btn-xs m-0" href="' . $input->draft_file_link . '" target="_blank"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"> Jumlah halaman</td>
                        <td><?= $input->draft_pages; ?></td>
                    </tr>
                    <?php if ($level == 'reviewer' and $reviewer_order == 0) : ?>
                        <tr>
                            <td width="200px"> Aksi Rekomendasi </td>
                            <td>
                                <?php if ($input->review1_flag == 'n') : ?>
                                    <span class="badge badge-danger">Tolak</span>
                                <?php elseif ($input->review1_flag == 'y') : ?>
                                    <span class="badge badge-success">Setuju</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php elseif ($level == 'reviewer' and $reviewer_order == 1) : ?>
                        <tr>
                            <td width="200px"> Aksi Rekomendasi </td>
                            <td>
                                <?php if ($input->review2_flag == 'n') : ?>
                                    <span class="badge badge-danger">Tolak</span>
                                <?php elseif ($input->review2_flag == 'y') : ?>
                                    <span class="badge badge-success">Setuju</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($level != 'reviewer') : ?>
                        <tr>
                            <td width="200px">
                                <?php if (is_admin()) : ?>
                                    <a
                                        href="#"
                                        title="Ubah tanggal masuk"
                                        data-toggle="modal"
                                        data-target="#modal-entry-date"
                                    >Tanggal Masuk <i class="fas fa-edit fa-fw"></i></a>
                                <?php else : ?>
                                    <span class="text-muted">Tanggal Masuk</span>
                                <?php endif ?>
                            </td>
                            <td>
                                <?= format_datetime($input->entry_date); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="200px"> Diinput oleh </td>
                            <td>
                                <em>
                                    <?= $input->input_by; ?></em>
                            </td>
                        </tr>
                        <tr>
                            <td width="200px"> Tanggal Selesai </td>
                            <td>
                                <?= format_datetime($input->finish_date); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="200px"> Status Proses </td>
                            <td>
                                <span class="font-weight-bold <?= ($input->draft_status == 99) ? 'text-danger' : '' ?>"> <?= draft_status_to_text($input->draft_status); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="200px"> Status Naskah </td>
                            <td class="align-middle">
                                <?= $input->is_reprint == 'y' ? '<span class="badge badge-warning mb-2">Cetak Ulang</span>' : '<span class="badge badge-success mb-2">Baru</span>'; ?>
                                <?php if ($input->is_reprint == 'n') : ?>
                                    <div class="alert alert-info m-0 p-2">
                                        <?php ($input->draft_status != 14) ? $atribut = 'disabled' : $atribut = ''; ?>
                                        <p class="m-0 p-0">Draft dengan status proses final dapat di cetak ulang.</p>
                                        <?php if ($level === 'superadmin' or $level === 'admin_penerbitan') : ?>
                                            <button
                                                <?= ($atribut == 'disabled') ? 'style="cursor:not-allowed" disabled' : ''; ?>
                                                type="button"
                                                class="btn btn-info btn-xs <?= $atribut; ?>"
                                                onClick="location.href='<?= base_url("draft/cetakUlang/$input->draft_id"); ?>'"
                                            >Cetak Ulang</button>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="200px">
                                <?php if (is_admin()) : ?>
                                    <a
                                        href="#"
                                        title="Ubah catatan draft"
                                        data-toggle="modal"
                                        data-target="#modal-draft-notes"
                                    >Catatan draft <i class="fas fa-edit fa-fw"></i></a>
                                <?php else : ?>
                                    <span class="text-muted">Catatan draft</span>
                                <?php endif ?>
                            </td>
                            <td>
                                <div class="font-weight-bold">
                                    <?= $input->draft_notes; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div
    id="modal-entry-date"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-entry-date"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tanggal Masuk</h5>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div class="form-group">
                        <?= form_input('entry_date', $input->entry_date, 'class="form-control d-none" id="entry_date"'); ?>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    id="btn-change-entry-date"
                    class="btn btn-primary"
                    type="button"
                >Pilih</button>
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
            </div>
        </div>
    </div>
</div>

<div
    id="modal-draft-notes"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-draft-notes"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Catatan Draft</h5>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div class="form-group">
                        <?= form_textarea('draft_notes', $input->draft_notes, 'class="form-control summernote-basic" id="draft_notes"'); ?>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    id="btn-change-draft-notes"
                    class="btn btn-primary"
                    type="button"
                >Pilih</button>
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const draftId = $('[name=draft_id]').val();

    // ubah entry date
    $('#btn-change-entry-date').on('click', function() {
        $(this).attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        const entry_date = $('[name=entry_date]').val();
        const category_id = $('[name=category_id]').val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_update_draft/'); ?>" + draftId,
            data: {
                entry_date,
                category_id
            },
            success: (res) => {
                showToast(true, res.data);
            },
            error: (err) => {
                showToast(false, err.responseJSON.message);
            },
            complete: () => {
                $(this).removeAttr("disabled").html("Submit");
                $('#draft-data').load(' #draft-data');
                $('#modal-entry-date').modal('toggle');
            }
        });
    });

    // ubah catatan draft
    $('#btn-change-draft-notes').on('click', function() {
        $(this).attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        const draftNotes = $('[name=draft_notes]').val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_update_draft/'); ?>" + draftId,
            data: {
                draft_notes: draftNotes,
            },
            success: (res) => {
                showToast(true, res.data);
            },
            error: (err) => {
                showToast(false, err.responseJSON.message);
            },
            complete: () => {
                $(this).removeAttr("disabled").html("Submit");
                $('#draft-data').load(' #draft-data');
                $('#modal-draft-notes').modal('toggle');
            }
        });
    });
})
</script>
