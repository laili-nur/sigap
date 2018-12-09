 <!-- .card -->
  <div class="card card-fluid">
    <h6 class="card-header"> Riwayat Buku </h6>
    <!-- .card-body -->
    <div class="card-body">
      <?php if ($books):?>
      <!-- .table-responsive -->
        <div class="table-responsive">
          <!-- .table -->
          <table class="table table-striped table-bordered mb-0">
            <!-- thead -->
                    <thead>
                      <tr>
                        <th scope="col">Judul Buku</th>
                        <th scope="col">Edisi</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">No Hak Cipta</th>
                        <th scope="col">Tanggal Terbit</th>
                      </tr>
                    </thead>
                    <!-- /thead -->
            <!-- tbody -->
            <tbody>
              <?php foreach($books as $book): ?>
              <!-- tr -->
              <tr>
                <td class="align-middle"><?= $book->book_title ?></td>
                <td class="align-middle"><?= $book->book_edition ?></td>
                <td class="align-middle"><?= $book->isbn ?></td>
                <td class="align-middle"><?= $book->nomor_hak_cipta ?></td>
                <td class="align-middle"><?= konversiTanggal($book->published_date,'dateonly') ?></td>
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
            <p>Book data were not available</p>
        <?php endif ?>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->