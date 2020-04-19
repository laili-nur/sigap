<div
    id="final-progress-wrapper"
    class="mx-3 mx-md-0"
>
    <div
        id="final-progress"
        class="card-button"
    >
        <?php $is_final_file_ready = $input->print_file || $input->print_file_link; ?>
        <?php
        $hidden_date = array(
            'type'  => 'hidden',
            'id'    => 'finish_date',
            'value' => date('Y-m-d H:i:s'),
        );
        echo form_input($hidden_date); ?>
        <?= ($input->is_print == 'n') ? '<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> Proses cetak belum disetujui</small></div>' : null ?>
        <?= $is_final_file_ready ? '' : '<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> File/Link cetak belum ada</small></div>'; ?>

        <button
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#modal-save-draft"
            <?= ($input->is_print == 'y' && $is_final_file_ready) ? null : 'disabled'; ?>
        >Simpan jadi buku</button>
        <button
            class="btn btn-danger"
            data-toggle="modal"
            data-target="#modaltolak"
            <?= ($input->is_print == 'y' && $is_final_file_ready) ? null : 'disabled'; ?>
        >Tolak</button>
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
    id="modaltolak"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modaltolak"
    aria-hidden="true"
>
    <div
        class="modal-dialog"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                        <i class="fa fa-exclamation-triangle text-red mr-1"></i> Tolak Draft
                    </h5>
            </div>
            <div class="modal-body">
                <p>Draft <span class="font-weight-bold">
                            <?= $input->draft_title; ?></span> ditolak?</p>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-danger"
                    type="button"
                    id="draft-tolak"
                    value="99"
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

    $('#btn-accept-draft').on('click', function() {
        const $this = $(this);
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");

        const draftId = $('[name=draft_id]').val();
        // let draft_title = $this.attr('draft-title');
        // let draft_file = $this.attr('draft-file');
        // let action = $('#btn-accept-draft').val();
        // let finish_date = $('#finish_date').val();

        window.location = "<?= base_url('draft/finish_draft/'); ?>" + draftId

        // $.ajax({
        //     type: "GET",
        //     url: "<?= base_url('draft/finish_draft/'); ?>" + draftId,
        //     success: function(res) {
        //         console.log(res);
        //         show_toast(true, res.data);
        //     },
        //     error: function(err) {
        //         console.log(err);
        //         show_toast(false, err.responseJSON.message);
        //     },
        //     // success: function(data) {
        //     //     let datax = JSON.parse(data);
        //     //     console.log(datax);
        //     //     $this.removeAttr("disabled").html("Submit");
        //     //     if (datax.status == true) {
        //     //         show_toast('111');
        //     //         location.href = '<?php echo base_url("draft/copyToBook/"); ?>' + draftId;
        //     //     } else {
        //     //         show_toast('000');
        //     //     }
        //     // }
        // });

        // $('#draft_aksi').modal('hide');
        // location.reload();
        return false;
    });

    $('#draft-tolak').on('click', function() {
        var $this = $(this);
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id = $('[name=draft_id]').val();
        let action = $('#draft-tolak').val();
        console.log(action);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + id,
            datatype: "JSON",
            data: {
                draft_status: action,
            },
            success: function(data) {
                let datax = JSON.parse(data);
                console.log(datax);
                $this.removeAttr("disabled").html("Tolak");
                if (datax.status == true) {
                    show_toast('111');
                } else {
                    show_toast('000');
                }
                location.href = '<?php echo base_url("draft/view/"); ?>' + id;
            }
        });

        // $('#draft_aksi').modal('hide');
        // location.reload();
        return false;
    });
})
</script>
