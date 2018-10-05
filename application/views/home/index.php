<?php
$username = $this->session->userdata('username');
$is_login = $this->session->userdata('is_login');
$ceklevel    = $this->session->userdata('level');
$semua    = $this->session->userdata();
?>
<!-- .page-title-bar -->
<header class="page-title-bar">
  <!-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <a class="text-muted"><span class="fa fa-home"></span> Admin Panel</a>
      </li>
    </ol>
  </nav> -->
  <h1 class="page-title"> Dashboard </h1>
  <p class="lead">
    <span class="font-weight-bold">Hi, <?=$username ?>.</span>
    <span class="d-block text-muted">Selamat bekerja dan semoga harimu menyenangkan.</span>
  </p>
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
    <!-- .section-block -->
    <div class="section-block">
      <!-- metric row -->
      <div class="metric-row">
        <div class="col-12">
          <div class="metric-row metric-flush">
            <!-- metric column -->
            <div class="col">
              <!-- .metric -->
              <a href="<?=base_url('category') ?>" class="metric metric-bordered align-items-center">
                <h2 class="metric-label"> Kategori </h2>
                <p class="metric-value h3">
                  <sub>
                    <i class="fa fa-list-alt"></i>
                  </sub>
                  <span class="value"><?=$tot_category ?></span>
                </p>
              </a>
              <!-- /.metric -->
            </div>
            <!-- /metric column -->
            <!-- metric column -->
            <div class="col">
              <!-- .metric -->
              <a href="<?=base_url('draft') ?>" class="metric metric-bordered align-items-center">
                <h2 class="metric-label"> Draft </h2>
                <p class="metric-value h3">
                  <sub>
                    <i class="fa fa-paperclip"></i>
                  </sub>
                  <span class="value"><?=$tot_draft ?></span>
                </p>
              </a>
              <!-- /.metric -->
            </div>
            <!-- /metric column -->
            <!-- metric column -->
            <div class="col">
              <!-- .metric -->
              <a href="<?=base_url('book') ?>" class="metric metric-bordered align-items-center">
                <h2 class="metric-label"> Buku </h2>
                <p class="metric-value h3">
                  <sub>
                    <i class="fa fa-book"></i>
                  </sub>
                  <span class="value"><?=$tot_book ?></span>
                </p>
              </a>
              <!-- /.metric -->
            </div>
            <!-- /metric column -->
            <!-- metric column -->
            <div class="col">
              <!-- .metric -->
              <a href="<?=base_url('author') ?>" class="metric metric-bordered align-items-center">
                <h2 class="metric-label"> Penulis </h2>
                <p class="metric-value h3">
                  <sub>
                    <i class="fa fa-users"></i>
                  </sub>
                  <span class="value"><?=$tot_author ?></span>
                </p>
              </a>
              <!-- /.metric -->
            </div>
            <!-- /metric column -->
            <!-- metric column -->
            <div class="col">
              <!-- .metric -->
              <a href="<?=base_url('reviewer') ?>" class="metric metric-bordered align-items-center">
                <h2 class="metric-label"> Reviewer </h2>
                <p class="metric-value h3">
                  <sub>
                    <i class="fa fa-university"></i>
                  </sub>
                  <span class="value"><?=$tot_reviewer ?></span>
                </p>
              </a>
              <!-- /.metric -->
            </div>
            <!-- /metric column -->
          </div>
        </div>
      </div>
      <!-- /metric row -->
      <!-- metric row -->
      <div class="metric-row">
        <div class="col-12">
          <div class="metric-row metric-flush">
            <!-- metric column -->
            <div class="col">
              <!-- .metric -->
              <a href="#" class="metric metric-bordered align-items-center">
                <div class="metric-badge">
                  <span class="badge badge-lg badge-success">
                    <span class="oi oi-media-record pulse mr-1"></span> REVIEW</span>
                  </div>
                  <p class="metric-value h3">
                    <sub>
                      <i class="fa fa-tasks"></i>
                    </sub>
                    <span class="value"><?=$tot_draft ?></span>
                  </p>
                </a>
                <!-- /.metric -->
              </div>
              <!-- /metric column -->
              <!-- metric column -->
              <div class="col">
                <!-- .metric -->
                <a href="#" class="metric metric-bordered align-items-center">
                  <div class="metric-badge">
                    <span class="badge badge-lg badge-success">
                      <span class="oi oi-media-record pulse mr-1"></span> EDITORIAL</span>
                    </div>
                    <p class="metric-value h3">
                      <sub>
                        <i class="fa fa-tasks"></i>
                      </sub>
                      <span class="value"><?=$tot_author ?></span>
                    </p>
                  </a>
                  <!-- /.metric -->
                </div>
                <!-- /metric column -->
                <!-- metric column -->
                <div class="col">
                  <!-- .metric -->
                  <a href="#" class="metric metric-bordered align-items-center">
                    <div class="metric-badge">
                      <span class="badge badge-lg badge-success">
                        <span class="oi oi-media-record pulse mr-1"></span> LAYOUT</span>
                      </div>
                      <p class="metric-value h3">
                        <sub>
                          <i class="fa fa-tasks"></i>
                        </sub>
                        <span class="value"><?=$tot_reviewer ?></span>
                      </p>
                    </a>
                    <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                    <!-- .metric -->
                    <a href="#" class="metric metric-bordered align-items-center">
                      <div class="metric-badge">
                        <span class="badge badge-lg badge-success">
                          <span class="oi oi-media-record pulse mr-1"></span> PROOFREAD</span>
                        </div>
                        <p class="metric-value h3">
                          <sub>
                            <i class="fa fa-tasks"></i>
                          </sub>
                          <span class="value"><?=$tot_category ?></span>
                        </p>
                      </a>
                      <!-- /.metric -->
                    </div>
                    <!-- /metric column -->
                  </div>
                </div>
              </div>
              <!-- /metric row -->
            </div>
            <!-- /.section-block -->
            <!-- grid row -->
            <div class="row">
              <!-- grid column -->
              <div class="col-12 col-lg-12 col-xl-4">
                <!-- .card -->
                <section class="card card-fluid">
                  <!-- .card-body -->
                  <div class="card-body">
                    <!-- .d-flex -->
                    <div class="d-flex align-items-center mb-3">
                      <h3 class="card-title mr-auto"> Data 1 </h3>
                    </div>
                    <!-- /.d-flex -->
                  </div>
                  <!-- /.card-body -->
                </section>
                <!-- /.card -->
              </div>
              <!-- /grid column -->
            </div>
            <!-- /grid row -->
          <?php endif ?>
          <!-- untuk level reviewer -->
          <?php if ($ceklevel == 'reviewer'): ?>
            <!-- .section-block -->
            <div class="section-block">
              <!-- metric row -->
              <div class="metric-row">
                <!-- metric column -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <!-- .metric -->
                  <div class="card-metric">
                    <div class="metric">
                      <div class="metric-badge">
                        <span class="badge badge-lg badge-info">TOTAL REVIEW</span>
                        </div>
                        <p class="metric-value h3">
                          <sub>
                            <i class="fa fa-tasks"></i>
                          </sub>
                          <span class="value"><?=$count['count_total'] ?></span>
                        </p>
                      </div>
                    </div>
                    <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <!-- .metric -->
                  <div class="card-metric">
                    <div class="metric">
                      <div class="metric-badge">
                        <span class="badge badge-lg badge-success">SUDAH DIREVIEW</span>
                        </div>
                        <p class="metric-value h3">
                          <sub>
                            <i class="fa fa-tasks"></i>
                          </sub>
                          <span class="value"><?=$count['count_sudah'] ?></span>
                        </p>
                      </div>
                    </div>
                    <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <!-- .metric -->
                  <div class="card-metric">
                    <div class="metric">
                      <div class="metric-badge">
                        <span class="badge badge-lg badge-danger">BELUM REVIEW</span>
                        </div>
                        <p class="metric-value h3">
                          <sub>
                            <i class="fa fa-tasks"></i>
                          </sub>
                          <span class="value"><?=$count['count_belum'] ?></span>
                        </p>
                      </div>
                    </div>
                    <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <!-- .metric -->
                  <div class="card-metric">
                    <div class="metric">
                      <div class="metric-badge">
                        <span class="badge badge-lg badge-warning">SEDANG REVIEW</span>
                        </div>
                        <p class="metric-value h3">
                          <sub>
                            <i class="fa fa-tasks"></i>
                          </sub>
                          <span class="value"><?=$count['count_sedang'] ?></span>
                        </p>
                      </div>
                    </div>
                    <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                </div>
                <!-- /metric row -->
                <!-- grid row -->
            <div class="row">
              <!-- grid column -->
              <div class="col-12">
                <!-- .card -->
                <section class="card card-fluid">
                  <!-- .card-header -->
                    <header class="card-header border-0">
                      <!-- .d-flex -->
                      <div class="d-flex align-items-center">
                        <span class="mr-auto">Draft Terbaru Untuk Direview</span>
                      </div>
                      <!-- /.d-flex -->
                    </header>
                    <!-- /.card-header -->
                  <!-- .table-responsive -->
                  <?php if ($drafts_newest):?>
                  <div class="table-responsive table-striped">
                    <!-- .table -->
                    <table class="table">
                      <!-- thead -->
                      <thead>
                        <tr>
                          <th scope="col">Judul</th>
                          <th scope="col">Tanggal masuk</th>
                          <th scope="col">Deadline Review</th>
                          <th scope="col">Sisa Waktu</th>
                        </tr>
                      </thead>
                      <!-- /thead -->
                      <!-- tbody -->
                      <tbody>
                        <?php foreach($drafts_newest as $draft):?>
                        <!-- tr -->
                        <tr>
                          <td class="align-middle"><?= $draft->draft_title ?></td>
                          <td class="align-middle"><?= $draft->entry_date ?></td>
                          <td class="align-middle"><?= $draft->deadline ?></td>
                          <td class="align-middle">
                            <?php
                            $sisa_waktu = round((strtotime($draft->deadline)-strtotime(date('Y-m-d H:i:s')))/86400);
                            if($sisa_waktu <= 0){
                              echo '<span class="font-weight-bold" style="color:red">Melebihi Deadline!</span>';
                            }else{
                              echo $sisa_waktu.' hari';
                            }
                            ?>
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
                  <p class="text-center">Data tidak tersedia</p>
                  <?php endif ?>
                  <!-- /.table-responsive -->
                  <!-- .card-footer -->
                  <footer class="card-footer">
                    <a href="<?= base_url('draft') ?>" class="card-footer-item">Lihat selengkapnya
                      <i class="fa fa-fw fa-angle-right"></i>
                    </a>
                  </footer>
                  <!-- /.card-footer -->
                </section>
                <!-- /.card -->
              </div>
              <!-- /grid column -->
            </div>
            <!-- /grid row -->
              </div>
              <!-- /.section-block -->
            <?php endif ?>
          <!-- untuk level reviewer -->
          <?php if ($ceklevel == 'author'): ?>
            <!-- .section-block -->
            <div class="section-block">
              <!-- metric row -->
              <div class="metric-row">
                <!-- metric column -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <!-- .metric -->
                  <div class="card-metric">
                    <div class="metric">
                      <div class="metric-badge">
                        <span class="badge badge-lg badge-info">TOTAL REVIEW</span>
                        </div>
                        <p class="metric-value h3">
                          <sub>
                            <i class="fa fa-tasks"></i>
                          </sub>
                          <span class="value">99</span>
                        </p>
                      </div>
                    </div>
                    <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <!-- .metric -->
                  <div class="card-metric">
                    <div class="metric">
                      <div class="metric-badge">
                        <span class="badge badge-lg badge-success">SUDAH DIREVIEW</span>
                        </div>
                        <p class="metric-value h3">
                          <sub>
                            <i class="fa fa-tasks"></i>
                          </sub>
                          <span class="value">99</span>
                        </p>
                      </div>
                    </div>
                    <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <!-- .metric -->
                  <div class="card-metric">
                    <div class="metric">
                      <div class="metric-badge">
                        <span class="badge badge-lg badge-danger">BELUM REVIEW</span>
                        </div>
                        <p class="metric-value h3">
                          <sub>
                            <i class="fa fa-tasks"></i>
                          </sub>
                          <span class="value">99</span>
                        </p>
                      </div>
                    </div>
                    <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                <div class="col-12 col-sm-6 col-lg-3">
                  <!-- .metric -->
                  <div class="card-metric">
                    <div class="metric">
                      <div class="metric-badge">
                        <span class="badge badge-lg badge-warning">SEDANG REVIEW</span>
                        </div>
                        <p class="metric-value h3">
                          <sub>
                            <i class="fa fa-tasks"></i>
                          </sub>
                          <span class="value">99</span>
                        </p>
                      </div>
                    </div>
                    <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                </div>
                <!-- /metric row -->
                <!-- grid row -->
            <div class="row">
              <!-- grid column -->
              <div class="col-12">
                <!-- .card -->
                <section class="card card-fluid">
                  <!-- .card-header -->
                    <header class="card-header border-0">
                      <!-- .d-flex -->
                      <div class="d-flex align-items-center">
                        <span class="mr-auto">Daftar Kategori</span>
                      </div>
                      <!-- /.d-flex -->
                    </header>
                    <!-- /.card-header -->
                  <!-- .table-responsive -->
                  <?php if ($categories):?>
                  <div class="table-responsive table-striped">
                    <!-- .table -->
                    <table class="table">
                      <!-- thead -->
                      <thead>
                        <tr>
                          <th scope="col" style="min-width: 150px;max-width: 150px">Kategori</th>
                          <th scope="col" style="min-width: 250px;max-width: 400px">Keterangan</th>
                          <th scope="col" style="min-width: 120px;max-width: 150px">Tanggal Buka</th>
                          <th scope="col" style="min-width: 120px;max-width: 150px">Tanggal tutup</th>
                          <th scope="col" style="min-width: 100px;max-width: 100px">Sisa Waktu</th>
                          <th scope="col">Aksi</th>
                        </tr>
                      </thead>
                      <!-- /thead -->
                      <!-- tbody -->
                      <tbody>
                        <?php foreach($categories as $category):?>
                        <!-- tr -->
                        <tr>
                          <td class="align-middle"><?= $category->category_name ?></td>
                          <td class="align-middle"><?= $category->category_note ?></td>
                          <td class="align-middle"><?= $category->date_open ?></td>
                          <td class="align-middle"><?= $category->date_close ?></td>
                          <td class="align-middle">
                            <?php
                            $sisa_waktu = round((strtotime($category->date_close)-strtotime(date('Y-m-d H:i:s')))/86400);
                            if($sisa_waktu <= 0){
                              echo '<span style="color:red">Berakhir</span>';
                            }else{
                              echo $sisa_waktu.' hari';
                            }
                            ?>
                          </td>
                          <td class="align-middle"><?= ($category->category_status == 'y')? '<a class="btn btn-success btn-xs" href="'.base_url('draft/add/'.$category->category_id).'">Daftar</a>' : '' ?></td>
                        </tr>
                        <!-- /tr -->
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
                </section>
                <!-- /.card -->
              </div>
              <!-- /grid column -->
            </div>
            <!-- /grid row -->
              </div>
              <!-- /.section-block -->

    
          <?php endif ?>
          </div>
          <!-- /.page-section -->