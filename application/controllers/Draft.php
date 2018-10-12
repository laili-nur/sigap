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
        $ceklevel = $this->session->userdata('level');
        $cekusername = $this->session->userdata('username');


        //get id user
        
        if ($ceklevel == 'author'){
            $drafts = $this->draft->join('category')->join('theme')->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('user.username',$cekusername)->paginate($page)->getAll();
            $tot = $this->draft->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('user','author','user')->where('user.username',$cekusername)->getAll();
        }elseif($ceklevel == 'editor' || $ceklevel == 'layouter'){
            $drafts = $this->draft->join('category')->join('theme')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('user.username',$cekusername)->paginate($page)->getAll();
            $tot = $this->draft->join('category')->join('theme')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('user.username',$cekusername)->getAll();
        }elseif($ceklevel == 'reviewer'){
            $drafts = $this->draft->join('category')->join('theme')->join3('draft_reviewer','draft','draft')->join3('reviewer','draft_reviewer','reviewer')->join3('user','reviewer','user')->where('user.username',$cekusername)->paginate($page)->getAll();
            $tot = $this->draft->join('category')->join('theme')->join3('draft_reviewer','draft','draft')->join3('reviewer','draft_reviewer','reviewer')->join3('user','reviewer','user')->where('user.username',$cekusername)->getAll();
        }else{
            $drafts     = $this->draft->join('category')->join('theme')->orderBy('entry_date','desc')->paginate($page)->getAll();
            $tot        = $this->draft->join('category')->join('theme')->getAll();
        }



        //tampilkan author dan status draft
        foreach ($drafts as $key => $value) {
            $authors = $this->draft->getIdAndName('author', 'draft_author', $value->draft_id);
            $value->author = $authors;
            $value->stts = $value->draft_status;
            $value->draft_status = $this->checkStatus($value->draft_status);
        }

        //cari tau rev 1 atau rev 2 yg sedang login
        foreach ($drafts as $key => $value) {
            $rev = $this->draft->getIdAndName('reviewer', 'draft_reviewer', $value->draft_id);
            $value->rev = key(array_filter(
                $rev,
                function ($e) {
                    return $e->reviewer_id == $this->session->userdata('role_id');
                }
            ));
        }
        

        $total     = count($tot);
        $pages    = $this->pages;
        $main_view  = 'draft/index_draft';
        $pagination = $this->draft->makePagination(site_url('draft'), 2, $total);

		$this->load->view('template', compact('pages', 'main_view', 'drafts', 'pagination', 'total'));
	}


    public function filter($page = null)
  {
        $filter   = $this->input->get('filter', true);
        $this->db->group_by('draft.draft_id');

        if($this->level == 'author'){
          if($filter == 'desk-screening'){
            $drafts = $this->draft->join('category')
                            ->join('theme')
                            ->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('draft_status','0')
                            ->where('user.username',$this->username)
                            ->orderBy('draft_title')
                            ->paginate($page)
                            ->getAll();
            $tot = $this->draft->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('draft_status','0')
                            ->where('user.username',$this->username)
                            ->getAll();
            $total = count($tot);
          }elseif($filter == 'review'){
            $drafts = $this->draft->join('category')
                            ->join('theme')
                            ->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('is_review','n')
                            ->where('draft_status','4')
                            ->where('user.username',$this->username)
                            ->orderBy('draft_title')
                            ->paginate($page)
                            ->getAll();
            $tot = $this->draft->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('is_review','n')
                            ->where('draft_status','4')
                            ->where('user.username',$this->username)
                            ->getAll();
            $total = count($tot);
          }elseif($filter == 'edit'){
            $drafts = $this->draft->join('category')
                            ->join('theme')
                            ->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('is_review','y')            
                            ->where('is_edit','n')
                            ->whereNot('draft_status','99')            
                            ->where('user.username',$this->username)
                            ->orderBy('draft_title')
                            ->paginate($page)
                            ->getAll();
            $tot = $this->draft->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('is_review','y')            
                            ->where('is_edit','n')
                            ->whereNot('draft_status','99')            
                            ->where('user.username',$this->username)
                            ->getAll();
            $total = count($tot);
          }elseif($filter == 'layout'){
            $drafts = $this->draft->join('category')
                            ->join('theme')
                            ->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('is_edit','y')            
                            ->where('is_layout','n')
                            ->whereNot('draft_status','99')       
                            ->where('user.username',$this->username)
                            ->orderBy('draft_title')
                            ->paginate($page)
                            ->getAll();
            $tot = $this->draft->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('is_edit','y')            
                            ->where('is_layout','n')
                            ->whereNot('draft_status','99')        
                            ->where('user.username',$this->username)
                            ->getAll();
            $total = count($tot);
          }elseif($filter == 'proofread'){
            $drafts = $this->draft->join('category')
                            ->join('theme')
                            ->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('is_proofread','n')            
                            ->where('is_layout','y')  
                            ->whereNot('draft_status','99')    
                            ->where('user.username',$this->username)
                            ->orderBy('draft_title')
                            ->paginate($page)
                            ->getAll();
            $tot = $this->draft->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('is_proofread','n')            
                            ->where('is_layout','y')  
                            ->whereNot('draft_status','99')          
                            ->where('user.username',$this->username)
                            ->getAll();
            $total = count($tot);
          }elseif($filter == 'reject'){
            $drafts = $this->draft->join('category')
                            ->join('theme')
                            ->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user') 
                            ->where('draft_status','99')    
                            ->where('user.username',$this->username)
                            ->orderBy('draft_title')
                            ->paginate($page)
                            ->getAll();
            $tot = $this->draft->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('draft_status','99')          
                            ->where('user.username',$this->username)
                            ->getAll();
            $total = count($tot);
          }elseif($filter == 'final'){
            $drafts = $this->draft->join('category')
                            ->join('theme')
                            ->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user') 
                            ->where('draft_status','14')    
                            ->where('user.username',$this->username)
                            ->orderBy('draft_title')
                            ->paginate($page)
                            ->getAll();
            $tot = $this->draft->join3('draft_author','draft','draft')
                            ->join3('author','draft_author','author')
                            ->join3('user','author','user')
                            ->where('draft_status','14')          
                            ->where('user.username',$this->username)
                            ->getAll();
            $total = count($tot);
          }else{}
        }else{
          if($filter == 'desk-screening'){
              $drafts = $this->draft->join('category')
                                    ->join('theme')
                                    ->joinRelationMiddle('draft', 'draft_author')
                                    ->joinRelationDest('author', 'draft_author')            
                                    ->where('draft_status','0')                      
                                    ->orderBy('draft_title')
                                    ->paginate($page)
                                    ->getAll();
              $tot = $this->draft->where('draft_status','0')                      
                                    ->getAll();
              $total = count($tot);
          }elseif($filter == 'review'){
              $drafts = $this->draft->join('category')
                                    ->join('theme')
                                    ->joinRelationMiddle('draft', 'draft_author')
                                    ->joinRelationDest('author', 'draft_author')            
                                    ->where('is_review','n')                        
                                    ->where('draft_status','4')                        
                                    ->orderBy('draft_title')
                                    ->paginate($page)
                                    ->getAll();
              $tot = $this->draft->where('is_review','n')            
                                    ->whereNot('review1_notes','')            
                                    ->whereNot('review2_notes','')            
                                    ->getAll();
              $total = count($tot);
          }elseif($filter == 'edit'){
              $drafts = $this->draft->join('category')
                                    ->join('theme')
                                    ->joinRelationMiddle('draft', 'draft_author')
                                    ->joinRelationDest('author', 'draft_author')
                                    ->where('is_review','y')            
                                    ->where('is_edit','n')
                                    ->whereNot('draft_status','99')            
                                    ->orderBy('draft_title')
                                    ->paginate($page)
                                    ->getAll();
              $tot = $this->draft->where('is_review','y')            
                                    ->where('is_edit','n')
                                    ->whereNot('draft_status','99')            
                                    ->getAll();
              $total = count($tot);
          }elseif($filter == 'layout'){
              $drafts = $this->draft->join('category')
                                    ->join('theme')
                                    ->joinRelationMiddle('draft', 'draft_author')
                                    ->joinRelationDest('author', 'draft_author')
                                    ->where('is_edit','y')            
                                    ->where('is_layout','n')
                                    ->whereNot('draft_status','99')            
                                    ->orderBy('draft_title')
                                    ->paginate($page)
                                    ->getAll();
              $tot = $this->draft->where('is_edit','y')            
                                    ->where('is_layout','n')
                                    ->whereNot('draft_status','99')            
                                    ->getAll();
              $total = count($tot);
          }elseif($filter == 'proofread'){
              $drafts = $this->draft->join('category')
                                    ->join('theme')
                                    ->joinRelationMiddle('draft', 'draft_author')
                                    ->joinRelationDest('author', 'draft_author')
                                    ->where('is_proofread','n')            
                                    ->where('is_layout','y')  
                                    ->whereNot('draft_status','99')          
                                    ->orderBy('draft_title')
                                    ->paginate($page)
                                    ->getAll();
              $tot = $this->draft->where('is_proofread','n')            
                                    ->where('is_layout','y')
                                    ->whereNot('draft_status','99')            
                                    ->getAll();
              $total = count($tot);
          }elseif($filter == 'reject'){
              $drafts = $this->draft->join('category')
                                    ->join('theme')
                                    ->joinRelationMiddle('draft', 'draft_author')
                                    ->joinRelationDest('author', 'draft_author')
                                    ->where('draft_status','99')          
                                    ->orderBy('draft_title')
                                    ->paginate($page)
                                    ->getAll();
              $tot = $this->draft->where('draft_status','99')           
                                    ->getAll();
              $total = count($tot);
          }elseif($filter == 'final'){
              $drafts = $this->draft->join('category')
                                    ->join('theme')
                                    ->joinRelationMiddle('draft', 'draft_author')
                                    ->joinRelationDest('author', 'draft_author')
                                    ->where('draft_status','14')          
                                    ->orderBy('draft_title')
                                    ->paginate($page)
                                    ->getAll();
              $tot = $this->draft->where('draft_status','14')           
                                    ->getAll();
              $total = count($tot);
          }else{}
        }
      
        
        

        $pagination = $this->draft->makePagination(site_url('draft/filter/'), 3, $total);

        if (!$drafts) {
            $this->session->set_flashdata('warning', 'Data were not found');
            redirect($this->pages);
        } else {
            foreach ($drafts as $key => $value) {
                $authors = $this->draft->getIdAndName('author', 'draft_author', $value->draft_id);
                $value->author = $authors;
                $value->draft_status = $this->checkStatus($value->draft_status);
            }
        }

        $pages    = $this->pages;
        $main_view  = 'draft/index_draft';
        $this->load->view('template', compact('pages', 'main_view', 'drafts', 'pagination', 'total'));
    }
        
        
