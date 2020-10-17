<?php
$level = check_level();
if ($level == 'superadmin') :
    $progress_text = '';
    if ($progress == 'preprint') {
        $progress_text = 'pracetak';
    } elseif ($progress == 'print') {
        $progress_text = 'cetak';
    } elseif ($progress == 'postprint') {
        $progress_text = 'jilid';
    }
?>
    <button
        id="btn-modal-select-staff-<?= $progress; ?>"
        type="button"
        class="d-inline btn mr-1 <?= empty($staff_percetakan) ? 'btn-warning' : 'btn-secondary'; ?>"
        title="Pilih Staff"
    ><i class="fas fa-user-plus fa-fw"></i><span class="d-none d-lg-inline"> Pilih Staff</span></button>

    <div
        class="modal fade"
        id="modal-select-staff-<?= $progress; ?>"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modal-select-staff-<?= $progress; ?>"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Pilih staff untuk progress <?= $progress_text; ?> </h5>
                </div>
                <div class="modal-body">
                    <form>
                        <fieldset>
                            <div
                                class="form-group"
                                id="form-staff-percetakan-<?= $progress; ?>"
                            >
                                <label for="staff-percetakan-id-<?= $progress; ?>">Nama Staff Cetak</label>
                                <select
                                    id="staff-percetakan-id-<?= $progress; ?>"
                                    name="staff-percetakan-id-<?= $progress; ?>"
                                    class="form-control custom-select d-block"
                                ></select>
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-end">
                            <button
                                id="btn-select-staff-percetakan-<?= $progress; ?>"
                                class="btn btn-primary"
                                type="button"
                            >Pilih</button>
                        </div>
                    </form>
                    <hr>

                    <div id="staff-percetakan-list-wrapper-<?= $progress; ?>">
                        <div id="staff-percetakan-list-<?= $progress; ?>">
                            <p>Daftar Staff Percetakan</p>
                            <?php if ($staff_percetakan) : ?>
                                <?php $i = 1; ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered mb-0 nowrap">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Email</th>
                                                <?php if ($level == 'superadmin') : ?>
                                                    <th style="width:100px; min-width:100px;"> &nbsp; </th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($staff_percetakan as $staff) : ?>
                                                <tr>
                                                    <td class="align-middle">
                                                        <?= $i++; ?>
                                                    </td>
                                                    <td class="align-middle">
                                                        <?= $staff->username; ?>
                                                    </td>
                                                    <td class="align-middle">
                                                        <?= $staff->email; ?>
                                                    </td>
                                                    <?php if ($level == 'superadmin') : ?>
                                                        <td class="align-middle text-center">
                                                            <button
                                                                title="Hapus"
                                                                class="btn btn-sm btn-danger btn-delete-staff-percetakan-<?= $progress; ?>"
                                                                data="<?= $staff->print_order_user_id; ?>"
                                                            >
                                                                <i class="fa fa-trash-alt"></i>
                                                                <span class="sr-only">Delete</span>
                                                            </button>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <p class="text-center text-muted my-3">Staff percetakan belum dipilih</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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
        const print_order_id = '<?= $print_order->print_order_id ?>'
        const progress = '<?= $progress ?>'

        // get data ketika buka modal pilih penulis
        $(`#${progress}-progress-wrapper`).on('click', `#btn-modal-select-staff-${progress}`, function() {

            // reload segmen ketika modal diclose
            $(`#modal-select-staff-${progress}`).off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
                // location.reload()
                $(`#${progress}-progress-wrapper`).load(` #${progress}-progress`, function() {
                    // reinitiate flatpickr modal after load
                    initFlatpickrModal()
                });
            })

            //  open modal
            $(`#modal-select-staff-${progress}`).modal('toggle')


            // get data semua reviewer
            $.get("<?= base_url('print_order/api_get_staff_percetakan'); ?>",
                function(res) {
                    //  inisialisasi select2
                    $(`#staff-percetakan-id-${progress}`).select2({
                        placeholder: '-- Pilih --',
                        dropdownParent: $(`#modal-select-staff-${progress}`),
                        allowClear: true,
                        data: res.data.map(r => {
                            return {
                                id: r.user_id,
                                text: `${r.username}`
                            }
                        })
                    });

                    //  reset selected data
                    $(`[name=staff-percetakan-id-${progress}]`).val(null).trigger('change');

                    //  event ketika data di select
                    $(`#staff-percetakan-id-${progress}`).off('select2:select').on('select2:select', function(e) {
                        var data = e.params.data;
                        console.log(data);
                    });
                }
            )
        })

        // pilih reviewer
        $(`#${progress}-progress-wrapper`).on('click', `#btn-select-staff-percetakan-${progress}`, function() {
            const $this = $(this);
            const user_id = $(`#staff-percetakan-id-${progress}`).val();

            if (!user_id) {
                showToast(false, 'Pilih staff percetakan dahulu');
                return
            }

            $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
            $.ajax({
                type: "POST",
                url: "<?= base_url('print_order/api_add_staff_percetakan'); ?>",
                datatype: "JSON",
                data: {
                    print_order_id,
                    user_id,
                    progress
                },
                success: function(res) {
                    showToast(true, res.data);
                },
                error: function(err) {
                    showToast(false, err.responseJSON.message);
                },
                complete: function() {
                    $(`[name=staff-percetakan-id-${progress}]`).val(null).trigger('change');
                    // reload segemen daftar reviewer
                    $(`#staff-percetakan-list-wrapper-${progress}`).load(` #staff-percetakan-list-${progress}`);

                    $this.removeAttr("disabled").html("Submit");
                },
            });
        });

        // hapus reviewer
        $(`#${progress}-progress-wrapper`).on('click', `.btn-delete-staff-percetakan-${progress}`, function() {
            $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
            let id = $(this).attr('data');

            $.ajax({
                url: "<?= base_url('print_order/api_delete_staff_percetakan/'); ?>" + id,
                success: function(res) {
                    showToast(true, res.data);
                },
                error: function(err) {
                    showToast(false, err.responseJSON.message);
                },
                complete: function() {
                    // reload segemen daftar reviewer
                    $(`#staff-percetakan-list-wrapper-${progress}`).load(` #staff-percetakan-list-${progress}`);
                },
            })
        });
    })
    </script>
<?php endif; ?>
