<?php defined('BASEPATH') or exit('No direct script access allowed');

class Responsibility extends Operator_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'responsibility';
    }

    public function index($page = null)
    {
        $responsibilities = $this->responsibility->join('draft')->join('user')->order_by('draft.draft_id')->order_by('user.user_id')->order_by('responsibility_id')->paginate($page)->get_all();
        $tot              = $this->responsibility->join('draft')->join('user')->order_by('draft.draft_id')->order_by('user.user_id')->order_by('responsibility_id')->get_all();
        $total            = count($tot);
        $pages            = $this->pages;
        $main_view        = 'responsibility/index_responsibility';
        $pagination       = $this->responsibility->make_pagination(site_url('responsibility'), 2, $total);

        $this->load->view('template', compact('pages', 'main_view', 'responsibilities', 'pagination', 'total'));
    }

    public function add($jenis_staff)
    {
        $data = array();
        if (!$_POST) {
            $input = (object) $this->responsibility->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->responsibility->validate()) {
            $data['validasi'] = false;
            echo json_encode($data);
            // $pages     = $this->pages;
            // $main_view   = 'responsibility/form_responsibility';
            // $form_action = 'responsibility/add';
            // $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        //$datax = array('draft_id' => $input->draft_id);
        if ($jenis_staff == 'editor') {
            $data['jmlstaff'] = count($this->responsibility->join('user')->where('user.level', 'editor')->where('responsibility.draft_id', $input->draft_id)->get_all());
            if ($data['jmlstaff'] > 1) {
                $data['validasi'] = 'max';
                echo json_encode($data);
                return;
            }
        } elseif ($jenis_staff == 'layouter') {
            $data['jmlstaff'] = count($this->responsibility->join('user')->where('user.level', 'layouter')->where('responsibility.draft_id', $input->draft_id)->get_all());
            if ($data['jmlstaff'] > 1) {
                $data['validasi'] = 'max';
                echo json_encode($data);
                return;
            }
        }

        if ($this->responsibility->insert($input)) {
            $data['validasi'] = true;
            $data['status']   = true;
            $data['isi']      = 'haahashsahdhasdhasd';
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $data['validasi'] = true;
            $data['status']   = false;
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        echo json_encode($data);
    }

    public function mulai_proses($jenis_staff = null)
    {
        //ketika editor/layouter klik mulai maka akan mencatat tanggal mulai dan tanggal deadline
        $input = (object) $this->input->post(null, true);

        if ($jenis_staff == 'editor') {
            $status = array('draft_status' => 6);
            $this->responsibility->update_draft_status($input->draft_id, $status);
            $current_date    = strtotime(date('Y-m-d H:i:s'));
            $end_date        = 30 * 24 * 60 * 60;
            $deadline_editor = date('Y-m-d H:i:s', ($current_date + $end_date));
            $this->responsibility->edit_draft_date($input->draft_id, 'edit_deadline', $deadline_editor);
            if ($this->responsibility->edit_draft_date($input->draft_id, $input->col)) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
        } elseif ($jenis_staff == 'layouter') {
            $status = array('draft_status' => 8);
            $this->responsibility->update_draft_status($input->draft_id, $status);
            $current_date      = strtotime(date('Y-m-d H:i:s'));
            $end_date          = 30 * 24 * 60 * 60;
            $deadline_layouter = date('Y-m-d H:i:s', ($current_date + $end_date));
            $this->responsibility->edit_draft_date($input->draft_id, 'layout_deadline', $deadline_layouter);
            if ($this->responsibility->edit_draft_date($input->draft_id, $input->col)) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $status = array('draft_status' => 15);
            $this->responsibility->update_draft_status($input->draft_id, $status);
            if ($this->responsibility->edit_draft_date($input->draft_id, $input->col)) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
        }
        echo json_encode($data);
    }

    public function selesai_proses($jenis_staff = null)
    {
        //ketika editor/layouter klik selesai maka akan mencatat tanggal selesai
        $input = (object) $this->input->post(null, true);

        if ($jenis_staff == 'editor') {
            //untuk set performance status
            // $this->db->query("UPDATE responsibility
            //  LEFT JOIN user ON responsibility.user_id = user.user_id
            //  SET performance_status = 2
            //  WHERE level = '".$jenis_staff."' and draft_id = ".$input->draft_id);

            if ($this->responsibility->edit_draft_date($input->draft_id, $input->col)) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
        } elseif ($jenis_staff == 'layouter') {
            //untuk set performance status
            // $this->db->query("UPDATE responsibility
            // LEFT JOIN user ON responsibility.user_id = user.user_id
            // SET performance_status = 2
            // WHERE level = '".$jenis_staff."' and draft_id = ".$input->draft_id);

            if ($this->responsibility->edit_draft_date($input->draft_id, $input->col)) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
        }
        echo json_encode($data);
    }

    public function edit($id = null)
    {
        $responsibility = $this->responsibility->where('responsibility_id', $id)->get();
        if (!$responsibility) {
            $this->session->set_flashdata('warning', 'Responsibility data were not available');
            redirect('responsibility');
        }

        if (!$_POST) {
            $input = (object) $responsibility;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->responsibility->validate()) {
            $pages       = $this->pages;
            $main_view   = 'responsibility/form_responsibility';
            $form_action = "responsibility/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->responsibility->where('responsibility_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('responsibility');
    }

    public function delete($id = null)
    {
        $data           = array();
        $responsibility = $this->responsibility->where('responsibility_id', $id)->get();
        if (!$responsibility) {
            $data['cek'] = false;
            $this->session->set_flashdata('warning', 'Responsibility data were not available');
            //redirect('responsibility');
        }

        if ($this->responsibility->where('responsibility_id', $id)->delete()) {
            $data['cek']    = true;
            $data['status'] = true;
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $data['cek']    = true;
            $data['status'] = false;
            $this->session->set_flashdata('error', 'Data failed to delete');
        }

        echo json_encode($data);
    }

    public function search($page = null)
    {
        $keywords         = $this->input->get('keywords', true);
        $responsibilities = $this->responsibility->like('responsibility_id', $keywords)
            ->or_like('user_id', $keywords)
            ->join('draft')
            ->join('user')
            ->order_by('draft.draft_id')
            ->order_by('user.user_id')
            ->order_by('responsibility_id')
            ->paginate($page)
            ->get_all();
        $tot = $this->responsibility->like('responsibility_id', $keywords)
            ->or_like('user_id', $keywords)
            ->join('draft')
            ->join('user')
            ->order_by('draft.draft_id')
            ->order_by('user.user_id')
            ->order_by('responsibility_id')
            ->get_all();
        $total = count($tot);

        $pagination = $this->responsibility->make_pagination(site_url('responsibility/search/'), 3, $total);

        if (!$responsibilities) {
            $this->session->set_flashdata('warning', 'Data were not found');
            redirect('responsibility');
        }

        $pages     = $this->pages;
        $main_view = 'responsibility/index_responsibility';
        $this->load->view('template', compact('pages', 'main_view', 'responsibilities', 'pagination', 'total'));
    }

    /*
    |-----------------------------------------------------------------
    | Callback
    |-----------------------------------------------------------------
     */
//    public function alpha_coma_dash_dot_space($str)
    //    {
    //        if ( !preg_match('/^[a-zA-Z .,\-]+$/i',$str) )
    //        {
    //            $this->form_validation->set_message('alpha_coma_dash_dot_space', 'Can only be filled with letters, numbers, dash(-), dot(.), and comma(,).');
    //            return false;
    //        }
    //    }
    //
    public function unique_responsibility_match()
    {
        $user_id           = $this->input->post('user_id');
        $draft_id          = $this->input->post('draft_id');
        $responsibility_id = $this->input->post('responsibility_id');

        $this->responsibility->where('user_id', $user_id);
        $this->responsibility->where('draft_id', $draft_id);
        !$responsibility_id || $this->responsibility->where('responsibility_id !=', $responsibility_id);
        $responsibility = $this->responsibility->get();

        if (count($responsibility)) {
            $this->form_validation->set_message('unique_responsibility_match', 'Both of %s has been used');
            return false;
        }
        return true;
    }

}
