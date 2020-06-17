<section
    id="section_preprint"
    class="card"
>
    <div id="preprint_progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Pracetak</span>
                <div class="card-header-control">
                    <a href="<?= base_url('printing/start_progress/'.$pData->print_id.'/preprint');?>" class="d-inline btn btn-warning mx-1 
                    <?php
                    if($pData->preprint_status == 1){echo 'disabled';}
                    elseif($pData->preprint_status == 2){echo 'disabled';}
                    else{echo '';}
                    ?>" role="button" aria-pressed="true">
                        <i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span>
                    </a>
                    <a href="<?= base_url('printing/stop_progress/'.$pData->print_id.'/preprint');?>" class="d-inline btn btn-secondary 
                    <?php
                    if($pData->preprint_status == 0){echo 'disabled';}
                    elseif($pData->preprint_flag == 1){echo 'disabled';}
                    elseif($pData->preprint_flag == 2){echo 'disabled';}
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
                <strong><?php if(empty($pData->preprint_start_date) == FALSE){echo date('d-F-Y H:i:s', strtotime($pData->preprint_start_date));} ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong><?php if(empty($pData->preprint_end_date) == FALSE){echo date('d-F-Y H:i:s', strtotime($pData->preprint_end_date));} ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <a
                    href="#"
                    id="btn_modal_preprint_deadline"
                    title="Ubah deadline"
                    data-toggle="modal"
                    data-target="#modal_preprint_deadline"
                >Deadline <i class="fas fa-edit fa-fw"></i></a>
                <strong><?php if(empty($pData->preprint_deadline) == FALSE){echo date('d-F-Y H:i:s', strtotime($pData->preprint_deadline));} ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Status</span>
                <strong>
                    <?php
                    if($pData->preprint_status == 0){echo 'Pracetak belum di proses.';}
                    elseif($pData->preprint_status == 1){echo 'Pracetak sedang di proses.';}
                    elseif($pData->preprint_status == 2){echo 'Pracetak sudah selesai.';}
                    else{echo '';}
                    ?>
                </strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">User</span>
                <strong><?= $pData->preprint_user;?></strong>
            </div>
            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <button
                    id="btn_modal_preprint_action"
                    title="Aksi admin"
                    class="btn btn-secondary btn-disabled"
                    data-toggle="modal"
                    data-target="#modal_preprint_action"
                ><i class="fa fa-thumbs-up"></i> Aksi</button>

                <!-- button tanggapan edit -->
                <button
                    id="btn_modal_preprint_book"
                    type="button"
                    class="btn btn-outline-dark"
                    data-toggle="modal"
                    data-target="#modal_preprint_book"
                >Pengaturan Buku</button>
                <button
                    id="btn_modal_preprint_notes"
                    data-toggle="modal"
                    data-target="#modal_preprint_notes"
                    class="btn btn-outline-dark"
                ><i class="far fa-sticky-note"></i> Catatan</button>
            </div>
        </div>
    </div>

    <!-- Modal Deadline -->
<div
    class="modal fade"
    id="modal_preprint_deadline"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_preprint_deadline"
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
                <form action="<?= base_url('printing/set_deadline/'.$pData->print_id.'/preprint');?>" method="post">
                <fieldset>
                    <div class="form-group">
                        <div class="has-clearable">
                            <input type="text" name="preprint_deadline" id="preprint_deadline" value="<?= $pData->preprint_deadline; ?>" class="form-control dates"/>
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
    id="modal_preprint_action"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_preprint_action"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aksi pracetak</h5>
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
            <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk melakukan aksi pada progress pracetak.</div>
                <form action="<?= base_url('printing/choose_action/'.$pData->print_id.'/preprint');?>" method="post">
                <fieldset>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="font-weight-bold">Aksi</label>
                        </div>
                        <div class="row">
                            <label>
                                <input type="radio" name="preprint_flag" value="2" <?php if($pData->preprint_flag == 2){echo 'checked';}else{echo '';} ?>/>
                                <i class="fa fa-check text-success"></i> Setuju
                            </label>
                        </div>
                        <div class="row">
                            <label>
                                <input type="radio" name="preprint_flag" value="1" <?php if($pData->preprint_flag == 1){echo 'checked';}else{echo '';} ?>/>
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
                            id="preprint_notes_admin"
                            name="preprint_notes_admin"
                        ><?= $pData->preprint_notes_admin;?></textarea>
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

    <!-- Modal Pengaturan Buku -->
    <div
    class="modal fade"
    id="modal_preprint_book"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_preprint_book"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-lg modal-dialog-overflow"
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
                <div class="alert alert-warning">
                    <p><strong>PERHATIAN!</strong> Buku order cetak yang digunakan adalah <a href="<?= base_url("book/view/".$pData->book_id);?>"><?= $pData->book_title."."; ?></a></p>
                    <p>Fitur ini berfungsi untuk mengubah buku yang akan dicetak dengan cara memilih buku yang sudah ada sebelumnya maupun membuat buku baru.</p>
                </div>
                <hr>
                <legend>Pilih buku</legend>

