<div
    class="modal fade"
    id="modal-select-editor"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-select-editor"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Pilih Editor </h5>
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
                <form>
                    <fieldset>
                        <div
                            class="form-group"
                            id="form-editor"
                        >
                            <label for="editor-id">Nama Editor</label>
                            <select
                                id="editor-id"
                                name="editor"
                                class="form-control custom-select d-block"
                            ></select>
                            <!-- <label for="pilih_editor">Editor</label>
                            <?= form_dropdown('editor', get_dropdown_listEditor('user', ['user_id', 'username']), '', 'id="pilih_editor" class="form-control custom-select d-block"'); ?> -->
                        </div>
                    </fieldset>
                    <div class="d-flex">
                        <button
                            id="btn-select-editor"
                            class="btn btn-primary ml-auto"
                            type="button"
                        >Pilih</button>
                    </div>
                </form>
                <hr>

                <div id="editor-list-wrapper">
                    <div id="editor-list">
                        <p class="font-weight-bold">Editor Terpilih</p>
                        <?php if ($editors) : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 nowrap">
                                    <tbody>
                                        <?php foreach ($editors as $editor) : ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <?= $editor->username; ?>
                                                </td>
                                                <td
                                                    class="align-middle text-right"
                                                    width="20px"
                                                >
                                                    <button
                                                        title="Hapus"
                                                        href="javascript"
                                                        class="btn btn-sm btn-danger btn-delete-editor"
                                                        data="<?= $editor->responsibility_id; ?>"
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
                            <p class="text-center text-muted my-3">Editor belum dipilih</p>
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

    // get data ketika buka modal select editor
    $('#edit-progress-wrapper').on('click', '#btn-modal-select-editor', function() {

        // reload segmen ketika modal diclose
        $('#modal-select-editor').off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $('#edit-progress-wrapper').load(' #edit-progress', function() {
                // reinitiate flatpickr modal after load
                init_flatpickr_modal()
            });
        })

        // open modal
        $('#modal-select-editor').modal('toggle')

        // get data semua editor
        $.get("<?= base_url('user/api_get_staffs/editor'); ?>",
            function(res) {
                //  inisialisasi select2
                $('#editor-id').select2({
                    placeholder: '-- Pilih --',
                    dropdownParent: $('#modal-select-editor'),
                    allowClear: true,
                    data: res.data.map(r => {
                        return {
                            id: r.user_id,
                            text: r.username,
                        }
                    })
                });

                //  reset selected data
                $('[name=editor]').val(null).trigger('change');

                //  event ketika data di select
                $('#editor-id').off('select2:select').on('select2:select', function(e) {
                    var data = e.params.data;
                    console.log(data);
                });
            }
        )
    })

    // pilih editor
    $('#edit-progress-wrapper').on('click', '#btn-select-editor', function() {
        const $this = $(this);
        const user_id = $('#editor-id').val();

        if (!user_id) {
            show_toast(false, 'Pilih editor dahulu');
            return
        }

        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?= base_url('responsibility/add/editor'); ?>",
            data: {
                draft_id,
                user_id
            },
            success: function(res) {
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                $('[name=editor]').val(null).trigger('change');
                // reload segemen daftar editor
                $('#editor-list-wrapper').load(' #editor-list');

                $this.removeAttr("disabled").html("Submit");
            },
        });
    });

    // hapus editor
    $('#edit-progress-wrapper').on('click', '.btn-delete-editor', function() {
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
                // reload segmen daftar editor
                $('#editor-list-wrapper').load(' #editor-list');
            },
        })
    });
})
</script>
