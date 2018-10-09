<?php $ceklevel = $this->session->userdata('level'); ?>
<?php
  $perPage = 10;
  $keywords = $this->input->get('keywords');
  $filter = $this->input->get('filter');
  if (isset($keywords) or isset($filter)) {
    $page = $this->uri->segment(3);
  } else {
    $page = $this->uri->segment(2);
  }
  // data table series number
  $i = isset($page) ? $page * $perPage - $perPage : 0;
?>
<!-- .page-title-bar -->
<header class="page-title-bar">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>"><span class="fa fa-home"></span></a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>">Penerbitan</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-muted">Draft</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Draft Usulan</h1>
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <!-- grid row -->
  <div class="row">
    <!-- grid column -->
    <div class="col-12">
      <!-- .card -->
      <section class="card card-fluid">
        <!-- .card-header -->
        <header class="card-header bg-light">
          <!-- .d-flex -->
          <div class="d-flex align-items-center">
            <span class="mr-auto">Tabel Draft <span class="badge badge-info"><?=$total ?></span></span>
            <!-- .card-header-control -->
            <div class="card-header-control">
              <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
              <!-- .tombol add -->
              <a href="<?=base_url('draft/add') ?>" class="btn btn-primary btn-sm">Tambah Draft</a>
              <!-- /.tombol add -->
              <?php endif ?>
            </div>
            <!-- /.card-header-control -->
          </div>
          <!-- /.d-flex -->
        </header>
        <!-- /.card-header -->
        <?php 
        $filter_status = [
          'all' => '- Filter Tahapan -',
          'desk-screening' => ' Tahap Desk Screening',
          'review' => ' Tahap Review',
          'edit' => 'Tahap Editorial',
          'layout' => 'Tahap Layout',
          'proofread' => 'Tahap Proofread',
          'reject' => 'Draft Ditolak',
          'final' => 'Draft Final',
        ]
         ?>
        <!-- .card-body -->
        <div class="card-body p-0">
          <div class="p-3">
            <div class="row">
              <?php if($ceklevel=='superadmin'): ?>
              <div class="col-12 col-md-3 mb-3">
                <?= form_open('draft/filter', ['method' => 'GET']) ?>
                  <?= form_dropdown('filter', $filter_status, $this->input->get('filter'), 'onchange="this.form.submit()" id="filter" class="form-control custom-select d-block"') ?>
                  <?= form_close() ?>
              </div>
              <?php endif ?>
              <div class="col-12 <?=($ceklevel=='superadmin')?'col-md-9':'' ?> ">
                <?= form_open('draft/search', ['method' => 'GET']) ?>
                <!-- .input-group -->
                <div class="input-group input-group-alt">
                  <?= form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Enter Category, Theme, or Title', 'class' => 'form-control']) ?>
                  <div class="input-group-append">
                    <?= form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']) ?>
                  </div>
                  <?= form_close() ?>
                </div>
              </div>
            </div>
            <!-- /.input-group -->
          </div>
          <!-- .table-responsive -->
          <?php if ($drafts):?>
          <div class="table-responsive">
            <!-- .table -->
            <table class="table nowrap">
              <!-- thead -->
              <thead>
                <tr>
                  <th scope="col" class="pl-4">No</th>
                  <th scope="col">Kategori</th>
                  <?php if($ceklevel!='reviewer'): ?>
                  <th scope="col">Penulis</th>
                  <?php endif ?>
                  <th scope="col">Judul</th>
                  <th scope="col">Tanggal Masuk</th>
                  <th scope="col">Status</th>
                  <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                  <th style="width:100px; min-width:100px;"> &nbsp; </th>
                  <?php else: ?>
                  <th scope="col"> Aksi </th>
                  <?php endif ?>
                </tr>
              </thead>
              <!-- /thead -->
              <!-- tbody -->
              <tbody>
                <?php foreach($drafts as $draft):
                $authors = '';
                foreach ($draft->author as $key => $value) {
                $authors .= $value->author_name;
                $authors .= '<br>';
                }
                $authors = substr($authors, 0, -2);
                ?>
                <!-- tr -->
                <tr>
                  <td class="align-middle pl-4"><?= ++$i ?></td>
                  <td class="align-middle"><?= $draft->category_name ?></td>
                  <?php if($ceklevel!='reviewer'): ?>
                  <td class="align-middle"><?= $draft->author[0]->author_name ?></td>
                  <?php endif ?>
                  <td class="align-middle">
                    <a href="<?= base_url('draft/view/'.$draft->draft_id) ?>"><?= $draft->draft_title ?></a>
                  </td>
                  <td class="align-middle"><?= $draft->entry_date ?></td>                  
                  <td class="align-middle">
                    <?php 
                    if ($ceklevel == 'reviewer'){
                      if($draft->rev == 0){
                        if($draft->review1_flag!=''){
                          echo '<span class="badge badge-success">Sudah direview</span>';
                        }else{
                          if($draft->review1_notes==''){
                            echo '<span class="badge badge-danger">Belum direview</span>';
                          }else{
                            echo '<span class="badge badge-warning">Sedang direview</span>';
                          }
                        }
                      }elseif($draft->rev == 1){
                        if($draft->review2_flag!=''){
                          echo '<span class="badge badge-success">Sudah direview</span>';
                        }else{
                          if($draft->review2_notes==''){
                            echo '<span class="badge badge-danger">Belum direview</span>';
                          }else{
                            echo '<span class="badge badge-warning">Sedang direview</span>';
                          }
                        }
                      }
                    }else{
                      echo $draft->draft_status;
                    } 
                    ?>                      
                  </td>
                  <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                  <td class="align-middle text-right">
                    <a href="<?= base_url('draft/view/'.$draft->draft_id.'') ?>" class="btn btn-sm btn-secondary">
                      <i class="fa fa-eye"></i> View
                      <span class="sr-only">View</span>
                    </a>
                    <a href="<?= base_url('draft/edit/'.$draft->draft_id.'') ?>" class="btn btn-sm btn-secondary">
                      <i class="fa fa-pencil-alt"></i>
                      <span class="sr-only">Edit</span>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#modalhapus-<?= $draft->draft_id ?>"><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                  </td>
                  <?php else: ?>
                  <td class="align-middle">
                    <a href="<?= base_url('draft/view/'.$draft->draft_id.'') ?>" class="btn btn-sm btn-secondary">
                      <i class="fa fa-eye"></i> View
                      <span class="sr-only">View</span>
                    </a>
                  </td>
                  <?php endif ?>
                </tr>
                <!-- /tr -->
                <!-- Alert Danger Modal -->
                <div class="modal modal-alert fade" id="modalhapus-<?= $draft->draft_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalhapus" aria-hidden="true">
                  <!-- .modal-dialog -->
                  <div class="modal-dialog" role="document">
                    <!-- .modal-content -->
                    <div class="modal-content">
                      <!-- .modal-header -->
                      <div class="modal-header">
                        <h5 class="modal-title">
                          <i class="fa fa-exclamation-triangle text-red mr-1"></i> Konfirmasi Hapus</h5>
                      </div>
                      <!-- /.modal-header -->
                      <!-- .modal-body -->
                      <div class="modal-body">
                        <p>Apakah anda yakin akan menghapus buku <span class="font-weight-bold"><?= $draft->draft_title ?></span>?</p>
                      </div>
                      <!-- /.modal-body -->
                      <!-- .modal-footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('draft/delete/'.$draft->draft_id.'') ?>'" data-dismiss="modal">Hapus</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                      </div>
                      <!-- /.modal-footer -->
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <?php endforeach ?>
              </tbody>
              <!-- /tbody -->
            </table>
            <!-- /.table -->
          </div>
          <?php else: ?>
          <p class="text-center">Data tidak tersedia</p>
          <?php endif ?>
          <!-- /.table-responsive -->
          <!-- Pagination -->
          <?php if ($pagination): ?>
          <?= $pagination ?>
          <?php else: ?>
          &nbsp;
          <?php endif ?>
          <!-- .pagination -->
        </div>
        <!-- /.card-body -->
        <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
        <!-- .card-footer -->
        <footer class="card-footer bg-light">
          <div class="card-footer-content">
            <a href="<?=base_url('category') ?>" class="btn btn-secondary mr-2">Kategori</a>
            <a href="<?=base_url('theme') ?>" class="btn btn-secondary mr-2">Tema</a>
          </div>
        </footer>
        <!-- /.card-footer -->
        <?php endif ?>
      </section>
      <!-- /.card -->
    </div>
    <!-- /grid column -->
  </div>
  <!-- /grid row -->
</div>
<!-- /.page-section -->

<!-- <script>
  $(document).ready(function() {
    //filter status
    $('#btn-filter-status').on('click',function(){
        //var $this = $(this);
        // $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('#filter_status').val();
        console.log(id);
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/filterdraft') ?>",
          datatype : "JSON",
          data : {
            filter_status : id
          },
          success :function(data){
            let datax = JSON.parse(data);
            console.log(datax)
          }
        });
        return false;
      });
  })
</script> -->