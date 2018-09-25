<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller
{

	public function __construct()
    {
        parent::__construct();
        $this->pages = 'user';
    }

	public function index($page = null)
	{
        $users      = $this->user->paginate($page)->orderBy('user_id')->getAll();
        $tot = $this->user->orderBy('user_id')->getAll();
        $total    = count($tot);
        $pages   = $this->pages;
        $main_view  = 'user/index_user';
        $pagination = $this->user->makePagination(site_url('user'), 2, $total);
		$this->load->view('template', compact('pagination','pages', 'main_view', 'users', 'total'));
	}
 
//--add--        
        	public function add()
	{
        if (!$_POST) {
            $input = (object) $this->user->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->user->validate()) {
            $pages     = $this->pages;
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
        
//--edit--        
        public function edit($id = null)
	{
        $user = $this->user->where('user_id', $id)->get();
        if (!$user) {
            $this->session->set_flashdata('warning', 'User data were not available');
            redirect('user');
        }

        if (!$_POST) {
            $input = (object) $user;
            $input->password = '';
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->user->validate()) {
            $pages    = $this->pages;
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

	public function delete($id = null)
	{
		$user = $this->user->where('user_id', $id)->get();
        if (!$user) {
            $this->session->set_flashdata('warning', 'User data were not available');
            redirect('user');
        }
        //prevent delete superadmin
        if ($user->level == 'superadmin' && $user->username == 'superadmin'){
            redirect('user');
        }

        if ($this->user->where('user_id', $id)->delete()) {
			$this->session->set_flashdata('success', 'Data deleted');
		} else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }

		redirect('user');
	}        

// -- search -- 

        public function search($page = null)
        {
        $keywords   = $this->input->get('keywords', true);
        $users     = $this->user->like('username', $keywords)
                                  ->orLike('level', $keywords)
                                  ->orderBy('user_id')
                                  ->orderBy('username')
                                  ->orderBy('level')
                                  ->paginate($page)
                                  ->getAll();
        $tot        = $this->user->like('username', $keywords)
                                  ->orLike('level', $keywords)
                                  ->orderBy('user_id')
                                  ->orderBy('username')
                                  ->orderBy('level')
                                  ->getAll();
        $total = count($tot);

        $pagination = $this->user->makePagination(site_url('user/search/'), 3, $total);

        if (!$users) {
            $this->session->set_flashdata('warning', 'Data were not found');
            redirect('user');
        }

        $pages    = $this->pages;
        $main_view  = 'user/index_user';
        $this->load->view('template', compact('pages', 'main_view', 'users', 'pagination', 'total'));
    }        
        
    /*
    |-----------------------------------------------------------------
    | Callback
    |-----------------------------------------------------------------
    */
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
        $user_id   = $this->input->post('user_id');

        $this->user->where('username', $username);
        !$user_id|| $this->user->where('user_id !=', $user_id);
        $user = $this->user->get();

        if (count($user)) {
            $this->form_validation->set_message('unique_username', '%s has been used');
            return false;
        }
        return true;
    }
}