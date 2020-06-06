<style type="text/css">
  .belum-dibaca a{
    color: red;
  }
  .highlight a{
    color: #FFC107;
  }
</style>
<?php $ceklevel = $this->session->userdata('level'); ?>
<?php
$perPage = $this->input->get('per_page');
if (empty($perPage)) {
  $perPage = 10;
}
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
        <a class="text-muted"><span class="fa fa-bell"></span> Notifikasi</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Notifikasi</h1>
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
        <header class="card-header">
          <!-- .d-flex -->
          <div class="d-flex">
            <?php if($total>0){ ?>
              <span>Total Notifikasi <span class="badge badge-danger">
                <?= $total ?></span></span>
            <?php } ?>
            &nbsp;
            <?php if($total_highlight>0){ ?>
              <span>Di Tandai <span class="badge badge-warning">
                <?= $total_highlight ?></span></span>
            <?php } ?>
            <!-- /.card-header-control -->
          </div>
          <!-- /.d-flex -->
        </header>
        <!-- /.card-header -->
        <?php
        /*==================================================
        =            Pilihan dropdown per level            =
        ==================================================*/
        $filter_status = [
            ' ' => '- Filter Notifikasi -',
            'belum dibaca' => ' Belum Dibaca',
            'highlight' => ' Di Highlight',
        ];

        $per_page = [
          '10' => '10',
          '25' => '25',
          '50' => '50',
          '100' => '100',
        ];
        ?>
        <!-- .card-body -->
        <div class="card-body p-0">
          <div class="p-3">
            <?php if($this->input->get('filter') == 'error'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <p class="m-0">note <em>halaman view</em>.</p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif ?>
            <div class="row">
              <div class="col-12">
                <?= form_open('notifikasi/searchs', ['method' => 'GET']) ?>
                <?php $placeholder = 'placeholder="Cari Notifikasi" class="form-control"'; ?>
                <div class="input-group input-group-alt">
                  <?= form_input('keywords', $this->input->get('keywords'), $placeholder) ?>
                  <div class="input-group-append">
                    <?= form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']) ?>
                  </div>
                  <?= form_close() ?>
                </div>
              </div>
            </div>
          </div>
          <!-- .table-responsive -->
          <?php if ($notifikasi):?>
          <div class="double-scroll">
            <!-- .table -->
            <table class="table table-striped">
              <!-- thead -->
              <thead>
                <tr>
                  <th scope="col" class="pl-3">No</th>
                  <th scope="col" style="min-width:220px;">Tgl</th>
                  <th scope="col" style="min-width:350px;">Judul</th>
                  <th scope="col" style="min-width:220px;">Isi</th>                  
                  <th scope="col" style="min-width:100px;"> Tandai </th>
                </tr>
              </thead>
              <!-- /thead -->
              <!-- tbody -->
              <tbody>
                <?php foreach($notifikasi as $notif): ?>
                  <?php mark_read($notif->id); ?>
                <!-- tr -->
                <tr class="belum-dibaca" <?php echo $notif->is_mark==1?'style="color: #FFC107;font-weight:bold;"':'style="color: #000;"'; ?>>
                  <td class="align-middle pl-3">
                    <?= ++$i ?>
                  </td>
                  <td class="align-middle">
                    <?php echo date('d/m/Y H:i:s', strtotime($notif->tgl)); ?>
                  </td>
                  <td class="align-middle"><?php echo $notif->judul; ?></td>
                  <td class="align-middle">
                    <?php echo $notif->isi; ?>
                  </td>
                  <td class="align-middle text-center">
                    <?php if($notif->is_mark == 1){ ?>

                        <button title="Hilangkan Tanda" type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalhapus-<?= $notif->id ?>"><i
                        class="fa fa-trash" style="color: red;"></i><span class="sr-only">Hilangkan Tanda</span></button>
                          <div class="text-left" style="color: #a0a0a0;">
                            <!-- Alert Danger Modal -->
                            <div class="modal modal-alert fade" id="modalhapus-<?= $notif->id ?>" tabindex="-1" role="dialog"
                              aria-labelledby="modalhapus" aria-hidden="true">
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
                                    <p>Apakah anda yakin akan menghilangkan tanda notifikasi <span class="font-weight-bold">
                                        "<?= $notif->judul ?> : <?= $notif->isi; ?>", jika iya maka notifikasi tidak akan tampil lagi</span>?</p>
                                  </div>
                                  <!-- /.modal-body -->
                                  <!-- .modal-footer -->
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('notifikasi/tandai_hapus/' . $notif->id . '') ?>'"
                                      data-dismiss="modal">Hapus</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                  </div>
                                  <!-- /.modal-footer -->
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                          </div>
                    <?php }else{ ?>
                        <a title="Tandai" href="<?= base_url('notifikasi/tandai/'.$notif->id) ?>" class="btn btn-sm btn-secondary">
                          <i class="fa fa-star" style="color: orange;"></i>
                          <span class="sr-only">Tandai</span>
                        </a>
                    <?php } ?>
                  </td>
                </tr>
                <?php endforeach ?>

                <!-- /tr -->
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
          <?php if ($pagination) : ?>
          <?= $pagination ?>
          <?php else : ?>
          &nbsp;
          <?php endif ?>
          <!-- .pagination -->
        </div>
      </section>
      <!-- /.card -->
    </div>
    <!-- /grid column -->
  </div>
  <!-- /grid row -->
</div>
<!-- /.page-section -->


<script type="text/javascript">
  $(document).ready(function () {
    doublescroll();
    $("#category").select2({
      placeholder: '-- Semua --',
      allowClear: true
    });
    $("#filter").select2({
      placeholder: '-- Filter Progress --',
      allowClear: true
    });
    $("#reprint").select2({
      placeholder: '-- Filter Naskah --',
      allowClear: true
    });
  });
</script>

<?php
function mark_read($id){
  $CI =& get_instance();
  $CI->db->update("notifikasi", array('is_read' => '1'), "id='$id'");
}
?>