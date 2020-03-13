<?php $level = check_level();?>
<section class="card">
   <header class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
         <li class="nav-item">
            <a
               class="nav-link active show"
               data-toggle="tab"
               href="#data_draft"
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
            id="data_draft"
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
                           <?=($level === 'superadmin' or $level === 'admin_penerbitan') ? '<button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#modal-entry-date">Edit</button>' : '';?>
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
                  id="btn-modal-select-author"
                  type="button"
                  class="btn btn-success mr-2"
               >Pilih Penulis</button>
            </div>
            <?php endif;?>
            <div id="author-list">
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
                           <th scope="col">Status</th>
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
                           <td class="align-middle">
                              <?=$author->draft_author_status;?>
                           </td>
                           <?php if ($level == 'superadmin' || $level == 'admin_penerbitan'): ?>
                           <td class="align-middle text-right">
                              <button
                                 class="btn btn-sm btn-danger btn-delete-author"
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
               <div class="text-center my-3">Penulis belum dipilih</div>
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
   id="modal-entry-date"
   class="modal fade"
   tabindex="-1"
   role="dialog"
   aria-labelledby="modal-entry-date"
   aria-hidden="true"
>
   <div
      class="modal-dialog"
      role="document"
   >
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Edit Tanggal Masuk</h5>
         </div>
         <div class="modal-body">
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
               id="btn-change-entry-date"
               class="btn btn-primary"
               type="button"
            >Pilih</button>
            <button
               type="button"
               class="btn btn-light"
               data-dismiss="modal"
            >Close</button>
         </div>
      </div>
   </div>
</div>

<div
   id="ubah_draft_notes"
   class="modal fade"
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
            <h5 class="modal-title">Edit Catatan Draft</h5>
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
               id="btn_change_draft_notes"
               class="btn btn-primary"
               type="submit"
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
   id="modal-select-author"
   tabindex="-1"
   role="dialog"
   aria-labelledby="modal-select-author"
   aria-hidden="true"
>
   <div
      class="modal-dialog modal-dialog-centered"
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
                     <select
                        id="author-id"
                        name="author"
                        class="form-control custom-select d-block"
                        required
                     ></select>
                  </div>
               </fieldset>
         </div>
         <div class="modal-footer">
            <button
               class="btn btn-primary"
               id="btn-select-author"
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
                     <?=form_dropdown('reviewer', get_dropdown_list_multi_column('reviewer', ['reviewer_id', 'reviewer_name', 'faculty_name', 'reviewer_expert']), '', 'id="pilih_reviewer" class="form-control custom-select d-block"');?>
                  </div>
               </fieldset>
         </div>
         <div class="modal-footer">
            <button
               class="btn btn-primary"
               type="submit"
               id="btn_select_reviewer"
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

<script>
$(document).ready(function() {
   $("#author-id").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#modal-select-author'),
      allowClear: true
   });
   $("#pilih_reviewer").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihreviewer'),
      allowClear: true
   });
})

// ambil data ketika buka modal pilih penulis
$('#btn-modal-select-author').on('click', function() {
   $.get("<?=base_url('author/api_get_authors');?>",
      function(res) {
         $('#author-id')
         const authors = res.data.map((a) => {
            return `<option value="${a.author_id}">${a.author_name} - ${a.work_unit_name} - ${a.institute_name}</option>`
         })
         $('#author-id').html(authors)
         $('[name=author]').val(null).trigger('change');
      }
   )
   $('#modal-select-author').modal('toggle')
})

// ubah entry date
$('#btn-change-entry-date').on('click', function() {
   const $this = $(this);
   $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
   const id = $('[name=draft_id]').val();
   const entry_date = $('[name=entry_date]').val();
   const category_id = $('[name=category_id]').val();

   $.ajax({
      type: "POST",
      url: "<?=base_url('draft/ubahnotes/');?>" + id,
      datatype: "JSON",
      data: {
         entry_date,
         category_id
      },
      success: function(res) {
         show_toast(true, res.data);
      },
      error: function(err) {
         show_toast(false, err.responseJSON.message);
      },
      complete: function() {
         $this.removeAttr("disabled").html("Submit");
         $('#data_draft').load(' #data_draft');
         $('#modal-entry-date').modal('toggle');
      }
   });
});

