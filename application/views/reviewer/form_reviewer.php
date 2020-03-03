<?php
$reviewer_nip = [
    'type'  => 'number',
    'name'  => 'reviewer_nip',
    'id'    => 'reviewer_nip',
    'value' => $input->reviewer_nip,
    'class' => 'form-control',
];
$reviewer_contact = [
    'type'  => 'number',
    'name'  => 'reviewer_contact',
    'id'    => 'reviewer_contact',
    'value' => $input->reviewer_contact,
    'class' => 'form-control',
];
?>
<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url('reviewer');?>">Reviewer</a>
         </li>
         <li class="breadcrumb-item active">
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
               <?=form_open($form_action, ' novalidate="" id="form_reviewer"');?>
               <fieldset>
                  <legend>Form Reviewer</legend>
                  <?=isset($input->reviewer_id) ? form_hidden('reviewer_id', $input->reviewer_id) : '';?>
                  <div class="form-group">
                     <label for="user_id">Pilih akun untuk login
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_dropdown('user_id', getDropdownListReviewer('user', ['user_id', 'username']), $input->user_id, 'id="user_id" class="form-control custom-select d-block"');?>
                     <small class="form-text text-muted">Reviewer wajib memiliki akun. Jika belum ada, daftarkan akun di
                        <a href="<?=base_url('user/add');?>"><strong>sini</strong></a></small>
                     <?=form_error('user_id');?>
                  </div>
                  <hr class="my-2">
                  <div class="form-group">
                     <label for="reviewer_nip">
                        <?=$this->lang->line('form_reviewer_nip');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_input($reviewer_nip);?>
                     <?=form_error('reviewer_nip');?>
                  </div>
                  <div class="form-group">
                     <label for="reviewer_name">
                        <?=$this->lang->line('form_reviewer_name');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_input('reviewer_name', $input->reviewer_name, 'class="form-control" id="reviewer_name"');?>
                     <?=form_error('reviewer_name');?>
                  </div>
                  <div class="form-group">
                     <label for="user_id">
                        <?=$this->lang->line('form_faculty_name');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_dropdown('faculty_id', getDropdownList('faculty', ['faculty_id', 'faculty_name']), $input->faculty_id, 'id="faculty_id" class="form-control custom-select d-block"');?>
                     <?=form_error('faculty_id');?>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="author_degree_front">
                              <?=$this->lang->line('form_reviewer_degree_front');?></label>
                           <?=form_input('reviewer_degree_front', $input->reviewer_degree_front, 'class="form-control" id="reviewer_degree_front" placeholder="contoh = Ir."');?>
                           <?=form_error('reviewer_degree_front');?>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="reviewer_degree_back">
                              <?=$this->lang->line('form_reviewer_degree_back');?></label>
                           <div class="has-clearable">
                              <button
                                 type="button"
                                 class="close"
                                 aria-label="Close"
                              >
                                 <span aria-hidden="true">
                                    <i class="fa fa-times-circle"></i>
                                 </span>
                              </button>
                              <?=form_input('reviewer_degree_back', $input->reviewer_degree_back, 'class="form-control" id="reviewer_degree_back" placeholder="contoh = S.T"');?>
                           </div>
                           <?=form_error('reviewer_degree_back');?>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="reviewer_expert">
                        <?=$this->lang->line('form_reviewer_expert');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_dropdown('reviewer_expert[]', $input->reviewer_expert_data, $input->reviewer_expert, 'id="reviewer_expert" class="form-control custom-select d-block" multiple="multiple"');?>
                     <small class="form-text text-muted">Pilih kepakaran yang telah ada, atau tambahkan kepakaran baru
                        (Ketik lalu tekan enter)</small>
                     <?=form_error('reviewer_expert[]');?>
                  </div>
                  <hr class="my-2">
                  <div class="form-group">
                     <label for="reviewer_contact"> <?=$this->lang->line('form_reviewer_contact');?></label>
                     <?=form_input($reviewer_contact);?>
                     <?=form_error('reviewer_contact');?>
                  </div>
                  <div class="form-group">
                     <label for="reviewer_email"> <?=$this->lang->line('form_reviewer_email');?></label>
                     <?=form_input('reviewer_email', $input->reviewer_email, 'class="form-control" id="reviewer_email"');?>
                     <?=form_error('reviewer_email');?>
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
   $("#form_reviewer").validate({
         rules: {
            user_id: "crequired",
            reviewer_nip: {
               crequired: true,
               cminlength: 3,
               cnumber: true
            },
            reviewer_name: {
               crequired: true,
               huruf: true
            },
            faculty_id: "crequired",
            "reviewer_expert[]": "crequired",
            reviewer_contact: {
               cnumber: true
            },
            reviewer_email: {
               cemail: true
            },
         },
         errorElement: "span",
         errorPlacement: validateErrorPlacement
      },
      validateSelect2()
   );

   $("#user_id").select2(defaultSelect2Options);
   $("#faculty_id").select2(defaultSelect2Options);
   $('#reviewer_expert option[value=""]').detach();
   $("#reviewer_expert").select2({
      tags: true,
      placeholder: '-- Multiple --',
      tokenSeparators: [',']
   });
})
</script>