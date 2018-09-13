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
          <a href="<?=base_url('author')?>">Penulis</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted">Tambah</a>
        </li>
      </ol>
    </nav> 
  </header>
  <!-- /.page-title-bar -->
  <!-- .page-section -->
  <div class="page-section">
    <div class="col-md-8">
      <!-- .card -->
    <section id="data-author" class="card">
      <!-- .card-body -->
      <div class="card-body">
        <!-- .form -->
        <?= form_open($form_action,'class="needs-validation" novalidate=""') ?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Data Penulis</legend>
            <?= isset($input->author_id) ? form_hidden('author_id', $input->author_id) : '' ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="user_id">User ID
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('user_id', getDropdownList('user', ['user_id', 'username']), $input->user_id, 'id="user_id" class="form-control custom-select d-block"') ?>
              <div class="invalid-feedback">erot</div>
              <?= form_error('user_id') ?>
            </div>
            <!-- /.form-group -->
            <hr class="my-2">
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_nip">NIP
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('author_nip', $input->author_nip, 'class="form-control" id="author_nip"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('author_nip') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_name">Nama Penulis
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('author_name', $input->author_name, 'class="form-control" id="author_name"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('author_name') ?>
            </div>
            <!-- /.form-group -->

            <!-- .form-group -->
            <div class="form-group">
              <label for="work_unit_id">Unit Kerja
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('work_unit_id', getDropdownList('work_unit', ['work_unit_id', 'work_unit_name']), $input->work_unit_id, 'id="work_unit" class="form-control custom-select d-block"') ?>
              <div class="invalid-feedback">erot</div>
              <?= form_error('work_unit_id') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="institute_id">Institusi
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('institute_id', getDropdownList('institute', ['institute_id', 'institute_name']), $input->institute_id, 'id="institute" class="form-control custom-select d-block"') ?>
              <div class="invalid-feedback">erot</div>
              <?= form_error('institute_id') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_degree">Gelar
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('author_degree', $input->author_degree,'class="form-control" id="author_degree"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('author_degree') ?>
            </div>
            <!-- /.form-group -->
            <hr class="my-2">
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_address">Alamat
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('author_address', $input->author_address,'class="form-control" id="author_address"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('author_address') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_contact">No HP
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?php 
                $data = array(
                  'name' => 'author_contact',
                  'id'   => 'author_contact',
                  'class'=> 'form-control',
                  'type' => 'number'
                ); ?>
              <?= form_input('author_contact', $input->author_contact,'class="form-control" id="author_contact"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('author_contact') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_email">Email
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?php  ?>
              <?= form_input('author_email', $input->author_email,'class="form-control" id="author_email"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('author_email') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="bank_id">Bank
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('bank_id', getDropdownBankList('bank', ['bank_id', 'bank_name']), $input->bank_id, 'id="institute" class="form-control custom-select d-block"') ?>
              <div class="invalid-feedback">erot</div>
              <?= form_error('bank_id') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_saving_num">Email
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?php  ?>
              <?= form_input('author_saving_num', $input->author_saving_num,'class="form-control" id="author_saving_num"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('author_saving_num') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="heir_name">Warisan
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?php  ?>
              <?= form_input('heir_name', $input->heir_name,'class="form-control" id="heir_name"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('heir_name') ?>
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
    <!-- /.card -->
    </div>
  </div>
  <!-- /.page-section -->
