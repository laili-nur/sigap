<div
    class="modal fade"
    id="modal-select-layouter"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-select-layouter"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Pilih Layouter </h5>
            </div>
            <div class="modal-body">
                <form>
                    <fieldset>
                        <div
                            class="form-group"
                            id="form-layouter"
                        >
                            <label for="layouter-id">Nama Layouter</label>
                            <select
                                id="layouter-id"
                                name="layouter"
                                class="form-control custom-select d-block"
                            ></select>
                            <small class="form-text text-muted">1 akun layouter dan 1 akun desain cover</small>
                        </div>
                    </fieldset>
                    <div class="d-flex">
                        <button
                            id="btn-select-layouter"
                            class="btn btn-primary ml-auto"
                            type="button"
                        >Pilih</button>
                    </div>
                </form>
                <hr>

                <div id="layouter-list-wrapper">
                    <div id="layouter-list">
                        <p class="font-weight-bold">Layouter Terpilih</p>
                        <?php if ($layouters) : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 nowrap">
                                    <tbody>
                                        <?php foreach ($layouters as $layouter) : ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <?= $layouter->username; ?>
                                                </td>
                                                <td
                                                    class="align-middle text-right"
                                                    width="20px"
                                                >
                                                    <button
                                                        title="Hapus"
                                                        href="javascript"
                                                        class="btn btn-sm btn-danger btn-delete-layouter"
                                                        data="<?= $layouter->responsibility_id; ?>"
                                                    >
                                                        <i class="fa fa-trash-alt"></i>
                                                        <span class="sr-only">Delete</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <p class="text-center text-muted my-3">Layouter belum dipilih</p>
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

    // get data ketika buka modal select layouter
    $('#layout-progress-wrapper').on('click', '#btn-modal-select-layouter', function() {

        // reload segmen ketika modal diclose
        $('#modal-select-layouter').off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $('#layout-progress-wrapper').load(' #layout-progress', function() {
                // reinitiate flatpickr modal after load
                init_flatpickr_modal()
            });
        })

        // open modal
        $('#modal-select-layouter').modal('toggle')

        // get data semua layouter
        $.get("<?= base_url('user/api_get_staffs/layouter'); ?>",
            function(res) {
                //  inisialisasi select2
                $('#layouter-id').select2({
                    placeholder: '-- Pilih --',
                    dropdownParent: $('#modal-select-layouter'),
                    allowClear: true,
                    data: res.data.map(r => {
                        return {
                            id: r.user_id,
                            text: r.username,
                        }
                    })
                });

                //  reset selected data
                $('[name=layouter]').val(null).trigger('change');

                //  event ketika data di select
                $('#layouter-id').off('select2:select').on('select2:select', function(e) {
                    var data = e.params.data;
                    console.log(data);
                });
            }
        )
    })

    // pilih layouter
    $('#layout-progress-wrapper').on('click', '#btn-select-layouter', function() {
        const $this = $(this);
        const user_id = $('#layouter-id').val();

        if (!user_id) {
            show_toast(false, 'Pilih layouter dahulu');
            return
        }

        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?= base_url('responsibility/add/layouter'); ?>",
            data: {
                draft_id,
                user_id
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
                $('[name=layouter]').val(null).trigger('change');
                // reload segemen daftar layouter
                $('#layouter-list-wrapper').load(' #layouter-list');

                $this.removeAttr("disabled").html("Submit");
            },
        });
    });

    // hapus layouter
    $('#layout-progress-wrapper').on('click', '.btn-delete-layouter', function() {
        $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        const id = $(this).attr('data');

        $.ajax({
            url: "<?= base_url('responsibility/delete/'); ?>" + id,
            success: function(res) {
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                // reload segmen daftar layouter
                $('#layouter-list-wrapper').load(' #layouter-list');
            },
        })
    });
})
</script>
