<?php
// penampil ktp
$ktp_place = null;
if (isset($author->author_ktp) && $author->author_ktp) {
    if ($author->author_ktp) {
        $getextension = explode(".", $author->author_ktp);
    } else {
        $getextension[1] = '';
    }
    // jika ekstensi pdf maka tampilkan link
    if ($getextension[1] != 'pdf') {
        $ktp_place = '<img class="uploaded-image" src="' . base_url('authorktp/' . $author->author_ktp) . '" width="30%"><br>';
    } else {
        $ktp_place = '<div align="middle"><a href="' . base_url('authorktp/' . $author->author_ktp) . '" class="btn btn-success><i class="fa fa-download"></i> Lihat KTP</a></div>';
    }
}
?>
<div class="card card-fluid">
   <h6 class="card-header"> Profil </h6>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-striped table-bordered mb-0 nowrap">
            <tbody>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_user_name');?> </td>
                  <td><?=(!empty($author->user_id)) ? konversiID('user', 'user_id', $author->user_id)->username : '';?>
                  </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_author_nip');?> </td>
                  <td><?=$author->author_nip;?> </td>
               </tr>
               <tr>
                  <td width="200px"> <?=$this->lang->line('form_author_name');?> </td>
                  <td><?=$author->author_degree_front;?> <?=$author->author_name;?> <?=$author->author_degree_back;?>
                  </td>
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
                     <?=$ktp_place;?>
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