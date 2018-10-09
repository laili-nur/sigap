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
        $drafts = array();
        $count = array();

        $drafts['tot_category']     = count($this->home->getAll('category'));
        $drafts['tot_draft']     = count($this->home->getAll('draft'));
        $drafts['tot_book']     = count($this->home->getAll('book'));
        $drafts['tot_author']     = count($this->home->getAll('author'));
        $drafts['tot_reviewer']     = count($this->home->getAll('reviewer'));

        $drafts['tot_desk_phase'] = count($tot = $this->home->where('draft_status','0')->getAll('draft'));
        $drafts['tot_review_phase'] = count($tot = $this->home->where('is_review','n')->where('draft_status','4')->getAll('draft'));
        $drafts['tot_edit_phase'] = count($tot = $this->home->where('is_review','y')->where('is_edit','n')->whereNot('draft_status','99')->getAll('draft'));
        $drafts['tot_layout_phase'] = count($tot = $this->home->where('is_edit','y')->where('is_layout','n')->whereNot('draft_status','99')->getAll('draft'));
        $drafts['tot_proofread_phase'] = count($tot = $this->home->where('is_proofread','n')->where('is_layout','y')->whereNot('draft_status','99')->getAll('draft'));
        $drafts['tot_approved'] = count($tot = $this->home->where('draft_status','14')->getAll('draft'));
        $drafts['tot_rejected'] = count($tot = $this->home->where('draft_status','99')->getAll('draft'));



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

            $drafts = $this->home->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('user.username',$cekusername)->getAll('draft');
            $draft_desk = $this->home->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('user.username',$cekusername)->where('draft_status','0')->getAll('draft');
            $draft_review = $this->home->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('user.username',$cekusername)->where('draft_status','4')->getAll('draft');
            $draft_edit = $this->home->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('user.username',$cekusername)->where('is_review','y')->where('is_edit','n')->whereNot('draft_status','99')->getAll('draft');
            $draft_layout = $this->home->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('user.username',$cekusername)->where('is_edit','y')->where('is_layout','n')->whereNot('draft_status','99')->getAll('draft');
            $draft_proofread = $this->home->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('user.username',$cekusername)->where('is_layout','y')->where('is_proofread','n')->whereNot('draft_status','99')->getAll('draft');

            $drafts_approved = $this->home->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->whereNot('draft_status','99')->where('user.username',$cekusername)->getAll('draft');
            $drafts_rejected = $this->home->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('draft_status','99')->where('user.username',$cekusername)->getAll('draft');
            $drafts_book = $this->home->join3('draft','book','draft')->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('user.username',$cekusername)->getAll('book');

            $count['draft_total'] = count($drafts);
            $count['draft_approved'] = count($drafts_approved);
            $count['draft_rejected'] = count($drafts_rejected);
            $count['draft_book'] = count($drafts_book);
            $count['draft_desk'] = count($draft_desk);
            $count['draft_review'] = count($draft_review);
            $count['draft_edit'] = count($draft_edit);
            $count['draft_layout'] = count($draft_layout);
            $count['draft_proofread'] = count($draft_proofread);
        }else{}


        $pages    = $this->pages;
        $main_view  = 'home/index';
	$this->load->view('template', compact('categories','count','drafts_newest','drafts','pages', 'main_view'));        
	}
}
