<?php
$is_preprint_started        = format_datetime($print_order->preprint_start_date);
$is_preprint_finished       = format_datetime($print_order->preprint_end_date);
$is_preprint_deadline_set   = format_datetime($print_order->preprint_deadline);
$staff_percetakan           = $this->print_order->get_staff_percetakan_by_progress('preprint', $print_order->print_order_id);
?>
<section
    id="preprint-progress-wrapper"
    class="card"
>
    <div id="preprint-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Pra Cetak</span>
                <?php if (!$is_final) :
                    //modal select
                    $this->load->view('print_order/view/common/select_modal', [
                        'progress' => 'preprint',
                        'staff_percetakan' => $staff_percetakan
                    ]);
                ?>
                    <div class="card-header-control">
                        <button
                            id="btn-start-preprint"
                            title="Mulai proses pra cetak"
                            type="button"
                            class="d-inline btn <?= !$is_preprint_started ? 'btn-warning' : 'btn-secondary'; ?> <?= ($is_preprint_started || !$staff_percetakan || !$is_preprint_deadline_set) ? 'btn-disabled' : ''; ?>"
                            <?= ($is_preprint_started || !$staff_percetakan || !$is_preprint_deadline_set) ? 'btn-disabled' : ''; ?>
                        ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
                        <button
                            id="btn-finish-preprint"
                            title="Selesai proses pra cetak"
                            type="button"
                            class="d-inline btn btn-secondary  <?= !$is_preprint_started ? 'btn-disabled' : '' ?>"
                            <?= !$is_preprint_started ? 'disabled' : '' ?>
                        ><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                    </div>
                <?php endif ?>
            </div>
        </header>

        <!-- ALERT -->
        <?php
        $this->load->view('print_order/view/common/progress_alert', [
            'progress'          => 'preprint',
            'staff_percetakan'  => $staff_percetakan
        ]);
        ?>

        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-preprint"
        >
            <div class="list-group-item justify-content-between">
                <span class="text-muted">Status</span>
                <span class="font-weight-bold">
                    <?php if ($print_order->is_preprint) : ?>
                        <span class="text-success">
                            <i class="fa fa-check"></i>
                            <span>Selesai</span>
                        </span>
                    <?php elseif (!$print_order->is_preprint && $print_order->print_order_status == 'reject') : ?>
                        <span class="text-danger">
                            <i class="fa fa-times"></i>
                            <span>Ditolak</span>
                        </span>
                    <?php elseif (!$print_order->is_preprint && $print_order->preprint_start_date) : ?>
                        <span class="text-primary">
                            <span>Sedang Diproses</span>
                        </span>
                    <?php endif ?>
                </span>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong>
                    <?= format_datetime($print_order->preprint_start_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong>
                    <?= format_datetime($print_order->preprint_end_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <?php if (($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_percetakan') && !$is_final) : ?>
                    <a
                        href="#"
                        id="btn-modal-deadline-preprint"
                        title="Ubah deadline"
                        data-toggle="modal"
                        data-target="#modal-deadline-preprint"
                    >Deadline <i class="fas fa-edit fa-fw"></i></a>
                <?php else : ?>
                    <span class="text-muted">Deadline</span>
                <?php endif ?>
                <strong><?= format_datetime($print_order->preprint_deadline); ?></strong>
            </div>

            <?php if ($staff_percetakan) : ?>
                <div class="list-group-item justify-content-between">
                    <span class="text-muted">Staff Bertugas</span>
                    <strong>
                        <?php foreach ($staff_percetakan as $staff) : ?>
                            <span class="badge badge-info p-1"><?= $staff->username; ?></span>
                        <?php endforeach; ?>
                    </strong>
                </div>
            <?php endif; ?>


            <div class="m-3">
                <div class="text-muted pb-1">Catatan Admin</div>
                <?= $print_order->preprint_notes_admin ?>
            </div>

            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <?php if (($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_percetakan') && !$is_final) : ?>
                    <button
                        title="Aksi admin"
                        class="btn btn-outline-dark <?= !$is_preprint_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-preprint"
                        <?= !$is_preprint_started ? 'disabled' : ''; ?>
                    >Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan preprint -->
                <button
                    type="button"
                    class="btn btn-outline-success"
                    data-toggle="modal"
                    data-target="#modal-preprint-notes"
                >Catatan</button>

                <?php if ($print_order->category == "outsideprint") : ?>
                    <!-- button modal preprint file info -->
                    <button
                        type="button"
                        class="btn btn-outline-dark <?= !$is_preprint_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-preprint-file-info"
                        <?= !$is_preprint_started ? 'disabled' : ''; ?>
                    >File Approval</button>
                    <!-- modal preprint file info -->
                    <div
                        class="modal fade"
                        id="modal-preprint-file-info"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="modal-preprint-file-info"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog modal-lg modal-dialog-overflow">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"> File Approval</h5>
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body py-3">
                                    <div
                                        class="tab-content"
                                        id="layout-tab-content-wrapper"
                                    >
                                        <div id="preprint-file-info">
                                            <?php if ($print_order->preprint_file_link || $print_order->preprint_file) : ?>
                                                <div class="alert alert-info m-0">
                                                    <?php if ($print_order->preprint_file) : ?>
                                                        <div>
                                                            <p class="alert-heading font-weight-bold">File Tersimpan</p>
                                                            <a
                                                                href="<?= base_url("print_order/download_file/preprintfile/" . $print_order->preprint_file) ?>"
                                                                class="d-block mb-3"
                                                            ><i class="fa fa-download"></i> <?= $print_order->preprint_file ?></a>
                                                            <!-- ?? -->
                                                            <?php if (!$is_final) : ?>
                                                                <button
                                                                    type="button"
                                                                    data-type="file"
                                                                    class="btn btn-outline-danger btn-sm preprint-delete-file"
                                                                ><i class="fa fa-trash"></i> Hapus file</button>
                                                            <?php endif ?>
                                                            <!-- ?? -->
                                                            <hr>
                                                        </div>
                                                    <?php endif ?>

                                                    <?php if ($print_order->preprint_file_link) : ?>
                                                        <div>
                                                            <p class="alert-heading font-weight-bold">File External</p>
                                                            <a
                                                                href="<?= $print_order->preprint_file_link ?>"
                                                                target="_blank"
                                                                class="d-block mb-3"
                                                            ><i class="fa fa-external-link-alt"></i> <?= $print_order->preprint_file_link ?></a>
                                                            <!-- ?? -->
                                                            <?php if (!$is_final) : ?>
                                                                <button
                                                                    type="button"
                                                                    data-type="link"
                                                                    class="btn btn-outline-danger btn-sm preprint-delete-file"
                                                                ><i class="fa fa-trash"></i> Hapus link</button>
                                                            <?php endif ?>
                                                            <!-- ?? -->
                                                            <hr>
                                                        </div>
                                                    <?php endif ?>
                                                    <div class="text-muted">Terakhir diubah: <span><?= $print_order->preprint_upload_date ?></span></div>
                                                    <div class="text-muted">Oleh: <span><?= $print_order->preprint_upload_by ?></span></div>
                                                </div>
                                            <?php else : ?>
                                                <div class="alert alert-secondary m-0">
                                                    File/Link progress belum tersimpan di server
                                                </div>
                                            <?php endif ?>


                                            <?php if (!$is_final) : ?>
                                                <hr class="my-4">
                                                <div class="alert alert-warning">Upload dan hapus file hanya dapat dilakukan oleh staff. Selain staff hanya bisa melihat file saja.</div>
                                                <form
                                                    id="preprint-upload-form"
                                                    method="post"
                                                    enctype="multipart/form-data"
                                                >
                                                    <?= isset($print_order->print_order_id) ? form_hidden('print_order_id', $print_order->print_order_id) : ''; ?>
                                                    <div class="form-group">
                                                        <label for="preprint-file">Upload File Approval</label>
                                                        <div class="custom-file">
                                                            <?= form_upload("preprint_file", '', "class='custom-file-input document' id='preprint-file'"); ?>
                                                            <label
                                                                class="custom-file-label"
                                                                for="preprint-file"
                                                            >Pilih file</label>
                                                        </div>
                                                        <small class="form-text text-muted">Tipe file upload bertype : <?= get_allowed_file_types('preprint_file')['to_text']; ?></small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="preprint-file-link">Link File Approval</label>
                                                        <div>
                                                            <?= form_input("preprint_file_link", $print_order->preprint_file_link, "class='form-control document' id='preprint-file-link'"); ?>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end mt-3">
                                                        <button
                                                            type="button"
                                                            class="btn btn-light ml-auto"
                                                            data-dismiss="modal"
                                                        >Close</button>
                                                        <button
                                                            id="btn-upload-preprint"
                                                            class="btn btn-primary"
                                                            type="submit"
                                                        > Update</button>
                                                    </div>
                                                </form>
                                            <?php else : ?>
                                                <div class="d-flex justify-content-end mt-3">
                                                    <button
                                                        type="button"
                                                        class="btn btn-light ml-auto"
                                                        data-dismiss="modal"
                                                    >Close</button>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal preprint outsideprint -->



                    <script>
                    $(document).ready(function() {
                        // identifier adalah 'review1','review2,'edit','layout','cover','proofread'
                        const identifier = 'preprint'
                        // progress adalah 'review','edit','layout','proofread'
                        let progress;
                        progress = identifier
                        const printorderId = '<?= $print_order->print_order_id ?>'

                        // upload progress
                        $(`#${progress}-progress-wrapper`).on('submit', `#${identifier}-upload-form`, function(e) {
                            e.preventDefault()

                            // validasi form
                            $(this).validate({
                                debug: true,
                                rules: {
                                    // [`${identifier}_file`]: {
                                    //     require_from_group: [1, ".document"],
                                    //     extension: "<?= get_allowed_file_types('preprint_file')['types']; ?>",
                                    // },
                                    // [`${identifier}_file_link`]: {
                                    //     curl: true,
                                    //     require_from_group: [1, ".document"]
                                    // }
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
                                        url: "<?= base_url('print_order/api_upload_preprint_file/'); ?>" + printorderId,
                                        type: "post",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        success: function(res) {
                                            console.log(res);
                                            showToast(true, res.data);
                                            // $(`#${identifier}-file-tab-content`).load(` #${identifier}-file-info`)
                                            $(`#${identifier}-file-info`).load(` #${identifier}-file-info`) //???
                                        },
                                        error: function(err) {
                                            console.log(err);
                                            showToast(false, err.responseJSON.message);
                                            $resetform = $(`#${identifier}-file`);
                                            $resetform.val('');
                                            $resetform.next('label.custom-file-label').html('');
                                            $this.removeAttr("disabled").html("Update");
                                        },
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
                                    url: "<?= base_url('print_order/api_delete_preprint_file/'); ?>" + printorderId,
                                    type: "post",
                                    data: {
                                        progress: identifier,
                                        file_type: $this.data().type // 'link' or 'file'
                                    },
                                    success: function(res) {
                                        console.log(res);
                                        showToast(true, res.data);
                                        // $(`#${identifier}-file-tab-content`).load(` #${identifier}-file-info`)
                                        $(`#${identifier}-file-info`).load(` #${identifier}-file-info`) //???
                                    },
                                    error: function(err) {
                                        console.log(err);
                                        showToast(false, err.responseJSON.message);
                                        $this.removeAttr("disabled").html("<i class='fa fa-trash'></i> Hapus file");
                                    },
                                });
                            }
                        })
                    })
                    </script>

                <?php endif; ?>
            </div>
        </div>

        <?php
        // modal deadline
        $this->load->view('print_order/view/common/deadline_modal', [
            'progress' => 'preprint',
        ]);

        // modal action
        $this->load->view('print_order/view/common/action_modal', [
            'progress' => 'preprint',
        ]);

        // modal note
        $this->load->view('print_order/view/common/notes_modal', [
            'progress' => 'preprint',
        ]);
        ?>
    </div>
</section>

<script>
$(document).ready(function() {
    const printorderId = '<?= $print_order->print_order_id ?>'

    // inisialisasi segment
    reload_preprint_segment()

    // ketika load segment, re-initialize call function-nya
    function reload_preprint_segment() {
        $('#preprint-progress-wrapper').load(' #preprint-progress', function() {
            // reinitiate modal after load
            initFlatpickrModal()
        });
    }

    // mulai pracetak
    $('#preprint-progress-wrapper').on('click', '#btn-start-preprint', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('print_order/api_start_progress/'); ?>" + printorderId,
            datatype: "JSON",
            data: {
                progress: 'preprint'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                // reload segmen preprint
                reload_preprint_segment()
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
                // reload data draft
                $('#print-data-wrapper').load(' #print-data');
            },
        })
    })

    // selesai pracetak
    $('#preprint-progress-wrapper').on('click', '#btn-finish-preprint', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('print_order/api_finish_progress/'); ?>" + printorderId,
            datatype: "JSON",
            data: {
                progress: 'preprint'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                // reload segmen preprint
                reload_preprint_segment()
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
                // reload data draft
                $('#print-data-wrapper').load(' #print-data');
            },
        })
    })
})
</script>