// ubah catatan draft
$('#btn_change_draft_notes').on('click', function() {
   const $this = $(this);
   $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
   const id = $('[name=draft_id]').val();
   const draft_notes = $('[name=draft_notes]').val();

   $.ajax({
      type: "POST",
      url: "<?=base_url('draft/ubahnotes/');?>" + id,
      datatype: "JSON",
      data: {
         draft_notes,
      },
      success: function(res) {
         show_toast(true, res.data);
      },
      error: function(err) {
         show_toast(false, err.responseJSON.message);
      },
      complete: function() {
         $this.removeAttr("disabled").html("Submit");
         $('#data_draft').load(' #data_draft');
         $('#ubah_draft_notes').modal('toggle');
      }
   });
});

// pilih author
$('#btn-select-author').on('click', function() {
   $('.help-block').remove();
   const $this = $(this);
   $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
   const draft_id = $('input[name=draft_id]').val();
   const author_id = $('#author-id').val();

   $.ajax({
      type: "POST",
      url: "<?=base_url('draftauthor/add');?>",
      datatype: "JSON",
      data: {
         draft_id,
         author_id
      },
      success: function(res) {
         show_toast(true, res.data);
      },
      error: function(err) {
         show_toast(false, err.responseJSON.message);
      },
      complete: function() {
         $this.removeAttr("disabled").html("Submit");
         $('[name=author]').val(null).trigger('change');
         $('#author-list').load(' #author-list');
         $('#modal-select-author').modal('toggle');
      },
   });
});

// hapus penulis
$('#data-penulis').on('click', '.btn-delete-author', function() {
   $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
   let id = $(this).attr('data');

   $.ajax({
      url: "<?=base_url('draftauthor/delete/');?>" + id,
      success: function(res) {
         show_toast(true, res.data);
      },
      error: function(err) {
         show_toast(false, err.responseJSON.message);
      },
      complete: function() {
         $('#author-list').load(' #author-list');
      },

      // success: function(data) {
      //    $('#reload-author').load(' #reload-author');
      //    show_toast('2');
      // }

   })
});

// hapus reviewer
$('#data-reviewer').on('click', '.delete-reviewer', function() {
   $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
   var id = $(this).attr('data');
   console.log(id);
   $.ajax({
      url: "<?php echo base_url('draftreviewer/delete/'); ?>" + id,
      success: function(data) {
         $('#reload-reviewer').load(' #reload-reviewer');
         show_toast('4');
      }

   })
});

// pilih reviewer
$('#btn_select_reviewer').on('click', function() {
   $('.help-block').remove();
   var $this = $(this);
   $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
   var draft = $('input[name=draft_id]').val();
   var reviewer = $('#pilih_reviewer').val();
   $.ajax({
      type: "POST",
      url: "<?php echo base_url('draftreviewer/add'); ?>",
      datatype: "JSON",
      data: {
         draft_id: draft,
         reviewer_id: reviewer
      },
      success: function(data) {
         var datareviewer = JSON.parse(data);
         console.log(datareviewer);
         if (!datareviewer.validasi) {
            $('#form-reviewer').append(
               '<div class="text-danger help-block">reviewer sudah dipilih</div>');
            show_toast('22');
         } else if (datareviewer.validasi == 'max') {
            show_toast('99');
         } else {
            $('#pilihreviewer').modal('hide');
            show_toast('3');
         }
         $('[name=reviewer]').val("");
         $('#reload-reviewer').load(' #reload-reviewer');
         //$('#list-group-review').load(' #list-group-review');
         $this.removeAttr("disabled").html("Pilih");
      }
   });
   return false;
});
</script>