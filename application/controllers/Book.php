<?php defined('BASEPATH') or exit('No direct script access allowed');
class Book extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'book';

        $this->load->model('author_model', 'author');


        // if ($ceklevel == 'author' || $ceklevel == 'reviewer' || $ceklevel == 'editor' || $ceklevel == 'layouter') {
        //     redirect('home');
        // }
    }

    public function index($page = null)
    {
        // all filter
        $filters = [
            'category' => $this->input->get('category', true),
            'keyword'  => $this->input->get('keyword', true),
            'status'  => $this->input->get('status', true),
            'reprint'  => $this->input->get('reprint', true),
            'published_year'  => $this->input->get('published_year', true),
        ];

        // custom per page
        $this->book->per_page = $this->input->get('per_page', true) ?? 10;

        $get_data = $this->book->filter_book($filters, $page);


        // $books = $this->book->join('draft')->join_table('category', 'draft', 'category')->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('work_unit', 'author', 'work_unit')->order_by('status_hak_cipta')->order_by('published_date')->order_by('book_title')->paginate($page)->get_all();
        // $tot   = $this->book->join('draft')->order_by('draft.draft_id')->order_by('book_id')->get_all();
        // //tampilkan author
        // foreach ($books as $key => $value) {
        //     if (!empty($value->draft_id)) {
        //         $authors = $this->book->get_id_and_name('author', 'draft_author', $value->draft_id, 'draft');
        //     } else {
        //         $authors = '';
        //     }
        //     $value->author = $authors;
        // }

        $books     = $get_data['books'];
        $total      = $get_data['total'];
        $pagination = $this->book->make_pagination(site_url('book'), 2, $total);
        $pages      = $this->pages;
        $main_view  = 'book/index_book';
        $this->load->view('template', compact('pages', 'main_view', 'books', 'pagination', 'total'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->book->get_default_values();
        } else {
            $input = (object) $this->input->post(null, false);

            if (!$input->published_date) {
                $input->published_date = empty_to_null($input->published_date);
            }
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

        if ($this->book->validate()) {
            // Upload new book (if any)
            if (!empty($_FILES) && $_FILES['book_file']['name']) {
                $getextension = explode(".", $_FILES['book_file']['name']);
                $bookFileName = str_replace(" ", "_", $input->book_title . '_' . date('YmdHis') . "." . $getextension[1]); // book file name
                $upload       = $this->book->upload_book_file('book_file', $bookFileName);
                if ($upload) {
                    $input->book_file = "$bookFileName";
                }
            }
        }

        if (!$this->book->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'book/form_book';
            $form_action = 'book/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->book->insert($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }

        redirect($this->pages);
    }

    public function view($book_id)
    {
        $book = $this->book->join('draft')->where('book_id', $book_id)->get();
        if (!$book) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        // if (!$_POST) {
        $input = (object) $book;
        // } else {
        //     $input            = (object) $this->input->post(null, true);
        //     $input->book_file = $book->book_file; // Set book file for preview.

        // }
        // tabel author
        if ($book->draft_id) {
            $authors = $this->author->get_draft_authors($book->draft_id);
        } else {
            $authors = [];
        }

        // get draft
        // $draft = $this->book->where('draft_id', $input->draft_id)->get('draft');

        // If something wrong
        // if (!$this->book->validate() || $this->form_validation->error_array()) {
        $pages       = $this->pages;
        $main_view   = 'book/view';
        // $form_action = "book/edit/$book_id";
        $this->load->view('template', compact('authors', 'pages', 'main_view', 'input'));
        return;
        // }

        // if ($this->book->where('book_id', $book_id)->update($input)) {
        //     $this->session->set_flashdata('success', 'Data updated');
        // } else {
        //     $this->session->set_flashdata('error', 'Data failed to update');
        // }
        // redirect($this->pages);
    }

    public function edit($book_id)
    {
        $book = $this->book->where('book_id', $book_id)->get();
        if (!$book) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        if (!$_POST) {
            $input = (object) $book;
        } else {
            $input            = (object) $this->input->post(null, false);

            // repopulate book_file ketika validasi form gagal
            if (!isset($input->book_file)) {
                $input->book_file = $book->book_file;
            }

            // forced to null, instead empty string/ 0000-00-00
            $input->published_date = empty_to_null($input->published_date);
        }

        if ($this->book->validate()) {
            if (!empty($_FILES) && $book_file_name = $_FILES['book_file']['name']) {
                $book_file_name = $this->_generate_book_name($book_file_name, $input->book_title);
                $upload       = $this->book->upload_book_file('book_file', $book_file_name);
                if ($upload) {
                    $input->book_file = $book_file_name;
                    // Delete old book file
                    if ($book->book_file) {
                        $this->book->delete_book_file($book->book_file);
                    }
                }
            }
        }

        if (!$this->book->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'book/form_book';
            $form_action = "book/edit/$book_id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->book->where('book_id', $book_id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect("$this->pages/view/$book_id");
    }

    public function edit_hakcipta($book_id)
    {
        $book = $this->book->where('book_id', $book_id)->get();
        if (!$book) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        if (!$_POST) {
            $input = (object) $book;
        } else {
            $input            = (object) $this->input->post(null, true);
            // $input->book_file = $book->book_file;

            // repopulate file hak cipta ketika validasi form gagal
            if (!isset($input->book_file)) {
                $input->file_hak_cipta = $book->file_hak_cipta;
            }
        }
        if ($this->book->validate()) {
            // Upload new hakcipta (if any)
            if (!empty($_FILES) && $hakcipta_file_name = $_FILES['file_hak_cipta']['name']) {
                $hakcipta_file_name = $this->_generate_book_name($hakcipta_file_name, $input->book_title, 'hakcipta');
                $upload       = $this->book->uploadHCfile('file_hak_cipta', $hakcipta_file_name);
                if ($upload) {
                    $input->file_hak_cipta = $hakcipta_file_name;
                    // Delete old HC file
                    if ($book->file_hak_cipta) {
                        $this->book->delete_hak_cipta_file($book->file_hak_cipta);
                    }
                }
            }
        }

        // If something wrong
        if (!$this->book->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'book/form_hakcipta';
            $form_action = "book/edit_hakcipta/$book_id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->book->where('book_id', $book_id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect("$this->pages/view/$book_id");
    }

    public function delete($book_id)
    {
        $book = $this->book->where('book_id', $book_id)->get();
        if (!$book) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        if ($this->book->where('book_id', $book_id)->delete()) {
            // Delete book file
            $this->book->delete_book_file($book->book_file);
            // Delete hak cipta file
            $this->book->delete_hak_cipta_file($book->file_hak_cipta);
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_success'));
        } else {
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_fail'));
        }

        redirect($this->pages);
    }

    private function _generate_book_name($file_name, $book_name, $type = 'book')
    {
        $get_extension = explode(".", $file_name)[1];
        return str_replace(" ", "_", $book_name . '_' . $type . '_' . date('YmdHis') . '.' . $get_extension); // progress file name
    }

    // validasi data unik
    public function unique_data($str, $data_key)
    {
        $book_id = $this->input->post('book_id');
        if (!$str) {
            return true;
        }
        $this->book->where($data_key, $str);
        !$book_id || $this->book->where_not('book_id', $book_id);
        $book = $this->book->get();

        if ($book) {
            $this->form_validation->set_message('unique_data', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }

    // validasi format tanggal
    public function is_date_format_valid($str)
    {
        if ($str == '') {
            // tanggal boleh kosong
            return true;
        }
        if (!preg_match('/([0-9]{4})-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $str)) {
            $this->form_validation->set_message('is_date_format_valid', 'Invalid date format (yyyy-mm-dd)');
            return false;
        }
        return true;
    }
}
