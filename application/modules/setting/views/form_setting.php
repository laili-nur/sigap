<!-- .page-title-bar -->
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span> Admin Panel</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('setting'); ?>">Setting</a>
            </li>
        </ol>
    </nav>
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-info">Data dibawah ini ditampilkan pada halaman dashboard.</div>
            <!-- .card -->
            <section class="card">
                <!-- .card-body -->
                <div class="card-body">
                    <!-- .form -->
                    <?= form_open($form_action, 'id="formsetting" novalidate=""'); ?>
                    <!-- .fieldset -->
                    <fieldset>
                        <legend>Pengaturan</legend>
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="dashboard_head">Judul
                            </label>
                            <?= form_input('dashboard_head', $input->dashboard_head, 'class="form-control" id="dashboard_head"'); ?>
                            <?= form_error('dashboard_head'); ?>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="dashboard_content_author">Dashboard author
                            </label>
                            <?= form_textarea('dashboard_content_author', $input->dashboard_content_author, 'class="form-control summernote-basic" id="dashboard_content_author"'); ?>
                            <?= form_error('dashboard_content_author'); ?>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="dashboard_content_reviewer">Dashboard reviewer
                            </label>
                            <?= form_textarea('dashboard_content_reviewer', $input->dashboard_content_reviewer, 'class="form-control summernote-basic" id="dashboard_content_reviewer"'); ?>
                            <?= form_error('dashboard_content_reviewer'); ?>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="dashboard_content_editor">Dashboard editor
                            </label>
                            <?= form_textarea('dashboard_content_editor', $input->dashboard_content_editor, 'class="form-control summernote-basic" id="dashboard_content_editor"'); ?>
                            <?= form_error('dashboard_content_editor'); ?>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="dashboard_content_layouter">Dashboard layouter
                            </label>
                            <?= form_textarea('dashboard_content_layouter', $input->dashboard_content_layouter, 'class="form-control summernote-basic" id="dashboard_content_layouter"'); ?>
                            <?= form_error('dashboard_content_layouter'); ?>
                        </div>
                        <!-- /.form-group -->
                    </fieldset>
                    <!-- /.fieldset -->
                    <hr>
                    <!-- .form-actions -->
                    <div class="form-actions">
                        <button
                            class="btn btn-primary ml-auto"
                            type="submit"
                        >Submit</button>
                    </div>
                    <!-- /.form-actions -->
                    </form>
                    <!-- /.form -->
                </div>
                <!-- /.card-body -->
            </section>
            <!-- /.card -->
        </div>
    </div>
</div>
<!-- /.page-section -->
