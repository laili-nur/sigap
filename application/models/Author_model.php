<?php defined('BASEPATH') or exit('No direct script access allowed');

class Author_model extends MY_Model
{
    protected $per_page = 10;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'user_id',
                'label' => $this->lang->line('form_user_name'),
                'rules' => 'trim|callback_unique_data[user_id]',
            ],
            [
                'field' => 'work_unit_id',
                'label' => $this->lang->line('form_work_unit_name'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'institute_id',
                'label' => $this->lang->line('form_institute_name'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'author_name',
                'label' => $this->lang->line('form_author_name'),
                'rules' => 'trim|required|min_length[1]|max_length[256]',
            ],
            [
                'field' => 'author_nip',
                'label' => $this->lang->line('form_author_nip'),
                'rules' => 'trim|required|numeric|min_length[3]|max_length[256]|callback_unique_data[author_nip]',
            ],
            [
                'field' => 'author_degree_front',
                'label' => $this->lang->line('form_author_degree_front'),
                'rules' => 'trim|min_length[2]|max_length[256]',
            ],
            [
                'field' => 'author_degree_back',
                'label' => $this->lang->line('form_author_degree_back'),
                'rules' => 'trim|min_length[2]|max_length[256]',
            ],
            [
                'field' => 'author_latest_education',
                'label' => $this->lang->line('form_author_latest_education'),
                'rules' => 'trim',
            ],
            [
                'field' => 'author_address',
                'label' => $this->lang->line('form_author_address'),
                'rules' => 'trim|max_length[256]',
            ],
            [
                'field' => 'author_contact',
                'label' => $this->lang->line('form_author_contact'),
                'rules' => 'trim|max_length[20]|callback_unique_data[author_contact]',
            ],
            [
                'field' => 'author_email',
                'label' => $this->lang->line('form_author_email'),
                'rules' => 'trim|valid_email|callback_unique_data[author_email]',
            ],
            [
                'field' => 'author_saving_num',
                'label' => $this->lang->line('form_author_saving_num'),
                'rules' => 'trim|max_length[30]|callback_unique_data[author_saving_num]',
            ],
            [
                'field' => 'heir_name',
                'label' => $this->lang->line('form_author_heir_name'),
                'rules' => 'trim|max_length[256]',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'work_unit_id'            => null,
            'institute_id'            => null,
            'author_nip'              => null,
            'author_name'             => null,
            'author_degree_front'     => null,
            'author_degree_back'      => null,
            'author_latest_education' => null,
            'author_address'          => null,
            'author_contact'          => null,
            'author_email'            => null,
            'bank_id'                 => null,
            'author_saving_num'       => null,
            'heir_name'               => null,
            'user_id'                 => null,
            'author_ktp'              => null,
        ];
    }

    public function get_data($keywords, $page = null)
    {
        $query = $this->select('author_id,author_nip,author_name,author_degree_front,author_degree_back,work_unit_name,institute_name,username,author.user_id')
            ->like('work_unit_name', $keywords)
            ->or_like('institute_name', $keywords)
            ->or_like('author_nip', $keywords)
            ->or_like('author_name', $keywords)
            ->or_like('username', $keywords)
            ->join('work_unit')
            ->join('institute')
            ->join('bank')
            ->join('user')
            ->order_by('author.work_unit_id')
            ->order_by('author.institute_id')
            ->order_by('author_name');

        return [
            'data'  => $query->paginate($page)->get_all(),
            'count' => $this
                ->like('work_unit_name', $keywords)
                ->or_like('institute_name', $keywords)
                ->or_like('author_nip', $keywords)
                ->or_like('author_name', $keywords)
                ->or_like('username', $keywords)
                ->join('work_unit')
                ->join('institute')
                ->join('bank')
                ->join('user')
                ->count(),
        ];
    }

    public function get_author_details($author_id)
    {
        return $this->author
            ->join_table('user', 'author', 'user')
            ->where('author_id', $author_id)
            ->get();
    }

    public function get_author_drafts($author_id)
    {
        $this->load->model('draft_model', 'draft');
        return $this->draft
            ->select(['draft_author.draft_id', 'draft_title', 'category_name', 'theme_name', 'entry_date', 'finish_date'])
            ->join('theme')
            ->join('category')
            ->join_table('draft_author', 'draft', 'draft')
            ->join_table('author', 'draft_author', 'author')
            ->where('draft_author.author_id', $author_id)
            ->get_all();
    }

    public function get_author_books($author_id)
    {
        $this->load->model('book_model', 'book');
        return $this->book
            ->select(['book_title', 'book_edition', 'isbn', 'nomor_hak_cipta', 'published_date'])
            ->join_table('draft', 'book', 'draft')
            ->join_table('draft_author', 'draft', 'draft')
            ->join_table('author', 'draft_author', 'author')
            ->where('draft_author.author_id', $author_id)
            ->get_all();
    }

    public function upload_author_ktp($ktp_field_name, $ktp_name)
    {
        $config = [
            'upload_path'      => './authorktp/',
            'file_name'        => $ktp_name,
            'allowed_types'    => 'jpg|png|jpeg|pdf',
            'max_size'         => 15360, // 15MB
            'overwrite'        => true,
            'file_ext_tolower' => true,
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($ktp_field_name)) {
            // Upload OK, return uploaded file info.
            return $this->upload->data();
        } else {
            // Add error to $_error_array
            $this->form_validation->add_to_error_array($ktp_field_name, $this->upload->display_errors('', ''));
            return false;
        }
    }

    public function delete_author_ktp($ktp_name)
    {
        if ($ktp_name != "") {
            if (file_exists("./authorktp/$ktp_name")) {
                unlink("./authorktp/$ktp_name");
            }
        }
    }
}