<?php
    $level  = check_level();
?>
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('logistic_request'); ?>">Permintaan Logistik</a>
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
                    <form action="<?= base_url("logistic_request/add_logistic_request"); ?>" method="post">
                        <fielsdet>
                            <legend>Form Permintaan Logistik</legend>
                            <?php if($level == 'superadmin') : ?>
                                <div class="form-group">
                                    <label for="type" class="font-weight-bold">Tipe Stok Ulang<abbr title="Required">*</abbr></label>
                                    <select class="form-control" id="type" name="type">
                                        <option selected>-- Tipe Stok Ulang --</option>
                                        <option value="0">Stok Ulang Percetakan</option>
                                        <option value="1">Stok Ulang Gudang</option>
                                    </select>
                                </div>
                                <hr>
                            <?php endif; ?>
                            <link href="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.css" rel="stylesheet"><!-- JQuery UI CSS -->
                            <div class="form-group">
                                <div id="prefetch">
                                    <label for="name" class="font-weight-bold">Nama Logistik<abbr title="Required">*</abbr></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Cari logistik"/>
                                    <input type="hidden" name="logistic_id" id="logistic_id" class="form-control" value='0'/>
                                </div>
                            </div>
                            <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery.min.js"></script><!-- JQuery JS -->
                            <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.js"></script><!-- JQuery UI JS -->
                            <script>
                                $(document).ready(function () {
                                    $("#name").autocomplete({
                                        source: function (request, response) {
                                            // Fetch data
                                            $.ajax({
                                                url: "<?php echo base_url("$pages/ac_logistic_id"); ?>",
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
                                            $('#name').val(ui.item.label); // display the selected text
                                            $('#logistic_id').val(ui.item.value); // save selected id to input
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
                                <label for="total" class="font-weight-bold">Jumlah Permintaan Logistik<abbr title="Required">*</abbr></label>
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
                        <a class="btn btn-secondary" href="<?php echo base_url('logistic_request') ?>" role="button">Back</a>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>