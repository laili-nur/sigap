<!-- modal_request_notes_admin -->
<div
    class="modal fade"
    id="modal_request_notes_admin"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_request_notes_admin"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan aksi permintaan oleh admin</h5>
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
                <label for="" class="font-weight-bold">Aksi</label>
                <p><?php if($rData->flag == 1){echo 'Ditolak.';}elseif($rData->flag == 2){echo 'Diterima.';}?></p>
                <label for="" class="font-weight-bold">Tanggal Permintaan di Proses</label>
                <p><?= date('d F Y H:i:s', strtotime($rData->request_date)); ?></p>
                <label for="" class="font-weight-bold">User</label>
                <p><?= $rData->request_user; ?></p>
                <label for="" class="font-weight-bold">Catatan</label>
                <p class="text-justify"><?= $rData->request_notes_admin; ?></p>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light ml-auto"
                    data-dismiss="modal"
                >Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal_request_notes_admin -->