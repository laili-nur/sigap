<?php defined('BASEPATH') or exit('No direct script access allowed');

class Draft_model extends MY_Model
{
    // set public if want to ovveride per_page
    public $per_page;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'category_id',
                'label' => $this->lang->line('form_category_name'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'theme_id',
                'label' => $this->lang->line('form_theme_name'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'draft_title',
                'label' => $this->lang->line('form_draft_title'),
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_data[draft_title]',
            ],
            [
                'field' => 'author_id[]',
                'label' => $this->lang->line('form_author_name'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'draft_file_link',
                'label' => $this->lang->line('form_draft_file_link'),
                'rules' => 'trim|callback_valid_url',
            ],
            // [
            //     'field' => 'draft_pages',
            //     'label' => 'Halaman Draft',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'entry_date',
            //     'label' => 'Entry Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'finish_date',
            //     'label' => 'Finish Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'draft_status',
            //     'label' => 'Draft Status',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'draft_notes',
            //     'label' => 'Draft Notes',
            //     'rules' => 'trim',
            // ],
            // //review
            // [
            //     'field' => 'is_review',
            //     'label' => 'Is Review',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review_start_date',
            //     'label' => 'Review Start Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review_end_date',
            //     'label' => 'Review End Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review1_file',
            //     'label' => 'Review 1 File',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review1_file_link',
            //     'label' => 'Reviewer1 File Link',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review1_upload_date',
            //     'label' => 'Review 1 Upload Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review1_notes',
            //     'label' => 'Review 1 Notes',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review1_notes_author',
            //     'label' => 'Author Review 1 Notes',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review1_deadline',
            //     'label' => 'Review 1 Deadline',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review2_file',
            //     'label' => 'Review 2 File',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review2_file_link',
            //     'label' => 'Reviewer2 File Link',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review2_upload_date',
            //     'label' => 'Review 2 Upload Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review2_notes',
            //     'label' => 'Review 2 Notes',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review2_notes_author',
            //     'label' => 'Author Review 2 Notes',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'review2_deadline',
            //     'label' => 'Review 2 Deadline',
            //     'rules' => 'trim',
            // ],
            // //edit
            // [
            //     'field' => 'is_edit',
            //     'label' => 'Is Edit',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'edit_start_date',
            //     'label' => 'Edit Start Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'edit_end_date',
            //     'label' => 'Edit End Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'edit_file',
            //     'label' => 'Edit File',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'edit_file_link',
            //     'label' => 'Editor File Link',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'edit_upload_date',
            //     'label' => 'Edit Upload Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'edit_notes',
            //     'label' => 'Edit Notes',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'edit_notes_author',
            //     'label' => 'Author Edit Notes',
            //     'rules' => 'trim',
            // ],
            // //layout
            // [
            //     'field' => 'is_layout',
            //     'label' => 'Is Layout',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'layout_start_date',
            //     'label' => 'Layout Start Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'layout_end_date',
            //     'label' => 'Layout End Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'layout_file',
            //     'label' => 'Layout File',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'layout_file_link',
            //     'label' => 'Layouter File Link',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'layout_upload_date',
            //     'label' => 'Layout Upload Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'layout_notes',
            //     'label' => 'Layout Notes',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'layout_notes_author',
            //     'label' => 'Author Layout Notes',
            //     'rules' => 'trim',
            // ],
            // //cover
            // [
            //     'field' => 'cover_file',
            //     'label' => 'Cover File',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'cover_file_link',
            //     'label' => 'Cover File Link',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'cover_upload_date',
            //     'label' => 'Cover Upload Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'cover_notes',
            //     'label' => 'Cover Notes',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'cover_notes_author',
            //     'label' => 'Author Cover Notes',
            //     'rules' => 'trim',
            // ],
            // //proofread
            // [
            //     'field' => 'is_proofread',
            //     'label' => 'Is Proofread',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'proofread_start_date',
            //     'label' => 'Proofread Start Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'proofread_end_date',
            //     'label' => 'Proofread End Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'proofread_file',
            //     'label' => 'Proofread File',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'proofread_file_link',
            //     'label' => 'Proofread File Link',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'proofread_upload_date',
            //     'label' => 'Proofread Upload Date',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'proofread_notes',
            //     'label' => 'Proofread Notes',
            //     'rules' => 'trim',
            // ],
            // [
            //     'field' => 'proofread_notes_author',
            //     'label' => 'Author Proofread Notes',
            //     'rules' => 'trim',
            // ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'category_id'            => null,
            'theme_id'               => null,
            'draft_title'            => null,
            'draft_pages'            => null,
            'author_id'              => null,
            'draft_file'             => null,
            'entry_date'             => null,
            'finish_date'            => null,
            'is_review'              => null,
            'review_start_date'      => null,
            'review_end_date'        => null,
            'review1_file'           => null,
            'review1_file_link'    => null,
            'review1_upload_date'    => null,
            'review1_upload_by'    => null,
            'review1_notes'          => null,
            'review1_notes_author'   => null,
            'review1_deadline'       => null,
            'review2_file'           => null,
            'review2_file_link'    => null,
            'review2_upload_date'    => null,
            'review2_upload_by'    => null,
            'review2_notes'          => null,
            'review2_notes_author'   => null,
            'review2_deadline'       => null,
            'is_edit'                => null,
            'edit_start_date'        => null,
            'edit_end_date'          => null,
            'edit_file'              => null,
            'edit_file_link'       => null,
            'edit_upload_date'       => null,
            'edit_upload_by'       => null,
            'edit_notes'             => null,
            'edit_notes_author'      => null,
            'is_layout'              => null,
            'layout_start_date'      => null,
            'layout_end_date'        => null,
            'layout_file'            => null,
            'layout_file_link'     => null,
            'layout_upload_date'     => null,
            'layout_upload_by'     => null,
            'layout_notes'           => null,
            'layout_notes_author'    => null,
            'cover_file'             => null,
            'cover_file_link'        => null,
            'cover_upload_date'      => null,
            'cover_notes'            => null,
            'cover_notes_author'     => null,
            'is_proofread'           => null,
            'proofread_start_date'   => null,
            'proofread_end_date'     => null,
            'proofread_file'         => null,
            'proofread_file_link'    => null,
            'proofread_upload_date'  => null,
            'proofread_last_upload'  => null,
            'proofread_notes'        => null,
            'proofread_notes_author' => null,
            'draft_status'           => null,
            'draft_notes'            => null,
            'draft_file_link'        => null,
        ];
    }

