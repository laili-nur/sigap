<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->pages = 'home';
        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }

    }

	public function index($page = null)
	{

        $tot_category     = count($this->home->getAll('category'));
        $tot_draft     = count($this->home->getAll('book'));
        $tot_book     = count($this->home->getAll('draft'));
        $tot_author     = count($this->home->getAll('author'));
        $tot_reviewer     = count($this->home->getAll('reviewer'));

        $pages    = $this->pages;
        $main_view  = 'home/index';
	$this->load->view('template', compact('tot_category','tot_draft','tot_book','tot_author','tot_reviewer','pages', 'main_view'));        
	}
}
