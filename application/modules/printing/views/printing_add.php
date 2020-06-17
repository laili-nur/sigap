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
                <a class="text-muted">Form</a>
            </li>
        </ol>
    </nav>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-md-8">
            <section class="card">
                <div class="card-body">
                    <form action="<?= base_url("printing/add_printing"); ?>" method="post">
                        <fielsdet>
                            <legend>Form Order Cetak</legend>
                            <link href="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.css" rel="stylesheet"><!-- JQuery UI CSS -->
                            <div class="form-group">
                                <div id="prefetch">
                                    <label for="book_title" class="font-weight-bold">Judul buku<abbr title="Required">*</abbr></label>
                                    <input type="text" name="book_title" id="book_title" class="form-control" placeholder="Cari judul buku"/>
                                    <input type="hidden" name="book_id" id="book_id" class="form-control" value='0'/>
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
                                        }
                                    });
                                });
                            </script>
                            <div class="form-group">
                                <label for="print_type" class="font-weight-bold">Tipe cetak<abbr title="Required">*</abbr></label>
                                <select class="custom-select" name="print_type" id="print_type">
                                    <option value="0">POD</option>
                                    <option value="1">Offset</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="print_total" class="font-weight-bold">Jumlah cetak<abbr title="Required">*</abbr></label>
                                <input type="text" name="print_total" id="print_total" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="print_category" class="font-weight-bold">Kategori cetak<abbr title="Required">*</abbr></label>
                                <select class="custom-select" name="print_category" id="print_category">
                                    <option value="0">Cetak baru</option>
                                    <option value="1">Cetak ulang</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="print_edition" class="font-weight-bold">Edisi cetak<abbr title="Required">*</abbr></label>
                                <input type="text" name="print_edition" id="print_edition" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="paper_content" class="font-weight-bold">Kertas isi<abbr title="Required">*</abbr></label>
                                <input type="text" name="paper_content" id="paper_content" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="paper_cover" class="font-weight-bold">Kertas cover<abbr title="Required">*</abbr></label>
                                <input type="text" name="paper_cover" id="paper_cover" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="paper_size" class="font-weight-bold">Ukuran kertas<abbr title="Required">*</abbr></label>
                                <input type="text" name="paper_size" id="paper_size" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="print_priority" class="font-weight-bold">Prioritas cetak<abbr title="Required">*</abbr></label>
                                <select class="custom-select" name="print_priority" id="print_priority">
                                    <option value="0">Rendah</option>
                                    <option value="1">Sedang</option>
                                    <option value="2">Tinggi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="order_number" class="font-weight-bold">Nomor order<abbr title="Required">*</abbr></label>
                                <input type="text" name="order_number" id="order_number" class="form-control"/>
                            </div>
                        </fieldset>
                        <hr>
                        <!-- button -->
                        <input type="submit" class="btn btn-primary" value="Submit" />
                        <a class="btn btn-secondary" href="<?php echo base_url('printing') ?>" role="button">Back</a>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<script>

</script>
