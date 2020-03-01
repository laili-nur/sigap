<div class="card card-fluid">
   <h6 class="card-header"> Profil </h6>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-striped table-bordered mb-0 nowrap">
            <tbody>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_user_name');?> </td>
                  <td>
                     <?=(!empty($author->user_id)) ? konversiID('user', 'user_id', $author->user_id)->username : '';?>
                     <?=isset($author->level) ? '<span class="badge badge-primary">' . ucwords(str_replace('_', ' ', $author->level)) . '</span>' : '<span class="text-danger">Penulis belum memiliki akun.</span>';?>
                  </td>
               </tr>
               <!-- <tr>
                  <td width="200px"> <?=$this->lang->line('form_user_level');?> </td>
                  <td>
                     <?=isset($author->level) ? ucwords(str_replace('_', ' ', $author->level)) : '<span class="text-danger">Penulis belum memiliki akun.</span>';?>
                  </td>
               </tr> -->
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_author_nip');?> </td>
                  <td><?=$author->author_nip;?> </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_author_latest_education');?> </td>
                  <td>
                     <?=($author->author_latest_education == 's4') ? 'Professor' : ucwords($author->author_latest_education);?>
                  </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_work_unit_name');?> </td>
                  <td> <?=konversiID('work_unit', 'work_unit_id', $author->work_unit_id)->work_unit_name;?> </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_institute_name');?> </td>
                  <td> <?=konversiID('institute', 'institute_id', $author->institute_id)->institute_name;?> </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_author_address');?> </td>
                  <td><?=$author->author_address;?> </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_author_contact');?> </td>
                  <td><?=$author->author_contact;?> </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_author_email');?> </td>
                  <td><?=$author->author_email;?> </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_author_heir_name');?> </td>
                  <td> <?=$author->heir_name;?> </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_author_ktp');?> </td>
                  <td>
                     <div class="row">
                        <div class="col-md-6">
                           <?=ktp_viewer($author->author_ktp);?>
                        </div>
                     </div>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   <footer class="card-footer">
      <div class="card-footer-content text-muted">
         <a
            href="<?=base_url('author/edit/' . $author->author_id);?>"
            class="btn btn-secondary"
         >Edit Data</a>
      </div>
   </footer>
</div>