    public function filter_draft_for_admin($filters, $page)
    {
        $drafts = $this->select(['draft.draft_id', 'draft_title', 'category_name', 'category_year', 'entry_date', 'draft_status', 'is_reprint', 'author_name'])
            ->when('keyword', $filters['keyword'])
            ->join('category')
            ->join_table('draft_author', 'draft', 'draft')
            ->join_table('author', 'draft_author', 'author')
            ->when('progress', $filters['progress'])
            ->when('reprint', $filters['reprint'])
            ->when('category', $filters['category'])
            ->order_by('draft_status')
            ->order_by('draft_title')
            ->group_by('draft_id')
            ->paginate($page)
            ->get_all();

        $total = $this->select('draft.draft_id')
            ->when('keyword', $filters['keyword'])
            ->join_table('draft_author', 'draft', 'draft')
            ->join_table('author', 'draft_author', 'author')
            ->when('progress', $filters['progress'])
            ->when('reprint', $filters['reprint'])
            ->when('category', $filters['category'])
            ->group_by('draft_id')
            ->count();

        return [
            'drafts' => $this->_get_draft_authors_and_status($drafts),
            'total'  => $total,
        ];
    }

    public function filter_draft_for_author($filters, $username, $page)
    {
        $drafts = $this->select(['draft.draft_id', 'draft_title', 'category_name', 'category_year', 'entry_date', 'draft_status', 'is_reprint', 'author_name'])
            ->when('keyword', $filters['keyword'])
            ->join('category')
            ->join_table('draft_author', 'draft', 'draft')
            ->join_table('author', 'draft_author', 'author')
            ->join_table('user', 'author', 'user')
            ->where('username', $username)
            ->when('progress', $filters['progress'])
            ->order_by('draft_status')
            ->order_by('draft_title')
            ->group_by('draft_id')
            ->paginate($page)
            ->get_all();

        $total = $this->select('draft.draft_id')
            ->when('keyword', $filters['keyword'])
            ->join_table('draft_author', 'draft', 'draft')
            ->join_table('author', 'draft_author', 'author')
            ->join_table('user', 'author', 'user')
            ->where('username', $username)
            ->when('progress', $filters['progress'])
            ->group_by('draft_id')
            ->count();

        return [
            'drafts' => $this->_get_draft_authors_and_status($drafts),
            'total'  => $total,
        ];
    }

