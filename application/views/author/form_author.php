<?php
$author_nip = [
    'type'  => 'number',
    'name'  => 'author_nip',
    'id'    => 'author_nip',
    'value' => $input->author_nip,
    'class' => 'form-control',
];

$latest_education_options = [
    ''      => '-- Pilih --',
    's1'    => 'S1',
    's2'    => 'S2',
    's3'    => 'S3',
    's4'    => 'Professor',
    'other' => 'Other',
];
?>
<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url('author');?>">Penulis</a>
         </li>
         <li class="breadcrumb-item">
            <a class="text-muted">Form</a>
         </li>
      </ol>
   </nav>
</header>
<div class="page-section">
   <div class="row">
      <div class="col-md-6">
         <section class="card">
            <div class="card-body">
               <?=form_open_multipart($form_action, 'novalidate="" id="form_author"');?>
               <fieldset>
                  <legend>Form Penulis</legend>
                  <?=isset($input->author_id) ? form_hidden('author_id', $input->author_id) : '';?>
                  <div class="form-group">
                     <label for="user_id">Pilih akun untuk login</label>
                     <?=form_dropdown('user_id', get_dropdown_list_author('user', ['user_id', 'username']), $input->user_id, 'id="user_id" class="form-control custom-select d-block"');?>
                     <small class="form-text text-muted">Author dapat login ke sistem apabila mempunyai akun pengguna.
                        Kosongkan pilihan jika tidak menetapkan akun.</small>
                     <?=form_error('user_id');?>
                  </div>
                  <hr class="my-2">

                  <div class="form-group">
                     <label for="author_name">
                        <?=$this->lang->line('form_author_name');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_input('author_name', $input->author_name, 'class="form-control" id="author_name"');?>
                     <?=form_error('author_name');?>
                  </div>

                  <div class="form-group">
                     <label for="author_nip">
                        <?=$this->lang->line('form_author_nip');?>
                        <abbr title="Required">*</abbr>
                     </label>

                     <?=form_input($author_nip);?>
                     <?=form_error('author_nip');?>
                  </div>

                  <div class="form-group">
                     <label for="work_unit_id">
                        <?=$this->lang->line('form_work_unit_name');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_dropdown('work_unit_id', get_dropdown_list('work_unit', ['work_unit_id', 'work_unit_name']), $input->work_unit_id, 'id="work_unit" class="form-control custom-select d-block"');?>
                     <?=form_error('work_unit_id');?>
                  </div>

                  <div class="form-group">
                     <label for="institute_id">
                        <?=$this->lang->line('form_institute_name');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_dropdown('institute_id', get_dropdown_list('institute', ['institute_id', 'institute_name']), $input->institute_id, 'id="institute" class="form-control custom-select d-block"');?>
                     <?=form_error('institute_id');?>
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="author_degree_front"><?=$this->lang->line('form_author_degree_front');?></label>
                           <?=form_input('author_degree_front', $input->author_degree_front, 'class="form-control" id="author_degree_front" placeholder="contoh = Ir."');?>
                           <?=form_error('author_degree_front');?>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="author_degree_back"><?=$this->lang->line('form_author_degree_back');?></label>
                           <?=form_input('author_degree_back', $input->author_degree_back, 'class="form-control" id="author_degree_back" placeholder="contoh = S.T"');?>
                           <?=form_error('author_degree_back');?>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label
                        for="author_latest_education"><?=$this->lang->line('form_author_latest_education');?></label>
                     <?=form_dropdown('author_latest_education', $latest_education_options, $input->author_latest_education, 'id="author_latest_education" class="form-control custom-select d-block"');?>
                     <?=form_error('author_latest_education');?>
                  </div>

                  <div class="form-group">
                     <label for="author_address"><?=$this->lang->line('form_author_address');?></label>
                     <?=form_input('author_address', $input->author_address, 'class="form-control" id="author_address"');?>
                     <?=form_error('author_address');?>
                  </div>

                  <div class="form-group">
                     <label for="author_contact"><?=$this->lang->line('form_author_contact');?></label>
                     <?=form_input('author_contact', $input->author_contact, 'class="form-control" id="author_contact" type="number"');?>
                     <?=form_error('author_contact');?>
                  </div>

                  <div class="form-group">
                     <label for="author_email"><?=$this->lang->line('form_author_email');?></label>
                     <?=form_input('author_email', $input->author_email, 'class="form-control" id="author_email"');?>
                     <?=form_error('author_email');?>
                  </div>

                  <div class="form-group">
                     <label for="bank_id"><?=$this->lang->line('form_author_bank_name');?></label>
                     <?=form_dropdown('bank_id', getDropdownBankList('bank', ['bank_id', 'bank_name']), $input->bank_id, 'id="bank" class="form-control custom-select d-block"');?>
                     <?=form_error('bank_id');?>
                  </div>

                  <div class="form-group">
                     <label for="author_saving_num"><?=$this->lang->line('form_author_saving_num');?></label>
                     <?=form_input('author_saving_num', $input->author_saving_num, 'class="form-control" id="author_saving_num"');?>
                     <?=form_error('author_saving_num');?>
                  </div>

                  <div class="form-group">
                     <label for="heir_name"><?=$this->lang->line('form_author_heir_name');?></label>
                     <?=form_input('heir_name', $input->heir_name, 'class="form-control" id="heir_name"');?>
                     <?=form_error('heir_name');?>
                  </div>
                  <hr>

                  <div class="form-group">
                     <label for="author_ktp"><?=$this->lang->line('form_author_ktp');?></label>
                     <div class="custom-file">
                        <?=form_upload('author_ktp', '', 'class="custom-file-input" onchange="preview_image(event)"');?>
                        <label
                           class="custom-file-label"
                           for="author_ktp"
                        >Pilih file</label>
                     </div>
                     <small class="form-text text-muted">Hanya menerima file bertype : jpg, jpeg, png, pdf. Maksimal 15
                        MB</small>
                     <small class="text-danger"><?=$this->session->flashdata('ktp_no_data');?></small>
                     <?=file_form_error('author_ktp', '<p class="text-danger">', '</p>');?>
                     <?php if ($input->author_ktp): ?>
                     <div class="mt-3">
                        <?php if (in_array(check_file_extension($input->author_ktp), ['jpg', 'png', 'jpeg'])): ?>
                        <img
                           class="uploaded-file"
                           src="<?=base_url("author/view_image/authorktp/$input->author_ktp");?>"
                           width="100%"
                        >
                        <?php endif;?>
                        <a
                           href="<?=base_url("author/download_file/authorktp/$input->author_ktp");?>"
                           class="btn btn-success btn-sm my-2 uploaded-file"
                        >Unduh ktp</a>
                     </div>
                     <?php endif;?>

                     <!-- temp image placeholder -->
                     <img
                        width="50%"
                        id="temp-image"
                     />
                  </div>
               </fieldset>
               <hr>
               <div class="form-actions">
                  <button
                     class="btn btn-primary ml-auto"
                     type="submit"
                  >Submit data</button>
               </div>
               </form>
            </div>
         </section>
      </div>
   </div>
</div>
<script>
$(document).ready(function() {
   loadValidateSetting();
   $("#form_author").validate({
         rules: {
            author_nip: {
               crequired: true,
               cminlength: 3,
               cnumber: true
            },
            author_name: {
               crequired: true,
               huruf: true
            },
            work_unit_id: "crequired",
            institute_id: "crequired",
            author_contact: {
               cnumber: true
            },
            author_email: {
               cemail: true
            },
            heir_name: {
               huruf: true
            },
            author_ktp: {
               dokumen: "jpg|png|jpeg|pdf",
               filesize15: 157280640
            }
         },
         errorElement: "span",
         errorPlacement: validateErrorPlacement
      },
      validateSelect2()
   );

   $("#user_id").select2(defaultSelect2Options);
   $("#work_unit").select2(defaultSelect2Options);
   $("#institute").select2(defaultSelect2Options);
   $("#bank").select2(defaultSelect2Options);
})
</script>