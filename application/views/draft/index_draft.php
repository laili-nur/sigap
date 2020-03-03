<?php
$level = check_level();

$per_page = $this->input->get('per_page');
if (empty($per_page)) {
    $per_page = 10;
}
$keywords = $this->input->get('keywords');
$progress = $this->input->get('progress');
if (isset($keywords) or isset($progress)) {
    $page = $this->uri->segment(3);
} else {
    $page = $this->uri->segment(2);
}
// data table series number
$i = isset($page) ? $page * $per_page - $per_page : 0;

// Pilihan dropdown per level
if ($level == 'reviewer') {
    $filter_status = [
        ''      => '- Filter Review -',
        'belum' => ' Belum Direview',
        'sudah' => ' Sudah direview',
    ];
} elseif ($level == 'editor') {
    $filter_status = [
        ''        => '- Filter Edit -',
        'belum'   => ' Belum Diedit',
        'sudah'   => ' Sudah Diedit',
        'approve' => ' Edit Diterima',
        'reject'  => ' Edit Dtolak',
    ];
} elseif ($level == 'layouter') {
    $filter_status = [
        ''        => '- Filter Layout -',
        'belum'   => ' Belum Dilayout',
        'sudah'   => ' Sudah Dilayout',
        'approve' => ' Layout Diterima',
        'reject'  => ' Layout Dtolak',
    ];
} else {
    $filter_status = [
        ''               => '- Filter Status -',
        'desk_screening' => 'Tahap Desk Screening',
        'review'         => 'Tahap Review',
        'edit'           => 'Tahap Editorial',
        'layout'         => 'Tahap Layout',
        'proofread'      => 'Tahap Proofread',
        'cetak'          => 'Tahap Cetak',
        'final'          => 'Final',
        'reject'         => 'Ditolak',
        'error'          => 'Draft Error',
    ];
}

$per_page_options = [
    '10'  => '10',
    '25'  => '25',
    '50'  => '50',
    '100' => '100',
];

$reprint_options = [
    ''  => '- Filter Naskah -',
    'n' => ' Naskah Baru',
    'y' => ' Naskah Cetak Ulang',
];
?>
<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item active">
            <a class="text-muted">Draft</a>
         </li>
      </ol>
   </nav>
   <div class="d-flex justify-content-between align-items-center">
      <div>
         <h1 class="page-title"> Draft Usulan </h1>
         <span class="badge badge-info">Total : <?=$total;?></span>
      </div>
      <a
         href="<?=base_url("$pages/add");?>"
         class="btn btn-primary btn-sm <?=!is_admin() ? 'd-none' : '';?>"
      ><i class="fa fa-plus fa-fw"></i> Tambah</a>
   </div>
</header>

