<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Revision extends MY_Controller
{

    public function index()
    {
        echo 'controller - revision';
    }

    public function get_revision($draft_id, $progress)
    {
        $input    = (object) $this->input->post(null);
        $revisions   = $this->revision->where('revision_role', $progress)->where('draft_id', $draft_id)->get_all();

        return $this->send_json_output(true, $revisions);



        // $urutan   = 1;
        // //flag menandai revisi yang belum selesai
        // //flag 1 dan lebih artinya ada yg blm selese
        // $flag = 0;
        // if ($revisions) {
        //     foreach ($revisions as $value) {
        //         if ($value->revision_end_date != '0000-00-00 00:00:00' and $value->revision_end_date != null) {
        //             $atribut_tombol_selesai = 'disabled';
        //             $atribut_tombol_simpan  = 'd-none';
        //             if (!empty($value->revision_notes)) {
        //                 $form_revisi = '<div class="font-italic">' . nl2br($value->revision_notes) . '</div>';
        //             } else {
        //                 $form_revisi = '<div class="font-italic mb-3">Tidak ada Catatan</div>';
        //             }
        //             $badge_revisi = '<span class="badge badge-success">Selesai</span>';
        //         } else {
        //             $flag++;
        //             $atribut_tombol_selesai = '';
        //             $atribut_tombol_simpan  = 'd-inline';
        //             if ($this->level != 'editor') {
        //                 if (!empty($value->revision_notes)) {
        //                     $form_revisi = '<div class="font-italic">' . nl2br($value->revision_notes) . '</div>';
        //                 } else {
        //                     $form_revisi = '<div class="font-italic mb-3">Tidak ada Catatan</div>';
        //                 }
        //             } else {
        //                 $form_revisi = '<textarea rows="6" name="revisi' . $value->revision_id . '" class="form-control summernote-basic" id="revisi' . $value->revision_id . '">' . $value->revision_notes . '</textarea>';
        //             }
        //             $badge_revisi = '<span class="badge badge-info">Dalam Proses</span>';
        //         }
        //         if ($input->role == 'editor') {
        //             $tahap = 'edit';
        //             $role  = 'editor';
        //         } else {
        //             $tahap = 'layout';
        //             $role  = 'layouter';
        //         }

        //         if ($this->level == 'superadmin' or $this->level == 'admin_penerbitan') {
        //             $tombol_hapus = '<button title="Hapus revisi" type="button" class="d-inline btn btn-danger hapus-revisi" data="' . $value->revision_id . '"><i class="fa fa-trash"></i><span class="d-none d-lg-inline"> Hapus</span></button>';
        //             $tombol_edit  = '<button type="button" class="d-inline btn btn-secondary btn-xs trigger-' . $tahap . '-revisi-deadline" data-toggle="modal" data-target="#' . $tahap . '-revisi-deadline" title="' . $tahap . ' Deadline" data="' . $value->revision_id . '">Edit</button>';
        //         } else {
        //             $tombol_hapus = '';
        //             $tombol_edit  = '';
        //         }

        //         $data['revisi'][] = '<section class="card card-expansion-item">
        //             <header class="card-header border-0" id="heading' . $value->revision_id . '">
        //               <button class="btn btn-reset collapsed" data-toggle="collapse" data-target="#collapse' . $value->revision_id . '" aria-expanded="false" aria-controls="collapse' . $value->revision_id . '">
        //                 <span class="collapse-indicator mr-2">
        //                   <i class="fa fa-fw fa-caret-right"></i>
        //                 </span>
        //                 <span>Revisi #' . $urutan . '</span>
        //                 ' . $badge_revisi . '
        //               </button>
        //             </header>
        //             <div id="collapse' . $value->revision_id . '" class="collapse" aria-labelledby="heading' . $value->revision_id . '" data-parent="#accordion-' . $role . '">
        //             <div class="list-group list-group-flush list-group-bordered">
        //                 <div class="list-group-item justify-content-between">
        //                   <span class="text-muted">Tanggal mulai</span>
        //                   <strong>' . format_datetime($value->revision_start_date) . '</strong>
        //                 </div>
        //                 <div class="list-group-item justify-content-between">
        //                   <span class="text-muted">Tanggal selesai</span>
        //                   <strong>' . format_datetime($value->revision_end_date) . '</strong>
        //                 </div>
        //                 <div class="list-group-item justify-content-between">
        //                   <span class="text-muted">Deadline ' . $tombol_edit . '</span>
        //                   <strong>' . format_datetime($value->revision_deadline) . '</strong>
        //                 </div>
        //                 <div class="list-group-item mb-0 pb-0">
        //                   <span class="text-muted">Catatan ' . $role . '</span>
        //                 </div>
        //             </div>
        //             <div class="card-body">
        //             <form>
        //             ' . $form_revisi . '
        //             </form>
        //                 <div class="el-example">
        //                     <button title="Submit catatan" type="button" class="' . $atribut_tombol_simpan . ' btn btn-primary submit-revisi" data="' . $value->revision_id . '"><i class="fas fa-save"></i><span class="d-none d-lg-inline"> Simpan</span></button>
        //                     <button title="Selesai revisi" type="button" class="d-inline btn btn-secondary selesai-revisi" ' . $atribut_tombol_selesai . ' data="' . $value->revision_id . '"><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
        //                     ' . $tombol_hapus . '
        //                 </div>
        //             </div>
        //             </div>
        //           </section>';
        //         $urutan++;
        //     }
        // } else {
        //     $data['revisi'] = 'Tidak ada revisi';
        // }

        // if ($flag > 0) {
        //     $data['flag'] = true;
        // } else {
        //     $data['flag'] = false;
        // }
        // echo json_encode($data);
    }

    public function insert_revision()
    {
        $input = (object) $this->input->post(null);
        if ($input->role == 'editor') {
            $status = array('draft_status' => 17);
        } elseif ($input->role == 'layouter') {
            $status = array('draft_status' => 18);
        }
        $this->revision->update_draft_status($input->draft_id, $status);

        $deadline = date('Y-m-d H:i:s', (strtotime(now()) + (7 * 24 * 60 * 60)));
        $insert   = $this->revision->insert([
            'draft_id' => $input->draft_id,
            'revision_start_date' => now(),
            'revision_role' => $input->role,
            'revision_deadline' => $deadline,
            'user_id' => $this->user_id
        ]);

        if ($insert) {
            return $this->send_json_output(true, $this->lang->line('toast_add_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_add_fail'));
        }
    }

    public function finish_revision()
    {
        $input  = (object) $this->input->post(null);

        // memastikan konsistensi data
        $this->db->trans_begin();

        // update tanggal end revisi
        $this->revision->where('revision_id', $input->revision_id)->update(['revision_end_date' => now()]);

        // update draft status
        $this->revision->update_draft_status($input->draft_id, ['draft_status' => 19]);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        } else {
            $this->db->trans_commit();
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        }
    }

    public function save_revision()
    {
        $input          = (object) $this->input->post(null);
        $update         = $this->revision->where('revision_id', $input->revision_id)->update(['revision_notes' => $input->revision_notes]);

        if ($update) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    public function delete_revision($revision_id)
    {
        $revision = $this->revision->where('revision_id', $revision_id)->get();
        if (!$revision) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        if ($this->revision->where('revision_id', $revision_id)->delete()) {
            return $this->send_json_output(true, $this->lang->line('toast_delete_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_delete_fail'));
        }
    }

    // public function deadlineRevision()
    // {
    //     $input  = (object) $this->input->post(null);
    //     $data   = ['revision_deadline' => $input->revision_deadline, 'revision_start_date' => $input->revision_start_date, 'revision_end_date' => $input->revision_end_date];
    //     $insert = $this->draft->where('revision_id', $input->revision_id)->update($data, 'revision');
    //     if ($insert) {
    //         $data['status'] = true;
    //     } else {
    //         $data['status'] = false;
    //     }
    //     echo json_encode($data);
    // }
}

/* End of file Revision.php */
