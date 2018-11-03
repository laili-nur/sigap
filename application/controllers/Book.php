<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends Operator_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->pages = 'book';
        //khusus admin
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel == 'author' || $ceklevel == 'reviewer' || $ceklevel == 'editor' || $ceklevel == 'layouter'){
            redirect('home');
        }
    }

	public function index($page = null)
	{
        $books     = $this->book->join('draft')->orderBy('draft.draft_id')->orderBy('book_id')->paginate($page)->getAll();
        $tot        = $this->book->join('draft')->orderBy('draft.draft_id')->orderBy('book_id')->getAll();
        $total     = count($tot);
        $pages    = $this->pages;
        $main_view  = 'book/index_book';
        $pagination = $this->book->makePagination(site_url('book'), 2, $total);

		$this->load->view('template', compact('pages', 'main_view', 'books', 'pagination', 'total'));
	}
        
// -- add --        
        public function add()
	{
        if (!$_POST) {
            $input = (object) $this->book->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, false);
        }
        
//        if (!empty($_FILES) && $_FILES['cover']['size'] > 0) {
//            $getextension=explode(".",$_FILES['cover']['name']);            
//            $coverFileName  = str_replace(" ","_",$input->book_title . '_' . date('YmdHis').".".$getextension[1]); // Cover name
//            $upload = $this->book->uploadCover('cover', $coverFileName);
//
//            if ($upload) {
//                $input->cover =  "$coverFileName"; // Data for column "cover".
//                $this->book->coverResize('cover', "./cover/$coverFileName", 100, 150);
//            }
//        }
        
        if($this->book->validate()){
        // Upload new book (if any)
        if (!empty($_FILES) && $_FILES['book_file']['size'] > 0) {            
            $getextension=explode(".",$_FILES['book_file']['name']);            
            $bookFileName  = str_replace(" ","_",$input->book_title . '_' . date('YmdHis').".".$getextension[1]); // book file name
            $upload = $this->book->uploadBookfile('book_file', $bookFileName);

            if ($upload) {
                $input->book_file =  "$bookFileName";
            }
        }   
        
        
            if (!empty($_FILES) && $_FILES['file_hak_cipta']['size'] > 0) {
                // Upload new hak cipta (if any)
                $getextension=explode(".",$_FILES['file_hak_cipta']['name']);            
                $HCFileName  = str_replace(" ","_",'Hak_Cipta' . '_' . $input->book_title . '_' . date('YmdHis').".".$getextension[1]); // hak cipta file name
                $upload = $this->book->uploadHCfile('file_hak_cipta', $HCFileName);

                if ($upload) {
                    $input->file_hak_cipta =  "$HCFileName";
                }
            }
        }
        
        if (!$this->book->validate() || $this->form_validation->error_array()) {
            $pages     = $this->pages;
            $main_view   = 'book/form_book';
            $form_action = 'book/add';

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->book->insert($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        redirect('book');
	}

    public function view($id = null)
    {
        $book = $this->book->join('draft')->where('book_id', $id)->get();
        if (!$book) {
            $this->session->set_flashdata('warning', 'Book data were not available');
            redirect('book');
        }

        if (!$_POST) {
            $input = (object) $book;
        } else {
            $input = (object) $this->input->post(null, true);
            $input->book_file = $book->book_file; // Set book file for preview.
        }

        // tabel author
        $authors =  $this->book->select(['draft_author.author_id','draft_author_id','author_name','author_nip','work_unit_name','institute_name','draft.draft_id'])->join3('draft_author','draft','draft')->join3('author','draft_author','author')->join3('work_unit','author','work_unit')->join3('institute','author','institute')->where('draft_author.draft_id',$book->draft_id)->getAll('draft');

        // get draft
        $draft = $this->book->where('draft_id',$input->draft_id)->get('draft');

        
        // If something wrong
        if (!$this->book->validate() || $this->form_validation->error_array()) {
            $pages    = $this->pages;
            $main_view   = 'book/view';
            $form_action = "book/edit/$id";

            $this->load->view('template', compact('draft','authors','pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->book->where('book_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('book');
    }
 
        
// -- edit --         
        public function edit($id = null)
	{
            
            
        $book = $this->book->where('book_id', $id)->get();
        if (!$book) {
            $this->session->set_flashdata('warning', 'Book data were not available');
            redirect('book');
        }

        if (!$_POST) {
            $input = (object) $book;
        } else {
            $input = (object) $this->input->post(null, false);
            $input->book_file = $book->book_file; // Set book file for preview.
            //$input->cover = $book->cover; // Set cover untuk preview.
        }

//         //Upload new cover (if any)
//        if (!empty($_FILES) && $_FILES['cover']['size'] > 0) {
//            $getextension=explode(".",$_FILES['cover']['name']);            
//            $coverFileName  = str_replace(" ","_",$input->book_title . '_' . date('YmdHis').".".$getextension[1]); //cover file name
//            $upload = $this->book->uploadCover('cover', $coverFileName);
//            // Resize to 100x150px
//            if ($upload) {
//                $input->cover =  "$coverFileName";
//                $this->book->coverResize('cover', "./cover/$coverFileName", 100, 150);
//                // Delete old cover
//                if ($book->cover) {
//                    $this->book->deleteCover($book->cover);
//                }
//            }
//        }
        
        if($this->book->validate()){
        // Upload new book (if any)
        if (!empty($_FILES) && $_FILES['book_file']['size'] > 0) {            
            $getextension=explode(".",$_FILES['book_file']['name']);            
            $bookFileName  = str_replace(" ","_",$input->book_title . '_' . date('YmdHis').".".$getextension[1]); // book file name
            $upload = $this->book->uploadBookfile('book_file', $bookFileName);

            if ($upload) {
                $input->book_file =  "$bookFileName";
                // Delete old book
                if ($book->book_file) {
                    $this->book->deleteBookfile($book->book_file);
                }
            }
        }   
        
            //pindah ke fungsi terpisah
        
            // if (!empty($_FILES) && $_FILES['file_hak_cipta']['size'] > 0) {
            //     // Upload new hak cipta (if any)
            //     $getextension=explode(".",$_FILES['file_hak_cipta']['name']);            
            //     $HCFileName  = str_replace(" ","_",'Hak_Cipta' . '_' . $input->book_title . '_' . date('YmdHis').".".$getextension[1]); // hak cipta file name
            //     $upload = $this->book->uploadHCfile('file_hak_cipta', $HCFileName);

            //     if ($upload) {
            //         $input->file_hak_cipta =  "$HCFileName";
            //         // Delete old HC file
            //         if ($book->file_hak_cipta) {
            //             $this->book->deleteHCfile($book->file_hak_cipta);
            //         }
            //     }
            // }
        }
        
        
        // If something wrong
        if (!$this->book->validate() || $this->form_validation->error_array()) {
            $pages    = $this->pages;
            $main_view   = 'book/form_book';
            $form_action = "book/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->book->where('book_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('book');
	}

    public function edit_hakcipta($id = null)
    {
            
        $book = $this->book->where('book_id', $id)->get();
        if (!$book) {
            $this->session->set_flashdata('warning', 'Book data were not available');
            redirect('book');
        }

        if (!$_POST) {
            $input = (object) $book;
        } else {
            $input = (object) $this->input->post(null, true);
            $input->book_file = $book->book_file; // Set book file for preview.
            //$input->cover = $book->cover; // Set cover untuk preview.
        }

        
        if($this->book->validate()){
        // Upload new hakcipta (if any)

            if (!empty($_FILES) && $_FILES['file_hak_cipta']['size'] > 0) {
                // Upload new hak cipta (if any)
                $getextension=explode(".",$_FILES['file_hak_cipta']['name']);            
                $HCFileName  = str_replace(" ","_",'Hak_Cipta' . '_' . $input->book_title . '_' . date('YmdHis').".".$getextension[1]); // hak cipta file name
                $upload = $this->book->uploadHCfile('file_hak_cipta', $HCFileName);

                if ($upload) {
                    $input->file_hak_cipta =  "$HCFileName";
                    // Delete old HC file
                    if ($book->file_hak_cipta) {
                        $this->book->deleteHCfile($book->file_hak_cipta);
                    }
                }
            }
        }
        
        
        // If something wrong
        if (!$this->book->validate() || $this->form_validation->error_array()) {
            $pages    = $this->pages;
            $main_view   = 'book/form_hakcipta';
            $form_action = "book/edit_hakcipta/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->book->where('book_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('book');
    }

// -- delete --         
        public function delete($id = null)
	{
	$book = $this->book->where('book_id', $id)->get();
        if (!$book) {
            $this->session->set_flashdata('warning', 'Book data were not available');
            redirect('book');
        }

        if ($this->book->where('book_id', $id)->delete()) {
            // Delete book.
            $this->book->deleteBookfile($book->book_file);
            // Delete HC.
            $this->book->deleteHCfile($book->file_hak_cipta);
            $this->session->set_flashdata('success', 'Data deleted');
		} else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }

		redirect('book');
	}
 
// -- search --        
        public function search($page = null)
        {
        $keywords   = $this->input->get('keywords', true);
        $books     = $this->book->like('book_code', $keywords)
                                  ->orLike('draft_title', $keywords)
                                  ->orLike('book_title', $keywords)
                                  ->orLike('ISBN', $keywords)
                                  ->join('draft')
                                  ->orderBy('book_id')
                                  ->orderBy('draft.draft_id')
                                  ->orderBy('book_title')                
                                  ->orderBy('book_code')
                                  ->orderBy('ISBN')
                                  ->paginate($page)
                                  ->getAll();
        $tot        = $this->book->like('book_code', $keywords)
                                  ->orLike('draft_title', $keywords)
                                  ->orLike('book_title', $keywords)
                                  ->orLike('ISBN', $keywords)
                                  ->join('draft')
                                  ->orderBy('book_id')
                                  ->orderBy('draft.draft_id')
                                  ->orderBy('book_title')                
                                  ->orderBy('book_code')
                                  ->orderBy('ISBN')
                                  ->getAll();
        $total = count($tot);

        $pagination = $this->book->makePagination(site_url('book/search/'), 3, $total);

        if (!$books) {
            $this->session->set_flashdata('warning', 'Data were not found');
            redirect('book');
        }

        $pages    = $this->pages;
        $main_view  = 'book/index_book';
        $this->load->view('template', compact('pages', 'main_view', 'books', 'pagination', 'total'));
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
    public function unique_book_title()
    {
        $book_title      = $this->input->post('book_title');
        $book_id = $this->input->post('book_id');

        $this->book->where('book_title', $book_title);
        !$book_id || $this->book->where('book_id !=', $book_id);
        $book = $this->book->get();

        if (count($book)) {
            $this->form_validation->set_message('unique_book_title', '%s has been used');
            return false;
        }
        return true;
    }
    
    public function unique_isbn()
    {
        $isbn      = $this->input->post('isbn');
        $book_id = $this->input->post('book_id');

        $this->book->where('isbn', $isbn);
        !$book_id || $this->book->where('book_id !=', $book_id);
        $book = $this->book->get();

        if (count($book)) {
            $this->form_validation->set_message('unique_isbn', '%s has been used');
            return false;
        }
        return true;
    }
    
    public function unique_serial_num()
    {
        $serial_num      = $this->input->post('serial_num');
        $book_id = $this->input->post('book_id');

        $this->book->where('serial_num', $serial_num);
        !$book_id || $this->book->where('book_id !=', $book_id);
        $book = $this->book->get();

        if (count($book)) {
            $this->form_validation->set_message('unique_serial_num', '%s has been used');
            return false;
        }
        return true;
    }
    
            public function is_date_format_valid($str)
    {
        if(!preg_match('/([0-9]{4})-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $str)) {
            //tanggal boleh kosong
            if($str==''){return TRUE;}
                //if(!preg_match('/(0[1-9]|1[0-9]|2[0-9]|3[01]-([0-9]{4})-(0[1-9]|1[012]))/', $str)) {    
            
            $this->form_validation->set_message('is_date_format_valid', 'Invalid date format (yyyy-mm-dd)');
            return FALSE;
        }

        return TRUE;
    }

}