<div class="page-section">
   <div class="row">
      <div class="col-12">
         <section class="card card-fluid">
            <div class="card-body p-0">
               <div class="p-3">
                  <?php if ($progress == 'error'): ?>
                  <div
                     class="alert alert-danger alert-dismissible fade show"
                     role="alert"
                  >
                     <p class="m-0">Lakukan penyesuaian draft berikut agar tidak terjadi error progress, dengan cara
                        masuk ke menu edit manual lalu sesuaikan progress dan tanggalnya. Selain itu dapat juga direset
                        dengan mengosongi isian pada <em>halaman edit</em>, lalu memulai progress dengan benar di
                        <em>halaman view</em>.</p>
                     <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-label="Close"
                     >
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <?php endif; // filter error?>
                  <?=form_open('draft/filter', ['method' => 'GET']);?>
                  <div class="row">
                     <div class="col-12 col-lg-1 mb-3">
                        <?=form_dropdown('per_page', $per_page_options, $per_page, 'id="per_page" class="form-control custom-select d-block" title="List per page"');?>
                     </div>
                     <?php if ($level == 'superadmin'): ?>
                     <div class="col-12 col-lg-3 mb-3">
                        <?=form_dropdown('reprint', $reprint_options, $this->input->get('reprint'), 'id="reprint" class="form-control custom-select d-block" title="Filter Naskah"');?>
                     </div>
                     <div class="col-12 col-lg-3 mb-3">
                        <?=form_dropdown('progress', $filter_status, $progress, 'id="progress" class="form-control custom-select d-block" title="Filter Progress"');?>
                     </div>
                     <div class="col-12 col-lg-3 mb-3">
                        <?=form_dropdown('category', getDropdownListCategory('category', ['category_id', 'category_name'], true), $this->input->get('category'), '" id="category" class="form-control custom-select d-block "');?>
                     </div>
                     <?php else: ?>
                     <div class="col-12 col-lg-9 mb-3">
                        <?=form_dropdown('progress', $filter_status, $progress, ' id="progress" class="form-control custom-select d-block" title="Filter status"');?>
                     </div>
                     <?php endif;?>
                     <div class="col-12 col-lg-2 mb-3">
                        <button
                           class="btn btn-primary btn-block ml-auto"
                           type="submit"
                           value="Submit"
                        ><i class="fa fa-filter"></i> Filter</button>
                     </div>
                  </div>
                  <?=form_close();?>
                  <div class="row">
                     <div class="col-12">
                        <?=form_open('draft/search', ['method' => 'GET']);?>
                        <?php $placeholder = ($level == 'superadmin') ? 'placeholder="Cari berdasarkan Judul, Kategori, atau Tema" class="form-control"' : 'placeholder="Enter Title" class="form-control"';?>
                        <div class="input-group input-group-alt">
                           <?=form_input('keywords', $keywords, $placeholder);?>
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
                  </div>
               </div>
               <?php if ($drafts): ?>
               <div class="double-scroll">
                  <table class="table table-striped mb-0">
                     <thead>
                        <tr>
                           <th
                              scope="col"
                              class="pl-3"
                           >No</th>
                           <th
                              scope="col"
                              style="min-width:350px;"
                           >Judul</th>
                           <th
                              scope="col"
                              style="min-width:220px;"
                           >Kategori</th>
                           <th
                              scope="col"
                              style="min-width:50px;"
                           >Tahun</th>
                           <?php if ($level != 'reviewer'): ?>
                           <th
                              scope="col"
                              style="min-width:150px;"
                           >Penulis</th>
                           <?php endif;?>
                           <th
                              scope="col"
                              style="max-width:100px;"
                           >Tanggal Masuk</th>
                           <th
                              scope="col"
                              style="min-width:130px;"
                           >Status</th>
                           <?php if ($level == 'reviewer' or $level == 'editor' or $level == 'layouter'): ?>
                           <th scope="col">Sisa Waktu</th>
                           <?php endif;?>
                           <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                           <th style="min-width:170px;"> &nbsp; </th>
                           <?php else: ?>
                           <th scope="col"> Aksi </th>
                           <?php endif;?>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($drafts as $draft):
    $authors = '';
    foreach ($draft->author as $key => $value) {
        $authors .= $value->author_name;
        $authors .= '<br>';
    }
    $authors = substr($authors, 0, -2);
    ?>
                        <tr>
                           <td class="align-middle pl-3">
                              <?=++$i;?>
                           </td>
                           <td class="align-middle"><strong><a
                                    href="<?=base_url('draft/view/' . $draft->draft_id . '');?>"
                                 >
                                    <?=($draft->is_reprint == 'y') ? '<span class="badge badge-warning"><i class="fa fa-redo " data-toggle="tooltip" title="Cetak Ulang"></i></span>' : '';?>
                                    <?=$draft->draft_title;?></a></strong></td>
                           <td class="align-middle">
                              <?=$draft->category_name;?>
                           </td>
                           <td class="align-middle">
                              <?=$draft->category_year;?>
                           </td>
                           <?php if ($level != 'reviewer'): ?>
                           <td class="align-middle">
                              <?=isset($draft->author[0]->author_name) ? $draft->author[0]->author_name : '-';?>
                           </td>
                           <?php endif;?>
                           <td class="align-middle">
                              <?=konversiTanggal($draft->entry_date);?>
                           </td>
                           <td class="align-middle">
                              <?php
if ($level == 'reviewer') {
    if ($draft->review_flag != '') {
        echo '<span class="badge badge-success">Sudah direview</span>';
    } else {
        echo '<span class="badge badge-danger">Belum direview</span>';
    }
} else {
    echo $draft->draft_status;
}
?>
                           </td>
                           <?php if ($level == 'reviewer'): ?>
                           <td class="align-middle">
                              <?php