    public function filter_draft_for_reviewer($filters, $username, $page)
    {
        $drafts = $this->select(['draft.draft_id', 'draft_title', 'category_name', 'category_year', 'entry_date', 'draft_status', 'is_reprint', 'review1_flag', 'review1_deadline', 'review2_flag', 'review2_deadline'])
            ->join('category')
            ->join_table('draft_reviewer', 'draft', 'draft')
            ->join_table('reviewer', 'draft_reviewer', 'reviewer')
            ->join_table('user', 'reviewer', 'user')
            ->where('username', $username)
            ->when('keyword', $filters['keyword'])
            ->when('progress', $filters['progress'])
            ->order_by('draft_status')
            ->order_by('draft_title')
            ->group_by('draft_id')
            ->paginate($page)
            ->get_all();

        $total = $this->select('draft.draft_id')
            ->join_table('draft_reviewer', 'draft', 'draft')
            ->join_table('reviewer', 'draft_reviewer', 'reviewer')
            ->join_table('user', 'reviewer', 'user')
            ->where('username', $username)
            ->when('keyword', $filters['keyword'])
            ->when('progress', $filters['progress'])
            ->group_by('draft_id')
            ->count();

        return [
            'drafts' => $drafts,
            'total'  => $total,
        ];
    }

    public function filter_draft_for_staff($filters, $username, $page)
    {
        $drafts = $this->select(['draft.draft_id', 'draft_title', 'category_name', 'category_year', 'entry_date', 'draft_status', 'is_reprint', 'author_name', 'edit_start_date', 'edit_end_date', 'edit_deadline'])
            ->when('keyword', $filters['keyword'])
            ->join('category')
            ->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')
            ->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')
            ->where('username', $username)
            ->when('progress', $filters['progress'])
            // ->when('status', $filters['status'])
            ->order_by('draft_status')
            ->order_by('draft_title')
            ->group_by('draft_id')
            ->paginate($page)
            ->get_all();

        $total = $this->select('draft.draft_id')
            ->when('keyword', $filters['keyword'])
            ->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')
            ->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')
            ->where('username', $username)
            ->when('progress', $filters['progress'])
            // ->when('status', $filters['status'])
            ->group_by('draft_id')
            ->count();

        return [
            'drafts' => $this->_get_draft_authors_and_status($drafts),
            'total'  => $total,
        ];
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data) {
            if ($params == 'reprint') {
                $this->where('is_reprint', $data);
            }

            if ($params == 'category') {
                $this->where('draft.category_id', $data);
            }

            if ($params == 'progress') {
                $this->resolve_progress($data);
            }

            if ($params == 'keyword') {
                $this->group_start();
                $this->like('draft_title', $data);
                if ($this->session->userdata('level') != 'reviewer') {
                    $this->or_like('author_name', $data);
                }
                $this->group_end();
            }

            // if ($params == 'status') {
            //     if ($data == 'y') {
            //         $this->where_not('edit_notes', '');
            //     } elseif ($data == 'n') {
            //         $this->where('edit_notes', '');
            //     }
            // }
        }
        return $this;
    }

    public function resolve_progress($progress)
    {
        switch ($progress) {
            case 'desk_screening':
                $this->group_start()
                    ->where('draft_status', 0)
                    ->or_where('draft_status', 1)
                    ->group_end();
                break;

            case 'review':
                $this->where('is_review', 'n')
                    ->where('draft_status', '4');
                break;

            case 'edit':
                $this->where('is_review', 'y')
                    ->where('is_edit', 'n')
                    ->where_not('draft_status', '99');
                break;

            case 'layout':
                $this->where('is_review', 'y')
                    ->where('is_edit', 'y')
                    ->where('is_layout', 'n')
                    ->where_not('draft_status', '99');
                break;

            case 'proofread':
                $this->where('is_review', 'y')
                    ->where('is_edit', 'y')
                    ->where('is_layout', 'y')
                    ->where('is_proofread', 'n')
                    ->where_not('draft_status', '99');
                break;

            case 'print':
                $this->where('is_review', 'y')
                    ->where('is_edit', 'y')
                    ->where('is_layout', 'y')
                    ->where('is_proofread', 'y')
                    ->group_start()
                    ->where('is_print', 'n')
                    ->or_where('is_print', 'y')
                    ->group_end()
                    ->group_start()
                    ->where_not('draft_status', '99')
                    ->where_not('draft_status', '14')
                    ->group_end();
                break;

            case 'reject':
                $this->group_start()
                    ->where('draft_status', '99')
                    ->or_where('draft_status', '2')
                    ->group_end();
                break;

            case 'final':
                $this->where('is_review', 'y')
                    ->where('is_edit', 'y')
                    ->where('is_layout', 'y')
                    ->where('is_proofread', 'y')
                    ->where('is_print', 'y')
                    ->where('is_reprint', 'n')
                    ->where('draft_status', '14');
                break;

            default:
                # code...
                break;
        }
        return $this;
    }

    public function is_authorized($level, $username, $draft_id)
    {
        if (is_admin()) {
            return true;
        }

        $this->select('draft.draft_id');

        if ($level == 'reviewer') {
            $this->join_table('draft_reviewer', 'draft', 'draft')
                ->join_table('reviewer', 'draft_reviewer', 'reviewer')
                ->join_table('user', 'reviewer', 'user');
        } elseif ($level == 'author') {
            $this->join_table('draft_author', 'draft', 'draft')
                ->join_table('author', 'draft_author', 'author')
                ->join_table('user', 'author', 'user');
        } elseif ($level == 'editor' || $level == 'layouter') {
            $this->join_table('responsibility', 'draft', 'draft')
                ->join_table('user', 'responsibility', 'user');
        }

        $is_authorized = $this->where('draft.draft_id', $draft_id)
            ->where('username', $username)
            ->count();

        return !!$is_authorized;
    }

    public function upload_draft_file($field_name, $draft_file_name)
    {
        $config = [
            'upload_path'      => './draftfile/',
            'file_name'        => $draft_file_name,
            'allowed_types'    => get_allowed_file_types('draft_file')['types'],
            'max_size'         => 51200, // 50MB
            'overwrite'        => true,
            'file_ext_tolower' => true,
        ];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($field_name)) {
            // Upload OK, return uploaded file info.
            return $this->upload->data();
        } else {
            // Add error to $_error_array
            $this->form_validation->add_to_error_array($field_name, $this->upload->display_errors('', ''));
            return false;
        }
    }

    public function delete_draft_file($draft_file)
    {
        if ($draft_file != "") {
            if (file_exists("./draftfile/$draft_file")) {
                unlink("./draftfile/$draft_file");
            }
        }
    }
    // public function deleteCoverfile($draftFile)
    // {
    //     if ($draftFile != "") {
    //         if (file_exists("./coverfile/$draftFile")) {
    //             unlink("./coverfile/$draftFile");
    //         }
    //     }
    // }

    public function upload_file($field_name, $draft_file_name)
    {
        $config = [
            'upload_path'      => './draftfile/',
            'file_name'        => $draft_file_name,
            'allowed_types'    => 'docx|doc|pdf|idml|indd|indt|zip|rar|jpg|jpeg|png', // docx dan indesign
            'max_size'         => 151200,
            'overwrite'        => true,
            'file_ext_tolower' => true,
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($field_name)) {
            // Upload OK, return uploaded file info.
            return $this->upload->data();
        } else {
            // Add error to $_error_array
            $this->form_validation->add_to_error_array($field_name, $this->upload->display_errors('', ''));
            return false;
        }
    }

    // public function uploadProgressCover($field_name, $draft_file_name)
    // {
    //     $config = [
    //         'upload_path'      => './coverfile/',
    //         'file_name'        => $draft_file_name,
    //         'allowed_types'    => 'pdf|jpg|jpeg|png|zip|rar', // image only
    //         'max_size'         => 20480, // 20MB
    //         'overwrite'        => true,
    //         'file_ext_tolower' => true,
    //     ];

    //     $this->load->library('upload', $config);
    //     if ($this->upload->do_upload($field_name)) {
    //         // Upload OK, return uploaded file info.
    //         return $this->upload->data();
    //     } else {
    //         // Add error to $_error_array
    //         $this->form_validation->add_to_error_array($field_name, $this->upload->display_errors('', ''));
    //         return false;
    //     }
    // }

    public function delete_file($draft_file)
    {
        if ($draft_file) {
            if (file_exists("./draftfile/$draft_file")) {
                unlink("./draftfile/$draft_file");
                return true;
            }
            return false;
        }
    }

    // public function deleteProgressCover($draftFile)
    // {
    //     if ($draftFile != "") {
    //         if (file_exists("./coverfile/$draftFile")) {
    //             unlink("./coverfile/$draftFile");
    //         }
    //     }
    // }

    private function _get_draft_authors_and_status(array $drafts)
    {
        foreach ($drafts as $d) {
            $d->authors = $this->get_id_and_name('author', 'draft_author', $d->draft_id);
        }

        return $drafts;
    }
}