// --add--        
        public function add($category='')
	{
        //khusus admin dan author
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'author' and $ceklevel != 'admin_penerbitan' and $ceklevel != 'superadmin'){
            redirect('home');
        }

        if (!$_POST) {
            $input = (object) $this->draft->getDefaultValues();
            $input->category_id = $category;
        } else {
            $input = (object) $this->input->post(null, true);
        }


        if (!$this->draft->validate() || $this->form_validation->error_array()) {
            $pages     = $this->pages;
            $main_view   = 'draft/form_draft_add';
            $form_action = 'draft/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if (!empty($_FILES) && $_FILES['draft_file']['size'] > 0) {
            $getextension=explode(".",$_FILES['draft_file']['name']);            
            $draftFileName  = str_replace(" ","_",$input->draft_title . '_' . date('YmdHis').".".$getextension[1]) ; // draft file name
            $upload = $this->draft->uploadDraftfile('draft_file', $draftFileName);

            if ($upload) {
                $input->draft_file =  "$draftFileName"; // Data for column "draft".
            }
        }   
        
        $draft_id = $this->draft->insert($input);

        $isSuccess = true;

        if ($draft_id > 0) {
            foreach ($input->author_id as $key => $value) {
                $data_author = array('author_id' => $value, 'draft_id' => $draft_id);

                $draft_author_id = $this->draft->insert($data_author, 'draft_author');

                if ($draft_author_id < 1 ) {
                    $isSuccess = false;
                    break;
                }
            }
        } else {
            $isSuccess = false;
        }

        if ($isSuccess) {
            $worksheet_num = $this->generateWorksheetNumber();

            $data_worksheet = array('draft_id' => $draft_id, 'worksheet_num' => $worksheet_num, 'worksheet_status' => 0);
            $worksheet_id = $this->draft->insert($data_worksheet, 'worksheet');

            if ($worksheet_id < 1) {
                $isSuccess = false;
            }
        }

        if ($isSuccess) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data author failed to save');
        } 

        redirect('draft/view/'.$draft_id);
      }

