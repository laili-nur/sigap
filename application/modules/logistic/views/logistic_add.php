<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('logistic'); ?>">Logistik</a>
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
                    <form action="<?= base_url("logistic/add_logistic"); ?>" method="post">
                        <fielsdet>
                            <legend>Form Tambah Logistik</legend>
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Nama Logistik<abbr title="Required">*</abbr></label>
                                <input type="text" name="name" id="name" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="type" class="font-weight-bold">Tipe Logistik<abbr title="Required">*</abbr></label>
                                <input type="text" name="type" id="type" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="category" class="font-weight-bold">Kategori Logistik<abbr title="Required">*</abbr></label>
                                <input type="text" name="category" id="category" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="notes" class="font-weight-bold">Catatan</label>
                                <textarea name="notes"  id="notes" cols="20" rows="5" class="form-control summernote-basic" ></textarea>
                            </div>
                        </fieldset>
                        <hr>
                        <!-- button -->
                        <input type="submit" class="btn btn-primary" value="Submit" />
                        <a class="btn btn-secondary" href="<?php echo base_url('logistic') ?>" role="button">Back</a>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>