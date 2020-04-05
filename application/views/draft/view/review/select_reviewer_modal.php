<?php $level = check_level() ?>
<div
    class="modal fade"
    id="modal-select-reviewer"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-select-reviewer"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-lg modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> REVIEWER </h5>
            </div>
            <div class="modal-body">
                <form>
                    <fieldset>
                        <div
                            class="form-group"
                            id="form-reviewer"
                        >
                            <label for="user_id">Nama Reviewer</label>
                            <select
                                id="reviewer-id"
                                name="reviewer"
                                class="form-control custom-select d-block"
                            ></select>
                        </div>
                    </fieldset>
                    <div class="d-flex justify-content-end">
                        <button
                            class="btn btn-primary"
                            type="button"
                            id="btn-select-reviewer"
                        >Pilih</button>
                    </div>
                </form>
                <hr>

                <div id="reviewer-list-wrapper">
                    <div id="reviewer-list">
                        <p>Daftar Reviewer</p>
                        <?php if ($reviewers) : ?>
                            <?php $ii = 1; ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mb-0 nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">NIP</th>
                                            <th scope="col">Fakultas</th>
                                            <?php if ($level == 'superadmin' || $level == 'admin_penerbitan') : ?>
                                                <th style="width:100px; min-width:100px;"> &nbsp; </th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reviewers as $reviewer) : ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <?= $ii++; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?= $reviewer->reviewer_name; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?= $reviewer->reviewer_nip; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?= $reviewer->faculty_name; ?>
                                                </td>
                                                <?php if ($level == 'superadmin' || $level == 'admin_penerbitan') : ?>
                                                    <td class="align-middle text-right">
                                                        <button
                                                            title="Hapus"
                                                            class="btn btn-sm btn-danger btn-delete-reviewer"
                                                            data="<?= $reviewer->draft_reviewer_id; ?>"
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
                            <p class="text-center text-muted my-3">Reviewer belum dipilih</p>
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
    const draft_id = $('input[name=draft_id]').val();

    // get data ketika buka modal pilih penulis
    $('#review-progress-wrapper').on('click', '#btn-modal-select-reviewer', function() {

        // reload segmen ketika modal diclose
        $('#modal-select-reviewer').off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            // location.reload()
            $('#review-progress-wrapper').load(' #review-progress', function() {
                // reinitiate flatpickr modal after load
                init_flatpickr_modal()
            });
        })

        //  open modal
        $('#modal-select-reviewer').modal('toggle')

        // get data semua reviewer
        $.get("<?= base_url('reviewer/api_get_reviewers'); ?>",
            function(res) {
                //  inisialisasi select2
                $('#reviewer-id').select2({
                    placeholder: '-- Pilih --',
                    dropdownParent: $('#modal-select-reviewer'),
                    allowClear: true,
                    data: res.data.map(r => {
                        return {
                            id: r.reviewer_id,
                            text: `${r.reviewer_name} - ${r.faculty_name}`,
                            faculty: r.faculty_name
                        }
                    })
                });

                //  reset selected data
                $('[name=reviewer]').val(null).trigger('change');

                //  event ketika data di select
                $('#reviewer-id').off('select2:select').on('select2:select', function(e) {
                    var data = e.params.data;
                    console.log(data);
                });
            }
        )
    })

    // pilih reviewer
    $('#review-progress-wrapper').on('click', '#btn-select-reviewer', function() {
        const $this = $(this);
        const reviewer_id = $('#reviewer-id').val();

        if (!reviewer_id) {
            show_toast(false, 'Pilih reviewer dahulu');
            return
        }

        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?= base_url('draftreviewer/add'); ?>",
            datatype: "JSON",
            data: {
                draft_id,
                reviewer_id
            },
            success: function(res) {
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                $('[name=reviewer]').val(null).trigger('change');
                // reload segemen daftar reviewer
                $('#reviewer-list-wrapper').load(' #reviewer-list');

                $this.removeAttr("disabled").html("Submit");
            },
        });
    });

    // hapus reviewer
    $('#review-progress-wrapper').on('click', '.btn-delete-reviewer', function() {
        $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        let id = $(this).attr('data');

        $.ajax({
            url: "<?= base_url('draftreviewer/delete/'); ?>" + id,
            success: function(res) {
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                // reload segemen daftar reviewer
                $('#reviewer-list-wrapper').load(' #reviewer-list');
            },
        })
    });
})
</script>
