<div id="<?= $progress ?>-file-info">
    <div class="alert alert-info m-0">
        <?php if ($input->{"{$progress}_file_link"} || $input->{"{$progress}_file"}) : ?>
            <?php if ($input->{"{$progress}_file"}) : ?>
                <div>
                    <p class="alert-heading font-weight-bold">File Tersimpan</p>
                    <a
                        href="<?= base_url("draft/download_file/draftfile/{$input->{"{$progress}_file"}}") ?>"
                        class="d-block mb-3"
                    ><i class="fa fa-download"></i> <?= $input->{"{$progress}_file"} ?></a>
                    <button
                        type="button"
                        data-type="file"
                        class="btn btn-outline-danger btn-sm <?= $progress ?>-delete-file"
                    ><i class="fa fa-trash"></i> Hapus file</button>
                    <hr>
                </div>
            <?php endif ?>

            <?php if ($input->{"{$progress}_file_link"}) : ?>
                <div>
                    <p class="alert-heading font-weight-bold">File External</p>
                    <a
                        href="<?= $input->{"{$progress}_file_link"} ?>"
                        target="_blank"
                        class="d-block mb-3"
                    ><i class="fa fa-external-link-alt"></i> <?= $input->{"{$progress}_file_link"} ?></a>
                    <?php if ((is_staff())) : ?>
                        <button
                            type="button"
                            data-type="link"
                            class="btn btn-outline-danger btn-sm <?= $progress ?>-delete-file"
                        ><i class="fa fa-trash"></i> Hapus link</button>
                    <?php endif ?>
                    <hr>
                </div>
            <?php endif ?>
            <div class="text-muted">Terakhir diubah: <span><?= $input->{"{$progress}_upload_date"} ?></span></div>
            <div class="text-muted">Oleh: <span><?= $input->{"{$progress}_upload_by"} ?></span></div>
        <?php else : ?>
            File/Link progress belum tersimpan di server
        <?php endif ?>
    </div>


    <?php if (is_staff()) : ?>
        <hr class="my-4">
        <div class="alert alert-warning">Upload dan hapus file hanya dapat dilakukan oleh staff. Selain staff hanya bisa melihat file saja.</div>
        <form
            id="<?= $progress ?>-upload-form"
            method="post"
            enctype="multipart/form-data"
        >
            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
            <div class="form-group">
                <label for="<?= $progress ?>-file">Upload File Naskah</label>
                <div class="custom-file">
                    <?= form_upload("{$progress}_file", '', "class='custom-file-input document' id='{$progress}-file'"); ?>
                    <label
                        class="custom-file-label"
                        for="<?= $progress ?>-file"
                    >Pilih file</label>
                </div>
                <small class="form-text text-muted">Tipe file upload bertype : <?= get_allowed_file_types('draft_file')['to_text']; ?></small>
            </div>
            <div class="form-group">
                <label for="<?= $progress ?>-file-link">Link Naskah</label>
                <div>
                    <?= form_input("{$progress}_file_link", $input->{"{$progress}_file_link"}, "class='form-control document' id='{$progress}-file-link'"); ?>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button
                    type="button"
                    class="btn btn-light ml-auto"
                    data-dismiss="modal"
                >Close</button>
                <button
                    id="btn-upload-<?= $progress ?>"
                    class="btn btn-primary"
                    type="submit"
                > Update</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    // identifier adalah 'review1','review2,'edit','layout','cover','proofread','print'
    const identifier = '<?= $progress ?>'
    // progress adalah 'review','edit','layout','proofread','print'
    let progress;
    if (identifier == 'review1' || identifier == 'review2') {
        progress = 'review'
    } else if (identifier == 'cover' || identifier == 'layout') {
        progress = 'layout'
    } else {
        progress = identifier
    }

    const draftId = $('[name=draft_id]').val();

    // upload progress
    $(`#${progress}-progress-wrapper`).on('submit', `#${identifier}-upload-form`, function(e) {
        e.preventDefault()

        // validasi form
        $(this).validate({
            debug: true,
            rules: {
                [`${identifier}_file`]: {
                    require_from_group: [1, ".document"],
                    extension: "<?= get_allowed_file_types('draft_file')['types']; ?>",
                },
                [`${identifier}_file_link`]: {
                    curl: true,
                    require_from_group: [1, ".document"]
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: validateErrorPlacement,
            submitHandler: function(form) {
                const $this = $(`#btn-upload-${identifier}`);
                $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

                // prepare form data
                const formData = new FormData(form);
                formData.append('progress', identifier)

                // send data
                $.ajax({
                    url: "<?= base_url('draft/upload_progress/'); ?>" + draftId,
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(res) {
                        console.log(res);
                        showToast(true, res.data);
                        $(`#${identifier}-file-tab-content`).load(` #${identifier}-file-info`)
                    },
                    error: function(err) {
                        console.log(err);
                        showToast(false, err.responseJSON.message);
                        $resetform = $(`#${identifier}-file`);
                        $resetform.val('');
                        $resetform.next('label.custom-file-label').html('');
                        $this.removeAttr("disabled").html("Update");
                    },
                    complete: function() {
                        // reload tombol finalisasi jika terdapat update file print
                        if (progress == 'print') {
                            $('#final-progress-wrapper').load(' #final-progress')
                        }
                    }
                });
            }
        });

        // trigger submit handler
        $(this).submit()
    })

    // delete file
    $(`#${progress}-progress-wrapper`).on('click', `.${identifier}-delete-file`, function(e) {
        const $this = $(this)

        if (confirm(`Apakah anda yakin akan menghapus ${$this.data().type} ini?`)) {
            $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');
            // send data
            $.ajax({
                url: "<?= base_url('draft/delete_progress/'); ?>" + draftId,
                type: "post",
                data: {
                    progress: identifier,
                    file_type: $this.data().type // 'link' or 'file'
                },
                success: function(res) {
                    console.log(res);
                    showToast(true, res.data);
                    $(`#${identifier}-file-tab-content`).load(` #${identifier}-file-info`)
                },
                error: function(err) {
                    console.log(err);
                    showToast(false, err.responseJSON.message);
                    $this.removeAttr("disabled").html("<i class='fa fa-trash'></i> Hapus file");
                },
                complete: function() {
                    // reload tombol finalisasi jika terdapat update file print
                    if (progress == 'print') {
                        $('#final-progress-wrapper').load(' #final-progress')
                    }
                }
            });
        }
    })
})
</script>
