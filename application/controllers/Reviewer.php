<?php defined('BASEPATH') or exit('No direct script access allowed');
class Reviewer extends Operator_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'reviewer';
        //khusus admin
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel == 'author' || $ceklevel == 'reviewer' || $ceklevel == 'editor' || $ceklevel == 'layouter') {
            redirect('home');
        }
    }

    public function index($page = null)
    {
        $reviewers  = $this->reviewer->join('faculty')->join('user')->order_by('faculty.faculty_name')->order_by('reviewer_nip')->paginate($page)->get_all();
        $total      = $this->reviewer->join('faculty')->join('user')->order_by('faculty.faculty_name')->order_by('reviewer_nip')->count();
        $pages      = $this->pages;
        $main_view  = 'reviewer/index_reviewer';
        $pagination = $this->reviewer->make_pagination(site_url('reviewer'), 2, $total);
        foreach ($reviewers as $reviewer) {
            $reviewer->reviewer_expert = explode(",", $reviewer->reviewer_expert);
        }
        $this->load->view('template', compact('pages', 'main_view', 'reviewers', 'pagination', 'total'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->reviewer->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }
        // untuk select2 tags sumber
        $allexpert = $this->reviewer->select('reviewer_expert')->get_all();
        if ($allexpert != null) {
            foreach ($allexpert as $value) {
                $pecah = explode(",", $value->reviewer_expert);
                foreach ($pecah as $key => $value) {
                    $input->sumber[$value] = $value;
                }
            }
        } else {
            $input->sumber = '';
        }
        // untuk select2 tags pilihan
        //$input->pilih = [];
        if (!$this->reviewer->validate()) {
            //assign select tags pilihan
            //$input->pilih = $input->reviewer_expert;
            $pages       = $this->pages;
            $main_view   = 'reviewer/form_reviewer';
            $form_action = 'reviewer/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        //gabungkan array masuk ke db
        $input->reviewer_expert = implode(",", $input->reviewer_expert);
        unset($input->sumber);
        if ($this->reviewer->insert($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('reviewer');
    }

    public function edit($id = null)
    {
        if ($id != -99) {
            $reviewer = $this->reviewer->where('reviewer_id', $id)->get();
            if (!$reviewer) {
                $this->session->set_flashdata('warning', 'Reviewer data were not available');
                redirect('reviewer');
            }
        } else {
            if (isset($_SESSION['user_id_temp'])) {
                $session_temp = array('user_id' => $this->session->user_id_temp, 'reviewer_nip' => $this->session->reviewer_nip_temp, 'reviewer_name' => $this->session->reviewer_name_temp, 'faculty_id' => '', 'reviewer_expert' => '', 'reviewer_degree_front' => '', 'reviewer_degree_back' => '', 'reviewer_contact' => '', 'reviewer_email' => '');
                $reviewer     = (object) $session_temp;
            }
        }
        // untuk select2 tags sumber
        $allexpert = $this->reviewer->select('reviewer_expert')->get_all();
        foreach ($allexpert as $value) {
            $pecah = explode(",", $value->reviewer_expert);
            foreach ($pecah as $key => $value) {
                $reviewer->sumber[$value] = $value;
            }
        }
        // untuk select2 tags pilihan
        $reviewer->reviewer_expert = explode(",", $reviewer->reviewer_expert);
        if (!$_POST) {
            $input = (object) $reviewer;
        } else {
            $input         = (object) $this->input->post(null, true);
            $input->sumber = $reviewer->sumber;
            //$input->pilih = $input->reviewer_expert;
        }
        if (!$this->reviewer->validate()) {
            $pages       = $this->pages;
            $main_view   = 'reviewer/form_reviewer';
            $form_action = "reviewer/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        //gabungkan array masuk ke db
        $input->reviewer_expert = implode(",", $input->reviewer_expert);
        if ($id == -99) {
            $data_level = array('level' => 'author_reviewer');
            if ($this->reviewer->insert($input) && $this->reviewer->where('user_id', $_SESSION['user_id_temp'])->update($data_level, 'user')) {
                $status  = 'success';
                $message = 'Data saved';
            } else {
                $status  = 'error';
                $message = 'Data failed to save';
            }
            unset($_SESSION['user_id_temp'], $_SESSION['reviewer_nip_temp'], $_SESSION['reviewer_name_temp']);
        } else {
            if ($this->reviewer->where('reviewer_id', $id)->update($input)) {
                $status  = 'success';
                $message = 'Data updated';
            } else {
                $status  = 'error';
                $message = 'Data failed to update';
            }
        }
        $this->session->set_flashdata($status, $message);
        redirect('reviewer');
    }

    public function delete($id = null)
    {
        $reviewer = $this->reviewer->where('reviewer_id', $id)->get();
        if (!$reviewer) {
            $this->session->set_flashdata('warning', 'Reviewer data were not available');
            redirect('reviewer');
        }
        $get_user = array();
        $get_user = $this->reviewer->select(['user.user_id', 'user.level'])->join('user')->where('reviewer_id', $id)->get();
        if ($this->reviewer->where('reviewer_id', $id)->delete()) {
            //set ke level author, jika akun reviewer dihapus
            if ($get_user->level == 'author_reviewer') {
                $data_level = array('level' => 'author');
                $this->reviewer->where('user_id', $get_user->user_id)->update($data_level, 'user');
            }
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }
        redirect('reviewer');
    }

    public function search($page = null)
    {
        $keywords   = $this->input->get('keywords', true);
        $reviewers  = $this->reviewer->like('reviewer_nip', $keywords)->or_like('reviewer_name', $keywords)->or_like('faculty_name', $keywords)->or_like('reviewer_expert', $keywords)->or_like('username', $keywords)->join('faculty')->join('user')->order_by('faculty.faculty_id')->order_by('reviewer_name')->paginate($page)->get_all();
        $tot        = $this->reviewer->like('reviewer_id', $keywords)->or_like('reviewer_name', $keywords)->or_like('reviewer_expert', $keywords)->join('faculty')->order_by('faculty.faculty_id')->order_by('reviewer_name')->get_all();
        $total      = count($tot);
        $pagination = $this->reviewer->make_pagination(site_url('reviewer/search/'), 3, $total);
        if (!$reviewers) {
            $this->session->set_flashdata('warning', 'Data were not found');
        } else {
            foreach ($reviewers as $reviewer) {
                $reviewer->reviewer_expert = explode(",", $reviewer->reviewer_expert);
            }
        }
        $pages     = $this->pages;
        $main_view = 'reviewer/index_reviewer';
        $this->load->view('template', compact('pages', 'main_view', 'reviewers', 'pagination', 'total'));
    }
    //    public function alpha_coma_dash_dot_space($str)
    //    {
    //        if ( !preg_match('/^[a-zA-Z .,\-]+$/i',$str) )
    //        {
    //            $this->form_validation->set_message('alpha_coma_dash_dot_space', 'Can only be filled with letters, numbers, dash(-), dot(.), and comma(,).');
    //            return false;
    //        }
    //    }
    //

    public function unique_reviewer_contact()
    {
        $reviewer_contact = $this->input->post('reviewer_contact');
        $reviewer_id      = $this->input->post('reviewer_id');
        if ($reviewer_contact == '') {
            return true;
        }
        $this->reviewer->where('reviewer_contact', $reviewer_contact);
        !$reviewer_id || $this->reviewer->where('reviewer_id !=', $reviewer_id);
        $reviewer = $this->reviewer->get();
        if (!is_null($reviewer) && count($reviewer)) {
            $this->form_validation->set_message('unique_reviewer_contact', '%s has been used');
            return false;
        }
        return true;
    }

    public function unique_reviewer_email()
    {
        $reviewer_email = $this->input->post('reviewer_email');
        $reviewer_id    = $this->input->post('reviewer_id');
        if ($reviewer_email == '') {
            return true;
        }
        $this->reviewer->where('reviewer_email', $reviewer_email);
        !$reviewer_id || $this->reviewer->where('reviewer_id !=', $reviewer_id);
        $reviewer = $this->reviewer->get();
        if (!is_null($reviewer) && count($reviewer)) {
            $this->form_validation->set_message('unique_reviewer_email', '%s has been used');
            return false;
        }
        return true;
    }

    public function unique_reviewer_nip()
    {
        $reviewer_nip = $this->input->post('reviewer_nip');
        $reviewer_id  = $this->input->post('reviewer_id');
        $this->reviewer->where('reviewer_nip', $reviewer_nip);
        !$reviewer_id || $this->reviewer->where('reviewer_id !=', $reviewer_id);
        $reviewer = $this->reviewer->get();
        if (!is_null($reviewer) && count($reviewer)) {
            $this->form_validation->set_message('unique_reviewer_nip', '%s has been used');
            return false;
        }
        return true;
    }

    public function unique_reviewer_username()
    {
        $user_id     = $this->input->post('user_id');
        $reviewer_id = $this->input->post('reviewer_id');
        $this->reviewer->where('user_id', $user_id);
        !$reviewer_id || $this->reviewer->where('reviewer_id !=', $reviewer_id);
        $reviewer = $this->reviewer->get();
        if (!is_null($reviewer) && count($reviewer)) {
            $this->form_validation->set_message('unique_reviewer_username', '%s has been used');
            return false;
        }
        return true;
    }
}
