<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url('theme');?>">Tema</a>
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
               <?=form_open($form_action, 'id="form_theme" novalidate=""');?>
               <fieldset>
                  <legend>Form Tema</legend>
                  <?=isset($input->theme_id) ? form_hidden('theme_id', $input->theme_id) : '';?>
                  <div class="form-group">
                     <label for="theme_name">
                        <?=$this->lang->line('form_theme_name');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_input('theme_name', $input->theme_name, 'class="form-control" id="theme_name" autofocus');?>
                     <?=form_error('theme_name');?>
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
   $("#form_theme").validate({
         rules: {
            theme_name: {
               crequired: true,
               alphanum: true,
            }
         },
         errorElement: "span",
         errorPlacement: validateErrorPlacement
      },
      validateSelect2()
   );
})
</script>