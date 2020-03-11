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

    public function changepassword($id = null)
    {
        $ceklevel  = $this->session->userdata('level');
        $cekuri    = $this->uri->segment(3);
        $cekuserid = $this->session->userdata('user_id');
        if ($ceklevel != 'superadmin' and $cekuserid != $cekuri) {
            redirect('error404');
        } elseif ($ceklevel == 'superadmin') {
        }
        $user = $this->user->where('user_id', $id)->get();
        if (!$user) {
            $this->session->set_flashdata('warning', 'User data were not available');
            redirect('user');
        }
        if (!$_POST) {
            $input           = (object) $user;
            $input->password = '';
        } else {
            $input = (object) $this->input->post(null, true);
        }
        if (!$this->user->validate()) {
            $pages       = $this->pages;
            $main_view   = 'user/form_changepassword';
            $form_action = "user/changepassword/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        //check password
        $input->password        = md5($input->password);
        $input->newpassword     = md5($input->newpassword);
        $input->confirmpassword = md5($input->confirmpassword);
        $datax                  = array('user_id' => $this->session->userdata('user_id'));
        $cekpass                = $this->user->select(['password'])->getwhere($datax);
        if ($input->password == $cekpass->password) {
            if ($input->password != $input->newpassword) {
                if ($input->newpassword == $input->confirmpassword) {
                    $input->password = $input->newpassword;
                    $this->session->set_flashdata('success', 'Password saved');
                    unset($input->newpassword);
                    unset($input->confirmpassword);
                } else {
                    $this->session->set_flashdata('error', 'Password baru dan konfirmasi password tidak sama');
                    unset($input->password);
                    unset($input->newpassword);
                    unset($input->confirmpassword);
                }
            } else {
                $this->session->set_flashdata('error', 'Password baru harus berbeda dengan password lama');
                unset($input->password);
                unset($input->newpassword);
                unset($input->confirmpassword);
            }
        } else {
            $this->session->set_flashdata('error', 'Password lama tidak sesuai');
            unset($input->password);
            unset($input->newpassword);
            unset($input->confirmpassword);
        }
        if ($this->user->where('user_id', $id)->update($input)) {
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('user/changepassword/' . $this->session->userdata('user_id'));
    }

    public function delete($id = null)
    {
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'superadmin') {
            redirect('home');
        }
        $user = $this->user->where('user_id', $id)->get();
        if (!$user) {
            $this->session->set_flashdata('warning', 'User data were not available');
            redirect('user');
        }
        //prevent delete superadmin
        if ($user->level == 'superadmin' && $user->username == 'superadmin') {
            redirect('user');
        }
        if ($this->user->where('user_id', $id)->delete()) {
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }
        redirect('user');
    }

    public function required_when_add($str)
    {
        if ($this->uri->segment(2) == 'add') {
            if (!$str) {
                $this->form_validation->set_message('required_when_add', 'Bidang %s dibutuhkan');
                return false;
            }
        }
        return true;
    }

    public function required_when_edit($str)
    {
        if ($this->uri->segment(2) == 'edit') {
            if (!$str) {
                $this->form_validation->set_message('required_when_edit', 'Bidang %s dibutuhkan');
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