// -- view --
      public function view($id = null)
    {

        $draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }

        //status draft
        $draft->stts = $draft->draft_status;
        $draft->draft_status = $this->checkStatus($draft->draft_status);
        
        // ambil tabel worksheet
        $this->load->model('Worksheet_model','worksheet',true);
        $ambil_worksheet = ['draft_id' => $id];
        $desk = $this->worksheet->getWhere($ambil_worksheet, 'worksheet');

        //pecah data csv jadi array
        $draft->nilai_reviewer1 = explode(",",$draft->nilai_reviewer1);
        $draft->nilai_reviewer2 = explode(",",$draft->nilai_reviewer2);
        // $arrayapa = array($draft->nilai_reviewer1[0],$draft->nilai_reviewer1[1],$draft->nilai_reviewer1[2]);
        // $draft->apa = implode(",",$arrayapa);
        if (!$_POST) {
            $input = (object) $draft;
        } else {
            $input = (object) $this->input->post(null, true);
            $input->draft_file = $draft->draft_file; // Set draft file for preview.
        }

        // tabel author
        $authors =  $this->draft->select(['draft_author.author_id','draft_author_id','author_name','author_nip','work_unit_name','institute_name','draft.draft_id'])->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('work_unit','author','work_unit')->join3('institute','author','institute')->where('draft_author.draft_id',$id)->getAll();
        

        // tabel reviewer
        $reviewers =  $this->draft->select(['draft_reviewer.reviewer_id','draft_reviewer_id','reviewer_name','reviewer_nip','faculty_name','username'])->join3('draft_reviewer','draft','draft')->join3('reviewer','draft_reviewer','reviewer')->join3('faculty','reviewer','faculty')->join3('user','reviewer','user')->where('draft_reviewer.draft_id',$id)->getAll();

        //cari reviewer 1 dan 2
        $reviewer_order = key(array_filter(
            $reviewers,
            function ($e) {
                return $e->username == $this->session->userdata('username');
            }
        ));

        // tampilkan editor
        $editors = $this->draft->select(['username','level','responsibility_id'])->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('responsibility.draft_id',$id)->where('level','editor')->getAll();

        // tampilkan layouter
        $layouters = $this->draft->select(['username','level','responsibility_id'])->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('responsibility.draft_id',$id)->where('level','layouter')->getAll();

        //prevent ganti link
        if ($this->level == "reviewer") {
            $prevent = count(array_filter(
                    $reviewers,
                    function ($e) {
                        return $e->reviewer_id == $this->role_id;
                    }
                ));
            if($prevent==0){
                redirect('draft');
            };
        }
        if ($this->level == "author") {
            $prevent = count(array_filter(
                    $authors,
                    function ($e) {
                        return $e->author_id == $this->role_id;
                    }
                ));
            if($prevent==0){
                redirect('draft');
            };
        }


        // If something wrong
        if (!$this->draft->validate() || $this->form_validation->error_array()) {
            $pages    = $this->pages;
            $main_view   = 'draft/view/view';
            $form_action = "draft/edit/$id";

            $this->load->view('template', compact('draft','reviewer_order','desk','pages', 'main_view', 'form_action', 'input', 'authors', 'reviewers','editors','layouters'));
            return;
        }
        

        if ($this->draft->where('draft_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('draft');
    }

    //upload file tiap tahap
    public function upload_progress($id,$column){
        $draft = $this->draft->where('draft_id', $id)->get();
        $datatitle = ['draft_id'=>$id];
        $title = $this->draft->getWhere($datatitle);
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }

        if (!$_POST) {
            $input = (object) $draft;
        } else {
            $input = (object) $this->input->post(null, true);
            $input->$column = $draft->$column; // Set draft file for preview.
        }
        
        if($column == 'review1_template' || $column == 'review2_template'){
          if (!empty($_FILES) && $_FILES[$column]['size'] > 0) {
              // Upload new draft (if any)
              $getextension=explode(".",$_FILES[$column]['name']);            
              $draftFileName  = str_replace(" ","_",$title->draft_title.'_'.$column . '_' . date('YmdHis').".".$getextension[1]); // draft file name
              $upload = $this->draft->uploadProgress($column, $draftFileName);

              if ($upload) {
                  $input->$column =  "$draftFileName";
                  // Delete old draft file
                  if ($draft->$column) {
                      $this->draft->deleteProgress($draft->$column);
                  }
              }
          }
        }else{
          //tiap upload, update upload date
          $tahap = explode('_', $column);
          $this->draft->editDraftDate($id, $tahap[0].'_upload_date');
          $last_upload = $tahap[0].'_last_upload';
          $input->$last_upload = $this->level;
          
          if (!empty($_FILES) && $_FILES[$column]['size'] > 0) {
              // Upload new draft (if any)
              $getextension=explode(".",$_FILES[$column]['name']);            
              $draftFileName  = str_replace(" ","_",$title->draft_title.'_'.$column . '_' . date('YmdHis').".".$getextension[1]); // draft file name
              $upload = $this->draft->uploadProgress($column, $draftFileName);

              if ($upload) {
                  $input->$column =  "$draftFileName";
                  // Delete old draft file
                  if ($draft->$column) {
                      $this->draft->deleteProgress($draft->$column);
                  }
              }
          }
        }
        


        //If something wrong
        // if (!$this->draft->validate() || $this->form_validation->error_array()) {
        //     $pages    = $this->pages;
        //     $main_view   = 'draft/view/view';
        //     $form_action = "draft/edit/$id";

        //     $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
        //     return;
        // }

        if ($this->draft->where('draft_id', $id)->update($input)) {
            //$this->session->set_flashdata('success', 'Data updated');
            $data['status'] = true;
        } else {
            //$this->session->set_flashdata('error', 'Data failed to update');
          $data['status'] = false;
        }
        echo json_encode($data);

        //redirect('draft/view/'.$id);

    }

