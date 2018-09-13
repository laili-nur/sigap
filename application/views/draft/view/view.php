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
          <a href="<?=base_url('draft')?>">Draft</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted"><?= $input->draft_title ?></a>
        </li>
      </ol>
    </nav> 
  </header>
  <!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <div class="d-xl-none">
    <button class="btn btn-danger btn-floated" type="button" data-toggle="sidebar">
      <i class="fa fa-th-list"></i>
    </button>
  </div>
  <!-- .card -->
  <section id="data-draft" class="card">
    <!-- .card-header -->
    <header class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link active show" data-toggle="tab" href="#data-drafts">Data Draft</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#data-penulis">Data Penulis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#data-reviewer">Data Reviewer</a>
        </li>
      </ul>
    </header>
    <!-- /.card-header -->
    <!-- .card-body -->
    <div class="card-body">
    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
    <!-- .tab-content -->
      <div id="myTabCard" class="tab-content">
        <div class="tab-pane fade active show" id="data-drafts">
          <!-- .table-responsive -->
        <div class="table-responsive">
          <!-- .table -->
          <table class="table table-striped table-bordered mb-0">
            <!-- tbody -->
            <tbody>
              <!-- tr -->
              <tr>
                <td width="200px"> Kategori </td>
                <td>: <?= konversiID('category','category_id', $input->category_id)->category_name;?> </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Tema </td>
                <td>: <?= konversiID('theme','theme_id', $input->theme_id)->theme_name;?> </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Judul Draft </td>
                <td>: <strong><?= $input->draft_title ?></strong> </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> File Draft </td>
                <td>: <?= $input->draft_file ?> </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Dana yang diajukan </td>
                <td>: <?= $input->proposed_fund ?>  </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Dana yang disetujui </td>
                <td>: <?= $input->approved_fund ?>  </td>
              </tr>
              <!-- /tr -->
            </tbody>
            <!-- /tbody -->
          </table>
          <!-- /.table -->
        </div>
        <!-- /.table-responsive -->
        </div>
        <div class="tab-pane fade" id="data-penulis">
          <div class="form-group">
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#pilihpenulis">Pilih Penulis</button>
          </div>
          <?php if ($authors):?>
          <?php $i=1; ?>
          <!-- .table-responsive -->
            <div class="table-responsive">
              <!-- .table -->
              <table class="table table-striped table-bordered mb-0">
                <!-- thead -->
                        <thead>
                          <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Unit Kerja</th>
                            <th scope="col">Institusi</th>
                          </tr>
                        </thead>
                        <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($authors as $author): ?>
                  <!-- tr -->
                  <tr>
                    <td class="align-middle"><?= $i++ ?></td>
                    <td class="align-middle"><a href="<?= base_url('author/profil/'.$author->author_id) ?>"><?= $author->author_name ?></a></td>
                    <td class="align-middle"><?= $author->author_nip ?></td>
                    <td class="align-middle"><?= $author->work_unit_name ?></td>
                    <td class="align-middle"><?= $author->institute_name ?></td>
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
              <p>Author data were not available</p>
          <?php endif ?>
        </div>
        <div class="tab-pane fade" id="data-reviewer">
          <div class="form-group">
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#pilihreviewer">Pilih Reviewer</button>
          </div>
          <?php if ($reviewers):?>
          <?php $ii=1; ?>
          <!-- .table-responsive -->
            <div class="table-responsive">
              <!-- .table -->
              <table class="table table-striped table-bordered mb-0">
                <!-- thead -->
                        <thead>
                          <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Fakultas</th>
                          </tr>
                        </thead>
                        <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($reviewers as $reviewer): ?>
                  <!-- tr -->
                  <tr>
                    <td class="align-middle"><?= $ii++ ?></td>
                    <td class="align-middle"><?= $reviewer->reviewer_name ?></td>
                    <td class="align-middle"><?= $reviewer->reviewer_nip ?></td>
                    <td class="align-middle"><?= $reviewer->faculty_name ?></td>
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
              <p>Reviewer data were not available</p>
          <?php endif ?>
        </div>
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->

  <!-- modal penulis -->
  <div class="modal fade" id="pilihpenulis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- .modal-dialog -->
    <div class="modal-dialog" role="document">
      <!-- .modal-content -->
      <div class="modal-content">
        <!-- .modal-header -->
        <div class="modal-header">
          <h5 class="modal-title"> PENULIS </h5>
        </div>
        <!-- /.modal-header -->
        <!-- .modal-body -->
        <div class="modal-body">
          <!-- .form -->
          <?= form_open('draftauthor/add/'.$input->draft_id) ?>
            <!-- .fieldset -->
            <fieldset>
              <?= form_hidden('draft_id', $input->draft_id, 'class="form-control" id="draft_id"') ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="user_id">Nama Penulis
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('author_id', getDropdownList('author', ['author_id', 'author_name']), '', 'id="author_id" class="form-control custom-select d-block"') ?>
            </div>
            <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
            <!-- .form-actions -->
            <div class="form-actions float-right">
              <button class="btn btn-primary" type="submit">Tambah</button>
            </div>
            <!-- /.form-actions -->
          <?= form_close() ?>
          <!-- /.form -->
        </div>
        <!-- /.modal-body -->
        <!-- .modal-footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        </div>
        <!-- /.modal-footer -->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- /.modal -->

