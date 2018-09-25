<script>
  function preview_image(event) 
  {
   var reader = new FileReader();
   reader.onload = function()
   {
    var output = document.getElementById('output_image');
    output.src = reader.result;
   }
   reader.readAsDataURL(event.target.files[0]);
  };
</script>
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
    <div class="col-md-6">
      <!-- .card -->
    <section id="data-author" class="card">
      <!-- .card-body -->
      <div class="card-body">
        <!-- .form -->
        <?= form_open_multipart($form_action,'class="needs-validation" novalidate=""') ?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Data Penulis</legend>
            <?= isset($input->author_id) ? form_hidden('author_id', $input->author_id) : '' ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="user_id">Pilih User ID untuk Login </label>
              <?= form_dropdown('user_id', getDropdownList('user', ['user_id', 'username']), $input->user_id, 'id="user_id" class="form-control custom-select d-block"') ?>
              <small id="tf1Help" class="form-text text-muted">Kosongkan pilihan jika tidak menetapkan User ID</small>
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
              <?= form_input('author_nip', $input->author_nip, 'class="form-control" id="author_nip" required') ?>
              <div class="invalid-feedback">Field is required</div>
              </div>
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
              <?= form_input('author_name', $input->author_name, 'class="form-control" id="author_name" required') ?>
              <div class="invalid-feedback">Field is required</div>
              </div>
              <?= form_error('author_name') ?>
            </div>
            <!-- /.form-group -->

            <!-- .form-group -->
            <div class="form-group">
              <label for="work_unit_id">Unit Kerja
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('work_unit_id', getDropdownList('work_unit', ['work_unit_id', 'work_unit_name']), $input->work_unit_id, 'id="work_unit" class="form-control custom-select d-block" required') ?>
              <div class="invalid-feedback">Field is required</div>
              <?= form_error('work_unit_id') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="institute_id">Institusi
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('institute_id', getDropdownList('institute', ['institute_id', 'institute_name']), $input->institute_id, 'id="institute" class="form-control custom-select d-block" required') ?>
              <div class="invalid-feedback">Field is required</div>
              <?= form_error('institute_id') ?>
            </div>
            <!-- /.form-group -->
            <div class="row">
              <div class="col-md-6">
                <!-- .form-group -->
                <div class="form-group">
                  <label for="author_degree_front">Gelar Depan Nama</label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                  <?= form_input('author_degree_front', $input->author_degree_front,'class="form-control" id="author_degree_front" placeholder="contoh = Ir."') ?>
                  </div>
                  <?= form_error('author_degree_front') ?>
                </div>
                <!-- /.form-group -->
              </div>
              <div class="col-md-6">
                <!-- .form-group -->
                <div class="form-group">
                  <label for="author_degree_back">Gelar Belakang Nama</label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                  <?= form_input('author_degree_back', $input->author_degree_back,'class="form-control" id="author_degree_back" placeholder="contoh = S.T"') ?>
                  </div>
                  <?= form_error('author_degree_back') ?>
                </div>
                <!-- /.form-group -->
              </div>
            </div>
            
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
              <?= form_input('author_address', $input->author_address,'class="form-control" id="author_address" required') ?>
              <div class="invalid-feedback">Field is required</div>
              </div>
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
              <?= form_input('author_contact', $input->author_contact,'class="form-control" id="author_contact" type="number" required') ?>
              <div class="invalid-feedback">Field is required</div>
              </div>
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
              <?= form_input('author_email', $input->author_email,'class="form-control" id="author_email" required') ?>
              <div class="invalid-feedback">Field is required</div>
              </div>
              <?= form_error('author_email') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="bank_id">Bank
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('bank_id', getDropdownBankList('bank', ['bank_id', 'bank_name']), $input->bank_id, 'id="bank" class="form-control custom-select d-block" required') ?>
              <div class="invalid-feedback">Field is required</div>
              <?= form_error('bank_id') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_saving_num">Nomor Rekening
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?php  ?>
              <?= form_input('author_saving_num', $input->author_saving_num,'class="form-control" id="author_saving_num" required') ?>
              <div class="invalid-feedback">Field is required</div>
              </div>
              <?= form_error('author_saving_num') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="heir_name">Ahli Waris
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?php  ?>
              <?= form_input('heir_name', $input->heir_name,'class="form-control" id="heir_name" required') ?>
              <div class="invalid-feedback">Field is required</div>
              </div>
              <?= form_error('heir_name') ?>
            </div>
            <!-- /.form-group -->
            <hr>
            <script></script>
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_ktp">KTP
                <abbr title="Required">*</abbr>
              </label>
              <div class="custom-file">
                <?= form_upload('author_ktp','','class="custom-file-input" onchange="preview_image(event)"') ?> 
                <label class="custom-file-label" for="author_ktp">Choose file</label>
                <div class="invalid-feedback">Field is required</div>
              </div>
              <small class="form-text text-muted">Hanya menerima file bertype : jpg dan png</small>
              <?= fileFormError('author_ktp', '<p class="text-danger">', '</p>'); ?>
              <div class="col-8 offset-2 mt-3"><img width="100%" id="output_image"/></div>
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
  <script>
    $(document).ready(function(){
      $("#user_id").select2({
      placeholder: '-- Choose --',
      allowClear: true
      });
      $("#work_unit").select2({
        placeholder: '-- Choose --',
        allowClear: true
      });
      $("#institute").select2({
        placeholder: '-- Choose --',
        allowClear: true
      });
      $("#bank").select2({
        placeholder: '-- Choose --',
        allowClear: true
      });

    })
  </script>
