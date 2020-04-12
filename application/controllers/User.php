<?php defined('BASEPATH') or exit('No direct script access allowed');
class User extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'user';
    }

    public function index($page = null)
    {
        $filters = [
            'keyword' => $this->input->get('keyword', true),
            'level'   => $this->input->get('level', true),
            'status'  => $this->input->get('status', true),
        ];

        // custom per page
        $this->user->per_page = $this->input->get('per_page', true) ?? 10;

        $get_data = $this->user->filter_data($filters, $page);

        $users      = $get_data['data'];
        $total      = $get_data['count'];
        $pages      = $this->pages;
        $main_view  = 'user/index_user';
        $pagination = $this->user->make_pagination(site_url('user'), 2, $total);
        $this->load->view('template', compact('pagination', 'pages', 'main_view', 'users', 'total'));
    }

    public function api_get_staffs($level)
    {
        $staffs = $this->user->get_all_staffs($level);
        return $this->send_json_output(true, $staffs);
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->user->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->user->validate()) {
            $pages       = $this->pages;
            $main_view   = 'user/form_user';
            $form_action = 'user/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        // hash password
        if ($this->user->insert_data($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }

        redirect($this->pages);
    }

    public function edit($id = null)
    {
        $user = $this->user->where('user_id', $id)->get();
        if (!$user) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        // prevent delete superadmin
        if ($user->level == 'superadmin' && $user->username == 'superadmin') {
            $this->session->set_flashdata('error', $this->lang->line('toast_error_not_authorized'));
            redirect($this->pages);
        }

        if (!$_POST) {
            $input = (object) $user;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->user->validate()) {
            $pages       = $this->pages;
            $main_view   = 'user/form_user';
            $form_action = "user/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->user->update_data($input, $id)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect($this->pages);
    }

    public function delete($id = null)
    {
        $user = $this->user->where('user_id', $id)->get();
        if (!$user) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        // prevent delete superadmin
        if ($user->level == 'superadmin' && $user->username == 'superadmin') {
            $this->session->set_flashdata('error', $this->lang->line('toast_error_not_authorized'));
            redirect($this->pages);
        }

        if ($this->user->where('user_id', $id)->delete()) {
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_delete_fail'));
        }

        redirect($this->pages);
    }

    public function required_on($str, $condition)
    {
        if ($this->uri->segment(2) == $condition) {
            if (!$str) {
                $this->form_validation->set_message('required_on', 'Bidang %s dibutuhkan');
                return false;
            }
        }
        return true;
    }

    public function unique_data($str, $data_key)
    {
        $author_id = $this->input->post('user_id');
        if (!$str) {
            return true;
        }
        $this->user->where($data_key, $str);
        !$author_id || $this->user->where_not('user_id', $author_id);
        $user = $this->user->get();
        if ($user) {
            $this->form_validation->set_message('unique_data', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }
}
