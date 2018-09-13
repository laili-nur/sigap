<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Draft extends Operator_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->pages = 'draft';
    }

	public function index($page = null)
	{
        $drafts     = $this->draft->join('category')->join('theme')->orderBy('category.category_id')->orderBy('theme.theme_id')->orderBy('draft_id')->paginate($page)->getAll();
        $tot        = $this->draft->join('category')->join('theme')->orderBy('category.category_id')->orderBy('theme.theme_id')->orderBy('draft_id')->getAll();
        $total     = count($tot);
        $pages    = $this->pages;
        $main_view  = 'draft/index_draft';
        $pagination = $this->draft->makePagination(site_url('draft'), 2, $total);

		$this->load->view('template', compact('pages', 'main_view', 'drafts', 'pagination', 'total'));
	}
        
        
// --add--        
        public function add()
	{
        if (!$_POST) {
            $input = (object) $this->draft->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!empty($_FILES) && $_FILES['draft_file']['size'] > 0) {
            $getextension=explode(".",$_FILES['draft_file']['name']);            
            $draftFileName  = str_replace(" ","_",$input->draft_title . '_' . date('YmdHis').".".$getextension[1]) ; // draft file name
            $upload = $this->draft->uploadDraftfile('draft_file', $draftFileName);

            if ($upload) {
                $input->draft_file =  "$draftFileName"; // Data for column "draft".
            }
        }

        if (!$this->draft->validate() || $this->form_validation->error_array()) {
            $pages     = $this->pages;
            $main_view   = 'draft/form_draft_add';
            $form_action = 'draft/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }


        if ($return_id = $this->draft->insert($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        redirect('draft/view/'.$return_id);
      }

// -- view --
      public function view($id = null)
    {
        $draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }

        if (!$_POST) {
            $input = (object) $draft;
        } else {
            $input = (object) $this->input->post(null, true);
            $input->draft_file = $draft->draft_file; // Set draft file for preview.
        }

        // tabel author
        $authors =  $this->draft->select(['draft_author.author_id','author_name','author_nip','work_unit_name','institute_name'])->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('work_unit','author','work_unit')->join3('institute','author','institute')->where('draft_author.draft_id',$id)->getAll();

        // tabel reviewer
        $reviewers =  $this->draft->select(['draft_reviewer.reviewer_id','reviewer_name','reviewer_nip','faculty_name'])->join3('draft_reviewer','draft','draft')->join3('reviewer','draft_reviewer','reviewer')->join3('faculty','reviewer','faculty')->where('draft_reviewer.draft_id',$id)->getAll();

        // If something wrong
        if (!$this->draft->validate() || $this->form_validation->error_array()) {
            $pages    = $this->pages;
            $main_view   = 'draft/view/view';
            $form_action = "draft/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input', 'authors', 'reviewers'));
            return;
        }
        

        if ($this->draft->where('draft_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('draft');
    }


// -- edit --
      
      public function edit($id = null)
	{
        $draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }

        if (!$_POST) {
            $input = (object) $draft;
        } else {
            $input = (object) $this->input->post(null, true);
            $input->draft_file = $draft->draft_file; // Set draft file for preview.
        }

        
         if (!empty($_FILES) && $_FILES['draft_file']['size'] > 0) {
            // Upload new draft (if any)
            $getextension=explode(".",$_FILES['draft_file']['name']);            
            $draftFileName  = str_replace(" ","_",$input->draft_title . '_' . date('YmdHis').".".$getextension[1]); // draft file name
            $upload = $this->draft->uploadDraftfile('draft_file', $draftFileName);

            if ($upload) {
                $input->draft_file =  "$draftFileName";
                // Delete old draft file
                if ($draft->draft_file) {
                    $this->draft->deleteDraftfile($draft->draft_file);
                }
            }
        }   
        
        // If something wrong
        if (!$this->draft->validate() || $this->form_validation->error_array()) {
            $pages    = $this->pages;
            $main_view   = 'draft/form_draft_edit';
            $form_action = "draft/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->draft->where('draft_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('draft');
	}

// -- delete --        
        public function delete($id = null)
	{
	$draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }

        if ($this->draft->where('draft_id', $id)->delete()) {
            // Delete cover.
            $this->draft->deleteDraftfile($draft->draft_file);
            $this->session->set_flashdata('success', 'Data deleted');
		} else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }

		redirect('draft');
	}

// -- search --        
        public function search($page = null)
        {
        $keywords   = $this->input->get('keywords', true);
        $drafts     = $this->draft->like('category_name', $keywords)
                                  ->orLike('draft_title', $keywords)
                                  ->orLike('theme_name', $keywords)
                                  ->join('category')
                                  ->join('theme')
                                  ->orderBy('category.category_id')
                                  ->orderBy('theme.theme_id')                
                                  ->orderBy('draft_title')
                                  ->paginate($page)
                                  ->getAll();
        $tot        = $this->draft->like('category_name', $keywords)
                                  ->orLike('draft_title', $keywords)
                                  ->orLike('theme_name', $keywords)
                                  ->join('category')
                                  ->join('theme')
                                  ->orderBy('category.category_name')
                                  ->orderBy('theme.theme_name')                
                                  ->orderBy('draft_title')
                                  ->getAll();
        $total = count($tot);

        $pagination = $this->draft->makePagination(site_url('draft/search/'), 3, $total);

        if (!$drafts) {
            $this->session->set_flashdata('warning', 'Data were not found');
            redirect('draft');
        }

        $pages    = $this->pages;
        $main_view  = 'draft/index_draft';
        $this->load->view('template', compact('pages', 'main_view', 'drafts', 'pagination', 'total'));
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
    public function unique_draft_title()
    {
        $draft_title     = $this->input->post('draft_title');
        $draft_id = $this->input->post('draft_id');

        $this->draft->where('draft_title', $draft_title);
        !$draft_id || $this->draft->where('draft_id !=', $draft_id);
        $draft = $this->draft->get();

        if (count($draft)) {
            $this->form_validation->set_message('unique_draft_title', '%s has been used');
            return false;
        }
        return true;
    }

    

    
}