<!-- modal reviewer -->
  <div class="modal fade" id="pilihreviewer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- .modal-dialog -->
    <div class="modal-dialog" role="document">
      <!-- .modal-content -->
      <div class="modal-content">
        <!-- .modal-header -->
        <div class="modal-header">
          <h5 class="modal-title"> REVIEWER </h5>
        </div>
        <!-- /.modal-header -->
        <!-- .modal-body -->
        <div class="modal-body">
          <!-- .form -->
          <?= form_open('draftreviewer/add/'.$input->draft_id) ?>
            <!-- .fieldset -->
            <fieldset>
              <?= form_hidden('draft_id', $input->draft_id, 'class="form-control" id="draft_id"') ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="user_id">Nama Reviewer
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('reviewer_id', getDropdownList('reviewer', ['reviewer_id', 'reviewer_name']), '', 'id="reviewer_id" class="form-control custom-select d-block"') ?>
            </div>
            <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
            <!-- .form-actions -->
            <div class="form-actions float-right">
              <button class="btn btn-primary" type="submit">Tambah</button>
            </div>
            <!-- /.form-actions -->
          <?= form_close() ?>
          <!-- /.form -->
        </div>
        <!-- /.modal-body -->
        <!-- .modal-footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        </div>
        <!-- /.modal-footer -->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- /.modal -->

  <hr class="my-5"> 
  <!-- .card -->
  <section id="desk-screening" class="card card-fluid">
    <header class="card-header">Desk Screening</header>
    <!-- screening diterima -->
    <div class="alert alert-success">
      <strong>Selamat!</strong>
      Draft Lolos Desk Screening. 
    </div>
    <!-- screening ditolak -->
    <div class="alert alert-danger">
      <strong>Maaf!</strong>
      Draft Tidak Lolos Desk Screening. 
    </div>
     <!-- .card-body -->
    <div class="card-body">
      <button type="button" class="btn btn-success">Download File</button>
      <hr>
      <form class="needs-validation" novalidate="">
        <!-- .fieldset -->
        <fieldset>
          <!-- .form-group -->
          <div class="form-group">
            <label for="tf5">Catatan Editor</label>
            <textarea class="form-control" id="tf5" rows="3"></textarea>
          </div>
          <!-- /.form-group -->
        </fieldset>
        <!-- /.fieldset -->
        <!-- .form-actions -->
        <div class="el-example">
          <button class="btn btn-primary" type="submit">Simpan</button>
          <a href="" class="btn btn-warning">Tolak</a>
          <button class="btn btn-default" type="reset">Reset</button>
        </div>
        <!-- /.form-actions -->
      </form>
      <!-- /.form -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->

  <hr class="my-5">   
  <!-- .card -->
  <section id="pilih-reviewer" class="card">
    <!-- .card-header -->
    <header class="card-header">Reviewer</header>
    <!-- .card-body -->
    <div class="card-body">
      <!-- .tab-content -->
      <div id="myTabCard" class="tab-content">
        <div class="tab-pane fade active show" id="card-tabel1">
          <div class="form-group el-example">
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#pilihreviewer">Pilih Reviewer</button>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahreviewer">Tambah Reviewer</button>
            <button type="button" class="btn btn-success">Simpan Reviewer</button>
            <!-- modal -->
              <div class="modal fade" id="pilihreviewer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- .modal-dialog -->
                <div class="modal-dialog" role="document">
                  <!-- .modal-content -->
                  <div class="modal-content">
                    <!-- .modal-header -->
                    <div class="modal-header">
                      <h5 class="modal-title"> Pilih REviewer </h5>
                    </div>
                    <!-- /.modal-header -->
                    <!-- .modal-body -->
                    <div class="modal-body">
                      <!-- .form -->
                      <form>
                        <!-- .fieldset -->
                        <fieldset>
                          <!-- .form-group -->
                          <div class="form-group">
                            <label for="sel1">Nama</label>
                            <select class="custom-select" id="sel1" required="">
                              <option value=""> Choose... </option>
                              <option> Pendidikan </option>
                            </select>
                          </div>
                          <!-- /.form-group -->
                        </fieldset>
                        <!-- /.fieldset -->
                        <!-- .form-actions -->
                        <div class="form-actions float-right">
                          <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                        <!-- /.form-actions -->
                      </form>
                      <!-- /.form -->
                    </div>
                    <!-- /.modal-body -->
                    <!-- .modal-footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                    <!-- /.modal-footer -->
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <!-- /.modal -->
            <!-- modal -->
              <div class="modal fade" id="tambahreviewer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- .modal-dialog -->
                <div class="modal-dialog" role="document">
                  <!-- .modal-content -->
                  <div class="modal-content">
                    <!-- .modal-header -->
                    <div class="modal-header">
                      <h5 class="modal-title"> Tambah Reviewer </h5>
                    </div>
                    <!-- /.modal-header -->
                    <!-- .modal-body -->
                    <div class="modal-body">
                      <!-- .form -->
                      <form>
                        <!-- .fieldset -->
                        <fieldset>
                          <!-- .form-group -->
                          <div class="form-group">
                            <label for="tf4">Nama</label>
                            <div class="has-clearable">
                              <button type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">
                                  <i class="fa fa-times-circle"></i>
                                </span>
                              </button>
                              <input type="text" class="form-control" id="tf4" placeholder="Type something..." value="">
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <!-- .form-group -->
                          <div class="form-group">
                            <label for="tf1">Alamat email</label>
                            <input type="email" class="form-control" id="tf1" aria-describedby="tf1Help" placeholder="e.g. johndoe@looper.com">
                            <small id="tf1Help" class="form-text text-muted">We'll never share your email with anyone else.</small>
                          </div>
                          <!-- /.form-group -->
                          <!-- .form-group -->
                          <div class="form-group">
                            <label for="sel1">Tema</label>
                            <select class="custom-select" id="sel1" required="">
                              <option value=""> Choose... </option>
                              <option> Pendidikan </option>
                            </select>
                          </div>
                          <!-- /.form-group -->
                        </fieldset>
                        <!-- /.fieldset -->
                        <!-- .form-actions -->
                        <div class="form-actions float-right">
                          <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                        <!-- /.form-actions -->
                      </form>
                      <!-- /.form -->
                    </div>
                    <!-- /.modal-body -->
                    <!-- .modal-footer -->
                    <div class="modal-footer">
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
        
          <!-- .table-responsive -->
          <div class="text-muted"> Showing 1 to 10 of 1,000 entries </div>
          <div class="table-responsive">
            <!-- .table -->
            <table class="table">
              <!-- thead -->
              <thead>
                <tr>
                  <th colspan="2" style="min-width:320px">
                    <div class="thead-dd dropdown">
                      <span class="custom-control custom-control-nolabel custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="check-handle">
                        <label class="custom-control-label" for="check-handle"></label>
                      </span>
                      <div class="thead-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                      </div>
                      <div class="dropdown-arrow"></div>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Select all</a>
                        <a class="dropdown-item" href="#">Unselect all</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Bulk remove</a>
                        <a class="dropdown-item" href="#">Bulk edit</a>
                        <a class="dropdown-item" href="#">Separate actions</a>
                      </div>
                    </div>
                  </th>
                  <th> Inventory </th>
                  <th> Variants </th>
                  <th> Prices </th>
                  <th> Sales </th>
                  <th style="width:100px; min-width:100px;"> &nbsp; </th>
                </tr>
              </thead>
              <!-- /thead -->
              <!-- tbody -->
              <tbody>
                <!-- tr -->
                <tr>
                  <td class="align-middle col-checker">
                    <div class="custom-control custom-control-nolabel custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p10">
                      <label class="custom-control-label" for="p10"></label>
                    </div>
                  </td>
                  <td>
                    <a href="#" class="tile tile-img mr-1">
                      <img class="img-fluid" src="assets/images/dummy/img-8.jpg" alt="Card image cap">
                    </a>
                    <a href="#">Tea - Grapefruit Green Tea</a>
                  </td>
                  <td class="align-middle"> 461 </td>
                  <td class="align-middle"> 6 </td>
                  <td class="align-middle"> $29.09 </td>
                  <td class="align-middle"> 1694 </td>
                  <td class="align-middle text-right">
                    <a href="#" class="btn btn-sm btn-secondary">
                      <i class="fa fa-pencil-alt"></i>
                      <span class="sr-only">Edit</span>
                    </a>
                    <a href="#" class="btn btn-sm btn-secondary">
                      <i class="far fa-trash-alt"></i>
                      <span class="sr-only">Remove</span>
                    </a>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td class="align-middle col-checker">
                    <div class="custom-control custom-control-nolabel custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p11">
                      <label class="custom-control-label" for="p11"></label>
                    </div>
                  </td>
                  <td>
                    <a href="#" class="tile tile-img mr-1">
                      <img class="img-fluid" src="assets/images/dummy/img-6.jpg" alt="Card image cap">
                    </a>
                    <a href="#">Pecan Raisin - Tarts</a>
                  </td>
                  <td class="align-middle"> 235 </td>
                  <td class="align-middle"> 1 </td>
                  <td class="align-middle"> $31.28 </td>
                  <td class="align-middle"> 353 </td>
                  <td class="align-middle text-right">
                    <a href="#" class="btn btn-sm btn-secondary">
                      <i class="fa fa-pencil-alt"></i>
                      <span class="sr-only">Edit</span>
                    </a>
                    <a href="#" class="btn btn-sm btn-secondary">
                      <i class="far fa-trash-alt"></i>
                      <span class="sr-only">Remove</span>
                    </a>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td class="align-middle col-checker">
                    <div class="custom-control custom-control-nolabel custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p12">
                      <label class="custom-control-label" for="p12"></label>
                    </div>
                  </td>
                  <td>
                    <a href="#" class="tile tile-img mr-1">
                      <img class="img-fluid" src="assets/images/dummy/img-5.jpg" alt="Card image cap">
                    </a>
                    <a href="#">Wine - Chateau Bonnet</a>
                  </td>
                  <td class="align-middle"> 113 </td>
                  <td class="align-middle"> 2 </td>
                  <td class="align-middle"> $22.38 </td>
                  <td class="align-middle"> 1281 </td>
                  <td class="align-middle text-right">
                    <a href="#" class="btn btn-sm btn-secondary">
                      <i class="fa fa-pencil-alt"></i>
                      <span class="sr-only">Edit</span>
                    </a>
                    <a href="#" class="btn btn-sm btn-secondary">
                      <i class="far fa-trash-alt"></i>
                      <span class="sr-only">Remove</span>
                    </a>
                  </td>
                </tr>
                <!-- /tr -->
              </tbody>
              <!-- /tbody -->
            </table>
            <!-- /.table -->
          </div>
          <!-- /.table-responsive -->
        </div>
        <div class="tab-pane fade" id="card-info">
          <h5 class="card-title"> Special title treatment </h5>
          <p class="card-text"> With supporting text below as a natural lead-in to additional content. </p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card --> 

  <hr class="my-5">
  <!-- .card -->
  <section id="progress" class="card">
    <!-- .card-header -->
    <header class="card-header">Progress Step</header>
    <!-- .card-body -->
    <div class="card-body">
      <!-- .progress-list -->
        <ol class="progress-list mb-0 mb-sm-4">
          <li class="success">
            <button type="button" data-toggle="tooltip" title="Step 1">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Step 1</span>
          </li>
          <li class="success">
            <button type="button" data-toggle="tooltip" title="Step 2">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Step 2</span>
          </li>
          <li class="active error">
            <button type="button" data-toggle="tooltip" title="Step 3">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Step 3</span>
          </li>
          <li>
            <button type="button" data-toggle="tooltip" title="Step 4">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Step 4</span>
          </li>
          <li>
            <button type="button" data-toggle="tooltip" title="Step 5">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Step 5</span>
          </li>
        </ol>
        <!-- /.progress-list -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->
  <!-- .card -->
  <section id="progress-review" class="card">
    <!-- .card-header -->
    <header class="card-header">Review</header>
     <div class="list-group list-group-flush list-group-bordered">
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal masuk</span>
            <strong>2 Agustus 2018</strong>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal jadi</span>
            <strong>15 Agustus 2018</strong>
          </div>
      </div>
    <!-- .card-body -->
    <div class="card-body">
      <div class="el-example">       
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#review">Lihat Detail</button>
        <!-- modal -->
        <div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Review </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <button type="button" class="btn btn-success">Download File</button>
                <hr>
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="tf5">Catatan Reviewer</label>
                      <textarea class="form-control" id="tf5" rows="3"></textarea>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="tf5">Catatan Penulis</label>
                      <textarea class="form-control" id="tf5" rows="3"></textarea>
                    </div>
                    <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Tambah</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              </form>
              <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
      </div>
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->
  <!-- .card -->
  <section id="progress-edit" class="card">
    <!-- .card-header -->
    <header class="card-header">Edit</header>
    <div class="list-group list-group-flush list-group-bordered">
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal masuk</span>
            <strong>2 Agustus 2018</strong>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal jadi</span>
            <strong>15 Agustus 2018</strong>
          </div>
      </div>
    <!-- .card-body -->
    <div class="card-body">
      <div class="el-example">       
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#edit">Lihat Detail</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#piliheditor">Pilih Editor</button>
        <!-- modal -->
        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Edit </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <button type="button" class="btn btn-success">Download File</button>
                <hr>
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="tf5">Catatan Editor</label>
                      <textarea class="form-control" id="tf5" rows="3"></textarea>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="tf5">Catatan Penulis</label>
                      <textarea class="form-control" id="tf5" rows="3"></textarea>
                    </div>
                    <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Tambah</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              </form>
              <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
      <!-- modal -->
        <div class="modal fade" id="piliheditor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Pilih editor </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                     <!-- .form-group -->
                      <div class="form-group">
                        <label for="sel1">Tema</label>
                        <select class="custom-select" id="sel1" required="">
                          <option value=""> Choose... </option>
                          <option> Pendidikan </option>
                        </select>
                      </div>
                      <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Tambah</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              </form>
              <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
      </div>
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->
  <!-- .card -->
  <section id="progress-layout" class="card">
    <!-- .card-header -->
    <header class="card-header">Layout</header>
    <div class="list-group list-group-flush list-group-bordered">
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal masuk</span>
            <strong>2 Agustus 2018</strong>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal jadi</span>
            <strong>15 Agustus 2018</strong>
          </div>
      </div>
    <!-- .card-body -->
    <div class="card-body">
      <div class="el-example">       
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#layout">Lihat Detail</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#pilihlayouter">Pilih Layouter</button>
        <!-- modal -->
        <div class="modal fade" id="layout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Layout </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <button type="button" class="btn btn-success">Download File</button>
                <hr>
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="tf5">Catatan Layout</label>
                      <textarea class="form-control" id="tf5" rows="3"></textarea>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="tf5">Catatan Penulis</label>
                      <textarea class="form-control" id="tf5" rows="3"></textarea>
                    </div>
                    <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Tambah</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              </form>
              <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
      <!-- modal -->
        <div class="modal fade" id="pilihlayouter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Pilih Layouter </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                     <!-- .form-group -->
                      <div class="form-group">
                        <label for="sel1">Tema</label>
                        <select class="custom-select" id="sel1" required="">
                          <option value=""> Choose... </option>
                          <option> Pendidikan </option>
                        </select>
                      </div>
                      <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Tambah</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              </form>
              <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
      </div>
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->
  <!-- .card -->
  <section id="progress-proofread" class="card">
    <!-- .card-header -->
    <header class="card-header">Review</header>
     <div class="list-group list-group-flush list-group-bordered">
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal masuk</span>
            <strong>2 Agustus 2018</strong>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal jadi</span>
            <strong>15 Agustus 2018</strong>
          </div>
      </div>
    <!-- .card-body -->
    <div class="card-body">
      <div class="el-example">       
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#proofread">Lihat Detail</button>
        <!-- modal -->
        <div class="modal fade" id="proofread" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Proofread </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <button type="button" class="btn btn-success">Download File</button>
                <hr>
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="tf5">Catatan Editor</label>
                      <textarea class="form-control" id="tf5" rows="3"></textarea>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="tf5">Catatan Penulis</label>
                      <textarea class="form-control" id="tf5" rows="3"></textarea>
                    </div>
                    <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Tambah</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              </form>
              <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
      </div>
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->
 
 <div class="el-example">
   <a href="" class="btn btn-primary disabled">Simpan jadi buku</a>
   <a href="" class="btn btn-warning">Tolak</a>
   <button class="btn btn-light" type="submit">Kembali</button>
 </div>
</div>
<!-- /.page-section -->