$sisa_waktu = ceil((strtotime($draft->deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
if ($sisa_waktu <= 0 and $draft->review_flag == '') {
    echo '<span class="font-weight-bold text-danger" ><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>';
} elseif ($sisa_waktu <= 0 and $draft->review_flag != '') {
    echo '-';
} else {
    echo $sisa_waktu . ' hari';
}
?>
                           </td>
                           <?php elseif ($level == 'editor'): ?>
                           <td class="align-middle">
                              <?php
if (konversiTanggal($draft->edit_start_date) == '-') {
    echo 'Belum Mulai';
} elseif (konversiTanggal($draft->edit_end_date) != '-') {
    echo 'Selesai';
} else {
    $sisa_waktu = ceil((strtotime($draft->edit_deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
    if ($sisa_waktu <= 0 and $draft->edit_notes == '') {
        echo '<span class="font-weight-bold text-danger" ><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>';
    } elseif ($sisa_waktu <= 0 and $draft->edit_notes != '') {
        echo '-';
    } else {
        echo $sisa_waktu . ' hari';
    }
}

?>
                           </td>
                           <?php elseif ($level == 'layouter'): ?>
                           <td class="align-middle">
                              <?php
if (konversiTanggal($draft->layout_start_date) == '-') {
    echo 'Belum Mulai';
} elseif (konversiTanggal($draft->layout_end_date) != '-') {
    echo 'Selesai';
} else {
    $sisa_waktu = ceil((strtotime($draft->layout_deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
    if ($sisa_waktu <= 0 and $draft->layout_notes == '') {
        echo '<span class="font-weight-bold text-danger" ><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>';
    } elseif ($sisa_waktu <= 0 and $draft->layout_notes != '') {
        echo '-';
    } else {
        echo $sisa_waktu . ' hari';
    }
}

?>
                           </td>
                           <?php else: ?>
                           <?php $sisa_waktu = 1;
$draft->review_flag                          = true;?>
                           <?php endif;?>
                           <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                           <td class="align-middle text-right">
                              <a
                                 title="View"
                                 href="<?=base_url('draft/view/' . $draft->draft_id . '');?>"
                                 class="btn btn-sm btn-secondary"
                              >
                                 <i class="fa fa-eye"></i> View
                                 <span class="sr-only">View</span>
                              </a>
                              <a
                                 title="Edit"
                                 href="<?=base_url('draft/edit/' . $draft->draft_id . '');?>"
                                 class="btn btn-sm btn-secondary"
                              >
                                 <i class="fa fa-pencil-alt"></i>
                                 <span class="sr-only">Edit</span>
                              </a>
                              <button
                                 title="Delete"
                                 type="button"
                                 class="btn btn-sm btn-danger"
                                 data-toggle="modal"
                                 data-target="#modal-hapus-<?=$draft->draft_id;?>"
                              ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                              <div class="text-left">
                                 <div
                                    class="modal modal-alert fade"
                                    id="modal-hapus-<?=$draft->draft_id;?>"
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
                                             <p>Apakah anda yakin akan menghapus buku <span class="font-weight-bold">
                                                   <?=$draft->draft_title;?></span>?</p>
                                          </div>
                                          <div class="modal-footer">
                                             <button
                                                type="button"
                                                class="btn btn-danger"
                                                onclick="location.href='<?=base_url('draft/delete/' . $draft->draft_id . '');?>'"
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
                           <?php else: ?>
                           <td class="align-middle">
                              <a
                                 title="View"
                                 href="<?=base_url('draft/view/' . $draft->draft_id . '');?>"
                                 class="btn btn-sm btn-secondary"
                              >
                                 <i class="fa fa-eye"></i> View
                                 <span class="sr-only">View</span>
                              </a>

                           </td>
                           <?php endif;?>
                        </tr>


                        <?php endforeach;?>
                     </tbody>
                  </table>
               </div>

               <?php else: ?>
               <p class="text-center">Data tidak tersedia</p>
               <?php endif;?>
               <?php if ($pagination): ?>
               <?=$pagination;?>
               <?php else: ?>
               &nbsp;
               <?php endif;?>
            </div>
         </section>
      </div>
   </div>
</div>


<script type="text/javascript">
$(document).ready(function() {
   doublescroll();
   $("#category").select2({
      placeholder: '-- Semua --',
      allowClear: true
   });
   $("#progress").select2({
      placeholder: '-- Filter Progress --',
      allowClear: true
   });
   $("#reprint").select2({
      placeholder: '-- Filter Naskah --',
      allowClear: true
   });
});
</script>