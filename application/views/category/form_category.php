<!-- .page-title-bar -->
<header class="page-title-bar">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>">Penerbitan</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?=base_url('draft')?>">Draft</a>
      </li>
      <li class="breadcrumb-item active">
        <a href="<?=base_url('draft')?>">Kategori</a>
      <li class="breadcrumb-item active">
        <a class="text-muted">Tambah</a>
      </li>
      </li>
    </ol>
  </nav>
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <div class="row">
    <div class="col-md-6">
      <!-- .card -->
        <section id="data-category" class="card">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .form -->
            <?= form_open($form_action,'class="needs-validation" novalidate=""') ?>
              <!-- .fieldset -->
              <fieldset>
                <legend>Data Kategori</legend>
                <?= isset($input->category_id) ? form_hidden('category_id', $input->category_id) : '' ?>
                <!-- .form-group -->
                <div class="form-group">
                  <label for="category_name">Judul Kategori
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                  <?= form_input('category_name', $input->category_name, 'class="form-control" id="category_name" autofocus') ?>
                  </div>
                  <div class="invalid-feedback">Field is Required</div>
                  <?= form_error('category_name') ?>
                </div>
              </fieldset>
                <!-- /.form-group -->

                <!-- .form-group -->
                <div class="form-group">
                  <label for="category_year">Tahun Kategori
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                  <?= form_input('category_year', $input->category_year, 'class="form-control" id="category_year"') ?>
                  </div>
                  <div class="invalid-feedback">Harap diisi</div>
                  <?= form_error('category_year') ?>
                </div>
                <!-- /.form-group -->

                <!-- .form-group -->
                <div class="form-group">
                  <label for="date_open">Tanggal Buka
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('date_open', $input->date_open, 'class="form-control mydate" id="date_open" required=""') ?>
                     </div>
                    <div class="invalid-feedback">Harap diisi</div>
                    <?= form_error('date_open') ?>
                </div>
                <!-- /.form-group -->

                <!-- .form-group -->
                <div class="form-group">
                  <label for="date_close">Tanggal Tutup
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('date_close', $input->date_close, 'class="form-control mydate" id="date_close" required=""') ?>
                    <div class="invalid-feedback"> Field is Required </div>
                    <?= form_error('date_close') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="category_note">Keterangan</label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_textarea('category_note', $input->category_note, 'class="form-control"') ?>
                     </div>
                  <div class="invalid-feedback"> Field is Required </div>
                  <?= form_error('category_note') ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label>Status</label>
                  <div>
                    <!-- button radio -->
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary <?=($input->category_status == 'y') ? 'active' : '' ?>">
                      <?= form_radio('category_status', 'y',
                      isset($input->category_status) && ($input->category_status == 'y') ? true : false,'required class="custom-control-input" id="blocked1"')?> Aktif</label>
                    <label class="btn btn-secondary <?=($input->category_status == 'n') ? 'active' : '' ?>">
                      <?= form_radio('category_status', 'n',
                      isset($input->category_status) && ($input->category_status == 'n') ? true : false,' class="custom-control-input" id="blocked2"')?> Tidak Aktif</label>
                  </div>
                  <!-- /button radio -->
                  </div>
                  <?= form_error('category_status') ?>
                </div>
                <!-- /.form-group -->
              </fieldset>
              <!-- /.fieldset -->
              <hr>
              <!-- .form-actions -->
              <div class="form-actions">
                <button class="btn btn-primary ml-auto" type="submit">Submit data</button>
              </div>
              <!-- /.form-actions -->
            </form>
            <!-- /.form -->
          </div>
          <!-- /.card-body -->
        </section>
        <!-- /.card --
    </div>
  </div>      
</div>
<!-- /.page-section -->
