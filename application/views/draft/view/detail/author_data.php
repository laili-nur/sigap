<?php $level = check_level(); ?>
<div
    class="tab-pane fade"
    id="author-data"
>
    <?php if ($level == 'superadmin' || $level == 'admin_penerbitan') : ?>
        <div class="alert alert-warning">
            Pastikan penulis sudah ada pada tabel <strong>Penulis</strong> agar dapat dipilih, Apabila belum
            maka
            <a
                href="<?= base_url('author/add'); ?>"
                target="_blank"
            ><strong>Tambahkan Penulis</strong></a><br>
            Penulis pertama dapat memberikan tanggapan, komentar, dan upload file. Sedangkan penulis kedua dst
            hanya dapat melihat progress draft.
        </div>
        <div class="form-group">
            <button
                id="btn-modal-select-author"
                type="button"
                class="btn btn-success mr-2"
            >Pilih Penulis</button>
        </div>
    <?php endif; ?>
    <div id="author-list">
        <?php if ($authors) : ?>
            <?php $i = 1; ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0 nowrap">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Unit Kerja</th>
                            <th scope="col">Institusi</th>
                            <th scope="col">Status</th>
                            <?php if ($level == 'superadmin' || $level == 'admin_penerbitan') : ?>
                                <th style="width:100px; min-width:100px;"> &nbsp; </th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authors as $author) : ?>
                            <tr>
                                <td class="align-middle">
                                    <?= $i++; ?>
                                </td>
                                <?php if ($level == 'superadmin' || $level == 'admin_penerbitan') : ?>
                                    <td class="align-middle"><a href="<?= base_url('author/view/profile/' . $author->author_id); ?>">
                                            <?= $author->author_name; ?></a></td>
                                <?php else : ?>
                                    <td class="align-middle">
                                        <?= $author->author_name; ?>
                                    </td>
                                <?php endif; ?>
                                <td class="align-middle">
                                    <?= $author->author_nip; ?>
                                </td>
                                <td class="align-middle">
                                    <?= $author->work_unit_name; ?>
                                </td>
                                <td class="align-middle">
                                    <?= $author->institute_name; ?>
                                </td>
                                <td class="align-middle">
                                    <?= $author->draft_author_status; ?>
                                </td>
                                <?php if ($level == 'superadmin' || $level == 'admin_penerbitan') : ?>
                                    <td class="align-middle text-right">
                                        <button
                                            class="btn btn-sm btn-danger btn-delete-author"
                                            data="<?= $author->draft_author_id; ?>"
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
            <div class="text-center text-muted my-3">Penulis belum dipilih</div>
        <?php endif; ?>
    </div>
</div>

<div
    class="modal fade"
    id="modal-select-author"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-select-author"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> PENULIS </h5>
            </div>
            <div class="modal-body">
                <form>
                    <fieldset>
                        <div
                            class="form-group"
                            id="form-author"
                        >
                            <label for="user_id">Nama Penulis</label>
                            <select
                                id="author-id"
                                name="author"
                                class="form-control custom-select d-block"
                                required
                            ></select>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-primary"
                    id="btn-select-author"
                    type="submit"
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
    $('#btn-modal-select-author').on('click', function() {
        //  open modal
        $('#modal-select-author').modal('toggle')

        // get data
        $.get("<?= base_url('author/api_get_authors'); ?>",
            function(res) {
                $("#author-id").select2({
                    placeholder: '-- Pilih --',
                    dropdownParent: $('#modal-select-author'),
                    allowClear: true,
                    data: res.data.map(a => {
                        return {
                            id: a.author_id,
                            text: `${a.author_name} - ${a.work_unit_name} - ${a.institute_name}`,
                            work_unit: a.work_unit_name,
                            institute: a.institute_name
                        }
                    })
                });

                //  reset selected data
                $('[name=author]').val(null).trigger('change');

                //  event ketika data di select
                $('#author-id').on('select2:select', function(e) {
                    var data = e.params.data;
                    console.log(data);
                });
            }
        )
    })

    // pilih penulis
    $('#btn-select-author').on('click', function() {
        const $this = $(this);
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        const draft_id = $('input[name=draft_id]').val();
        const author_id = $('#author-id').val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('draftauthor/add'); ?>",
            datatype: "JSON",
            data: {
                draft_id,
                author_id
            },
            success: function(res) {
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                $this.removeAttr("disabled").html("Submit");
                $('[name=author]').val(null).trigger('change');
                $('#author-list').load(' #author-list');
                $('#modal-select-author').modal('toggle');
            },
        });
    });

    // hapus penulis
    $('#author-data').on('click', '.btn-delete-author', function() {
        $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        let id = $(this).attr('data');

        $.ajax({
            url: "<?= base_url('draftauthor/delete/'); ?>" + id,
            success: function(res) {
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#author-list').load(' #author-list');
            },
        })
    });
})
</script>
