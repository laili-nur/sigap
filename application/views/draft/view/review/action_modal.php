<?php $level = check_level() ?>
<div
    class="modal fade"
    id="modal-action-<?= $progress ?>"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-action-<?= $progress ?>"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aksi <?= $progress ?></h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div class="form-group">
                        <label
                            for="action_status"
                            class="font-weight-bold"
                        >Catatan Admin</label>
                        <div class="alert alert-info">
                            Catatan admin dapat dilihat oleh semua user yang terkait dengan draft ini.
                        </div>
                        <?php
                        if (!is_admin()) {
                            echo '<div class="font-italic">' . nl2br($input->{"{$progress}_status"}) . '</div>';
                        } else {
                            echo form_textarea([
                                'name'  => 'action_status',
                                'class' => 'form-control summernote-basic',
                                'id'    => 'crp2',
                                'rows'  => '6',
                                'value' => $input->{"{$progress}_status"},
                            ]);
                        }
                        ?>
                        <div class="alert alert-info">
                            Pilih salah satu tombol dibawah ini: <br>
                            Jika <strong class="text-success">Setuju</strong>, maka tahap <?= $progress ?> akan
                            diakhiri
                            dan tanggal selesai <?= $progress ?> akan dicatat <br>
                            Jika <strong class="text-danger">Tolak</strong> maka proses draft akan diakhiri
                            sampai tahap ini.
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
                <button
                    id="btn-<?= $progress ?>-decline"
                    class="btn btn-danger"
                    type="button"
                >Tolak</button>
                <button
                    id="btn-<?= $progress ?>-accept"
                    class="btn btn-success"
                    type="button"
                >Setuju</button>
            </div>
        </div>
    </div>
</div>

<script>
// contoh progress = 'review','edit','layout','proofread','print'
var progress = "<?= $progress ?>"

function send_action_data(accept) {
    this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
    const draft_id = $('[name=draft_id]').val();
    const action_status = $('[name=action_status]').val();

    $.ajax({
        type: "POST",
        url: "<?= base_url('draft/api_action_progress/'); ?>" + draft_id,
        data: {
            progress,
            accept: accept,
            action_status,
        },
        success: function(res) {
            console.log(res);
            show_toast(true, res.data);
        },
        error: function(err) {
            console.log(err);
            show_toast(false, err.responseJSON.message);
        },
        complete: function() {
            location.reload()
        },
    });
}

// aksi setuju
$(`#${progress}-progress-wrapper`).on('click', `#btn-${progress}-accept`, function() {
    send_action_data.call($(this), true)
});

// aksi tolak
$(`#${progress}-progress-wrapper`).on('click', `#btn-${progress}-decline`, function() {
    send_action_data.call($(this), false)
});
</script>
