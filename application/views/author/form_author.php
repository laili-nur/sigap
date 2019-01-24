<!-- .page-title-bar -->
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>"><span class="fa fa-home"></span></a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>">Penerbitan</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url('author')?>">Penulis</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted">Form</a>
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
    <section id="data-author" class="card">
      <!-- .card-body -->
      <div class="card-body">
        <!-- .form -->
        <?= form_open_multipart($form_action,'novalidate="" id="formauthor"') ?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Data Penulis</legend>
            <?= isset($input->author_id) ? form_hidden('author_id', $input->author_id) : '' ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="user_id">Pilih User ID untuk Login</label>
              <?= form_dropdown('user_id', getDropdownListAuthor('user', ['user_id', 'username']), $input->user_id, 'id="user_id" class="form-control custom-select d-block"') ?>
              <small class="form-text text-muted">Kosongkan pilihan jika tidak menetapkan User ID</small>
              <?= form_error('user_id') ?>
            </div>
            <!-- /.form-group -->
            <hr class="my-2">
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_nip">NIP
                <abbr title="Required">*</abbr>
              </label>
              <?= form_input('author_nip', $input->author_nip, 'class="form-control" id="author_nip"') ?>
              <?= form_error('author_nip') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_name">Nama Penulis
                <abbr title="Required">*</abbr>
              </label>
              <?= form_input('author_name', $input->author_name, 'class="form-control" id="author_name"') ?>
              <?= form_error('author_name') ?>
            </div>
            <!-- /.form-group -->

            <!-- .form-group -->
            <div class="form-group">
              <label for="work_unit_id">Unit Kerja
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('work_unit_id', getDropdownList('work_unit', ['work_unit_id', 'work_unit_name']), $input->work_unit_id, 'id="work_unit" class="form-control custom-select d-block"') ?>
              <?= form_error('work_unit_id') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="institute_id">Institusi
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('institute_id', getDropdownList('institute', ['institute_id', 'institute_name']), $input->institute_id, 'id="institute" class="form-control custom-select d-block"') ?>
              <?= form_error('institute_id') ?>
            </div>
            <!-- /.form-group -->
            <div class="row">
              <div class="col-md-6">
                <!-- .form-group -->
                <div class="form-group">
                  <label for="author_degree_front">Gelar Depan Nama</label>
                  <?= form_input('author_degree_front', $input->author_degree_front,'class="form-control" id="author_degree_front" placeholder="contoh = Ir."') ?>
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
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_latest_education">Pendidikan Terakhir</label>
              <?php
              $options = array(
                ''         => '-- Choose --',
                's1'         => 'S1',
                's2'         => 'S2',
                's3'         => 'S3',
                's4'         => 'Professor',
                'other'      => 'Other',
              );
              echo form_dropdown('author_latest_education', $options,$input->author_latest_education,'id="author_latest_education" class="form-control custom-select d-block" ' )
              ?>
               <?= form_error('author_latest_education') ?>
            </div>
            <!-- /.form-group -->
            <hr class="my-2">
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_address">Alamat</label>
              <?= form_input('author_address', $input->author_address,'class="form-control" id="author_address"') ?>
              <?= form_error('author_address') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_contact">No HP</label>
              <?= form_input('author_contact', $input->author_contact,'class="form-control" id="author_contact" type="number"') ?>
              <?= form_error('author_contact') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_email">Email</label>
              <?= form_input('author_email', $input->author_email,'class="form-control" id="author_email"') ?>
              <?= form_error('author_email') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="bank_id">Bank</label>
              <?= form_dropdown('bank_id', getDropdownBankList('bank', ['bank_id', 'bank_name']), $input->bank_id, 'id="bank" class="form-control custom-select d-block"') ?>
              <?= form_error('bank_id') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_saving_num">Nomor Rekening</label>
              <?= form_input('author_saving_num', $input->author_saving_num,'class="form-control" id="author_saving_num"') ?>
              <?= form_error('author_saving_num') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="heir_name">Ahli Waris</label>
              <?= form_input('heir_name', $input->heir_name,'class="form-control" id="heir_name"') ?>
              <?= form_error('heir_name') ?>
            </div>
            <!-- /.form-group -->
            <hr>
            <script></script>
            <!-- .form-group -->
            <div class="form-group">

              <label for="author_ktp">KTP</label>
              <div class="custom-file">
                <?= form_upload('author_ktp','','class="custom-file-input" onchange="preview_image(event)"') ?>
                <label class="custom-file-label" for="author_ktp">Choose file</label>
              </div>
              <small class="form-text text-muted">Hanya menerima file bertype : jpg, jpeg, png, pdf. Maksimal 15 MB</small>
              <?= fileFormError('author_ktp', '<p class="text-danger">', '</p>'); ?>
              <div class="col-8 offset-2 mt-3">
                <?php
                //liat ekstensi file 
                if($input->author_ktp!=''){
                  $getextension = explode(".", $input->author_ktp); 
                }else{
                  $getextension[1] = '';
                }
                if($input->author_ktp !=''){
                //jika ekstensi pdf maka tampilkan link
                  if($getextension[1]!='pdf'){
                    echo '<img src="'.base_url('authorktp/'.$input->author_ktp).'" width="100%" class="previewxx"><br>';
                  }else{
                    echo '<div align="middle"><a href="'.base_url('authorktp/'.$input->author_ktp).'" class="btn btn-success btn-sm previewxx"><i class="fa fa-download"></i> Lihat KTP</a></div>';
                  }
                }
                ?>

                <img width="100%" id="output_image"/>
              </div>
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
  </div>
  <!-- /.page-section -->
  <script>
    $(document).ready(function(){
      setting_validasi();
    $("#formauthor").validate({
        rules: {
          author_nip : {
            crequired :true,
            cminlength : 3,
            cnumber : true
          },
          author_name : {
            crequired :true,
            huruf :true
          },
          work_unit_id : "crequired",
          institute_id : "crequired",
          author_contact : {
            cnumber :true
          },
          author_email : {
            cemail :true
          },
          heir_name : {
            huruf :true
          },
          author_ktp: {
            dokumen: "jpg|png|jpeg|pdf",
            filesize15: 157280640
          }
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
           error.addClass( "invalid-feedback" );
            if (element.parent('.input-group').length) {
                error.insertAfter(element.next('span.select2'));      // input group
            } else if (element.hasClass("select2-hidden-accessible")){
                error.insertAfter(element.next('span.select2'));  // select2
            } else if (element.hasClass("custom-file-input")){
                error.insertAfter(element.next('label.custom-file-label'));  // fileinput custom
            } else if (element.hasClass("custom-control-input")){
                error.insertAfter($(".custom-radio").last());  // radio
            }else {
                error.insertAfter(element);               // default
            }
        }
      },
      select2_validasi()
     );

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
