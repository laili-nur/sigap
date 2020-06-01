<div
    id="final-progress-wrapper"
    class="mx-3 mx-md-0"
>
    <div
        id="final-progress"
        class="card-button"
    >
        <?php if (!isset($book)) : ?>
            <?php $is_final_file_ready = $input->proofread_file || $input->proofread_file_link; ?>
            <?php
            $hidden_date = array(
                'type'  => 'hidden',
                'id'    => 'finish_date',
                'value' => date('Y-m-d H:i:s'),
            );
            echo form_input($hidden_date); ?>
            <?= ($input->is_proofread == 'n') ? '<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> Proses proofread belum disetujui</small></div>' : null ?>
            <?= !$is_final_file_ready ? '<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> File/Link proofread belum ada</small></div>' : null; ?>

            <button
                class="btn btn-primary <?= ($input->is_proofread == 'y' && $is_final_file_ready) ? null : 'btn-disabled'; ?>"
                data-toggle="modal"
                data-target="#modal-save-draft"
                <?= ($input->is_proofread == 'y' && $is_final_file_ready) ? null : 'disabled'; ?>
            >Finalisasi Draft</button>
            <button
                class="btn btn-danger <?= ($input->is_proofread == 'y' && $is_final_file_ready) ? null : 'btn-disabled'; ?>"
                data-toggle="modal"
                data-target="#modal-decline-draft"
                <?= ($input->is_proofread == 'y' && $is_final_file_ready) ? null : 'disabled'; ?>
            >Tolak Draft</button>
        <?php else : ?>
            <div>Buku sudah dibuat menggunakan draft ini.&nbsp;<span><a
                        href="<?= base_url("book/view/{$book->book_id}") ?>"
                        target="_blank"
                    > <i class="fa fa-external-link-alt"></i> Link buku</a></span></div>
        <?php endif ?>
    </div>
</div>

<div
    class="modal modal-warning fade"
    id="modal-save-draft"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-save-draft"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-bullhorn text-yellow mr-1"></i> Konfirmasi Finalisasi Draft</h5>
            </div>
            <div class="modal-body">
                <p>Draft <span class="font-weight-bold"><?= $input->draft_title; ?></span> sudah final dan akan disimpan jadi buku?</p>
                <div class="alert alert-info">Tanggal selesai draft akan tercatat ketika klik Submit</div>
            </div>
            <div class="modal-footer">
                <button
                    id="btn-accept-draft"
                    class="btn btn-primary"
                >Submit</button>
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
    class="modal modal-alert fade"
    id="modal-decline-draft"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-decline-draft"
    aria-hidden="true"
>
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle text-red mr-1"></i> Tolak Draft</h5>
            </div>
            <div class="modal-body">
                <p>Draft <span class="font-weight-bold"> <?= $input->draft_title; ?></span> ditolak?</p>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-danger"
                    id="btn-decline-draft"
                >Tolak</button>
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

    // draft disetujui
    $('#btn-accept-draft').on('click', function() {
        $(this).attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        window.location = "<?= base_url('draft/finish_draft/'); ?>" + draftId
    });

    // draft ditolak
    $('#btn-decline-draft').on('click', function() {
        $(this).attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");

        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_update_draft/'); ?>" + draftId,
            data: {
                draft_status: 99,
            },
            success: (res) => {
                console.log(res);
                showToast(true, res.data);
            },
            error: (err) => {
                console.log(err);
                showToast(false, err.responseJSON.message);
            },
            complete: () => {
                location.reload();
            }
        });
    });
})
</script>
