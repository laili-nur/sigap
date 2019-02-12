<?php $ceklevel = $this->session->userdata('level'); ?>
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
  <!-- tombol floating mobile version
    <div class="d-xl-none">
       <button class="btn btn-danger btn-floated" type="button" data-toggle="sidebar">
         <i class="fa fa-th-list"></i>
       </button>
     </div> -->
  <!-- .card -->
  <section id="data-draft" class="card">
    <!-- .card-header -->
    <header class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link active show" data-toggle="tab" href="#data-drafts">Data Draft</a>
        </li>
        <!-- if hilangkan data penulis di reviewer -->
        <?php if($ceklevel != 'reviewer'): ?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#data-penulis">Data Penulis</a>
        </li>
        <!-- endif hilangkan data penulis di reviewer -->
        <?php endif ?>
        <!-- if hilangkan tab data reviewer -->
        <?php if($ceklevel != 'author' and $ceklevel != 'reviewer' and $desk->worksheet_status=='1'): ?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#data-reviewer">Data Reviewer</a>
        </li>
        <!-- endif hilangkan tab data reviewer -->
        <?php endif ?>
        <?php if($ceklevel == 'author'): ?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#data-buku">Data Buku</a>
        </li>
        <?php endif ?>
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
            <table class="table table-striped table-bordered mb-0 nowrap">
              <!-- tbody -->
              <tbody>
                <!-- tr -->
                <tr>
                  <td width="200px"> Judul Draft </td>
                  <td><strong><?= $input->draft_title ?></strong> </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> Kategori </td>
                  <td>
                    <?=isset($input->category_id)? konversiID('category','category_id', $input->category_id)->category_name : ''?>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> Tema </td>
                  <td>
                    <?=isset($input->theme_id)? konversiID('theme','theme_id', $input->theme_id)->theme_name : ''?>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> File Draft </td>
                  <td>
                    <?=(!empty($input->draft_file))? '<a data-toggle="tooltip" data-placement="right" title="'.$input->draft_file.'" class="btn btn-success btn-xs m-0" href="'.base_url('draftfile/'.$input->draft_file).'" target="_blank"><i class="fa fa-download"></i> Download</a>' : '' ?>
                    <?=(!empty($input->draft_file_link))? '<a data-toggle="tooltip" data-placement="right" title="'.$input->draft_file_link.'" class="btn btn-success btn-xs m-0" href="'.$input->draft_file_link.'" target="_blank"><i class="fa fa-external-link-alt"></i> External file</a>' : '' ?>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- tampilkan status rekomendasi pada level reviewer  masing2 -->
                <?php if ($ceklevel == 'reviewer' and $reviewer_order == 0): ?>
                  <!-- tr -->
                  <tr>
                    <td width="200px"> Aksi Rekomendasi </td>
                    <td>
                      <?php if ($input->review1_flag == 'n'): ?>
                      <span class="badge badge-danger">Tolak</span>
                      <?php elseif($input->review1_flag == 'y'): ?>
                      <span class="badge badge-success">Setuju</span>
                      <?php endif ?>
                    </td>
                  </tr>
                  <!-- /tr -->
                <?php elseif($ceklevel == 'reviewer' and $reviewer_order == 1): ?>
                  <!-- tr -->
                  <tr>
                    <td width="200px"> Aksi Rekomendasi </td>
                    <td>
                      <?php if ($input->review2_flag == 'n'): ?>
                      <span class="badge badge-danger">Tolak</span>
                      <?php elseif($input->review2_flag == 'y'): ?>
                      <span class="badge badge-success">Setuju</span>
                      <?php endif ?>
                    </td>
                  </tr>
                  <!-- /tr -->
                <?php endif ?>
                <?php if($ceklevel != 'reviewer'): ?>
                <!-- tr -->
                <tr>
                  <td width="200px"> Tanggal Masuk
                    <?=($ceklevel==='superadmin' or $ceklevel==='admin_penerbitan')?'<button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#ubah_entry_date">Edit</button>':'' ?>
                  </td>
                  <td>
                    <?= konversiTanggal($input->entry_date) ?>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> Tanggal Selesai </td>
                  <td>
                    <?= konversiTanggal($input->finish_date) ?>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> Status Proses </td>
                  <td><span class="font-weight-bold"><?= $input->draft_status ?></span> </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> Status Naskah </td>
                  <td class="align-middle">
                    <?= $input->is_reprint == 'y' ? '<span class="badge badge-warning mb-2">Cetak Ulang</span>' : '<span class="badge badge-success mb-2">Baru</span>' ?>
                    <?php if($input->is_reprint == 'n'): ?>
                    <div class="alert alert-info m-0 p-2">
                      <?php ($input->stts != 14)? $atribut = 'disabled' : $atribut = '' ;?>
                      <p class="m-0 p-0">Draft dengan status proses final dapat di cetak ulang.</p>
                      <?=($ceklevel==='superadmin' or $ceklevel==='admin_penerbitan')? '<a type="button" class="btn btn-info btn-xs '.$atribut.'" href="'.base_url('draft/cetakUlang/'.$input->draft_id).'">Cetak Ulang</a>':'' ?>
                    </div>
                    <?php endif ?>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> Catatan Draft
                    <?=($ceklevel!='author' and $ceklevel!='reviewer')?'<button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#ubah_draft_notes">Edit</button>':'' ?>
                  </td>
                  <td>
                    <div class="font-weight-bold">
                      <?= $input->draft_notes ?>
                    </div>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- endif data yang dilihat reviewer -->
                <?php endif ?>
              </tbody>
              <!-- /tbody -->
            </table>
            <!-- /.table -->
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- modal ubah entry date -->
        <div class="modal fade" id="ubah_entry_date" tabindex="-1" role="dialog" aria-labelledby="ubah_entry_date" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title">Ubah Tanggal masuk</h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <!-- .form -->
                <?= form_open('draft/ubahnotes/'.$input->draft_id) ?>
                <!-- .fieldset -->
                <fieldset>
                  <!-- .form-group -->
                  <div class="form-group">
                    <!-- <label for="edit_deadline">Deadline Edit</label> -->
                    <div>
                      <?= form_input('entry_date', $input->entry_date, 'class="form-control d-none" id="entry_date"') ?>
                    </div>
                    <?= form_error('entry_date') ?>
                  </div>
                  <!-- /.form-group -->
                </fieldset>
                <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit" id="btn-ubah_entry_date">Pilih</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              <?=form_close(); ?>
              <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- modal ubah draft notes -->
        <div class="modal fade" id="ubah_draft_notes" tabindex="-1" role="dialog" aria-labelledby="ubah_draft_notes" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title">Ubah Catatan Draft</h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <!-- .form -->
                <?= form_open('draft/ubahnotes/'.$input->draft_id) ?>
                <!-- .fieldset -->
                <fieldset>
                  <!-- .form-group -->
                  <div class="form-group">
                    <div>
                      <?= form_textarea('draft_notes', $input->draft_notes, 'class="form-control summernote-basic" id="draft_notes"') ?>
                    </div>
                    <?= form_error('draft_notes') ?>
                  </div>
                  <!-- /.form-group -->
                </fieldset>
                <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit" id="btn-ubah_draft_notes">Pilih</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              <?=form_close(); ?>
              <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="tab-pane fade" id="data-penulis">
          <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
          <div class="alert alert-warning">
            Pastikan penulis sudah ada pada tabel <strong>Penulis</strong> agar dapat dipilih, Apabila belum maka <a href="<?=base_url('author/add');?>" target="_blank"><strong>Tambahkan Penulis</strong></a><br>
            Penulis pertama dapat memberikan tanggapan, komentar, dan upload file. Sedangkan penulis kedua dst hanya dapat melihat progress draft.
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#pilihauthor">Pilih Penulis</button>
          </div>
          <?php endif ?>
          <div id="reload-author">
            <?php if ($authors):?>
            <?php $i=1; ?>
            <!-- .table-responsive -->
            <div class="table-responsive">
              <!-- .table -->
              <table class="table table-striped table-bordered mb-0 nowrap">
                <!-- thead -->
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">NIP</th>
                    <th scope="col">Unit Kerja</th>
                    <th scope="col">Institusi</th>
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <th style="width:100px; min-width:100px;"> &nbsp; </th>
                    <?php endif ?>
                  </tr>
                </thead>
                <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($authors as $author): ?>
                  <!-- tr -->
                  <tr>
                    <td class="align-middle">
                      <?= $i++ ?>
                    </td>
                    <!-- jika admin maka ada linknya ke profil -->
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <td class="align-middle"><a href="<?= base_url('author/view/profil/'.$author->author_id) ?>"><?= $author->author_name ?></a></td>
                    <?php else: ?>
                    <td class="align-middle">
                      <?= $author->author_name ?>
                    </td>
                    <?php endif ?>
                    <td class="align-middle">
                      <?= $author->author_nip ?>
                    </td>
                    <td class="align-middle">
                      <?= $author->work_unit_name ?>
                    </td>
                    <td class="align-middle">
                      <?= $author->institute_name ?>
                    </td>
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <td class="align-middle text-right">
                      <button data-toggle="tooltip" data-placement="right" title="Hapus" href="javascript" class="btn btn-sm btn-danger delete-author" data="<?= $author->draft_author_id ?>">
                        <i class="fa fa-trash-alt"></i>
                        <span class="sr-only">Delete</span>
                      </button>
                    </td>
                    <?php endif ?>
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
            <p>Penulis belum dipilih</p>
            <?php endif ?>
          </div>
        </div>
        <div class="tab-pane fade" id="data-reviewer">
          <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
          <div class="alert alert-warning">
            Pastikan reviewer sudah ada pada tabel <strong>Reviewer</strong> agar dapat dipilih, Apabila belum maka <a href="<?=base_url('reviewer/add');?>" target="_blank"><strong>Tambahkan Reviewer</strong></a>.<br>
            Reviewer yang dipilih maksimal 2 orang. <br>
            Ketika memilih reviewer, tanggal mulai progress review akan tercatat.
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#pilihreviewer">Pilih Reviewer</button>
          </div>
          <?php endif ?>
          <div id="reload-reviewer">
            <?php if ($reviewers):?>
            <?php $ii=1; ?>
            <!-- .table-responsive -->
            <div class="table-responsive">
              <!-- .table -->
              <table class="table table-striped table-bordered mb-0 nowrap">
                <!-- thead -->
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">NIP</th>
                    <th scope="col">Fakultas</th>
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <th style="width:100px; min-width:100px;"> &nbsp; </th>
                    <?php endif ?>
                  </tr>
                </thead>
                <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($reviewers as $reviewer): ?>
                  <!-- tr -->
                  <tr>
                    <td class="align-middle">
                      <?= $ii++ ?>
                    </td>
                    <td class="align-middle">
                      <?= $reviewer->reviewer_name ?>
                    </td>
                    <td class="align-middle">
                      <?= $reviewer->reviewer_nip ?>
                    </td>
                    <td class="align-middle">
                      <?= $reviewer->faculty_name ?>
                    </td>
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <td class="align-middle text-right">
                      <button data-toggle="tooltip" data-placement="right" title="Hapus" href="javascript" class="btn btn-sm btn-danger delete-reviewer" data="<?= $reviewer->draft_reviewer_id ?>">
                        <i class="fa fa-trash-alt"></i>
                        <span class="sr-only">Delete</span>
                      </button>
                    </td>
                    <?php endif ?>
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
            <p>Reviewer belum dipilih</p>
            <?php endif ?>
          </div>
        </div>
        <div class="tab-pane fade" id="data-buku">
          <?php if ($books):?>
          <!-- .table-responsive -->
          <div class="table-responsive">
            <!-- .table -->
            <table class="table table-striped table-bordered mb-0 nowrap">
              <!-- tbody -->
              <tbody>
                <!-- tr -->
                <tr>
                  <td width="200px"> Judul Buku </td>
                  <td><strong><?= $books->book_title ?></strong> </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> Nomor Hak Cipta </td>
                  <td><strong><?= $books->nomor_hak_cipta ?></strong> </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> File hak cipta </td>
                  <td>
                    <?=(!empty($books->file_hak_cipta))? '<a data-toggle="tooltip" data-placement="right" title="'.$books->file_hak_cipta.'" class="btn btn-success btn-xs m-0" href="'.base_url('hakcipta/'.$books->file_hak_cipta).'"><i class="fa fa-download"></i> Download</a>' : '' ?>
                    <?=(!empty($books->file_hak_cipta_link))? '<a data-toggle="tooltip" data-placement="right" title="'.$books->file_hak_cipta_link.'" class="btn btn-success btn-xs m-0" href="'.$books->file_hak_cipta_link.'"><i class="fa fa-external-link-alt"></i> External file</a>' : '' ?>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- tr -->
                <tr>
                  <td width="200px"> Status Hak Cipta</td>
                  <td>
                    <?= ($books->status_hak_cipta == '')? '-' : '' ?>
                    <?= ($books->status_hak_cipta == 1)? '<span class="badge badge-info">Dalam Proses</span>' : '' ?>
                    <?= ($books->status_hak_cipta == 2)? '<span class="badge badge-success">Sudah Jadi</span>' : '' ?>
                  </td>
                </tr>
                <!-- /tr -->
              </tbody>
              <!-- /tbody -->
            </table>
            <!-- /.table -->
          </div>
          <!-- /.table-responsive -->
          <?php else: ?>
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            Data akan tampil apabila draft telah disetujui untuk menjadi buku.
          </div>
          <p class="text-center my-4">Draft belum final</p>
          <?php endif ?>
        </div>
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->
  <!-- modal penulis -->
  <div class="modal fade" id="pilihauthor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <form>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group" id="form-author">
                <label for="user_id">Nama Penulis</label>
                <?= form_dropdown('author', getMoreDropdownList('author', ['author_id', 'author_name', 'work_unit_name']), '', 'id="pilih_author" class="form-control custom-select d-block" required') ?>
              </div>
              <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
            <!-- .form-actions -->
        </div>
        <!-- /.modal-body -->
        <!-- .modal-footer -->
        <div class="modal-footer">
          <button class="btn btn-primary" id="btn-pilih-author" type="submit">Pilih</button>
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
          <form>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group" id="form-reviewer">
                <label for="user_id">Nama Reviewer</label>
                <?= form_dropdown('reviewer', getMoreDropdownList('reviewer', ['reviewer_id', 'reviewer_name','faculty_name','reviewer_expert']), '', 'id="pilih_reviewer" class="form-control custom-select d-block"') ?>
              </div>
              <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
        </div>
        <!-- /.modal-body -->
        <!-- .modal-footer -->
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit" id="btn-pilih-reviewer">Pilih</button>
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
  <?php if($ceklevel != 'reviewer'):?>
    <?php $this->load->view('draft/view/desk_screening') ?>
  <?php endif ?>
  <!-- jika desk screening ditolak, maka progress tidak ditampilkan -->
  <?php if ($desk->worksheet_status == 1): ?>
    <!-- reviewer tidak bisa melihat progress draft -->
    <?php if($ceklevel != 'reviewer'): ?>
      <!-- panel-progress -->
      <?php $this->load->view('draft/view/progress'); ?>
    <?php endif ?>
    <!-- endif reviewer tidak bisa melihat progress draft -->
    <!-- if hanya peringatan penulis kedua dst -->
    <?php if($ceklevel == 'author' and $author_order!=1): ?>
      <div class="alert alert-danger"><strong>PERHATIAN! </strong>Hanya penulis pertama yang dapat memberikan komentar dan catatan, penulis kedua hanya dapat melihat progress.</div>
    <?php endif ?>
    <!-- progress-review -->
    <?php if($reviewers == null): ?>
      <?php if($ceklevel == 'superadmin'): ?>
        <div class="alert alert-warning">
          <strong>PERHATIAN!</strong> Pilih reviewer terlebih dahulu sebelum lanjut ke tahap selanjutnya. Apabila progress belum terbuka maka lakukan reload
          <p class="m-0 p-0 mt-2"><button class="btn btn-warning btn-xs" type="button" id="pil-rev"><i class="fa fa-user-graduate"></i> Pilih reviewer</button> <button class="btn btn-warning btn-xs" type="button" onClick="window.location.reload()"><i class="fa fa-sync"></i> Reload</button></p>
        </div>
      <?php else: ?>
        <div class="alert alert-info">
          <h5 class="alert-heading">Pencarian Reviewer</h5>
          Mohon ditunggu, Pihak admin sedang melakukan pencarian reviewer yang sesuai dengan draft anda.
        </div>
      <?php endif ?>
    <?php else: ?>
      <?php $this->load->view('draft/view/review'); ?>
    <?php endif ?>
    <!-- reviewer tidak bisa melihat progress draft -->
    <?php if($ceklevel != 'reviewer'): ?>
      <?php if($input->is_review == 'y'): ?>
        <!-- progress-edit -->
        <?php $this->load->view('draft/view/edit'); ?>
      <?php endif ?>
      <?php if($input->is_edit == 'y'): ?>
        <!-- progress-layout -->
        <?php $this->load->view('draft/view/layout'); ?>
      <?php endif ?>
      <?php if($input->is_layout == 'y'): ?>
        <!-- progress-proofread -->
        <?php $this->load->view('draft/view/proofread'); ?>
      <?php endif ?>
      <?php if($input->is_proofread == 'y' and $ceklevel!='author' and $ceklevel!='reviewer'): ?>
        <!-- progress-cetak -->
        <?php $this->load->view('draft/view/print'); ?>
      <?php elseif($input->is_proofread == 'y' and $input->is_print == 'n'  and $ceklevel=='author' or $ceklevel=='reviewer'): ?>
        <div class="alert alert-info">
          <h5 class="alert-heading">Proses Cetak</h5>
          Draft ini sedang dalam proses pencetakan.
        </div>
      <?php elseif($input->is_print == 'y' and $input->stts != 14  and $ceklevel=='author' or $ceklevel=='reviewer'): ?>
        <div class="alert alert-info">
          <h5 class="alert-heading">Proses Final</h5>
          Draft ini sedang dalam proses finalisasi.
        </div>
      <?php endif ?>
      <!-- if tombol final tampilan admin -->
      <?php if($ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
        <div class="el-example mx-3 mx-md-0">
          <?php 
            $hidden_date = array(
                'type'  => 'hidden',
                'id'    => 'finish_date',
                'value' => date('Y-m-d H:i:s')
            );
            echo form_input($hidden_date);?>
          <?=($input->is_print == 'y')? '':'<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> Proses cetak belum disetujui</small></div>' ?>
          <?=($input->print_file != '' or $input->print_file_link != '')? '':'<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> File/Link cetak belum ada</small></div>' ?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalsimpan" <?=($input->is_print == 'y' and ($input->print_file != '' or $input->print_file_link != ''))? '':'disabled' ?>>Simpan jadi buku</button>
            <button class="btn btn-danger" data-toggle="modal" data-target="#modaltolak" <?=($input->is_print == 'y' and ($input->print_file != '' or $input->print_file_link != ''))? '':'disabled' ?>>Tolak</button>
        </div>
        <!-- Alert Danger Modal -->
        <div class="modal modal-warning fade" id="modalsimpan" tabindex="-1" role="dialog" aria-labelledby="modalsimpan" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title">
                  <i class="fa fa-bullhorn text-yellow mr-1"></i> Konfirmasi Draft Final
                </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <p>Draft <span class="font-weight-bold"><?= $input->draft_title ?></span> sudah final dan akan disimpan jadi buku?</p>
                <div class="alert alert-warning">Tanggal selesai draft akan tercatat ketika klik Submit</div>
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" id="draft-setuju" draft-title="<?=$draft->draft_title ?>" draft-file="<?=$draft->print_file ?>" value="14">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- Alert Danger Modal -->
        <div class="modal modal-alert fade" id="modaltolak" tabindex="-1" role="dialog" aria-labelledby="modalsimpan" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title">
                  <i class="fa fa-exclamation-triangle text-red mr-1"></i> Tolak Draft
                </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <p>Draft <span class="font-weight-bold"><?= $input->draft_title ?></span> ditolak?</p>
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-danger" type="submit" id="draft-tolak" value="99">Tolak</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      <!-- endif tombol final tampilan admin -->
      <?php endif ?>
    <!-- endif tampilan reviewer -->
    <?php endif ?>
  <!-- endif worksheet status -->
  <?php endif ?>
</div>
<!-- /.page-section -->
<script>
  $(document).ready(function() {
    $('#entry_date').flatpickr({
      disableMobile: true,
      altInput: true,
      altFormat: 'j F Y',
      dateFormat: 'Y-m-d',
      inline: true
    });
  
    //scroll to top dan ganti tab
    function activaTab(tab){
        $('.nav-tabs.card-header-tabs a[href="#' + tab + '"]').tab('show');
    };
    $('#pil-rev').click(function(){
       $('html, body').animate({scrollTop: 1}, 400);
       setTimeout(function() {activaTab('data-reviewer');}, 500);
      return false;
    });
  
  
    $("#pilih_author").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihauthor'),
      allowClear : true
    });
    $("#pilih_reviewer").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihreviewer'),
      allowClear : true
    });
    $("#pilih_editor").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#piliheditor'),
      allowClear : true
    });
    $("#pilih_layouter").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihlayouter'),
      allowClear : true
    });
  
    //pilih reviewer
    $('#btn-pilih-author').on('click', function(){
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var author = $('#pilih_author').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('draftauthor/add') ?>",
        datatype : "JSON",
        data : {
          draft_id : draft,
          author_id : author
        },
        success :function(data){
          var datapenulis = JSON.parse(data);
          console.log(datapenulis);
          if(!datapenulis.validasi){
            $('#form-author').append('<div class="text-danger help-block">Penulis sudah dipilih</div>');
            toastr_view('11');
          }else{
            $('#pilihauthor').modal('hide');
            toastr_view('1');
          }
          $('[name=author]').val("");
          $('#reload-author').load(' #reload-author');
          $this.removeAttr("disabled").html("Pilih");
        }
      });
      return false;
    });
  
    //pilih reviewer
    $('#btn-pilih-reviewer').on('click', function(){
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var reviewer = $('#pilih_reviewer').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('draftreviewer/add') ?>",
        datatype : "JSON",
        data : {
          draft_id : draft,
          reviewer_id : reviewer
        },
        success :function(data){
          var datareviewer = JSON.parse(data);
          console.log(datareviewer);
          if(!datareviewer.validasi){
            $('#form-reviewer').append('<div class="text-danger help-block">reviewer sudah dipilih</div>');
            toastr_view('22');
          }else if(datareviewer.validasi == 'max'){
            toastr_view('99');
          }else{
            $('#pilihreviewer').modal('hide');
            toastr_view('3');
          }
          $('[name=reviewer]').val("");
          $('#reload-reviewer').load(' #reload-reviewer');
          $('#list-group-review').load(' #list-group-review');
          $this.removeAttr("disabled").html("Pilih");
        }
      });
      return false;
    });
  
    
    //hapus penulis
    $('#data-penulis').on('click','.delete-author',function(){
        $(this).attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        var id=$(this).attr('data');
        console.log(id);
        $.ajax({
          url : "<?php echo base_url('draftauthor/delete/') ?>"+id,
          success : function(data){
            $('#reload-author').load(' #reload-author');
  
            toastr_view('2');
          }
  
        })
    });
  
    // hapus reviewer
    $('#data-reviewer').on('click','.delete-reviewer',function(){
        $(this).attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        var id=$(this).attr('data');
        console.log(id);
        $.ajax({
          url : "<?php echo base_url('draftreviewer/delete/') ?>"+id,
          success : function(data){
            $('#reload-reviewer').load(' #reload-reviewer');
            toastr_view('4');
          }
  
        })
    });
  
    
    //ubah entry date
    $('#btn-ubah_entry_date').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let entry_date=$('[name=entry_date]').val();
        console.log(entry_date)
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            entry_date : entry_date,
          },
          success :function(data){
            let datax = JSON.parse(data);
            console.log(datax)
            $this.removeAttr("disabled").html("Submit");
            if(datax.status == true){
              toastr_view('111');
            }else{
              toastr_view('000');
            }
             $('#data-drafts').load(' #data-drafts');
             $('#ubah_entry_date').modal('toggle');
          }
  
        });
        return false;
      });
  
    //ubah entry date
    $('#btn-ubah_draft_notes').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let draft_notes=$('[name=draft_notes]').val();
        console.log(draft_notes)
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            draft_notes : draft_notes,
          },
          success :function(data){
            let datax = JSON.parse(data);
            console.log(datax)
            $this.removeAttr("disabled").html("Submit");
            if(datax.status == true){
              toastr_view('111');
            }else{
              toastr_view('000');
            }
             $('#data-drafts').load(' #data-drafts');
             $('#ubah_draft_notes').modal('toggle');
          }
  
        });
        return false;
      });
  
    $('#draft-setuju').on('click', function() {
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let draft_title=$this.attr('draft-title');
        let draft_file=$this.attr('draft-file');
        let action=$('#draft-setuju').val();
        let finish_date=$('#finish_date').val();
        let cek = '<?php echo base_url('draft/copyToBook/')?>'+id;
        console.log(cek);
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
            datatype : "JSON",
            data : {
              draft_status : action,
              finish_date : finish_date,
            },
            success :function(data){
              let datax = JSON.parse(data);
              console.log(datax);
              $this.removeAttr("disabled").html("Submit");
              if(datax.status == true){
                toastr_view('111');
                location.href ='<?php echo base_url('draft/copyToBook/')?>'+id;
              }else{
                toastr_view('000');
              }
            }
          });
  
          // $('#draft_aksi').modal('hide');
          // location.reload();
          return false;
      });
  
      $('#draft-tolak').on('click', function() {
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let action=$('#draft-tolak').val();
        console.log(action);
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
            datatype : "JSON",
            data : {
              draft_status : action,
            },
            success :function(data){
              let datax = JSON.parse(data);
              console.log(datax);
              $this.removeAttr("disabled").html("Tolak");
              if(datax.status == true){
                toastr_view('111');
              }else{
                toastr_view('000');
              }
              location.href = '<?php echo base_url('draft/view/') ?>'+id;
            }
          });
  
          // $('#draft_aksi').modal('hide');
          // location.reload();
          return false;
      });
  
  
  });
</script>