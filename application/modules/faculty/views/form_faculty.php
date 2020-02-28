<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url('faculty');?>">Fakultas</a>
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
               <?=form_open($form_action, 'id="form_faculty" novalidate=""');?>
               <fieldset>
                  <legend>Form Fakultas</legend>
                  <?=isset($input->faculty_id) ? form_hidden('faculty_id', $input->faculty_id) : '';?>
                  <div class="form-group">
                     <label for="faculty_name">Fakultas
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_input('faculty_name', $input->faculty_name, 'class="form-control" id="faculty_name" autofocus');?>
                     <?=form_error('faculty_name');?>
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
   $("#form_faculty").validate({
         rules: {
            faculty_name: {
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