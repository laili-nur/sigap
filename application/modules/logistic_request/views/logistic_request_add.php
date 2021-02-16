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
                            <?php if ($level == 'superadmin') : ?>

                            <div class="form-group">
                                <label for="order-number"> Kode Permintaan <abbr title="Required">*</abbr></label>
                                <input type="text" name="order_number" value="" class="form-control" id="order-number">
                            </div>
                            <div class="form-group">
                                <label for="print-mode">Tanggal Permintaan<abbr title="Required">*</abbr></label>
                                <div class="input-group mb-3">
                                    <input type="date" name="deadline_date" value="" class="form-control dates" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="print-mode">
                                    Jatuh Tempo<abbr title="Required">*</abbr>
                                </label>
                                <div class="input-group mb-3">
                                    <input type="date" name="deadline_date" value="" class="form-control dates" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="total">List Pembelian Logistik<abbr title="Required">*</abbr></label>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <p class="m-0">Nama Logistik</p>
                                        <select class="form-control" name="logistic_name" id="logistic_name">
                                            <option value="" selected="selected">-- Pilih --</option>
                                            <option value="HVS 70">HVS 70</option>
                                            <option value="Pulpen">Pulpen </option>
                                            <option value="Pensil">Pensil</option>
                                            <option value="Penghapus">Penghapus</option>
                                            <option value="Stepler">Stepler</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <p class="m-0">Jumlah</p>
                                        <input type="number" class="form-control" style="max-width: auto;" name="qty"
                                            id="qty">
                                    </div>
                                    <div class="col-2">
                                        <br>
                                        <input class="btn btn-dark" id="add_data" value="Tambah" readonly
                                            style="width:80px">
                                        <script type="text/javascript">
                                        $(function() {
                                            $('#add_data').click(function() {
                                                var logistic_name = $('#logistic_name').val();
                                                var qty = $('#qty').val();
                                                $('#list tbody:last-child').append(
                                                    '<tr>' +
                                                    '<td>' + logistic_name + '</td>' +
                                                    '<td>' + qty + '</td>' +
                                                    '</tr>'
                                                );
                                            });
                                        });
                                        </script>
                                    </div>
                                </div>
                                <div class="row mx-auto">
                                    <table class="table table-bordered" id="list">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Nama Logistik</th>
                                                <th>Jumlah</th>
                                                <!-- <th>Aksi</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <label for="print-order-notes">
                                        Deskripsi </label>
                                    <textarea name="print_order_notes" cols="40" rows="10" class="form-control"
                                        id="print-order-notes"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="order-number">
                                        PIC <abbr title="Required">*</abbr>
                                    </label>
                                    <input type="text" name="order_number" value="" class="form-control"
                                        id="order-number" />
                                </div>


                                <!-- <div class="form-group col-md-4">
                                        <label for="type" class="font-weight-bold">Tipe Stok Ulang<abbr title="Required">*</abbr></label>
                                        <select class="form-control" id="type" name="type">
                                            <option selected>-- Tipe Stok Ulang --</option>
                                            <option value="0">Stok Ulang Percetakan</option>
                                            <option value="1">Stok Ulang Gudang</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="order_number" class="font-weight-bold">Nomor Order<abbr title="Required">*</abbr></label>
                                        <input type="text" name="order_number" id="order_number" class="form-control"/>
                                    </div> -->
                                <!-- <div class="form-group">
                                        <label for="total" class="font-weight-bold">Jumlah Permintaan Logistik<abbr title="Required">*</abbr></label>
                                        <input type="number" min=1 name="total" id="total" class="form-control"/>
                                    </div> -->
                                <!-- <div class="form-group col-md-4">
                                        <label for="notes" class="font-weight-bold">Catatan<abbr title="Required">*</abbr></label>
                                        <textarea name="notes"  id="notes" cols="20" rows="2" class="form-control summernote-basic" ></textarea>
                                    </div> -->
                                <?php endif; ?>
                                <link href="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.css"
                                    rel="stylesheet"><!-- JQuery UI CSS -->
                                <!-- <div class="form-group">
                                <div id="prefetch">
                                    <label for="name" class="font-weight-bold">Nama Logistik<abbr title="Required">*</abbr></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Cari logistik"/>
                                    <input type="hidden" name="logistic_id" id="logistic_id" class="form-control" value='0'/>
                                </div>
                            </div> -->
                                <script language="JavaScript" type="text/javascript"
                                    src="<?php echo base_url(); ?>assets/autocomplete/jquery.min.js"></script>
                                <!-- JQuery JS -->
                                <script language="JavaScript" type="text/javascript"
                                    src="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.js"></script>
                                <!-- JQuery UI JS -->
                                <script>
                                $(document).ready(function() {
                                    $("#name").autocomplete({
                                        source: function(request, response) {
                                            // Fetch data
                                            $.ajax({
                                                url: "<?php echo base_url("$pages/ac_logistic_id"); ?>",
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
                                            $('#name').val(ui.item
                                            .label); // display the selected text
                                            $('#logistic_id').val(ui.item
                                            .value); // save selected id to input
                                            return false;
                                        }
                                    });
                                });
                                </script>
                                <!-- <div class="form-group">
                                <label for="order_number" class="font-weight-bold">Nomor Order<abbr title="Required">*</abbr></label>
                                <input type="text" name="order_number" id="order_number" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="total" class="font-weight-bold">Jumlah Permintaan Logistik<abbr title="Required">*</abbr></label>
                                <input type="number" min=1 name="total" id="total" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="notes" class="font-weight-bold">Catatan<abbr title="Required">*</abbr></label>
                                <textarea name="notes"  id="notes" cols="20" rows="5" class="form-control summernote-basic" ></textarea>
                            </div> -->
                                </fieldset>
                                <hr>
                                <!-- button -->
                                <input type="submit" class="btn btn-primary" value="Submit" />
                                <a class="btn btn-secondary" href="<?php echo base_url('logistic_request') ?>"
                                    role="button">Back</a>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>