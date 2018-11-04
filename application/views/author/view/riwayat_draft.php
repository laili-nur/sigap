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
                        <th scope="col">Tema</th>
                        <th scope="col">Tanggal Masuk</th>
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
                <td class="align-middle"><?= $draft->theme_name ?></td>
                <td class="align-middle"><?= konversiTanggal($draft->entry_date) ?></td>
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
            <p>Author data were not available</p>
        <?php endif ?>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->