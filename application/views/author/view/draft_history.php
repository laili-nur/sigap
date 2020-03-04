<?php $i = 1;?>
<div class="card card-fluid">
   <h6 class="card-header"> Riwayat Draft </h6>
   <div class="card-body">
      <?php if ($drafts): ?>
      <div class="table-responsive">
         <table class="table table-striped table-bordered mb-0">
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
            <tbody>
               <?php foreach ($drafts as $draft): ?>
               <tr>
                  <td class="align-middle"><?=$i++;?></td>
                  <td class="align-middle"><a
                        href="<?=base_url('draft/view/' . $draft->draft_id);?>"><?=$draft->draft_title;?></a></td>
                  <td class="align-middle"><?=$draft->category_name;?></td>
                  <td class="align-middle"><?=format_datetime($draft->entry_date, 'dateonly');?></td>
                  <td class="align-middle"><?=format_datetime($draft->finish_date, 'dateonly');?></td>
                  <td class="align-middle">
                     <?=is_datetime_null($draft->finish_date) ? ceil((strtotime($draft->finish_date) - strtotime($draft->entry_date)) / 86400) . ' hari' : '-';?>
                  </td>
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