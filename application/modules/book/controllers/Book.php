<?php defined('BASEPATH') or exit('No direct script access allowed');
class Book extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'book';

        $this->load->model('author/author_model', 'author');
        $this->load->model('draft/draft_model', 'draft');


        // if ($ceklevel == 'author' || $ceklevel == 'reviewer' || $ceklevel == 'editor' || $ceklevel == 'layouter') {
        //     redirect('home');
        // }

        // load model
        $this->load->model('book_model', 'book');
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
            'from_outside'  => intval($this->input->get('from_outside', true)),
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

            if (!isset($input->book_file)) {
                $input->book_file = null;
            }

            $this->session->set_flashdata('draft_file_no_data', $this->lang->line('form_error_file_no_data'));

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
                $bookFileName = strip_disallowed_char(str_replace(" ", "_", $input->book_title . '_' . date('YmdHis') . "." . $getextension[1])); // book file name
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

        // jika buku dari luar
        if ($input->from_outside == 1) {
            $input->draft_id = empty_to_null($input->draft_id);
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

        $get_stock      = $this->book->fetch_stock_by_id($book_id);

        $stock_history  = $get_stock['stock_history'];
        $stock_last     = $get_stock['stock_last'];

        // If something wrong
        // if (!$this->book->validate() || $this->form_validation->error_array()) {
        $pages       = $this->pages;
        $main_view   = 'book/view_book';
        // $form_action = "book/edit/$book_id";
        $this->load->view('template', compact('authors', 'pages', 'main_view', 'input', 'stock_history', 'stock_last'));
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
            $input = (object) $this->input->post(null, false);

            // repopulate book_file ketika validasi form gagal
            if (!isset($input->book_file)) {
                $input->book_file = $book->book_file;
            }

            // forced to null, instead empty string/ 0000-00-00
            $input->published_date = empty_to_null($input->published_date);
            if ($input->from_outside == 1) {
                $input->draft_id = empty_to_null($input->draft_id);
            }
        }

        if ($this->book->validate()) {
            if (!empty($_FILES) && $book_file_name = $_FILES['book_file']['name']) {
                $book_file_name = strip_disallowed_char($this->_generate_book_name($book_file_name, $input->book_title));
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

        // memastikan konsistensi data
        $this->db->trans_begin();

        //  hapus buku jika check delete_book
        if (isset($input->delete_book) && $input->delete_book == 1) {
            $this->book->delete_book_file($book->book_file);
            $this->book->delete_book_file($input->book_file);
            $input->book_file = null;
            unset($input->delete_book);
        }

        // update
        $this->book->where('book_id', $book_id)->update($input);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
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
                $hakcipta_file_name = strip_disallowed_char($this->_generate_book_name($hakcipta_file_name, $input->book_title, 'hakcipta'));
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
            // kembalikan status draft menjadi sebelum final
            $this->draft->where('draft_id', $book->draft_id)->update(['draft_status' => 13]);

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

    public function required_draft_id()
    {
        $from_outside = $this->input->post('from_outside');
        $draft_id = $this->input->post('draft_id');

        if ($from_outside == 0 && !$draft_id) {
            $this->form_validation->set_message('required_draft_id', "Draft is required.");
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

    public function add_book_stock()
    {
        if ($this->check_level_gudang() == TRUE) :
            $this->load->library('form_validation');
            $this->form_validation->set_rules('warehouse_modifier', 'Stok Gudang', 'required|max_length[10]');
            $this->form_validation->set_rules('notes', 'Catatan', 'max_length[256]');
            $this->form_validation->set_rules('date', 'Tanggal Input', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Gagal mengubah data stok buku.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            } else {
                $check  =   $this->book->add_book_stock();
                if ($check   ==  TRUE) {
                    $this->session->set_flashdata('success', 'Berhasil mengubah data stok buku.');
                    redirect($_SERVER['HTTP_REFERER'], 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengubah data stok buku.');
                    redirect($_SERVER['HTTP_REFERER'], 'refresh');
                }
            }
        endif;
    }

    public function delete_book_stock($book_stock_id)
    {
        if ($this->check_level_gudang() == TRUE) :
            $book_stock = $this->book->fetch_book_stock_by_id($book_stock_id);

            if ($book_stock->warehouse_operator == "+") {
                $stock_warehouse = intval($book_stock->warehouse_present) - intval($book_stock->warehouse_modifier);
            } elseif ($book_stock->warehouse_operator == "-") {
                $stock_warehouse = intval($book_stock->warehouse_present) + intval($book_stock->warehouse_modifier);
            }

            $this->db->set('stock_warehouse', $stock_warehouse)->where('book_id', $book_stock->book_id)->update('book');

            $isDeleted  = $this->book->delete_book_stock($book_stock_id);
            if ($isDeleted   ==  TRUE) {
                $this->session->set_flashdata('success', 'Berhasil menghapus data stok buku.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus data stok buku.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        endif;
    }

    public function check_level_gudang()
    {
        if ($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang') {
            return TRUE;
        } else {
            $this->session->set_flashdata('error', 'Hanya admin gudang dan superadmin yang dapat mengakses.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
    }
}
