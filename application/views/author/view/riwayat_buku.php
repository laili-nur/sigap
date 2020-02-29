<?php $i = 1;?>
<div class="card card-fluid">
   <h6 class="card-header"> Riwayat Buku </h6>
   <div class="card-body">
      <?php if ($books): ?>
      <div class="table-responsive">
         <table class="table table-striped table-bordered mb-0">
            <thead>
               <tr>
                  <th scope="col">No</th>
                  <th scope="col">Judul Buku</th>
                  <th scope="col">Edisi</th>
                  <th scope="col">ISBN</th>
                  <th scope="col">No Hak Cipta</th>
                  <th scope="col">Tanggal Terbit</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($books as $book): ?>
               <tr>
                  <td class="align-middle"><?=$i++;?></td>
                  <td class="align-middle"><?=$book->book_title;?></td>
                  <td class="align-middle"><?=$book->book_edition;?></td>
                  <td class="align-middle"><?=$book->isbn;?></td>
                  <td class="align-middle"><?=$book->nomor_hak_cipta;?></td>
                  <td class="align-middle"><?=konversiTanggal($book->published_date, 'dateonly');?></td>
               </tr>
               <?php endforeach;?>
            </tbody>
         </table>
      </div>
      <?php else: ?>
      <p class="text-center">Data tidak tersedia</p>
      <?php endif;?>
   </div>
</div>