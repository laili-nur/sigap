<?php
    $perPage = 10;
    $keywords = $this->input->get('keywords');

    if (isset($keywords)) {
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
          <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>">Penerbitan</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted">Draft</a>
        </li>
      </ol>
    </nav> 
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
              <span class="mr-auto">Tabel Draft <span class="text-muted">(<?=$total ?>)</span></span>
              <!-- .card-header-control -->
              <div class="card-header-control">
                <!-- .tombol add -->
                <a href="<?=base_url('draft/add') ?>" class="btn btn-primary btn-sm">Tambah Draft</a>
                <!-- /.tombol add -->
              </div>
              <!-- /.card-header-control -->
            </div>
            <!-- /.d-flex -->
          </header>
            <!-- /.card-header -->
           <!-- .card-body -->
          <div class="card-body p-0">
            <div class="p-3">
              <!-- .input-group -->
              <?= form_open('draft/search', ['method' => 'GET']) ?>
              <div class="input-group input-group-alt">
                <?= form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Enter Category, Theme, or Title', 'class' => 'form-control']) ?>
                <div class="input-group-append">
                   <?= form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']) ?>
                </div>
              <?= form_close() ?>
              </div>
              <!-- /.input-group -->
            </div>
            <!-- .table-responsive -->
            <?php if ($drafts):?>
            <div class="table-responsive">
              <!-- .table -->
              <table class="table">
                <!-- thead -->
                <thead>
                  <tr>
                    <th scope="col" class="pl-4">No</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Theme Name</th>
                    <th scope="col">Draft Title</th>
                    <th scope="col">Entry Date</th>
                    <th style="width:100px; min-width:100px;"> &nbsp; </th>
                  </tr>
                </thead>
                <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($drafts as $draft): ?>
                  <!-- tr -->
                  <tr>
                    <td class="align-middle pl-4"><?= ++$i ?></td>
                    <td class="align-middle"><?= $draft->category_name ?></td>
                    <td class="align-middle"><?= $draft->theme_name ?></td>
                    <td class="align-middle"><a href="<?= base_url('draft/view/'.$draft->draft_id) ?>"><?= $draft->draft_title ?></a></td>
                    <td class="align-middle"><?= $draft->entry_date ?></td>
                    <td class="align-middle text-right">
                      <a href="<?= base_url('draft/edit/'.$draft->draft_id.'') ?>" class="btn btn-sm btn-secondary">
                        <i class="fa fa-pencil-alt"></i>
                        <span class="sr-only">Edit</span>
                      </a>
                      <a href="<?= base_url('draft/delete/'.$draft->draft_id.'') ?>" class="btn btn-sm btn-danger">
                        <i class="fa fa-trash-alt"></i>
                        <span class="sr-only">Edit</span>
                      </a>
                    </td>
                  </tr>
                  <!-- /tr -->
                  <?php endforeach ?>
                </tbody>
                <!-- /tbody -->
              </table>
              <!-- /.table -->
            </div>
            <?php else: ?>
                <p>Draft data were not available</p>
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
          <!-- .card-footer -->
            <footer class="card-footer bg-light">
              <div class="card-footer-content">
                <a href="<?=base_url('category') ?>" class="btn btn-secondary mr-2">Kategori</a>
                  <a href="<?=base_url('theme') ?>" class="btn btn-secondary mr-2">Tema</a>
              </div>
            </footer>
          <!-- /.card-footer -->
        </section>
        <!-- /.card -->
      </div>
      <!-- /grid column -->
    </div>
    <!-- /grid row -->
  </div>
  <!-- /.page-section -->
