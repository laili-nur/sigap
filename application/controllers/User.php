<?php defined('BASEPATH') or exit('No direct script access allowed');
class User extends Operator_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'user';
    }

    public function index($page = null)
    {
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'superadmin') {
            redirect('home');
        }
        $users      = $this->user->paginate($page)->order_by('username')->order_by('level')->get_all();
        $total      = $this->user->order_by('level')->order_by('username')->count();
        $pages      = $this->pages;
        $main_view  = 'user/index_user';
        $pagination = $this->user->make_pagination(site_url('user'), 2, $total);
        $this->load->view('template', compact('pagination', 'pages', 'main_view', 'users', 'total'));
    }

    public function add()
    {
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'superadmin') {
            redirect('home');
        }
        if (!$_POST) {
            $input = (object) $this->user->getDefaultValues();
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
        //--hash password--
        $input->password = md5($input->password);
        if ($this->user->insert($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('user');
    }

    public function edit($id = null)
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
        if (!$_POST) {
            $input           = (object) $user;
            $input->password = '';
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
        // Password
        if (!empty($input->password)) {
            $input->password = md5($input->password);
        } else {
            unset($input->password);
        }
        if ($this->user->where('user_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('user');
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

    public function search($page = null)
    {
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'superadmin') {
            redirect('home');
        }
        $keywords   = $this->input->get('keywords', true);
        $users      = $this->user->like('username', $keywords)->or_like('level', $keywords)->order_by('user_id')->order_by('username')->order_by('level')->paginate($page)->get_all();
        $tot        = $this->user->like('username', $keywords)->or_like('level', $keywords)->order_by('user_id')->order_by('username')->order_by('level')->get_all();
        $total      = count($tot);
        $pagination = $this->user->make_pagination(site_url('user/search/'), 3, $total);
        if (!$users) {
            $this->session->set_flashdata('warning', 'Data were not found');
        }
        $pages     = $this->pages;
        $main_view = 'user/index_user';
        $this->load->view('template', compact('pages', 'main_view', 'users', 'pagination', 'total'));
    }

    public function is_password_required()
    {
        $edit = $this->uri->segment(2);
        if ($edit != 'edit') {
            $password = $this->input->post('password', true);
            if (empty($password)) {
                $this->form_validation->set_message('is_password_required', '%s must be filled');
                return false;
            }
        }
        return true;
    }
    public function unique_username()
    {
        $username = $this->input->post('username');
        $user_id  = $this->input->post('user_id');
        $this->user->where('username', $username);
        !$user_id || $this->user->where('user_id !=', $user_id);
        $user = $this->user->get();
        if ($user) {
            $this->form_validation->set_message('unique_username', '%s has been used');
            return false;
        }
        return true;
    }
}
