<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>">Penerbitan</a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url('workunit');?>">Unit Kerja</a>
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
               <?=form_open($form_action, 'id="form_work_unit" novalidate=""');?>
               <fieldset>
                  <legend>Form Unit Kerja</legend>
                  <?=isset($input->work_unit_id) ? form_hidden('work_unit_id', $input->work_unit_id) : '';?>
                  <div class="form-group">
                     <label for="work_unit_name">
                        <?=$this->lang->line('form_work_unit_name');?>
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_input('work_unit_name', $input->work_unit_name, 'class="form-control" id="work_unit_name" autofocus');?>
                     <?=form_error('work_unit_name');?>
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
   $("#form_work_unit").validate({
         rules: {
            work_unit_name: {
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