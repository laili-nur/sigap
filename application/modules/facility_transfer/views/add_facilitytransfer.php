<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('logistic_purchase'); ?>">Mutasi Fasilitas</a>
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
                    <form action="<?= base_url("logistic_purchase/add_logisticpurchase"); ?>" method="post">
                        <fieldset>
                            <legend>Form Mutasi Fasilitas</legend>

                            <link href="<?php echo base_url(); ?>assets/autocomplete/jquery-ui.min.css"
                                rel="stylesheet"><!-- JQuery UI CSS -->
                            <div class="form-group">
                                <label for="unit_from" class="font-weight-bold">Unit Asal<abbr
                                        title="Required">*</abbr></label>
                                <input type="text" name="book_title" id="book_title" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="unit_to" class="font-weight-bold">Unit Tujuan<abbr
                                        title="Required">*</abbr></label>
                                <input type="text" name="book_title" id="book_title" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="unit_to" class="font-weight-bold">No. BA Mutasi<abbr
                                        title="Required">*</abbr></label>
                                <input type="text" name="book_title" id="book_title" class="form-control" />
                            </div>
                            <!-- <div class="form-group">
                                <div id="prefetch">
                                    <label for="book_title" class="font-weight-bold">Kode Pembelian<abbr
                                            title="Required">*</abbr></label>
                                    <input type="text" name="book_title" id="book_title" class="form-control" />
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="date_transfer" class="font-weight-bold">Tanggal BA Mutasi<abbr
                                        title="Required">*</abbr></label>
                                <input type="date" name="date_transfer" id="date_transfer" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="pic" class="font-weight-bold">PIC<abbr title="Required">*</abbr></label>
                                <input type="text" name="pic" id="pic" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="nip" class="font-weight-bold">NIP<abbr title="Required">*</abbr></label>
                                <input type="text" name="nip" id="nip" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="book_file" class="font-weight-bold">
                                    File BA Mutasi
                                </label>
                                <div id="upload-file-form">
                                    <div class="custom-file">
                                        <input type="file" name="book_file" class="custom-file-input" id="book_file">
                                        <label class="custom-file-label" for="book_file">Pilih
                                            file</label>
                                    </div>
                                    <small class="form-text text-muted">Hanya menerima file
                                        bertype *.gif, *.jpg, *.jpeg, *.png, *.bmp</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="book_notes">Keterangan Tambahan</label>
                                <textarea name="book_notes" cols="40" rows="10" class="form-control"
                                    id="book_notes"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="total" class="font-weight-bold">List Barang<abbr
                                        title="Required">*</abbr></label>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <p class="m-0">Nama Barang</p>
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
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <!-- <th>Aksi</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="col-md-8">

                                    </div>
                                    <div class="col-md-4">

                                    </div>
                                </div>

                                <!-- <label for="total" class="font-weight-bold">Total Harga<abbr
                                        title="Required">*</abbr></label>


                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-center" id="category_span">Rp</span>
                                    </div>
                                    <input type="number" min="1" name="total" id="total" class="form-control" />

                                </div> -->
                            </div>
                            <!-- <div class="form-group">
                                <label for="notes" class="font-weight-bold">Catatan<abbr
                                        title="Required">*</abbr></label>
                                <textarea name="notes" id="notes" cols="20" rows="5"
                                    class="form-control summernote-basic"></textarea>
                            </div> -->
                            <!-- button -->
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <a class="btn btn-secondary" href="<?php echo base_url('logistic_request') ?>"
                                role="button">Back</a>
                        </fieldset>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>