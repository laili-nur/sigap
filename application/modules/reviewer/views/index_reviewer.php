<?php
// data number
$per_page = 10;
$keywords = $this->input->get('keywords');
$page     = $this->uri->segment(2);
$i        = isset($page) ? $page * $per_page - $per_page : 0;
?>

<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item active">
            <a class="text-muted">Reviewer</a>
         </li>
      </ol>
   </nav>
   <div class="d-flex justify-content-between align-items-center">
      <div>
         <h1 class="page-title"> Reviewer </h1>
         <span class="badge badge-info">Total : <?=$total;?></span>
      </div>
      <a
         href="<?=base_url("$pages/add");?>"
         class="btn btn-primary btn-sm"
      ><i class="fa fa-plus fa-fw"></i> Tambah</a>
   </div>
</header>
<div class="page-section">
   <div class="row">
      <div class="col-12">
         <section class="card card-fluid">
            <div class="card-body p-0">
               <div class="p-3">
                  <?=form_open($pages, ['method' => 'GET']);?>
                  <div class="input-group input-group-alt">
                     <?=form_input('keywords', $keywords, ['placeholder' => 'Cari berdasarkan Nama Reviewer, Username, NIP, Fakultas, atau Kepakaran', 'class' => 'form-control']);?>
                     <div class="input-group-append">
                        <button
                           type="button"
                           class="btn btn-secondary"
                           onclick="location.href = '<?=base_url($pages);?>'"
                        >Reset</button>
                        <?=form_button(['type' => 'submit', 'content' => '<i class="fa fa-search"></i>', 'class' => 'btn btn-primary']);?>
                     </div>
                     <?=form_close();?>
                  </div>
               </div>
               <?php if ($reviewers): ?>
               <div class="double-scroll">
                  <table class="table table-striped mb-0">
                     <thead>
                        <tr>
                           <th
                              scope="col"
                              class="pl-4"
                           >No</th>
                           <th
                              scope="col"
                              style="min-width:200px;"
                           >Nama</th>
                           <th
                              scope="col"
                              style="min-width:100px;"
                           >Akun</th>
                           <th
                              scope="col"
                              style="min-width:100px;"
                           >NIP</th>
                           <th
                              scope="col"
                              style="min-width:100px;"
                           >Fakultas</th>
                           <th
                              scope="col"
                              style="min-width:300px;"
                           >Kepakaran</th>
                           <th style="min-width:150px;"> &nbsp; </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($reviewers as $reviewer): ?>
                        <tr>
                           <td class="align-middle pl-4"><?=++$i;?></td>
                           <td class="align-middle">
                              <?=$reviewer->reviewer_degree_front;?>
                              <?=ucwords(highlight_keyword($reviewer->reviewer_name, $keywords));?>
                              <?=$reviewer->reviewer_degree_back;?></td>
                           <td class="align-middle"><?=highlight_keyword($reviewer->username, $keywords);?></td>
                           <td class="align-middle"><?=highlight_keyword($reviewer->reviewer_nip, $keywords);?></td>
                           <td class="align-middle"><?=highlight_keyword($reviewer->faculty_name, $keywords);?></td>
                           <td class="align-middle">
                              <?php foreach ($reviewer->reviewer_expert as $pakar) {echo '<span class="badge badge-dark">' . highlight_keyword($pakar, $keywords) . '</span>&nbsp;';}?>
                           </td>
                           <td class="align-middle text-right">
                              <a
                                 href="<?=base_url('reviewer/edit/' . $reviewer->reviewer_id . '');?>"
                                 class="btn btn-sm btn-secondary"
                              >
                                 <i class="fa fa-pencil-alt"></i>
                                 <span class="sr-only">Edit</span>
                              </a>
                              <button
                                 type="button"
                                 class="btn btn-sm btn-danger"
                                 data-toggle="modal"
                                 data-target="#modal-hapus-<?=$reviewer->reviewer_id;?>"
                              ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                              <div class="text-left">
                                 <div
                                    class="modal modal-alert fade"
                                    id="modal-hapus-<?=$reviewer->reviewer_id;?>"
                                    tabindex="-1"
                                    role="dialog"
                                    aria-labelledby="modal-hapus"
                                    aria-hidden="true"
                                 >
                                    <div
                                       class="modal-dialog"
                                       role="document"
                                    >
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title">
                                                <i class="fa fa-exclamation-triangle text-red mr-1"></i> Konfirmasi
                                                Hapus</h5>
                                          </div>
                                          <div class="modal-body">
                                             <p>Apakah anda yakin akan menghapus reviewer <span
                                                   class="font-weight-bold"><?=$reviewer->reviewer_name;?></span>?</p>
                                          </div>
                                          <div class="modal-footer">
                                             <button
                                                type="button"
                                                class="btn btn-danger"
                                                onclick="location.href='<?=base_url('reviewer/delete/' . $reviewer->reviewer_id . '');?>'"
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
               <?=$pagination ?? null;?>
            </div>

            <footer class="card-footer ">
               <div class="card-footer-content text-muted">
                  <a
                     href="<?=base_url('faculty');?>"
                     class="btn btn-secondary mr-2"
                  >Fakultas</a>
               </div>
            </footer>
         </section>
      </div>
   </div>
</div>

<script>
$(document).ready(function() {
   doublescroll();
});
</script>