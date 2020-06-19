<section
    id="section_binding"
    class="card"
>
    <div id="binding_progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Jilid</span>
                <div class="card-header-control">
                    <a href="<?= base_url('printing/start_progress/'.$pData->print_id.'/binding');?>" class="d-inline btn btn-warning mx-1 
                    <?php
                    if($pData->binding_status == 1){echo 'disabled';}
                    elseif($pData->binding_status == 2){echo 'disabled';}
                    else{echo '';}
                    ?>" role="button" aria-pressed="true">
                        <i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span>
                    </a>
                    <a href="<?= base_url('printing/stop_progress/'.$pData->print_id.'/binding');?>" class="d-inline btn btn-secondary 
                    <?php
                    if($pData->binding_status == 0){echo 'disabled';}
                    elseif($pData->binding_flag == 1){echo 'disabled';}
                    elseif($pData->binding_flag == 2){echo 'disabled';}
                    else{echo '';}
                    ?>" role="button" aria-pressed="true">
                        <i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span>
                    </a>
                </div>
            </div>
        </header>
        <!-- <div class="alert alert-warning"><strong>PERHATIAN!</strong> Pilih editor terlebih dahulu sebelum mulai proses
            editorial</div> -->
        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-edit"
        >

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong><?php if(empty($pData->binding_start_date) == FALSE){echo date('d F Y H:i:s', strtotime($pData->binding_start_date));} ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong><?php if(empty($pData->binding_end_date) == FALSE){echo date('d F Y H:i:s', strtotime($pData->binding_end_date));} ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <a
                    href="#"
                    id="btn_modal_binding_deadline"
                    title="Ubah deadline"
                    data-toggle="modal"
                    data-target="#modal_binding_deadline"
                >Deadline <i class="fas fa-edit fa-fw"></i></a>
                <strong><?php if(empty($pData->binding_deadline) == FALSE){echo date('d F Y H:i:s', strtotime($pData->binding_deadline));} ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Status</span>
                <strong>
                    <?php
                    if($pData->binding_status == 0){echo 'Jilid belum di proses.';}
                    elseif($pData->binding_status == 1){echo 'Jilid sedang di proses.';}
                    elseif($pData->binding_status == 2){echo 'Jilid sudah selesai.';}
                    else{echo '';}
                    ?>
                </strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">User</span>
                <strong><?= $pData->binding_user;?></strong>
            </div>
            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <button
                    id="btn_modal_binding_action"
                    title="Aksi admin"
                    class="btn btn-secondary btn-disabled"
                    data-toggle="modal"
                    data-target="#modal_binding_action"
                ><i class="fa fa-thumbs-up"></i> Aksi</button>

                <!-- button tanggapan edit -->
                <button
                    id="btn_modal_binding_notes"
                    data-toggle="modal"
                    data-target="#modal_binding_notes"
                    class="btn btn-outline-dark"
                ><i class="far fa-sticky-note"></i> Catatan</button>
            </div>
        </div>
    </div>

    <!-- Modal Deadline -->
<div
    class="modal fade"
    id="modal_binding_deadline"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_binding_deadline"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="modal-title-edit"
                >Deadline edit</h5>
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
                <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk menetapkan tenggat waktu.</div>
                <form action="<?= base_url('printing/set_deadline/'.$pData->print_id.'/binding');?>" method="post">
                <fieldset>
                    <div class="form-group">
                        <div class="has-clearable">
                            <input type="text" name="binding_deadline" id="binding_deadline" value="<?= $pData->binding_deadline; ?>" class="form-control dates"/>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
                <button
                    class="btn btn-primary"
                    type="submit"
                >Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Modal Deadline -->

    <!-- Modal Aksi -->
<div
    class="modal fade"
    id="modal_binding_action"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_binding_action"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aksi jilid</h5>
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
            <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk melakukan aksi pada progress jilid.</div>
                <form action="<?= base_url('printing/choose_action/'.$pData->print_id.'/binding');?>" method="post">
                <fieldset>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="font-weight-bold">Aksi</label>
                        </div>
                        <div class="row">
                            <label>
                                <input type="radio" name="binding_flag" value="2" <?php if($pData->binding_flag == 2){echo 'checked';}else{echo '';} ?>/>
                                <i class="fa fa-check text-success"></i> Setuju
                            </label>
                        </div>
                        <div class="row">
                            <label>
                                <input type="radio" name="binding_flag" value="1" <?php if($pData->binding_flag == 1){echo 'checked';}else{echo '';} ?>/>
                                <i class="fa fa-times text-danger"></i> Tolak
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan</label>
                        <textarea
                            cols="40"
                            rows="6"
                            class="form-control summernote-basic"
                            id="binding_notes_admin"
                            name="binding_notes_admin"
                        ><?= $pData->binding_notes_admin;?></textarea>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light ml-auto"
                    data-dismiss="modal"
                >Close</button>
                <button
                    class="btn btn-primary"
                    type="submit"
                >Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Modal Aksi -->

    <!-- Modal Catatan -->
<div
    class="modal fade"
    id="modal_binding_notes"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_binding_notes"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-md modal-dialog-overflow"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan</h5>
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
                <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk menambahkan catatan pada progress jilid.</div>
                <form action="<?= base_url('printing/add_notes/'.$pData->print_id.'/binding');?>" method="post">
                <fieldset>
                    <div class="form-group">
                        <textarea
                            cols="40"
                            rows="6"
                            class="form-control summernote-basic"
                            id="binding_notes"
                            name="binding_notes"
                        ><?= $pData->binding_notes;?></textarea>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light ml-auto"
                    data-dismiss="modal"
                >Close</button>
                <button
                    class="btn btn-primary"
                    type="submit"
                >Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Modal Catatan -->
</section>