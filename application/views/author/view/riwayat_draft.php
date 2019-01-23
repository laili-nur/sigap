<?php $i=1; ?>
<!-- .card -->
<div class="card card-fluid">
  <h6 class="card-header"> Riwayat Draft </h6>
  <!-- .card-body -->
  <div class="card-body">
    <?php if ($drafts):?>
    <!-- .table-responsive -->
    <div class="table-responsive">
      <!-- .table -->
      <table class="table table-striped table-bordered mb-0">
        <!-- thead -->
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Judul Draft</th>
            <th scope="col">Kategori</th>
            <th scope="col">Tanggal Masuk</th>
            <th scope="col">Tanggal Selesai</th>
            <th scope="col">Lama Proses</th>
          </tr>
        </thead>
        <!-- /thead -->
        <!-- tbody -->
        <tbody>
          <?php foreach($drafts as $draft): ?>
          <!-- tr -->
          <tr>
            <td class="align-middle"><?= $i++ ?></td>
            <td class="align-middle"><a href="<?= base_url('draft/view/'.$draft->draft_id) ?>"><?= $draft->draft_title ?></a></td>
            <td class="align-middle"><?= $draft->category_name ?></td>
            <td class="align-middle"><?= konversiTanggal($draft->entry_date,'dateonly') ?></td>
            <td class="align-middle"><?= konversiTanggal($draft->finish_date,'dateonly') ?></td>
            <td class="align-middle"><?= isset($draft->finish_date)? ceil((strtotime($draft->finish_date)-strtotime($draft->entry_date))/86400).' hari' : '-' ?></td>
          </tr>
          <!-- /tr -->
          <?php endforeach ?>
        </tbody>
        <!-- /tbody -->
      </table>
      <!-- /.table -->
    </div>
    <!-- /.table-responsive -->
    <?php else: ?>
    <p>Draft data were not available</p>
    <?php endif ?>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->