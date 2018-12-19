<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Author extends Operator_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->pages = 'author';
        //khusus admin
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel == 'author' || $ceklevel == 'reviewer' || $ceklevel == 'editor' || $ceklevel == 'layouter'){
            redirect('home');
        }
    }

	public function index($page = null)
	{
        $authors    = $this->author->join('work_unit')->join('institute')->join('bank')->join('user')->orderBy('work_unit.work_unit_id')->orderBy('institute.institute_id')->orderBy('author_nip')->paginate($page)->getAll();
        $tot        = $this->author->join('work_unit')->join('institute')->join('bank')->join('user')->orderBy('work_unit.work_unit_id')->orderBy('institute.institute_id')->orderBy('author_nip')->getAll();
        $total      = count($tot);
        $pages      = $this->pages;
        $main_view  = 'author/index_author';
        $pagination = $this->author->makePagination(site_url('author'), 2, $total);
        
        $this->load->view('template', compact('pages', 'main_view', 'authors', 'pagination', 'total'));
	}

    public function view($halaman, $id = null)
    {
        if($halaman and $id == null){
            redirect('author');
        }

        $author = $this->author->join3('user','author','user')->where('author_id', $id)->get();
        if (!$author) {
            $this->session->set_flashdata('warning', 'Author data were not available');
            redirect('author');
        }

        if (!$_POST) {
            $input = (object) $author;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        //total draft penulis
        $drafts =  $this->author->select(['draft_author.author_id','author_name','draft_author.draft_id','draft_title','category_name','theme_name','entry_date','finish_date'])->join3('draft_author','author','author')->join3('draft','draft_author','draft')->join3('category','draft','category')->join3('theme','draft','theme')->where('draft_author.author_id',$id)->getAll();

        //total riwayat draft
        $total_draft =  count($drafts);

        $books =  $this->author->join3('draft','book','draft')->join3('draft_author','draft','draft')->join3('author','draft_author','author')->where('draft_author.author_id',$id)->getAll('book');

        $total_book =  count($books);

        $main_view   = 'author/view_author';
        $pages    = $this->pages;
        $this->load->view('template', compact('pages','main_view', 'drafts', 'input', 'total_draft','books','total_book'));
    
    }
        
        
        public function add()
	{
        if (!$_POST) {
            $input = (object) $this->author->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->author->validate()){
            if (!empty($_FILES) && $_FILES['author_ktp']['size'] > 0) {
                $getextension=explode(".",$_FILES['author_ktp']['name']);            
                $authorKTP  = str_replace(" ","_","KTP".'_'.$input->author_name . '_' . date('YmdHis').'.'.$getextension[1]) ; // author ktp name
                $upload = $this->author->uploadAuthorKTP('author_ktp', $authorKTP);

                if ($upload) {
                    $input->author_ktp =  "$authorKTP"; // Data for column "author".
                }
            }
        }
        

        if (!$this->author->validate() || $this->form_validation->error_array()) {
            $pages     = $this->pages;
            $main_view   = 'author/form_author';
            $form_action = 'author/add';

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        
        

        if ($this->author->insert($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        redirect('author');
	}
        
    public function edit($id = null)
	{
        $author = $this->author->where('author_id', $id)->get();
        if (!$author) {
            $this->session->set_flashdata('warning', 'Author data were not available');
            redirect('author');
        }

        if (!$_POST) {
            $input = (object) $author;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!empty($_FILES) && $_FILES['author_ktp']['size'] > 0) {
            // Upload new draft (if any)
            $getextension=explode(".",$_FILES['author_ktp']['name']);            
            $authorKTP  = str_replace(" ","_",$input->author_name . '_' . date('YmdHis').".".$getextension[1]); // author ktp name
            $upload = $this->author->uploadAuthorKTP('author_ktp', $authorKTP);

            if ($upload) {
                $input->author_ktp =  "$authorKTP";
                // Delete old KTP file
                if ($author->author_ktp) {
                    $this->author->deleteAuthorKTP($author->author_ktp);
                }
            }
        }

        if (!$this->author->validate() || $this->form_validation->error_array()) {
            $pages    = $this->pages;
            $main_view   = 'author/form_author';
            $form_action = "author/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->author->where('author_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('author');
	}
        
    public function delete($id = null)
	{
	   $author = $this->author->where('author_id', $id)->get();
        if (!$author) {
            $this->session->set_flashdata('warning', 'Author data were not available');
            redirect('author');
        }
        //
        $get_user = array();
        $get_user = $this->author->select(['user.user_id','user.level'])->join('user')->where('author_id', $id)->get();
        if ($this->author->where('author_id', $id)->delete()) {
            //deletektp
            if($author->author_ktp != ''){
                $this->author->deleteAuthorKTP($author->author_ktp);
            }
            //set ke level reviewer, jika akun author dihapus
             if($get_user->level =='author_reviewer'){
                $data_level = array(
                    'level' => 'reviewer'
                );
                $this->author->where('user_id',$get_user->user_id)->update($data_level, 'user');
             }

			$this->session->set_flashdata('success', 'Data deleted');
		} else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }
		redirect('author');
	}

    public function copyToReviewer($user_id, $nip, $name) 
    {

        $this->load->model('reviewer_model', 'reviewer', true);
        $reviewer_id = $this->reviewer->getIdRoleFromUserId($user_id, 'reviewer');

        if ($reviewer_id == 0) {
            $data = array(
                'user_id' => $user_id,
                'reviewer_nip' => $nip,
                'reviewer_name' => urldecode($name)
            );

            if ($this->reviewer->insert($data)) {
                $reviewer_id = $this->db->insert_id();

                if ($reviewer_id != 0) {
                    $data_level = array(
                        'level' => 'author_reviewer'
                    );
                    $this->reviewer->where('user_id', $user_id)->update($data_level, 'user');
                    redirect('reviewer/edit/' . $reviewer_id);
                }
            }
        } else {
            $this->session->set_flashdata('warning', 'User telah memiliki role Author dan Reviewer');
            redirect('author');

        }
    }
        
    public function search($page = null)
    {
        $keywords   = $this->input->get('keywords', true);
        $authors     = $this->author->like('work_unit_name', $keywords)
                                  ->orLike('institute_name', $keywords)
                                  ->orLike('author_nip', $keywords)
                                  ->orLike('author_name', $keywords)
                                  ->orLike('username', $keywords)
                                  ->join('work_unit')
                                  ->join('institute')
                                  ->join('bank')
                                  ->join('user')
                                  ->orderBy('work_unit.work_unit_id')
                                  ->orderBy('institute.institute_id')                
                                  ->orderBy('author_name')
                                  ->paginate($page)
                                  ->getAll();
        $total        = $this->author->like('work_unit_name', $keywords)
                                  ->orLike('institute_name', $keywords)
                                  ->orLike('author_nip', $keywords)
                                  ->orLike('author_name', $keywords)
                                  ->orLike('username', $keywords)
                                  ->join('work_unit')
                                  ->join('institute')
                                  ->join('bank')
                                  ->join('user')
                                  ->orderBy('work_unit.work_unit_id')
                                  ->orderBy('institute.institute_id')                
                                  ->orderBy('author_name')
                                  ->count();

        $pagination = $this->author->makePagination(site_url('author/search/'), 3, $total);

        if (!$authors) {
            $this->session->set_flashdata('warning', 'Data were not found');
            redirect('author');
        }

        $pages    = $this->pages;
        $main_view  = 'author/index_author';
        $this->load->view('template', compact('pages', 'main_view', 'authors', 'pagination', 'total'));
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
    public function unique_author_contact()
    {
        $author_contact      = $this->input->post('author_contact');
        $author_id = $this->input->post('author_id');
        if($author_contact==''){return true;}
        
        $this->author->where('author_contact', $author_contact);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();

        if (count($author)) {
            $this->form_validation->set_message('unique_author_contact', '%s has been used');
            return false;
        }
        return true;
    }
    
        public function unique_author_email()
    {
        $author_email      = $this->input->post('author_email');
        $author_id = $this->input->post('author_id');
        if($author_email==''){return true;}
        
        $this->author->where('author_email', $author_email);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();

        if (count($author)) {
            $this->form_validation->set_message('unique_author_email', '%s has been used');
            return false;
        }
        return true;
    }
    
            public function unique_author_saving_num()
    {
        $author_saving_num      = $this->input->post('author_saving_num');
        $author_id = $this->input->post('author_id');
        if($author_saving_num==''){return true;}
        
        $this->author->where('author_saving_num', $author_saving_num);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();

        if (count($author)) {
            $this->form_validation->set_message('unique_author_saving_num', '%s has been used');
            return false;
        }
        return true;
    }
            public function unique_author_nip()
    {
        $author_nip      = $this->input->post('author_nip');
        $author_id = $this->input->post('author_id');

        $this->author->where('author_nip', $author_nip);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();

        if (count($author)) {
            $this->form_validation->set_message('unique_author_nip', '%s has been used');
            return false;
        }
        return true;
    }
    
        public function unique_author_username()
    {
        $user_id      = $this->input->post('user_id');
        $author_id = $this->input->post('author_id');
        //boleh kosong
        if($user_id ==''){return true;}

        $this->author->where('user_id', $user_id);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();

        if (count($author)) {
            $this->form_validation->set_message('unique_author_username', '%s has been used');
            return false;
        }
        return true;
    }
}