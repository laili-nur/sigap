<?php $level = check_level();?>
<div
    class="tab-pane fade"
    id="data-reviewer"
>
    <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
    <div class="alert alert-warning">
        Pastikan reviewer sudah ada pada tabel <strong>Reviewer</strong> agar dapat dipilih, Apabila belum
        maka <a
            href="<?=base_url('reviewer/add');?>"
            target="_blank"
        ><strong>Tambahkan Reviewer</strong></a>.<br>
        Reviewer yang dipilih maksimal 2 orang. <br>
        Ketika memilih reviewer, tanggal mulai progress review akan tercatat.
    </div>
    <div class="form-group">
        <button
            id="btn-modal-select-reviewer"
            type="button"
            class="btn btn-success mr-2"
        >Pilih Reviewer</button>
    </div>
    <?php endif;?>
    <div id="reviewer-list">
        <?php if ($reviewers): ?>
        <?php $ii = 1;?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0 nowrap">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NIP</th>
                        <th scope="col">Fakultas</th>
                        <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                        <th style="width:100px; min-width:100px;"> &nbsp; </th>
                        <?php endif;?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviewers as $reviewer): ?>
                    <tr>
                        <td class="align-middle">
                            <?=$ii++;?>
                        </td>
                        <td class="align-middle">
                            <?=$reviewer->reviewer_name;?>
                        </td>
                        <td class="align-middle">
                            <?=$reviewer->reviewer_nip;?>
                        </td>
                        <td class="align-middle">
                            <?=$reviewer->faculty_name;?>
                        </td>
                        <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                        <td class="align-middle text-right">
                            <button
                                title="Hapus"
                                class="btn btn-sm btn-danger btn-delete-reviewer"
                                data="<?=$reviewer->draft_reviewer_id;?>"
                            >
                                <i class="fa fa-trash-alt"></i>
                                <span class="sr-only">Delete</span>
                            </button>
                        </td>
                        <?php endif;?>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-center text-muted my-3">Reviewer belum dipilih</p>
        <?php endif;?>
    </div>
</div>

<div
    class="modal fade"
    id="modal-select-reviewer"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-select-reviewer"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
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
                                required
                            ></select>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-primary"
                    type="submit"
                    id="btn-select-reviewer"
                >Pilih</button>
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // ambil data ketika buka modal pilih penulis
    $('#btn-modal-select-reviewer').on('click', function() {
        //  open modal
        $('#modal-select-reviewer').modal('toggle')

        //   get data
        $.get("<?=base_url('reviewer/api_get_reviewers');?>",
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
                $('#reviewer-id').on('select2:select', function(e) {
                    var data = e.params.data;
                    console.log(data);
                });
            }
        )
    })

    // pilih reviewer
    $('#btn-select-reviewer').on('click', function() {
        const $this = $(this);
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        const draft_id = $('input[name=draft_id]').val();
        const reviewer_id = $('#reviewer-id').val();

        $.ajax({
            type: "POST",
            url: "<?=base_url('draftreviewer/add');?>",
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
                $('#reviewer-list').load(' #reviewer-list');
                $('#modal-select-reviewer').modal('toggle');
                $this.removeAttr("disabled").html("Submit");
            },
        });
    });

    // hapus reviewer
    $('#data-reviewer').on('click', '.btn-delete-reviewer', function() {
        $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        let id = $(this).attr('data');

        $.ajax({
            url: "<?=base_url('draftreviewer/delete/');?>" + id,
            success: function(res) {
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#reviewer-list').load(' #reviewer-list');
            },
        })
    });
})
</script>