<?php defined('BASEPATH') or exit('No direct script access allowed');
class Reviewer extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'reviewer';

        // load model
        $this->load->model('reviewer_model', 'reviewer');
    }

    public function index($page = null)
    {
        $keywords   = $this->input->get('keywords', true);
        $get_data   = $this->reviewer->get_data($keywords, $page);
        $reviewers  = $get_data['data'];
        $total      = $get_data['count'];
        $pagination = $this->reviewer->make_pagination(site_url('reviewer'), 2, $total);
        if (!$reviewers) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
        }

        foreach ($reviewers as $reviewer) {
            $reviewer->reviewer_expert = explode(",", $reviewer->reviewer_expert);
        }

        $pages     = $this->pages;
        $main_view = 'reviewer/index_reviewer';
        $this->load->view('template', compact('pages', 'main_view', 'reviewers', 'pagination', 'total'));
    }

    public function api_get_reviewers()
    {
        $reviewers = $this->reviewer->api_get_reviewers();
        return $this->send_json_output(true, $reviewers);
    }

    public function add($copy = false)
    {
        if ($copy == 'copy') {
            if (isset($this->session->user_id_temp)) {
                $input                = (object) $this->reviewer->get_default_values();
                $input->user_id       = $this->session->user_id_temp;
                $input->reviewer_nip  = $this->session->reviewer_nip_temp;
                $input->reviewer_name = $this->session->reviewer_name_temp;
            }
        } else {
            if (!$_POST) {
                $input = (object) $this->reviewer->get_default_values();
            } else {
                $input = (object) $this->input->post(null, true);

                // repopulate reviewer_expert ketika validasi form gagal
                if (!isset($input->reviewer_expert)) {
                    $input->reviewer_expert = [];
                }

                // forced to null, instead empty string
                $input->user_id    = empty_to_null($input->user_id);
                $input->faculty_id = empty_to_null($input->faculty_id);
            }
        }

        // select2 data expert
        $input->reviewer_expert_data = $this->_generate_reviewer_expert_data($input->reviewer_expert);

        if (!$this->reviewer->validate()) {
            $pages       = $this->pages;
            $main_view   = 'reviewer/form_reviewer';
            $form_action = 'reviewer/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        // gabungkan array masuk ke db
        $input->reviewer_expert = implode(",", $input->reviewer_expert);
        unset($input->reviewer_expert_data);

        if ($copy == 'copy') {
            if ($this->reviewer->insert($input) && $this->reviewer->where('user_id', $this->session->user_id_temp)->update(['level' => 'author_reviewer'], 'user')) {
                $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
            } else {
                $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
            }
            unset($this->session->user_id_temp, $this->session->reviewer_nip_temp, $this->session->reviewer_name_temp);
        } else {
            if ($this->reviewer->insert($input)) {
                $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
            } else {
                $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
            }
        }

        redirect($this->pages);
    }

    public function edit($id = null)
    {
        $reviewer = $this->reviewer->where('reviewer_id', $id)->get();
        if (!$reviewer) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        // untuk select2 tags pilihan
        if (!$_POST) {
            $input = (object) $reviewer;
            // pecah expert data string ketika ambil dari db
            $input->reviewer_expert = explode(",", $input->reviewer_expert);
        } else {
            $input = (object) $this->input->post(null, true);

            // repopulate reviewer_expert ketika validasi form gagal
            if (!isset($input->reviewer_expert)) {
                $input->reviewer_expert = [];
            }

            // forced to null, instead empty string
            $input->user_id    = empty_to_null($input->user_id);
            $input->faculty_id = empty_to_null($input->faculty_id);
        }

        // select2 data expert
        $input->reviewer_expert_data = $this->_generate_reviewer_expert_data($input->reviewer_expert);

        if (!$this->reviewer->validate()) {
            $pages       = $this->pages;
            $main_view   = 'reviewer/form_reviewer';
            $form_action = "reviewer/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        // gabungkan array masuk ke db
        $input->reviewer_expert = implode(",", $input->reviewer_expert);
        unset($input->reviewer_expert_data);

        if ($this->reviewer->where('reviewer_id', $id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('success', $this->lang->line('toast_fail_fail'));
        }

        redirect($this->pages);
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

    /**
     * Menghasilkan array kepakaran
     *
     * @param array $reviewer_expert_input
     * @return array
     */
    public function _generate_reviewer_expert_data(array $reviewer_expert_input)
    {
        $reviewer_expert_data = [];
        $all_expert           = $this->reviewer->select('reviewer_expert')->get_all();
        if ($all_expert) {
            foreach ($all_expert as $e) {
                $reviewer_expert_arr = explode(",", $e->reviewer_expert);
                foreach ($reviewer_expert_arr as $r) {
                    $reviewer_expert_data[$r] = $r;
                }
            }

            // repopulate data baru yang belum ada di db
            foreach ($reviewer_expert_input as $r) {
                $reviewer_expert_data[$r] = $r;
            }
        } else {
            $reviewer_expert_data = [];
        }

        return $reviewer_expert_data;
    }

    public function unique_data($str, $data_key)
    {
        $reviewer_id = $this->input->post('reviewer_id');
        if (!$str) {
            return true;
        }
        $this->reviewer->where($data_key, $str);
        !$reviewer_id || $this->reviewer->where_not('reviewer_id', $reviewer_id);
        $reviewer = $this->reviewer->get();
        if ($reviewer) {
            $this->form_validation->set_message('unique_data', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }
}
