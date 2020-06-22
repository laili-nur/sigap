<section
    id="section_print"
    class="card"
>
    <div id="print_progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Cetak</span>
                <div class="card-header-control">
                    <a href="<?= base_url('printing/start_progress/'.$pData->print_id.'/print');?>" class="d-inline btn btn-warning mx-1 
                    <?php
                    if($pData->print_status == 1){echo 'disabled';}
                    elseif($pData->print_status == 2){echo 'disabled';}
                    else{echo '';}
                    ?>" role="button" aria-pressed="true">
                        <i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span>
                    </a>
                    <a href="<?= base_url('printing/stop_progress/'.$pData->print_id.'/print');?>" class="d-inline btn btn-secondary 
                    <?php
                    if($pData->print_status == 0){echo 'disabled';}
                    elseif($pData->print_flag == 1){echo 'disabled';}
                    elseif($pData->print_flag == 2){echo 'disabled';}
                    else{echo '';}
                    ?>" role="button" aria-pressed="true">
                        <i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span>
                    </a>
                </div>
            </div>
        </header>
        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-edit"
        >

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong style="max-width:50%"><?php if(empty($pData->print_start_date) == FALSE){echo date('d F Y H:i:s', strtotime($pData->print_start_date));} ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong style="max-width:50%"><?php if(empty($pData->print_end_date) == FALSE){echo date('d F Y H:i:s', strtotime($pData->print_end_date));} ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <a
                    href="#"
                    id="btn_modal_print_deadline"
                    title="Ubah deadline"
                    data-toggle="modal"
                    data-target="#modal_print_deadline"
                >Deadline <i class="fas fa-edit fa-fw"></i></a>
                <strong style="max-width:50%"><?php if(empty($pData->print_deadline) == FALSE){echo date('d F Y H:i:s', strtotime($pData->print_deadline));} ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Status</span>
                <strong style="max-width:50%">
                    <?php
                    if($pData->print_status == 0){echo 'Cetak belum di proses.';}
                    elseif($pData->print_status == 1){echo 'Cetak sedang di proses.';}
                    elseif($pData->print_status == 2){echo 'Cetak sudah selesai.';}
                    else{echo '';}
                    ?>
                </strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">User</span>
                <strong style="max-width:50%"><?= $pData->print_user;?></strong>
            </div>
            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <button
                    id="btn_modal_print_action"
                    title="Aksi admin"
                    class="btn btn-secondary btn-disabled"
                    data-toggle="modal"
                    data-target="#modal_print_action"
                ><i class="fa fa-thumbs-up"></i> Aksi</button>

                <!-- button tanggapan edit -->                
                <button
                    id="btn_modal_print_notes"
                    data-toggle="modal"
                    data-target="#modal_print_notes"
                    class="btn btn-outline-dark"
                ><i class="far fa-sticky-note"></i> Catatan</button>
                <a
                    href="#detail_print"
                    class="btn btn-outline-dark"
                ><i class="far fa-sticky-note"></i> Informasi Cetak</a>
                <a ></a>
            </div>
        </div>
    </div>

    <!-- Modal Deadline -->
<div
    class="modal fade"
    id="modal_print_deadline"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_print_deadline"
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
                <form action="<?= base_url('printing/set_deadline/'.$pData->print_id.'/print');?>" method="post">
                <fieldset>
                    <div class="form-group">
                        <div class="has-clearable">
                            <input type="text" name="print_deadline" id="print_deadline" value="<?= $pData->print_deadline; ?>" class="form-control dates"/>
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
    id="modal_print_action"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_print_action"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aksi cetak</h5>
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
            <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk melakukan aksi pada progress cetak.</div>
                <form action="<?= base_url('printing/choose_action/'.$pData->print_id.'/print');?>" method="post">
                <fieldset>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="font-weight-bold">Aksi</label>
                        </div>
                        <div class="row">
                            <label>
                                <input type="radio" name="print_flag" value="2" <?php if($pData->print_flag == 2){echo 'checked';}else{echo '';} ?>/>
                                <i class="fa fa-check text-success"></i> Setuju
                            </label>
                        </div>
                        <div class="row">
                            <label>
                                <input type="radio" name="print_flag" value="1" <?php if($pData->print_flag == 1){echo 'checked';}else{echo '';} ?>/>
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
                            id="print_notes_admin"
                            name="print_notes_admin"
                        ><?= $pData->print_notes_admin;?></textarea>
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
    id="modal_print_notes"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_print_notes"
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
                <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk menambahkan catatan pada progress cetak.</div>
                <form action="<?= base_url('printing/add_notes/'.$pData->print_id.'/print');?>" method="post">
                <fieldset>
                    <div class="form-group">
                        <textarea
                            cols="40"
                            rows="6"
                            class="form-control summernote-basic"
                            id="print_notes"
                            name="print_notes"
                        ><?= $pData->print_notes;?></textarea>
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