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
        $cekusername = $this->session->userdata('username');
        $ceklevel = $this->session->userdata('level');

        $tot_category     = count($this->home->getAll('category'));
        $tot_draft     = count($this->home->getAll('book'));
        $tot_book     = count($this->home->getAll('draft'));
        $tot_author     = count($this->home->getAll('author'));
        $tot_reviewer     = count($this->home->getAll('reviewer'));

        $drafts = array();
        $count = array();

        if($ceklevel == 'reviewer'){
            $drafts = $this->home->join3('draft_reviewer','draft','draft')->join3('reviewer','draft_reviewer','reviewer')->join3('user','reviewer','user')->where('user.username',$cekusername)->getAll('draft');
            $drafts_newest = $this->home->join3('draft_reviewer','draft','draft')->join3('reviewer','draft_reviewer','reviewer')->join3('user','reviewer','user')->where('user.username',$cekusername)->limit(5)->orderBy('entry_date','desc')->getAll('draft');

            foreach ($drafts_newest as $key => $value) {
                $rev = $this->home->getIdAndName('reviewer', 'draft_reviewer', $value->draft_id,'draft');
                $value->rev = key(array_filter(
                    $rev,
                    function ($e) {
                        return $e->reviewer_id == $this->session->userdata('role_id');
                    }
                ));

                if($value->rev == 0){
                    if(!empty($value->review1_deadline)){
                        $value->deadline = $value->review1_deadline;
                    }
                }elseif($value->rev == 1){
                    if(!empty($value->review2_deadline)){
                        $value->deadline = $value->review2_deadline;
                    }
                }   
            }

            $count_sudah=0;
            $count_belum=0;
            $count_sedang=0;
            $count_total=count($drafts);

            foreach ($drafts as $key => $value) {
                $rev = $this->home->getIdAndName('reviewer', 'draft_reviewer', $value->draft_id,'draft');
                $value->rev = key(array_filter(
                    $rev,
                    function ($e) {
                        return $e->reviewer_id == $this->session->userdata('role_id');
                    }
                ));

                if($value->rev == 0){
                    if($value->review1_flag!=''){
                        $count_sudah++;
                    }elseif($value->review1_notes==''){
                        $count_belum++;
                    }else{
                        $count_sedang++;
                    }
                }
                if($value->rev == 1){
                    if($value->review2_flag!=''){
                        $count_sudah++;
                    }elseif($value->review2_notes==''){
                        $count_belum++;
                    }else{
                        $count_sedang++;
                    }
                }   
            }

            $count['count_sudah'] = $count_sudah;
            $count['count_sedang'] = $count_sedang;
            $count['count_belum'] = $count_belum;
            $count['count_total'] = $count_total;
        }elseif($ceklevel == 'author'){
            $categories = $this->home->orderBy('category_name')->getAll('category');
        }


        $pages    = $this->pages;
        $main_view  = 'home/index';
	$this->load->view('template', compact('categories','count','drafts_newest','drafts','tot_category','tot_draft','tot_book','tot_author','tot_reviewer','pages', 'main_view'));        
	}
}
