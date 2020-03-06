<?php $level = check_level();?>
<section class="card">
   <header class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
         <li class="nav-item">
            <a
               class="nav-link active show"
               data-toggle="tab"
               href="#data-drafts"
            ><i class="fa fa-info-circle"></i> Detail Draft</a>
         </li>
         <?php if ($level != 'reviewer'): ?>
         <!-- reviewer tidak bisa melihat penulis -->
         <li class="nav-item">
            <a
               class="nav-link"
               data-toggle="tab"
               href="#data-penulis"
            ><i class="fa fa-user-tie"></i> Penulis</a>
         </li>
         <?php endif;?>
         <?php if ($level != 'author' and $level != 'reviewer' and $desk->worksheet_status == '1'): ?>
         <li class="nav-item">
            <a
               class="nav-link"
               data-toggle="tab"
               href="#data-reviewer"
            ><i class="fa fa-user-graduate"></i> Reviewer</a>
         </li>
         <?php endif;?>
         <?php if ($level == 'author'): ?>
         <!-- author bisa melihat data buku -->
         <li class="nav-item">
            <a
               class="nav-link"
               data-toggle="tab"
               href="#data-buku"
            ><i class="fa fa-book"></i> Buku</a>
         </li>
         <?php endif;?>
      </ul>
   </header>

   <div class="card-body">
      <?=isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '';?>
      <div class="tab-content">
         <div
            class="tab-pane fade active show"
            id="data-drafts"
         >
            <div class="table-responsive">
               <table class="table table-striped table-bordered mb-0 nowrap">
                  <tbody>
                     <tr>
                        <td width="200px"> Judul Draft </td>
                        <td><strong>
                              <?=$input->draft_title;?></strong> </td>
                     </tr>
                     <tr>
                        <td width="200px"> Kategori </td>
                        <td>
                           <?=isset($input->category_id) ? konversiID('category', 'category_id', $input->category_id)->category_name : '';?>
                        </td>
                     </tr>
                     <tr>
                        <td width="200px"> Tema </td>
                        <td>
                           <?=isset($input->theme_id) ? konversiID('theme', 'theme_id', $input->theme_id)->theme_name : '';?>
                        </td>
                     </tr>
                     <tr>
                        <td width="200px"> File Draft </td>
                        <td>
                           <?=($input->draft_file) ? '<a data-toggle="tooltip" data-placement="right" title="' . $input->draft_file . '" class="btn btn-success btn-xs m-0" href="' . base_url('draft/download_file/draftfile/' . $input->draft_file) . '" target="_blank"><i class="fa fa-download"></i> Download</a>' : '';?>
                           <?=($input->draft_file_link) ? '<a data-toggle="tooltip" data-placement="right" title="' . $input->draft_file_link . '" class="btn btn-success btn-xs m-0" href="' . $input->draft_file_link . '" target="_blank"><i class="fa fa-external-link-alt"></i> External file</a>' : '';?>
                        </td>
                     </tr>
                     <tr>
                        <td width="200px"> Jumlah halaman</td>
                        <td><?=$input->draft_pages;?></td>
                     </tr>
                     <?php if ($level == 'reviewer' and $reviewer_order == 0): ?>
                     <tr>
                        <td width="200px"> Aksi Rekomendasi </td>
                        <td>
                           <?php if ($input->review1_flag == 'n'): ?>
                           <span class="badge badge-danger">Tolak</span>
                           <?php elseif ($input->review1_flag == 'y'): ?>
                           <span class="badge badge-success">Setuju</span>
                           <?php endif;?>
                        </td>
                     </tr>
                     <?php elseif ($level == 'reviewer' and $reviewer_order == 1): ?>
                     <tr>
                        <td width="200px"> Aksi Rekomendasi </td>
                        <td>
                           <?php if ($input->review2_flag == 'n'): ?>
                           <span class="badge badge-danger">Tolak</span>
                           <?php elseif ($input->review2_flag == 'y'): ?>
                           <span class="badge badge-success">Setuju</span>
                           <?php endif;?>
                        </td>
                     </tr>
                     <?php endif;?>
                     <?php if ($level != 'reviewer'): ?>
                     <tr>
                        <td width="200px"> Tanggal Masuk
                           <?=($level === 'superadmin' or $level === 'admin_penerbitan') ? '<button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#ubah_entry_date">Edit</button>' : '';?>
                        </td>
                        <td>
                           <?=format_datetime($input->entry_date);?>
                        </td>
                     </tr>
                     <tr>
                        <td width="200px"> Diinput oleh </td>
                        <td>
                           <em>
                              <?=$input->input_by;?></em>
                        </td>
                     </tr>
                     <tr>
                        <td width="200px"> Tanggal Selesai </td>
                        <td>
                           <?=format_datetime($input->finish_date);?>
                        </td>
                     </tr>
                     <tr>
                        <td width="200px"> Status Proses </td>
                        <td><span class="font-weight-bold">
                              <?=draft_status_to_text($input->draft_status);?></span> </td>
                     </tr>
                     <tr>
                        <td width="200px"> Status Naskah </td>
                        <td class="align-middle">
                           <?=$input->is_reprint == 'y' ? '<span class="badge badge-warning mb-2">Cetak Ulang</span>' : '<span class="badge badge-success mb-2">Baru</span>';?>
                           <?php if ($input->is_reprint == 'n'): ?>
                           <div class="alert alert-info m-0 p-2">
                              <?php ($input->draft_status != 14) ? $atribut = 'disabled' : $atribut = '';?>
                              <p class="m-0 p-0">Draft dengan status proses final dapat di cetak ulang.</p>
                              <?php if ($level === 'superadmin' or $level === 'admin_penerbitan'): ?>
                              <button
                                 <?=($atribut == 'disabled') ? 'style="cursor:not-allowed" disabled' : '';?>
                                 type="button"
                                 class="btn btn-info btn-xs <?=$atribut;?>"
                                 onClick="location.href='<?=base_url("draft/cetakUlang/$input->draft_id");?>'"
                              >Cetak Ulang</button>
                              <?php endif;?>
                           </div>
                           <?php endif;?>
                        </td>
                     </tr>
                     <tr>
                        <td width="200px"> Catatan Draft
                           <?=($level != 'author' and $level != 'reviewer') ? '<button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#ubah_draft_notes">Edit</button>' : '';?>
                        </td>
                        <td>
                           <div class="font-weight-bold">
                              <?=$input->draft_notes;?>
                           </div>
                        </td>
                     </tr>
                     <?php endif;?>
                  </tbody>
               </table>
            </div>
         </div>
         <div
            class="modal fade"
            id="ubah_entry_date"
            tabindex="-1"
            role="dialog"
            aria-labelledby="ubah_entry_date"
            aria-hidden="true"
         >
            <div
               class="modal-dialog"
               role="document"
            >
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">Ubah Tanggal masuk</h5>
                  </div>
                  <div class="modal-body">
                     <?=form_open('draft/ubahnotes/' . $input->draft_id);?>
                     <fieldset>
                        <div class="form-group">
                           <div>
                              <?=form_input('entry_date', $input->entry_date, 'class="form-control d-none" id="entry_date"');?>
                           </div>
                           <?=form_error('entry_date');?>
                        </div>
                     </fieldset>
                  </div>
                  <div class="modal-footer">
                     <button
                        class="btn btn-primary"
                        type="submit"
                        id="btn-ubah_entry_date"
                     >Pilih</button>
                     <button
                        type="button"
                        class="btn btn-light"
                        data-dismiss="modal"
                     >Close</button>
                  </div>
                  <?=form_close();?>
               </div>
            </div>
         </div>
         <div
            class="modal fade"
            id="ubah_draft_notes"
            tabindex="-1"
            role="dialog"
            aria-labelledby="ubah_draft_notes"
            aria-hidden="true"
         >
            <div
               class="modal-dialog"
               role="document"
            >
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">Ubah Catatan Draft</h5>
                  </div>
                  <div class="modal-body">
                     <?=form_open('draft/ubahnotes/' . $input->draft_id);?>
                     <fieldset>
                        <div class="form-group">
                           <div>
                              <?=form_textarea('draft_notes', $input->draft_notes, 'class="form-control summernote-basic" id="draft_notes"');?>
                           </div>
                           <?=form_error('draft_notes');?>
                        </div>
                     </fieldset>
                  </div>
                  <div class="modal-footer">
                     <button
                        class="btn btn-primary"
                        type="submit"
                        id="btn-ubah_draft_notes"
                     >Pilih</button>
                     <button
                        type="button"
                        class="btn btn-light"
                        data-dismiss="modal"
                     >Close</button>
                  </div>
                  <?=form_close();?>
               </div>
            </div>
         </div>
         <div
            class="tab-pane fade"
            id="data-penulis"
         >
            <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
            <div class="alert alert-warning">
               Pastikan penulis sudah ada pada tabel <strong>Penulis</strong> agar dapat dipilih, Apabila belum maka
               <a
                  href="<?=base_url('author/add');?>"
                  target="_blank"
               ><strong>Tambahkan Penulis</strong></a><br>
               Penulis pertama dapat memberikan tanggapan, komentar, dan upload file. Sedangkan penulis kedua dst
               hanya dapat melihat progress draft.
            </div>
            <div class="form-group">
               <button
                  type="button"
                  class="btn btn-success mr-2"
                  data-toggle="modal"
                  data-target="#pilihauthor"
               >Pilih Penulis</button>
            </div>
            <?php endif;?>
            <div id="reload-author">
               <?php if ($authors): ?>
               <?php $i = 1;?>
               <div class="table-responsive">
                  <table class="table table-striped table-bordered mb-0 nowrap">
                     <thead>
                        <tr>
                           <th scope="col">No</th>
                           <th scope="col">Nama</th>
                           <th scope="col">NIP</th>
                           <th scope="col">Unit Kerja</th>
                           <th scope="col">Institusi</th>
                           <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                           <th style="width:100px; min-width:100px;"> &nbsp; </th>
                           <?php endif;?>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($authors as $author): ?>
                        <tr>
                           <td class="align-middle">
                              <?=$i++;?>
                           </td>
                           <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                           <td class="align-middle"><a
                                 href="<?=base_url('author/view/profile/' . $author->author_id);?>"
                              >
                                 <?=$author->author_name;?></a></td>
                           <?php else: ?>
                           <td class="align-middle">
                              <?=$author->author_name;?>
                           </td>
                           <?php endif;?>
                           <td class="align-middle">
                              <?=$author->author_nip;?>
                           </td>
                           <td class="align-middle">
                              <?=$author->work_unit_name;?>
                           </td>
                           <td class="align-middle">
                              <?=$author->institute_name;?>
                           </td>
                           <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                           <td class="align-middle text-right">
                              <button
                                 data-toggle="tooltip"
                                 data-placement="right"
                                 title="Hapus"
                                 href="javascript"
                                 class="btn btn-sm btn-danger delete-author"
                                 data="<?=$author->draft_author_id;?>"
                              >
                                 <i class="fa fa-trash-alt"></i>
                                 <span class="sr-only">Delete</span>
                              </button>
                           </td>
                           <?php endif;?>
                        </tr>
                        <?php endforeach;?>
                     </tbody>
                  </table>
               </div>
               <?php else: ?>
               <p>Penulis belum dipilih</p>
               <?php endif;?>
            </div>
         </div>
         <div
            class="tab-pane fade"
            id="data-reviewer"
         >
            <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
            <div class="alert alert-warning">
               Pastikan reviewer sudah ada pada tabel <strong>Reviewer</strong> agar dapat dipilih, Apabila belum
               maka <a
                  href="<?=base_url('reviewer/add');?>"
                  target="_blank"
               ><strong>Tambahkan Reviewer</strong></a>.<br>
               Reviewer yang dipilih maksimal 2 orang. <br>
               Ketika memilih reviewer, tanggal mulai progress review akan tercatat.
            </div>
            <div class="form-group">
               <button
                  type="button"
                  class="btn btn-success mr-2"
                  data-toggle="modal"
                  data-target="#pilihreviewer"
               >Pilih Reviewer</button>
            </div>
            <?php endif;?>
            <div id="reload-reviewer">
               <?php if ($reviewers): ?>
               <?php $ii = 1;?>
               <div class="table-responsive">
                  <table class="table table-striped table-bordered mb-0 nowrap">
                     <thead>
                        <tr>
                           <th scope="col">No</th>
                           <th scope="col">Nama</th>
                           <th scope="col">NIP</th>
                           <th scope="col">Fakultas</th>
                           <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                           <th style="width:100px; min-width:100px;"> &nbsp; </th>
                           <?php endif;?>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($reviewers as $reviewer): ?>
                        <tr>
                           <td class="align-middle">
                              <?=$ii++;?>
                           </td>
                           <td class="align-middle">
                              <?=$reviewer->reviewer_name;?>
                           </td>
                           <td class="align-middle">
                              <?=$reviewer->reviewer_nip;?>
                           </td>
                           <td class="align-middle">
                              <?=$reviewer->faculty_name;?>
                           </td>
                           <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                           <td class="align-middle text-right">
                              <button
                                 data-toggle="tooltip"
                                 data-placement="right"
                                 title="Hapus"
                                 href="javascript"
                                 class="btn btn-sm btn-danger delete-reviewer"
                                 data="<?=$reviewer->draft_reviewer_id;?>"
                              >
                                 <i class="fa fa-trash-alt"></i>
                                 <span class="sr-only">Delete</span>
                              </button>
                           </td>
                           <?php endif;?>
                        </tr>
                        <?php endforeach;?>
                     </tbody>
                  </table>
               </div>
               <?php else: ?>
               <p>Reviewer belum dipilih</p>
               <?php endif;?>
            </div>
         </div>
         <div
            class="tab-pane fade"
            id="data-buku"
         >
            <?php if ($books): ?>
            <div class="table-responsive">
               <table class="table table-striped table-bordered mb-0 nowrap">
                  <tbody>
                     <tr>
                        <td width="200px"> Judul Buku </td>
                        <td><strong>
                              <?=$books->book_title;?></strong> </td>
                     </tr>
                     <tr>
                        <td width="200px"> Nomor Hak Cipta </td>
                        <td><strong>
                              <?=$books->nomor_hak_cipta;?></strong> </td>
                     </tr>
                     <tr>
                        <td width="200px"> File hak cipta </td>
                        <td>
                           <?=(!empty($books->file_hak_cipta)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $books->file_hak_cipta . '" class="btn btn-success btn-xs m-0" href="' . base_url('hakcipta/' . $books->file_hak_cipta) . '"><i class="fa fa-download"></i> Download</a>' : '';?>
                           <?=(!empty($books->file_hak_cipta_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $books->file_hak_cipta_link . '" class="btn btn-success btn-xs m-0" href="' . $books->file_hak_cipta_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : '';?>
                        </td>
                     </tr>
                     <tr>
                        <td width="200px"> Status Hak Cipta</td>
                        <td>
                           <?=($books->status_hak_cipta == '') ? '-' : '';?>
                           <?=($books->status_hak_cipta == 1) ? '<span class="badge badge-info">Dalam Proses</span>' : '';?>
                           <?=($books->status_hak_cipta == 2) ? '<span class="badge badge-success">Sudah Jadi</span>' : '';?>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <?php else: ?>
            <div
               class="alert alert-info alert-dismissible fade show"
               role="alert"
            >
               Data akan tampil apabila draft telah disetujui untuk menjadi buku.
            </div>
            <p class="text-center my-4">Draft belum final</p>
            <?php endif;?>
         </div>
      </div>
   </div>
</section>

<div
   class="modal fade"
   id="pilihauthor"
   tabindex="-1"
   role="dialog"
   aria-labelledby="exampleModalLabel"
   aria-hidden="true"
>
   <div
      class="modal-dialog"
      role="document"
   >
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title"> PENULIS </h5>
         </div>
         <div class="modal-body">
            <form>
               <fieldset>
                  <div
                     class="form-group"
                     id="form-author"
                  >
                     <label for="user_id">Nama Penulis</label>
                     <?=form_dropdown('author', getMoreDropdownList('author', ['author_id', 'author_name', 'work_unit_name']), '', 'id="pilih_author" class="form-control custom-select d-block" required');?>
                  </div>
               </fieldset>
         </div>
         <div class="modal-footer">
            <button
               class="btn btn-primary"
               id="btn-pilih-author"
               type="submit"
            >Pilih</button>
            <button
               type="button"
               class="btn btn-light"
               data-dismiss="modal"
            >Close</button>
         </div>
         </form>
      </div>
   </div>
</div>

<div
   class="modal fade"
   id="pilihreviewer"
   tabindex="-1"
   role="dialog"
   aria-labelledby="exampleModalLabel"
   aria-hidden="true"
>
   <div
      class="modal-dialog"
      role="document"
   >
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title"> REVIEWER </h5>
         </div>
         <div class="modal-body">
            <form>
               <fieldset>
                  <div
                     class="form-group"
                     id="form-reviewer"
                  >
                     <label for="user_id">Nama Reviewer</label>
                     <?=form_dropdown('reviewer', getMoreDropdownList('reviewer', ['reviewer_id', 'reviewer_name', 'faculty_name', 'reviewer_expert']), '', 'id="pilih_reviewer" class="form-control custom-select d-block"');?>
                  </div>
               </fieldset>
         </div>
         <div class="modal-footer">
            <button
               class="btn btn-primary"
               type="submit"
               id="btn-pilih-reviewer"
            >Pilih</button>
            <button
               type="button"
               class="btn btn-light"
               data-dismiss="modal"
            >Close</button>
         </div>
         </form>
      </div>
   </div>
</div>