<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item active">
            <a class="text-muted">Kategori</a>
         </li>
      </ol>
   </nav>
</header>
<div class="page-section">
   <div class="row">
      <div class="col-12">
         <section class="card card-fluid">
            <header class="card-header">
               <div class="d-flex align-items-center">
                  <span class="mr-auto"><i class="fa fa-puzzle-piece"></i> Daftar Kategori</span>
                  <div class="card-header-control">
                     <a
                        href="<?=base_url('category/add');?>"
                        class="btn btn-primary btn-sm"
                     ><i class="fa fa-plus fa-fw"></i> Tambah</a>
                  </div>
               </div>
            </header>
            <div class="card-body p-0">
               <?php if ($categories): ?>
               <div class="double-scroll">
                  <table class="table table-striped">
                     <thead>
                        <tr>
                           <th
                              scope="col"
                              style="min-width:200px;"
                           >Nama</th>
                           <th scope="col">Tahun</th>
                           <th scope="col">Tanggal Buka</th>
                           <th scope="col">Sisa Waktu Buka</th>
                           <th scope="col">Tanggal Tutup</th>
                           <th scope="col">Sisa Waktu Tutup</th>
                           <th scope="col">Status</th>
                           <th style="min-width:100px;"> &nbsp; </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                           <td class="align-middle"><?=$category->category_name;?></td>
                           <td class="align-middle"><?=$category->category_year;?></td>
                           <td class="align-middle"><?=konversiTanggal($category->date_open, 'dateonly');?></td>
                           <td class="align-middle">
                              <?=$category->sisa_waktu_buka >= 1 ? $category->sisa_waktu_buka . ' hari' : '<span style="color:green">Sudah dibuka</span>';?>
                           </td>
                           <td class="align-middle"><?=konversiTanggal($category->date_close, 'dateonly');?></td>
                           <td class="align-middle">
                              <?=$category->sisa_waktu_tutup <= 0 ? '<span style="color:red">Berakhir</span>' : $category->sisa_waktu_tutup . ' hari';?>
                           </td>
                           <td class="align-middle"><?=$category->category_status == 'y' ? 'Aktif' : 'Nonaktif';?>
                           </td>
                           <td class="align-middle text-right">
                              <a
                                 href="<?=base_url('category/edit/' . $category->category_id . '');?>"
                                 class="btn btn-sm btn-secondary"
                              >
                                 <i class="fa fa-pencil-alt"></i>
                                 <span class="sr-only">Edit</span>
                              </a>
                              <button
                                 type="button"
                                 class="btn btn-sm btn-danger"
                                 data-toggle="modal"
                                 data-target="#modal-hapus-<?=$category->category_id;?>"
                              ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                              <div
                                 id="modal-hapus-<?=$category->category_id;?>"
                                 class="modal modal-alert fade"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="modal-hapus"
                                 aria-hidden="true"
                              >
                                 <div
                                    class="modal-dialog"
                                    role="document"
                                 >
                                    <div class="modal-content text-left">
                                       <div class="modal-header">
                                          <h5 class="modal-title">
                                             <i class="fa fa-exclamation-triangle text-red mr-1"></i> Konfirmasi
                                             Hapus
                                          </h5>
                                       </div>
                                       <div class="modal-body">
                                          <p>Apakah anda yakin akan menghapus kategori <span
                                                class="font-weight-bold"><?=$category->category_name;?></span>?</p>
                                       </div>
                                       <div class="modal-footer">
                                          <button
                                             type="button"
                                             class="btn btn-danger"
                                             onclick="location.href='<?=base_url('category/delete/' . $category->category_id . '');?>'"
                                             data-dismiss="modal"
                                          >Hapus</button>
                                          <button
                                             type="button"
                                             class="btn btn-light"
                                             data-dismiss="modal"
                                          >Close</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
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
         </section>
      </div>
   </div>
</div>

<script>
$(document).ready(function() {
   doublescroll();
});
</script>