<?php defined('BASEPATH') or exit('No direct script access allowed');

class Draft_author extends Operator_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'draft_author';
    }

    // public function index($page = null)
    // {
    //     $draft_authors = $this->draft_author->join('draft')->join('author')->order_by('draft.draft_id')->order_by('author.author_id')->order_by('draft_author_id')->paginate($page)->get_all();
    //     $tot           = $this->draft_author->join('draft')->join('author')->order_by('draft.draft_id')->order_by('author.author_id')->order_by('draft_author_id')->get_all();
    //     $total         = count($tot);
    //     $pages         = $this->pages;
    //     $main_view     = 'draftauthor/index_draft_author';
    //     $pagination    = $this->draft_author->make_pagination(site_url('draftauthor'), 2, $total);

    //     $this->load->view('template', compact('pages', 'main_view', 'draft_authors', 'pagination', 'total'));
    // }

    // public function addmulti($draft_id = null)
    // {
    //     $input = $this->input->post(null, true);

    //     // $data =array();
    //     // foreach ($inputs as $input) {
    //     //      $data[$i] = array(
    //     //        'author_id' => $input['author_id'],
    //     //        'draft_id' => $input['draft_id'],
    //     //     );
    //     //  }
    //     // $this->db->insert_batch('draft_author', $data);
    //     $isSuccess = true;

    //     foreach ($input->author_id as $key => $value) {
    //         $data_author = array('author_id' => $value, 'draft_id' => $draft_id);

    //         $draft_author_id = $this->draft->insert($data_author, 'draft_author');

    //         if ($draft_author_id < 1 ) {
    //             $isSuccess = false;
    //             break;
    //         } else {
    //             $isSuccess = true;
    //         }
    //     }

    //     if ($isSuccess) {
    //         $this->session->set_flashdata('success', 'Data saved');
    //     } else {
    //         $this->session->set_flashdata('error', 'Data author failed to save');
    //     }

    //     redirect('draft/view/'.$input->draft_id);

    // }

    public function add()
    {
        $input = (object) $this->input->post(null, true);

        if (!$input->draft_id || !$input->author_id) {
            return $this->send_json_output(false, $this->lang->line('toast_data_not_available'));
        }

        // set penulis pertama menjadi status 1, agar bisa edit draft
        $draft_authors = $this->draft_author->where('draft_id', $input->draft_id)->get();
        if (!$draft_authors) {
            $input->draft_author_status = 1;
        }

        if (!$this->draft_author->validate()) {
            return $this->send_json_output(false, $this->lang->line('toast_data_duplicate'), 422);
        }

        if ($this->draft_author->insert($input)) {
            return $this->send_json_output(true, $this->lang->line('toast_add_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_add_fail'));
        }
    }

    // public function edit($id = null)
    // {
    //     $draft_author = $this->draft_author->where('draft_author_id', $id)->get();
    //     if (!$draft_author) {
    //         $this->session->set_flashdata('warning', 'Draft Author data were not available');
    //         redirect('draftauthor');
    //     }

    //     if (!$_POST) {
    //         $input = (object) $draft_author;
    //     } else {
    //         $input = (object) $this->input->post(null, true);
    //     }

    //     if (!$this->draft_author->validate()) {
    //         $pages       = $this->pages;
    //         $main_view   = 'draftauthor/form_draft_author';
    //         $form_action = "draftauthor/edit/$id";

    //         $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
    //         return;
    //     }

    //     if ($this->draft_author->where('draft_author_id', $id)->update($input)) {
    //         $this->session->set_flashdata('success', 'Data updated');
    //     } else {
    //         $this->session->set_flashdata('error', 'Data failed to update');
    //     }

    //     redirect('draftauthor');
    // }

    public function delete($id = null)
    {
        $draft_author = $this->draft_author->where('draft_author_id', $id)->get();
        if (!$draft_author) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        if ($this->draft_author->where('draft_author_id', $id)->delete()) {
            return $this->send_json_output(true, $this->lang->line('toast_delete_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_delete_fail'));
        }
    }

    // public function search($page = null)
    // {
    //     $keywords      = $this->input->get('keywords', true);
    //     $draft_authors = $this->draft_author->like('draft_author_id', $keywords)
    //         ->or_like('draft_title', $keywords)
    //         ->or_like('author_name', $keywords)
    //         ->or_like('author_nip', $keywords)
    //         ->join('draft')
    //         ->join('author')
    //         ->order_by('draft_author_id')
    //         ->order_by('draft.draft_title')
    //         ->order_by('author.author_name')
    //         ->order_by('author.author_nip')
    //         ->paginate($page)
    //         ->get_all();
    //     $tot = $this->draft_author->like('draft_author_id', $keywords)
    //         ->or_like('draft_title', $keywords)
    //         ->or_like('author_name', $keywords)
    //         ->or_like('author_nip', $keywords)
    //         ->join('draft')
    //         ->join('author')
    //         ->order_by('draft_author_id')
    //         ->order_by('draft.draft_title')
    //         ->order_by('author.author_name')
    //         ->order_by('author.author_nip')
    //         ->get_all();
    //     $total = count($tot);

    //     $pagination = $this->draft_author->make_pagination(site_url('draft_author/search/'), 3, $total);

    //     if (!$draft_authors) {
    //         $this->session->set_flashdata('warning', 'Data were not found');
    //         redirect('draftauthor');
    //     }

    //     $pages     = $this->pages;
    //     $main_view = 'draftauthor/index_draft_author';
    //     $this->load->view('template', compact('pages', 'main_view', 'draft_authors', 'pagination', 'total'));
    // }

    public function unique_draft_author()
    {
        $author_id       = $this->input->post('author_id');
        $draft_id        = $this->input->post('draft_id');
        $draft_author_id = $this->input->post('draft_author_id');

        $this->draft_author->where('author_id', $author_id);
        $this->draft_author->where('draft_id', $draft_id);
        !$draft_author_id || $this->draft_author->where_not('draft_author_id', $draft_author_id);
        $draft_author = $this->draft_author->get();

        if ($draft_author) {
            $this->form_validation->set_message('unique_draft_author', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }

}