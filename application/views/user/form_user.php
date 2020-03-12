<?php
$is_add_user = $this->uri->segment(2) == 'add';
?>

<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url('user');?>">User</a>
         </li>
         <li class="breadcrumb-item">
            <a class="text-muted">Form</a>
         </li>
      </ol>
   </nav>
</header>
<div class="page-section">
   <div class="row">
      <div class="col-lg-8">
         <section class="card">
            <div class="card-body">
               <?=form_open($form_action, 'id="form_user" novalidate=""');?>
               <fieldset>
                  <legend>Form User</legend>
                  <?=isset($input->user_id) ? form_hidden('user_id', $input->user_id) : '';?>
                  <div class="form-group">
                     <label for="username">
                        <?=$this->lang->line('form_user_name');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_input('username', $input->username, 'class="form-control" id="username"');?>
                     <?=form_error('username');?>
                  </div>
                  <div class="form-group">
                     <label for="email">
                        <?=$this->lang->line('form_user_email');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_input('email', $input->email, 'class="form-control" id="email"');?>
                     <?=form_error('email');?>
                  </div>
                  <div class="form-group">
                     <label for="password">
                        <?=$this->lang->line('form_user_password');?>
                        <?=$is_add_user ? ' <abbr title="Required">*</abbr>' : null;?>
                     </label>
                     <?=form_password('password', null, 'class="form-control" id="password"');?>
                     <small class="form-text text-muted <?=$is_add_user ? 'd-none' : null;?>">Kosongkan jika tidak ingin
                        memperbarui password.</small>
                     <?=form_error('password');?>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>
                              <?=$this->lang->line('form_user_level');?>
                              <abbr title="Required">*</abbr>
                           </label>
                           <div class="custom-control custom-radio">
                              <?=form_radio('level', 'superadmin', isset($input->level) && ($input->level == 'superadmin') ? true : false, ' class="custom-control-input" id="level1"');?>
                              <label
                                 class="custom-control-label"
                                 for="level1"
                              >Superadmin</label>
                           </div>
                           <div class="custom-control custom-radio">
                              <?=form_radio('level', 'admin_penerbitan', isset($input->level) && ($input->level == 'admin_penerbitan') ? true : false, 'class="custom-control-input" id="level2"');?>
                              <label
                                 class="custom-control-label"
                                 for="level2"
                              >Admin Penerbitan</label>
                           </div>
                           <div class="custom-control custom-radio">
                              <?=form_radio('level', 'editor', isset($input->level) && ($input->level == 'editor') ? true : false, ' class="custom-control-input" id="level3"');?>
                              <label
                                 class="custom-control-label"
                                 for="level3"
                              >Editor</label>
                           </div>
                           <div class="custom-control custom-radio">
                              <?=form_radio('level', 'layouter', isset($input->level) && ($input->level == 'layouter') ? true : false, ' class="custom-control-input" id="level4"');?>
                              <label
                                 class="custom-control-label"
                                 for="level4"
                              >Layouter</label>
                           </div>
                           <div class="custom-control custom-radio">
                              <?=form_radio('level', 'author', isset($input->level) && ($input->level == 'author') ? true : false, ' class="custom-control-input" id="level5"');?>
                              <label
                                 class="custom-control-label"
                                 for="level5"
                              >Author</label>
                           </div>
                           <div class="custom-control custom-radio">
                              <?=form_radio('level', 'reviewer', isset($input->level) && ($input->level == 'reviewer') ? true : false, ' class="custom-control-input" id="level6"');?>
                              <label
                                 class="custom-control-label"
                                 for="level6"
                              >Reviewer</label>
                           </div>
                           <div class="custom-control custom-radio">
                              <?=form_radio('level', 'author_reviewer', isset($input->level) && ($input->level == 'author_reviewer') ? true : false, ' class="custom-control-input" id="level7"');?>
                              <label
                                 class="custom-control-label"
                                 for="level7"
                              >Author dan Reviewer</label>
                           </div>
                           <?=form_error('level');?>
                        </div>
                     </div>
                     <?php if (!$is_add_user): ?>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>
                              <?=$this->lang->line('form_user_is_blocked');?>
                              <abbr title="Required">*</abbr>
                           </label>
                           <div class="form-group">
                              <div class="custom-control custom-radio">
                                 <?=form_radio('is_blocked', 'n', isset($input->is_blocked) && ($input->is_blocked == 'n') ? true : false, ' class="custom-control-input" id="category_status1"');?>
                                 <label
                                    class="custom-control-label"
                                    for="category_status1"
                                 >Aktif</label>
                              </div>
                              <div class="custom-control custom-radio">
                                 <?=form_radio('is_blocked', 'y', isset($input->is_blocked) && ($input->is_blocked == 'y') ? true : false, 'class="custom-control-input" id="category_status2"');?>
                                 <label
                                    class="custom-control-label"
                                    for="category_status2"
                                 >Tidak aktif</label>
                              </div>
                              <?=form_error('is_blocked');?>
                           </div>
                        </div>
                     </div>
                     <?php endif;?>
                  </div>
                  <hr>
                  <div class="form-check">
                     <?=form_checkbox('send_mail', true, isset($input->send_mail) ? true : false, 'id="send_mail"');?>
                     <label
                        class="form-check-label"
                        for="send_mail"
                     >
                        Kirim email pemberitahuan ke user
                     </label>
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
   // loadValidateSetting();
   // $("#form_user").validate({
   //       rules: {
   //          username: {
   //             crequired: true,
   //             username: true,
   //          },
   //          password: {
   //             crequired: true,
   //             cminlength: 4
   //          },
   //          level: "crequired"
   //       },
   //       errorElement: "span",
   //       errorPlacement: validateErrorPlacement
   //    },
   //    validateSelect2()
   // );
})
</script>