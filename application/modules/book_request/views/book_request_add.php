<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('book_request'); ?>">Permintaan Buku</a>
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
                    <form action="<?= base_url("book_request/add_book_request"); ?>" method="post">
                        <fielsdet>
                            <legend>Form Permintaan Buku</legend>
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
                                <label for="order_number" class="font-weight-bold">Nomor Order<abbr title="Required">*</abbr></label>
                                <input type="text" name="order_number" id="order_number" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="total" class="font-weight-bold">Jumlah Permintaan Buku<abbr title="Required">*</abbr></label>
                                <input type="text" name="total" id="total" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="notes" class="font-weight-bold">Catatan<abbr title="Required">*</abbr></label>
                                <textarea name="notes"  id="notes" cols="20" rows="5" class="form-control summernote-basic" ></textarea>
                            </div>
                        </fieldset>
                        <hr>
                        <!-- button -->
                        <input type="submit" class="btn btn-primary" value="Submit" />
                        <a class="btn btn-secondary" href="<?php echo base_url('book_request') ?>" role="button">Back</a>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>