// -- ubah notes - buat ubah deadline juga  
      public function ubahnotes($id = null, $rev = null)
	{
        $data = array();
        $draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }

        if (!$_POST) {
            $input = (object) $draft;
        } else {
            $input = (object) $this->input->post(null, false);
        }

        if (empty($input->files)) {
            unset($input->files);
        }
        
        // If something wrong
        // if (!$this->draft->validate() || $this->form_validation->error_array()) {
        //     return;
        // }

        //gabungkan array menjadi csv
        if($rev == 1){
          $input->nilai_reviewer1 = implode(",",$input->nilai_reviewer1);
        }elseif($rev == 2){
          $input->nilai_reviewer2 = implode(",",$input->nilai_reviewer2);
        }else{
          unset($input->nilai_reviewer1);
          unset($input->nilai_reviewer2);
        }
        

        if ($this->draft->where('draft_id', $id)->update($input)) {
            //$this->session->set_flashdata('success', 'Data updated');
            $data['status'] = true;
        } else {
            $data['status'] = false;
            //$this->session->set_flashdata('error', 'Data failed to update');
        }

        echo json_encode($data);
	}

    public function edit($id = null)
    {
        //khusus admin
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'superadmin' and $ceklevel != 'admin_penerbitan'){
            redirect('draft');
        }

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
        //khusus admin
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'superadmin' and $ceklevel != 'admin_penerbitan'){
            redirect('draft');
        }
        
        $draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }

        $isSuccess = true;

        $this->draft->where('draft_id', $id)
                    ->delete('draft_author');

        $affected_rows = $this->db->affected_rows();

        if ($affected_rows > 0) {
            if ($this->draft->where('draft_id', $id)->delete()) {
                // Delete cover.
                $this->draft->deleteDraftfile($draft->draft_file);
                $this->draft->deleteDraftfile($draft->review1_file);
                $this->draft->deleteDraftfile($draft->review2_file);
                $this->draft->deleteDraftfile($draft->edit_file);
                $this->draft->deleteDraftfile($draft->layout_file);
                $this->draft->deleteDraftfile($draft->cover_file);
                $this->draft->deleteDraftfile($draft->proofread_file);
            } else {
                $isSuccess = false;
            }
        } else {
            $isSuccess = false;
        }

        if ($isSuccess) {
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }

        redirect('draft');
	}

    public function copyToBook($draft_id, $title, $file) 
    {
        
        $this->load->model('book_model', 'book', true);
        $book_id = $this->book->getIdDraftFromDraftId($draft_id, 'book');

        if ($book_id == 0) {
            $data = array(
                'draft_id' => $draft_id,
                'book_title' => urldecode($title),
                'book_file' => urldecode($file),
                'published_date' => date('Y-m-d H:i:s')
            );

            if ($this->book->insert($data)) {
                $book_id = $this->db->insert_id();

                if ($book_id != 0) {
                    redirect('book/edit/' . $book_id);
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Book has been created');
            redirect('book');
        }
        
    }

// -- search --        
        public function search($page = null)
        {
        $keywords   = $this->input->get('keywords', true);
        $this->db->group_by('draft.draft_id');
        $drafts     = $this->draft->like('category_name', $keywords)
                                  ->orLike('draft_title', $keywords)
                                  ->orLike('theme_name', $keywords)
                                  ->join('category')
                                  ->join('theme')
                                  ->orLike('author_name', $keywords)
                                  ->joinRelationMiddle('draft', 'draft_author')
                                  ->joinRelationDest('author', 'draft_author')
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
                                  ->orderBy('category.category_id')
                                  ->orderBy('theme.theme_id')                
                                  ->orderBy('draft_title')
                                  ->getAll();
        $total = count($tot);

        $pagination = $this->draft->makePagination(site_url('draft/search/'), 3, $total);

        if (!$drafts) {
            $this->session->set_flashdata('warning', 'Data were not found');
            redirect($this->pages);
        } else {
            foreach ($drafts as $key => $value) {
                $authors = $this->draft->getIdAndName('author', 'draft_author', $value->draft_id);
                $value->author = $authors;
                $value->draft_status = $this->checkStatus($value->draft_status);
            }
        }

        $pages    = $this->pages;
        $main_view  = 'draft/index_draft';
        $this->load->view('template', compact('pages', 'main_view', 'drafts', 'pagination', 'total'));
    }

    public function endProgress($id, $status) {
        $this->draft->updateDraftStatus($id, array('draft_status' => $status + 1));

        switch ($status) {
            case '4':
                $column = 'review_end_date';
                break;
            
            default:
                # code...
                break;
        }

        $this->draft->editDraftDate($id, $column);

        $this->detail($id);
    }


    public function generateWorksheetNumber() {
        $date = date('Y-m');

        $this->db->limit(1);
        $query = $this->draft->like('worksheet_num', $date, 'after')
                             ->orderBy('draft_id', 'desc')
                             ->get('worksheet');

        if ($query) {
            $worksheet_num = $query->worksheet_num;
            $worksheet_num = explode("-", $worksheet_num);
            $num = (int) $worksheet_num[2];
            $num++;

            $num = str_pad($num, 2, '0', STR_PAD_LEFT);
        } else {
            $num = '01';
        }

        return $date . '-' . $num;
    }

    public function checkStatus($code) {
        $status = "";
        switch ($code) {
            case 0:
                $status = 'Desk Screening';
                break;
            case 1:
                $status = 'Lolos Desk Screening';
                break;
            case 2:
                $status = 'Tidak Lolos Desk Screening';
                break;
            case 3:
                $status = 'Reviewer Rejected';
                break;
            case 4:
                $status = 'Reviewing...';
                break;
            case 5:
                $status = 'Review Selesai';
                break;
            case 6:
                $status = 'Editing...';
                break;
            case 7:
                $status = 'Editorial Selesai';
                break;
            case 8:
                $status = 'Layouting...';
                break;
            case 9:
                $status = 'Layout selesai';
                break;
            case 10:
                $status = 'Desain Cover';
                break;
            case 11:
                $status = 'Cover Selesai';
                break;
            case 12:
                $status = 'Proofreading...';
                break;
            case 13:
                $status = 'Proofread Selesai';
                break;
            case 14:
                $status = 'Draft Final';
                break;
            case 99:
                $status = 'Draft Ditolak';
                break;
            
            default:
                # code...
                break;
        }

        return $status;
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