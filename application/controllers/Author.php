<?php defined('BASEPATH') or exit('No direct script access allowed');
class Author extends Operator_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'author';

        // akses khusus admin
        check_if_admin();
    }

    public function index($page = null)
    {
        $keywords   = $this->input->get('keywords', true);
        $get_data   = $this->author->get_data($keywords, $page);
        $authors    = $get_data['data'];
        $total      = $get_data['count'];
        $pagination = $this->author->make_pagination(site_url('author/'), 2, $total);
        if (!$authors) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
        }

        foreach ($authors as $author) {
            // cek apakah author termasuk reviewer juga
            $author->is_author_reviewer = false;
            if ($author->user_id != 0) {
                $reviewer = $this->author->get_where(['user_id' => $author->user_id], 'reviewer');
                if (!is_null($reviewer)) {
                    $author->is_author_reviewer = true;
                }
            }
        }

        $pages     = $this->pages;
        $main_view = 'author/index_author';
        $this->load->view('template', compact('pages', 'main_view', 'authors', 'pagination', 'total'));
    }

    public function view($halaman = 'profile', $id = null)
    {
        if ($id == null) {
            redirect('author');
        }

        if ($halaman != 'profile' && $halaman != 'book_history' && $halaman != 'draft_history') {
            redirect('author');
        }

        // author join ke user, untuk mengecek apakah author punya akun
        $author = $this->author->get_author_details($id);
        if (!$author) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect('author');
        }

        // total draft
        $drafts      = $this->author->get_author_drafts($id);
        $total_draft = count($drafts);
        // total buku
        $books      = $this->author->get_author_books($id);
        $total_book = count($books);

        $main_view = 'author/view_author';
        $pages     = $this->pages;
        $this->load->view('template', compact('pages', 'main_view', 'drafts', 'author', 'total_draft', 'books', 'total_book'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->author->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);

            // repopulate author_ktp ketika validasi form gagal
            if (!isset($input->author_ktp)) {
                $input->author_ktp = null;
            }
            $this->session->set_flashdata('ktp_no_data', $this->lang->line('form_author_error_ktp_no_data'));

            // forced to null, instead empty string
            if (!$input->user_id) {
                $input->user_id = null;
            }

            if (!$input->bank_id) {
                $input->bank_id = null;
            }
        }

        // upload file hanya ketika validasi lolos
        if ($this->author->validate()) {
            if (!empty($_FILES) && $ktp_file_name = $_FILES['author_ktp']['name']) {
                $ktp_name = $this->_generate_ktp_name($ktp_file_name, $input->author_name);
                $upload   = $this->author->upload_author_ktp('author_ktp', $ktp_name);
                if ($upload) {
                    $input->author_ktp = $ktp_name;
                }
            }
        }

        if (!$this->author->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'author/form_author';
            $form_action = 'author/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($author_id = $this->author->insert($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }

        redirect('author/view/profile/' . $author_id);
    }

    public function edit($id = null)
    {
        $author = $this->author->where('author_id', $id)->get();
        if (!$author) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect('author');
        }
        if (!$_POST) {
            $input = (object) $author;
        } else {
            $input = (object) $this->input->post(null, true);

            // repopulate author_ktp ketika validasi form gagal
            if (!isset($input->author_ktp)) {
                $input->author_ktp = $author->author_ktp;
            }

            // forced to null, instead empty string
            if (!$input->user_id) {
                $input->user_id = null;
            }

            if (!$input->bank_id) {
                $input->bank_id = null;
            }
        }

        if ($this->author->validate()) {
            if (!empty($_FILES) && $ktp_file_name = $_FILES['author_ktp']['name']) {
                $ktp_name = $this->_generate_ktp_name($ktp_file_name, $input->author_name);
                $upload   = $this->author->upload_author_ktp('author_ktp', $ktp_name);
                if ($upload) {
                    $input->author_ktp = $ktp_name;
                    // Delete old KTP file
                    if ($author->author_ktp) {
                        $this->author->delete_author_ktp($author->author_ktp);
                    }
                }
            }
        }

        if (!$this->author->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'author/form_author';
            $form_action = "author/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->author->where('author_id', $id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect('author/view/profile/' . $id);
    }

    public function delete($id = null)
    {
        $author = $this->author->where('author_id', $id)->get();
        if (!$author) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect('author');
        }

        $get_user = $this->author->select(['user.user_id', 'user.level'])->join('user')->where('author_id', $id)->get();
        if ($this->author->where('author_id', $id)->delete()) {
            // deletektp
            if ($author->author_ktp != '') {
                $this->author->delete_author_ktp($author->author_ktp);
            }
            // jika akun author-reviewer, set ke level reviewer, jika akun author dihapus
            if ($get_user->level == 'author_reviewer') {
                $this->author->where('user_id', $get_user->user_id)->update(['level' => 'reviewer'], 'user');
            }
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_delete_fail'));
        }

        redirect('author');
    }

    public function copy_to_reviewer($user_id, $nip, $name)
    {
        $this->load->model('reviewer_model', 'reviewer', true);
        $reviewer_id = $this->reviewer->get_id_role_from_user_id($user_id, 'reviewer');
        if ($reviewer_id == 0) {
            $this->session->user_id_temp       = $user_id;
            $this->session->reviewer_nip_temp  = $nip;
            $this->session->reviewer_name_temp = urldecode($name);
            redirect('reviewer/edit/-99');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('form_author_error_copy_reviewer'));
            redirect('author');
        }
    }

    private function _generate_ktp_name($ktp_file_name, $author_name)
    {
        $get_extension = explode(".", $ktp_file_name)[1];
        return str_replace(" ", "_", "KTP" . '_' . $author_name . '_' . date('YmdHis') . '.' . $get_extension); // author ktp name
    }

    //validasi nama
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
        $author_contact = $this->input->post('author_contact');
        $author_id      = $this->input->post('author_id');
        // boleh kosong
        if ($author_contact == '') {
            return true;
        }
        $this->author->where('author_contact', $author_contact);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();
        if ($author) {
            $this->form_validation->set_message('unique_author_contact', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }

    public function unique_author_email()
    {
        $author_email = $this->input->post('author_email');
        $author_id    = $this->input->post('author_id');
        // boleh kosong
        if ($author_email == '') {
            return true;
        }
        $this->author->where('author_email', $author_email);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();
        if ($author) {
            $this->form_validation->set_message('unique_author_email', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }

    public function unique_author_saving_num()
    {
        $author_saving_num = $this->input->post('author_saving_num');
        $author_id         = $this->input->post('author_id');
        // boleh kosong
        if ($author_saving_num == '') {
            return true;
        }
        $this->author->where('author_saving_num', $author_saving_num);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();
        if ($author) {
            $this->form_validation->set_message('unique_author_saving_num', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }

    public function unique_author_nip()
    {
        $author_nip = $this->input->post('author_nip');
        $author_id  = $this->input->post('author_id');
        $this->author->where('author_nip', $author_nip);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();
        if ($author) {
            $this->form_validation->set_message('unique_author_nip', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }

    public function unique_author_username()
    {
        $user_id   = $this->input->post('user_id');
        $author_id = $this->input->post('author_id');
        // boleh kosong
        if ($user_id == '') {
            return true;
        }
        $this->author->where('user_id', $user_id);
        !$author_id || $this->author->where('author_id !=', $author_id);
        $author = $this->author->get();
        if ($author) {
            $this->form_validation->set_message('unique_author_username', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }
}