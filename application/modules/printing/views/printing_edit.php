<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('printing'); ?>">Printing</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted"><?= $pData->book_title; ?></a>
            </li>
        </ol>
    </nav>
</header>

<div class="page-section">
    <div class="row">
        <div class="col-12">
            <section class="card">
                <div class="card-body">
                    <form action="<?= base_url("printing/edit_printing/".$pData->print_id); ?>" method="post">
                        <fieldset>
                            <legend>Edit Order Cetak</legend>
                            <div class="alert alert-danger">
                                <strong>Perhatian</strong>
                                <p class="mb-0">1. Halaman ini digunakan untuk mengedit tanggal secara manual, namun pastikan sudah
                                    melakukan proses step-by-step dari halaman <a href="<?= base_url("printing/view/".$pData->print_id);?>">view order printing</a>.</p>
                                <p class="mb-0">2. Halaman ini juga digunakan untuk mereset progress order printing, dengan cara
                                    menyesuaikan status order printing, dan hapus tanggal masing-masing.</p>
                            </div>
                            <link href="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.css" rel="stylesheet"><!-- JQuery UI CSS -->
                            <div class="form-group">
                                <div id="prefetch">
                                    <label for="book_title" class="font-weight-bold">Judul buku</label>
                                    <input type="text" name="book_title" id="book_title" class="form-control" placeholder=""/>
                                    <input type="hidden" name="book_id" id="book_id" class="form-control" value='<?= $pData->book_id; ?>'/>
                                    <small>Previous value = <?= $pData->book_title; ?><br>*kosongkan jika tidak mengubah buku.</small>
                                </div>
                            </div>
                            <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery.min.js"></script><!-- JQuery JS -->
                            <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.js"></script><!-- JQuery UI JS -->
                            <script>
                                $(document).ready(function () {
                                    $("#book_title").autocomplete({
                                        source: function (request, response) {
                                            // Fetch data
                                            $.ajax({
                                                url: "<?php echo base_url("printing/ac_book_id"); ?>",
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
                                        }
                                    });
                                });
                            </script>
                            <div class="form-group">
                                <label for="print_type" class="font-weight-bold">Tipe cetak</label>
                                <select class="custom-select" name="print_type" id="print_type">
                                    <option value="0" <?php if($pData->print_type == 0){echo 'selected';}else{echo '';} ?>>POD</option>
                                    <option value="1" <?php if($pData->print_type == 1){echo 'selected';}else{echo '';} ?>>Offset</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="print_total" class="font-weight-bold">Jumlah cetak</label>
                                <input type="text" name="print_total" id="print_total" class="form-control" value="<?= $pData->print_total; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="print_category" class="font-weight-bold">Kategori cetak</label>
                                <select class="custom-select" name="print_category" id="print_category">
                                    <option value="0" <?php if($pData->print_type == 0){echo 'selected';}else{echo '';} ?>>Cetak baru</option>
                                    <option value="1" <?php if($pData->print_type == 1){echo 'selected';}else{echo '';} ?>>Cetak ulang</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="print_edition" class="font-weight-bold">Edisi cetak</label>
                                <input type="text" name="print_edition" id="print_edition" class="form-control" value="<?= $pData->print_edition; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="paper_content" class="font-weight-bold">Kertas isi</label>
                                <input type="text" name="paper_content" id="paper_content" class="form-control" value="<?= $pData->paper_content; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="paper_cover" class="font-weight-bold">Kertas cover</label>
                                <input type="text" name="paper_cover" id="paper_cover" class="form-control" value="<?= $pData->paper_cover; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="paper_size" class="font-weight-bold">Ukuran kertas</label>
                                <input type="text" name="paper_size" id="paper_size" class="form-control" value="<?= $pData->paper_size; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="print_priority" class="font-weight-bold">Prioritas cetak</label>
                                <select class="custom-select" name="print_priority" id="print_priority">
                                    <option value="0" <?php if($pData->print_type == 0){echo 'selected';}else{echo '';} ?>>Rendah</option>
                                    <option value="1" <?php if($pData->print_type == 1){echo 'selected';}else{echo '';} ?>>Sedang</option>
                                    <option value="2" <?php if($pData->print_type == 2){echo 'selected';}else{echo '';} ?>>Tinggi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="order_number" class="font-weight-bold">Nomor order</label>
                                <input type="text" name="order_number" id="order_number" class="form-control" value="<?= $pData->order_number; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="entry_date" class="font-weight-bold">Tanggal masuk</label>
                                <input type="text" name="entry_date" id="entry_date" value="<?= $pData->entry_date; ?>"  class="form-control dates"  />
                            </div>
                            <div class="form-group">
                                <label for="finish_date" class="font-weight-bold">Tanggal selesai</label>
                                <input type="text" name="finish_date" id="finish_date" value="<?= $pData->finish_date; ?>"  class="form-control dates"  />
                            </div>
                            <hr>
                            <!-- Pracetak -->
                            <h5 class="card-title">Pracetak</h5>
                            <div class="form-group">
                                <label>Status Pracetak</label>
                                <div class="mb-1">
                                    <label>
                                        <input type="radio" name="preprint_status" value="2" <?php if($pData->preprint_status == 2){echo 'checked';}else{echo '';} ?>/>
                                        <i class="fa fa-check text-success"></i> Sudah Pracetak
                                    </label>
                                </div>
                                <div class="mb-1">
                                    <label>
                                        <input type="radio" name="preprint_status" value="0" <?php if($pData->preprint_status == 0){echo 'checked';}else{echo '';} ?>/>
                                        <i class="fa fa-times text-danger"></i> Belum Pracetak
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pracetak_start_date">Tanggal Mulai Pracetak</label>
                                <div class="has-clearable">
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                                    </button>
                                    <input type="text" name="preprint_start_date" id="preprint_start_date" value="<?= $pData->preprint_start_date; ?>" class="form-control dates"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="preprint_end_date">Tanggal Selesai Pracetak</label>
                                <div class="has-clearable">
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                                    </button>
                                    <input type="text" name="preprint_end_date" id="preprint_end_date" value="<?= $pData->preprint_end_date; ?>" class="form-control dates"/>
                                </div>
                            </div>
                            <hr>
                            <!-- Cetak -->
                            <h5 class="card-title">Cetak</h5>
                            <div class="form-group">
                                <label>Status Cetak</label>
                                <div class="mb-1">
                                    <label>
                                        <input type="radio" name="print_status" value="2" <?php if($pData->print_status == 2){echo 'checked';}else{echo '';} ?>/>
                                        <i class="fa fa-check text-success"></i> Sudah Cetak
                                    </label>
                                </div>
                                <div class="mb-1">
                                    <label>
                                        <input type="radio" name="print_status" value="0" <?php if($pData->print_status == 0){echo 'checked';}else{echo '';} ?>/>
                                        <i class="fa fa-times text-danger"></i> Belum Cetak
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cetak_start_date">Tanggal Mulai Cetak</label>
                                <div class="has-clearable">
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                                    </button>
                                    <input type="text" name="print_start_date" id="print_start_date" value="<?= $pData->print_start_date; ?>" class="form-control dates"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="print_end_date">Tanggal Selesai Cetak</label>
                                <div class="has-clearable">
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                                    </button>
                                    <input type="text" name="print_end_date" id="print_end_date" value="<?= $pData->print_end_date; ?>" class="form-control dates"/>
                                </div>
                            </div>
                            <hr>
                            <!-- Jilid -->
                            <h5 class="card-title">Jilid</h5>
                            <div class="form-group">
                                <label>Status Jilid</label>
                                <div class="mb-1">
                                    <label>
                                        <input type="radio" name="binding_status" value="2" <?php if($pData->binding_status == 2){echo 'checked';}else{echo '';} ?>/>
                                        <i class="fa fa-check text-success"></i> Sudah Jilid
                                    </label>
                                </div>
                                <div class="mb-1">
                                    <label>
                                        <input type="radio" name="binding_status" value="0" <?php if($pData->binding_status == 0){echo 'checked';}else{echo '';} ?>/>
                                        <i class="fa fa-times text-danger"></i> Belum Jilid
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="binding_start_date">Tanggal Mulai Jilid</label>
                                <div class="has-clearable">
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                                    </button>
                                    <input type="text" name="binding_start_date" id="binding_start_date" value="<?= $pData->binding_start_date; ?>" class="form-control dates"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="binding_end_date">Tanggal Selesai Jilid</label>
                                <div class="has-clearable">
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                                    </button>
                                    <input type="text" name="binding_end_date" id="binding_end_date" value="<?= $pData->binding_end_date; ?>" class="form-control dates"/>
                                </div>
                            </div>
                            <hr>
                        </fieldset>
                        <hr>
                        <!-- button -->
                        <input type="submit" class="btn btn-primary" value="Submit" />
                        <a class="btn btn-secondary" href="<?= base_url('printing'); ?>" role="button">Back</a>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.dates').flatpickr({
        disableMobile: true,
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d',
        minDate: "2000-01-01",
    });
});
</script>
