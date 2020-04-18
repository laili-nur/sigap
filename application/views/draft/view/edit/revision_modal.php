<div
    class="modal fade"
    id="modal-edit-revision"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-edit-revision"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-overflow modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Revisi Edit</h5>
            </div>
            <div class="modal-body">
                <div
                    id="accordion-editor"
                    class="card-expansion"
                >
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button
                    disabled="disabled"
                    class="btn btn-success"
                    id="btn-insert-revision"
                    title="Tanggal mulai revisi akan tersimpan. Status draft akan diperbarui."
                    data-toggle="tooltip"
                ><i class="fa fa-plus"></i> Mulai Revisi Baru</button>
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
    const draftId = $('[name=draft_id]').val();

    // load data ketika modal dibuka
    $('#modal-edit-revision').on('shown.bs.modal', function(e) {
        getRevision();
    })

    // kosongkan modal ketika modal ditutup
    $('#modal-edit-revision').on('hidden.bs.modal', function(e) {
        $('#accordion-editor').html('');
    })

    // //gantian modal revisi dan deadline revisi
    // // $('#edit-revisi-deadline').on('shown.bs.modal', function (e) {
    // //   $('#edit-revisi').modal('toggle');
    // // })
    // $('#edit-revisi-deadline').on('hidden.bs.modal', function(e) {
    //     get_revision();
    // })

    // $('#accordion-editor').on('click', '.trigger-edit-revisi-deadline', function(e) {
    //     var revision_id = $(this).attr('data');
    //     $('#revision_id').val(revision_id);
    // });

    // $('#btn-edit-revisi-deadline').on('click', function(e) {
    //     var revision_id = $('#revision_id').val();
    //     e.preventDefault();
    //     let revision_edit_deadline = $('[name=revision_edit_deadline]').val();
    //     let revision_edit_start_date = $('[name=revision_edit_start_date]').val();
    //     let revision_edit_end_date = $('[name=revision_edit_end_date]').val();
    //     $.ajax({
    //         type: "POST",
    //         url: "<?php echo base_url('draft/deadlineRevision'); ?>",
    //         datatype: "JSON",
    //         data: {
    //             revision_id: revision_id,
    //             revision_deadline: revision_edit_deadline,
    //             revision_start_date: revision_edit_start_date,
    //             revision_end_date: revision_edit_end_date,
    //         },
    //         success: function(data) {
    //             let datax = JSON.parse(data);
    //             console.log(datax);
    //             if (datax.status == true) {
    //                 show_toast('111');
    //             } else {
    //                 show_toast('000');
    //             }
    //             $('#edit-revisi-deadline').modal('toggle');
    //         }
    //     })
    // })

    function getRevision() {
        const getUrl = '<?= base_url('revision/get_revision'); ?>'
        $('#accordion-editor').html('<i class="fa fa-spinner fa-spin"></i> Loading data...');
        $.ajax({
            type: "GET",
            url: `${getUrl}/${draftId}/editor`,
            success: function(res) {

                renderData(res.data)
                // let datax = JSON.parse(data);
                // console.log(datax.flag);
                // if (datax.flag != true) {
                //     $('#mulai-revisi-editor').removeAttr('disabled');
                // }
                // var i;
                // if (datax.revisi.length > 0) {
                //     for (i = 0; i < datax.revisi.length; i++) {
                //         $('#accordion-editor').html(datax.revisi);
                //         $('.summernote-basic').summernote({
                //             placeholder: 'Write here...',
                //             height: 100,
                //             disableDragAndDrop: true,
                //             toolbar: [
                //                 ['style', ['bold', 'italic', 'underline', 'clear']],
                //                 ['font', ['strikethrough']],
                //                 ['fontsize', ['fontsize', 'height']],
                //                 ['color', ['color']],
                //                 ['para', ['ul', 'ol', 'paragraph']],
                //                 ['height', ['height']],
                //                 ['view', ['codeview']],
                //             ]
                //         });
                //     }
                // } else {
                //     $('#accordion-editor').html(datax.revisi);
                // }

            }
        });
    }

    function renderData(revisions) {
        let list = '';
        let flag = 0;

        if (revisions.length) {
            revisions.forEach((r, idx) => {
                let finishBtnAttr;
                let saveBtnAttr
                let badge;
                let formRevision;
                if (r.revision_end_date) {
                    finishBtnAttr = 'd-none';
                    saveBtnAttr = 'd-none';
                    badge = '<span class="badge badge-success">Selesai</span>';
                    formRevision = r.revision_notes;
                } else {
                    flag++;
                    finishBtnAttr = 'd-inline';
                    saveBtnAttr = 'd-inline';
                    badge = '<span class="badge badge-info">Dalam Proses</span>';
                    formRevision = `<textarea rows="6" name="revision-notes-${r.revision_id}" class="form-control summernote-basic" id="revision-notes-${r.revision_id}">${r.revision_notes}</textarea>`;
                }

                list += `
            <div class="card card-expansion-item">
                <header class="card-header border-0" id="heading-revision-${r.revision_id}">
                    <button class="btn btn-reset collapsed" data-toggle="collapse" data-target="#collapse-${r.revision_id}" aria-expanded="false" aria-controls="collapse-${r.revision_id}">
                    <span class="collapse-indicator mr-2">
                        <i class="fa fa-fw fa-caret-right"></i>
                    </span>
                    <span class="mr-2">Revisi #${idx+1}</span> ${badge}
                    </button>
                </header>

                <div id="collapse-${r.revision_id}" class="collapse" aria-labelledby="heading-revision-${r.revision_id}" data-parent="#accordion-${r.revision_role}">
                    <div class="list-group list-group-flush list-group-bordered">
                        <div class="list-group-item justify-content-between">
                          <span class="text-muted">Tanggal mulai</span>
                          <strong>${r.revision_start_date}</strong>
                        </div>
                        <div class="list-group-item justify-content-between">
                          <span class="text-muted">Tanggal selesai</span>
                          <strong>${r.revision_end_date}</strong>
                        </div>
                        <div class="list-group-item justify-content-between">
                          <span class="text-muted">Deadline</span>
                          <strong>${r.revision_deadline}</strong>
                        </div>
                        <div class="list-group-item mb-0 pb-0">
                          <span class="text-muted">Catatan ${r.revision_role}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">${formRevision}</div>
                        <div class="card-button">
                            <button title="Submit catatan" type="button" class="${saveBtnAttr} btn btn-primary btn-save-revision" data-id="${r.revision_id}"><i class="fas fa-save"></i><span class="d-none d-lg-inline"> Simpan</span></button>

                            <button title="Selesai revisi" type="button" class="btn btn-secondary btn-finish-revision ${finishBtnAttr}" data-id="${r.revision_id}"><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>

                            <button title="Hapus revisi" type="button" class="d-inline btn btn-danger btn-delete-revision" data-id="${r.revision_id}"><i class="fa fa-trash"></i><span class="d-none d-lg-inline"> Hapus</span></button>
                        </div>
                    </div>
                </div>
            </div>
            `
            })
        } else {
            list = '<em>Tidak ada revisi editor</em>'
        }


        $('#accordion-editor').html(list)
        if (flag == 0) {
            $('#btn-insert-revision').removeAttr('disabled')
        }
    }


    // selesai revisi
    $('#accordion-editor').on('click', '.btn-finish-revision', function() {
        const $this = $(this);
        const revisionId = $this.data().id

        $this.attr("disabled", "disabled");
        $.ajax({
            type: "POST",
            url: "<?= base_url('revision/finish_revision'); ?>",
            data: {
                revision_id: revisionId,
                draft_id: draftId
            },
            success: function(res) {
                show_toast(true, res.data);
                getRevision()
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
                $this.removeAttr("disabled");
            },
        })
    });

    // simpan catatan revisi
    $('#accordion-editor').on('click', '.btn-save-revision', function() {
        const $this = $(this);
        const revisionId = $this.data().id
        const revisionNotes = $(`#revision-notes-${revisionId}`).val();

        $this.attr("disabled", "disabled");
        $.ajax({
            type: "POST",
            url: "<?= base_url('revision/save_revision'); ?>",
            data: {
                revision_id: revisionId,
                revision_notes: revisionNotes
            },
            success: function(res) {
                show_toast(true, res.data);
                getRevision()
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
                $this.removeAttr("disabled");
            },
        })
    });

    // hapus revisi
    $('#accordion-editor').on('click', '.btn-delete-revision', function() {
        const $this = $(this);
        const revisionId = $this.data().id

        if (confirm(`Apakah anda yakin akan menghapus revisi ini?`)) {
            $this.attr("disabled", "disabled");
            $.ajax({
                type: "GET",
                url: "<?= base_url('revision/delete_revision/'); ?>" + revisionId,
                success: function(res) {
                    show_toast(true, res.data);
                    getRevision()
                },
                error: function(err) {
                    show_toast(false, err.responseJSON.message);
                    $this.removeAttr("disabled");
                },
            })
        }
    });

    // tambah revisi baru
    $('#btn-insert-revision').on('click', function() {
        const $this = $(this);

        $this.attr("disabled", "disabled");
        $this.tooltip('dispose');

        $.ajax({
            type: "POST",
            url: "<?= base_url('revision/insert_revision'); ?>",
            data: {
                draft_id: draftId,
                role: 'editor'
            },
            success: function(res) {
                show_toast(true, res.data);
                getRevision()
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
                $this.removeAttr("disabled");
            },
        })
    });
})
</script>
