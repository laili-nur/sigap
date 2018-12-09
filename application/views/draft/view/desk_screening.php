<?php $ceklevel = $this->session->userdata('level'); ?>
<hr class="my-5"> 
  <!-- .card -->
  <section id="desk-screening" class="card card-fluid">
    <header class="card-header">Desk Screening</header>
     <!-- .card-body -->
    <div class="card-body">
      <?php if ($desk->worksheet_status == 1): ?>
      <!-- screening diterima -->
      <div class="alert alert-success">
        <strong>Draft Lolos Desk Screening.</strong>
      </div>
      <?php elseif ($desk->worksheet_status == 2): ?>
      <!-- screening ditolak -->
      <div class="alert alert-danger">
        <strong>Draft Tidak Lolos Desk Screening.</strong>
      </div>
      <?php else: ?>
        <!-- screening ditolak -->
      <div class="alert alert-warning">
        <strong>Draft Menunggu Desk Screening.</strong>
        <?php  if($ceklevel !='author' and $ceklevel !='reviewer'):?>
          <p class="m-0 p-0">Untuk melakukan desk screening, silakan menuju link berikut : <a href="<?=base_url('worksheet/edit/'.$desk->worksheet_id) ?>"><?=$input->draft_title ?></a></p>
        <?php endif ?>
      </div>
      <?php endif ?>
      <form class="needs-validation" novalidate="">
        <!-- .fieldset -->
        <fieldset>
          <!-- .form-group -->
          <div class="form-group">
            <label><strong>Catatan Editor</strong></label>
<!--             <textarea class="form-control" id="tf5" rows="3" disabled=""><?=$desk->worksheet_notes ?></textarea>
 -->            <div class="font-italic"><?=($desk->worksheet_notes!='')? nl2br($desk->worksheet_notes):'<em>Tidak ada catatan</em>'?></div>
          </div>
          <!-- /.form-group -->
        </fieldset>
        <!-- /.fieldset -->
      </form>
      <!-- /.form -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->