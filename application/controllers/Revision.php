<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Revision extends MY_Controller
{
    public function get_revision($draft_id, $progress)
    {
        if ($progress == 'edit') {
            $role = 'editor';
        } else if ($progress == 'layout') {
            $role = 'layouter';
        }
        $revisions = $this->revision->where('revision_role', $role)->where('draft_id', $draft_id)->get_all();

        return $this->send_json_output(true, $revisions);
    }

    public function insert_revision()
    {
        $input = (object) $this->input->post(null);
        if ($input->revision_type == 'edit') {
            $status = array('draft_status' => 17);
            $role = 'editor';
        } elseif ($input->revision_type == 'layout') {
            $status = array('draft_status' => 18);
            $role = 'layouter';
        }

        $this->revision->update_draft_status($input->draft_id, $status);

        $deadline = date('Y-m-d H:i:s', (strtotime(now()) + (7 * 24 * 60 * 60)));
        $insert   = $this->revision->insert([
            'draft_id'            => $input->draft_id,
            'revision_start_date' => now(),
            'revision_role'       => $role,
            'revision_deadline'   => $deadline,
            'user_id'             => $this->user_id,
        ]);

        if ($insert) {
            return $this->send_json_output(true, $this->lang->line('toast_add_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_add_fail'));
        }
    }

    public function finish_revision()
    {
        $input = (object) $this->input->post(null);

        // memastikan konsistensi data
        $this->db->trans_begin();

        // update tanggal end revisi
        $this->revision
            ->where('revision_id', $input->revision_id)
            ->update([
                'revision_end_date' => now(),
                'revision_notes' => $input->revision_notes
            ]);

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
        $input  = (object) $this->input->post(null);
        $update = $this->revision->where('revision_id', $input->revision_id)->update(['revision_notes' => $input->revision_notes]);

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

    public function save_deadline()
    {
        $input  = (object) $this->input->post(null);
        $update = $this->revision->where('revision_id', $input->revision_id)->update(['revision_deadline' => $input->revision_deadline]);

        if ($update) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }
}

/* End of file Revision.php */