<form action="<?= base_url("printing/set_book/".$pData->print_id."/preprint"); ?>" method="post">
    <link href="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.css" rel="stylesheet"><!-- JQuery UI CSS -->
    <div class="form-group">
        <div id="prefetch">
            <div class="row">
                <div class="col-10">
                    <input type="text" name="book_title" id="book_title" class="form-control" placeholder="Cari judul buku"/>
                    <input type="hidden" name="book_id" id="book_id" class="form-control" value='0'/>
                </div>
                <div class="col-2">
                    <button class="btn btn-primary ml-auto" type="submit" value="Submit">Submit</button>    
                </div>
            </div>
        </div>
    </div>
</form>
<script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery.min.js"></script><!-- JQuery JS -->
<script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.js"></script><!-- JQuery UI JS -->
<script>
    $(document).ready(function () {
        $("#book_title").autocomplete({
            source: function (request, response) {
                // Fetch data
                $.ajax({
                    url: "<?php echo base_url("$pages/ac_book_id"); ?>",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                $('#book_title').val(ui.item.label); // display the selected text
                $('#book_id').val(ui.item.value); // save selected id to input
                return false;
            },
        });
        $( "#book_title" ).autocomplete( "option", "appendTo", "#modal_preprint_buku" );
    });
</script>

                <hr>
                <form action="<?= base_url('printing/to_new_book/'.$pData->print_id.'/preprint');?>" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Tambahkan buku baru</legend>
                    <link href="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.css" rel="stylesheet"><!-- JQuery UI CSS -->
                    <div class="form-group">
                        <label for="category">Draft</label>
                        <div id="prefetch">
                            <input type="text" name="draft_title" id="draft_title" class="form-control" placeholder="Cari judul draft"/>
                            <input type="hidden" name="draft_id" id="draft_id" class="form-control" value='0'/>
                        </div>
                        <small class="form-text text-muted">Hanya draft berstatus FINAL yang dapat dipilih</small>
                    </div>
                    <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery.min.js"></script><!-- JQuery JS -->
                    <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.js"></script><!-- JQuery UI JS -->
                    <script>
                    $(document).ready(function() {
                        $("#draft_title").autocomplete({
                            source: function(request, response) {
                                // Fetch data
                                $.ajax({
                                    url: "<?php echo base_url("printing/ac_draft_id"); ?>",
                                    type: 'post',
                                    dataType: "json",
                                    data: {
                                        search: request.term
                                    },
                                    success: function(data) {
                                        response(data);
                                    }
                                });
                            },
                            select: function(event, ui) {
                                // Set selection
                                $('#draft_title').val(ui.item.label); // display the selected text
                                $('#draft_id').val(ui.item.value); // save selected id to input
                                return false;
                            },
                        });
                        $("#draft_title").autocomplete("option", "appendTo", "#modal_preprint_buku");
                    });
                    </script>
                    <div class="form-group">
                        <label for="book_code">Kode Buku</label>
                        <input type="text" name="book_code" class="form-control" id="book_code" />
                    </div>
                    <div class="form-group">
                        <label for="book_title">Judul Buku <abbr title="Required">*</abbr></label>
                        <input type="text" name="book_title" class="form-control" id="book_title"/>
                    </div>
                    <div class="form-group">
                        <label for="book_edition">Edisi Buku</label>
                        <input type="text" name="book_edition" class="form-control" id="book_edition"/>
                    </div>
                    <div class="form-group">
                        <label for="book_pages">Jumlah Halaman</label>
                        <input type="number" name="book_pages" class="form-control" id="book_pages"/>
                    </div>
                    <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input type="text" name="isbn" class="form-control" id="isbn" />
                    </div>
                    <div class="form-group">
                        <label for="eisbn">eISBN</label>
                        <input type="text" name="eisbn" class="form-control" id="eisbn" />
                    </div>
                    <div class="form-group">
                        <label for="published_date">Tanggal Terbit</label>
                        <input type="text" name="published_date" class="form-control mydate" id="published_date" />
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" class="form-control" id="harga" />
                    </div>
                    <div class="form-group">
                        <label for="book_file">File Buku</label>
                        <div class="custom-file">
                            <input type="file" name="book_file" class="custom-file-input" id="book_file"/>
                            <label class="custom-file-label" for="book_file" >Pilih file</label>
                        </div>
                        <small class="form-text text-muted">Hanya menerima file bertype : docx, doc, pdf, zip, rar</small>
                    </div>
                    <div class="form-group">
                        <label for="book_file_link">Link File Buku</label>
                        <input type="text" name="book_file_link" class="form-control" id="book_file_link" />
                    </div>
                    <div class="form-group">
                        <label for="book_notes">Keterangan Buku</label>
                        <textarea name="book_notes" cols="40" rows="10" class="form-control summernote-basic" ></textarea>
                    </div>
                </fieldset>
                <div class="col-12 text-right">
                    <button class="btn btn-primary" type="submit" >Submit</button>
                </div>
                </form>
            </div>
            <hr>
            <div class="modal-footer">
                <button type="button" class="btn btn-light ml-auto" data-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>
    <!-- Modal Pengaturan Buku -->

    <!-- Modal Catatan -->
<div
    class="modal fade"
    id="modal_preprint_notes"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_preprint_notes"
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
                <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk menambahkan catatan pada progress pracetak.</div>
                <form action="<?= base_url('printing/add_notes/'.$pData->print_id.'/preprint');?>" method="post">
                <fieldset>
                    <div class="form-group">
                        <textarea
                            cols="40"
                            rows="6"
                            class="form-control summernote-basic"
                            id="preprint_notes"
                            name="preprint_notes"
                        ><?= $pData->preprint_notes;?></textarea>
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