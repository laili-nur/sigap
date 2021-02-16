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
                            <link href="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.css"
                                rel="stylesheet"><!-- JQuery UI CSS -->
                            <!-- <div class="form-group">
                                <div id="prefetch">
                                    <label for="book_title">Judul buku<abbr title="Required">*</abbr></label>
                                    <input type="text" name="book_title" id="book_title" class="form-control"
                                        placeholder="Cari judul buku" />
                                    <input type="hidden" name="book_id" id="book_id" class="form-control" value='0' />
                                </div>
                            </div>
                            <script language="JavaScript" type="text/javascript"
                                src="<?php echo base_url(); ?>assets/autocomplete/jquery.min.js"></script>
                            <script language="JavaScript" type="text/javascript"
                                src="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.js"></script>
                            <script>
                            $(document).ready(function() {
                                $("#book_title").autocomplete({
                                    source: function(request, response) {
                                        // Fetch data
                                        $.ajax({
                                            url: "<?php echo base_url("$pages/ac_book_id"); ?>",
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
                                        $('#book_title').val(ui.item
                                            .label); // display the selected text
                                        $('#book_id').val(ui.item
                                            .value); // save selected id to input
                                        return false;
                                    }
                                });
                            });
                            </script> -->
                            <div class="form-group">
                                <label for="order_number">Nomor Order<abbr title="Required">*</abbr></label>
                                <input type="text" name="order_number" id="order_number" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Permintaan<abbr title="Required">*</abbr></label>
                                <div class="input-group mb-3">
                                    <input type="date" name="request_date" value="" class="form-control dates" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Jatuh Tempo<abbr title="Required">*</abbr></label>
                                <div class="input-group mb-3">
                                    <input type="date" name="deadline_date" value="" class="form-control dates" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="total">List Permintaan Buku<abbr
                                        title="Required">*</abbr></label>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <p class="m-0">Judul Buku</p>
                                        <div id="prefetch">
                                            <input type="text" name="book_title" id="book_title" class="form-control"
                                                placeholder="Cari judul buku" />
                                            <input type="hidden" name="book_id" id="book_id" class="form-control"
                                                value='0' />
                                            <script language="JavaScript" type="text/javascript"
                                                src="<?php echo base_url(); ?>assets/autocomplete/jquery.min.js">
                                            </script>
                                            <script language="JavaScript" type="text/javascript"
                                                src="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.js">
                                            </script>
                                            <script>
                                            $(document).ready(function() {
                                                $("#book_title").autocomplete({
                                                    source: function(request, response) {
                                                        // Fetch data
                                                        $.ajax({
                                                            url: "<?php echo base_url("$pages/ac_book_id"); ?>",
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
                                                        $('#book_title').val(ui.item
                                                            .label); // display the selected text
                                                        $('#book_id').val(ui.item
                                                            .value); // save selected id to input
                                                        return false;
                                                    }
                                                });
                                            });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <p class="m-0">Jumlah</p>
                                        <input type="number" class="form-control" style="max-width: auto;" name="qty"
                                            id="qty" min="1">
                                    </div>
                                    <div class="col-2">
                                        <br>
                                        <input class="btn btn-dark" id="add_data" value="Tambah" readonly
                                            style="width:80px">
                                        <script type="text/javascript">
                                        $(function() {
                                            $('#add_data').click(function() {
                                                var book_title = $('#book_title').val();
                                                var qty = $('#qty').val();
                                                $('#list tbody:last-child').append(
                                                    '<tr>' +
                                                    '<td>' + book_title + '</td>' +
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
                                                <th>Judul Buku</th>
                                                <th>Jumlah</th>
                                                <!-- <th>Aksi</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="total">Jumlah Permintaan Buku<abbr title="Required">*</abbr></label>
                                    <input type="number" min="1" name="total" id="total" class="form-control" />
                                </div> -->
                                <div class="form-group">
                                    <label for="notes">Deskripsi<abbr title="Required">*</abbr></label>
                                    <textarea name="notes" id="notes" cols="20" rows="5"
                                        class="form-control summernote-basic"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="notes">PIC<abbr title="Required">*</abbr></label>
                                    <input name="pic" id="pic" cols="20" rows="5" class="form-control summernote-basic">
                                </div>
                                </fieldset>
                                <hr>
                                <!-- button -->
                                <input type="submit" class="btn btn-primary ml-auto" value="Submit" />
                                <a class="btn btn-secondary" href="<?php echo base_url('book_request') ?>"
                                    role="button">Back</a>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>