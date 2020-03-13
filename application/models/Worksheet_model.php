<?php defined('BASEPATH') or exit('No direct script access allowed');

class Worksheet_model extends MY_Model
{
    // set public if want to override per_page
    public $per_page = 10;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'draft_id',
                'label' => $this->lang->line('form_draft_title'),
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_worksheet_draft',
            ],
            [
                'field' => 'worksheet_num',
                'label' => $this->lang->line('form_worksheet_num'),
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_worksheet_num',
            ],
            [
                'field' => 'worksheet_notes',
                'label' => $this->lang->line('form_worksheet_notes'),
                'rules' => 'trim',
            ],
            // [
            //     'field' => 'is_reprint',
            //     'label' => $this->lang->line('form_worksheet_is_reprint'),
            //     'rules' => 'trim|required',
            // ],
            [
                'field' => 'is_revise',
                'label' => $this->lang->line('form_worksheet_is_revise'),
                'rules' => 'trim|required',
            ],

        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'draft_id'           => '',
            'worksheet_num'      => '',
            'worksheet_notes'    => '',
            'is_reprint'         => 'n',
            'is_revise'          => 'n',
            'worksheet_status'   => '0',
            'worksheet_deadline' => '0',
            'worksheet_end_date' => '0',
        ];
    }

    public function filter_data($filters, $page = null)
    {
        $query = $this->select('worksheet.draft_id,draft_title,worksheet_id,worksheet_num,entry_date,draft.is_reprint,is_revise,worksheet_status,worksheet_pic')
            ->when('keyword', $filters['keyword'])
            ->when('status', $filters['status'])
            ->when('reprint', $filters['reprint'])
            ->when('revise', $filters['revise'])
            ->join('draft')
            ->order_by('worksheet_status')
            ->order_by('worksheet_id', 'desc')
            ->order_by('worksheet_num');

        return [
            'data'  => $query->paginate($page)->get_all(),
            'count' => $this
                ->when('keyword', $filters['keyword'])
                ->when('status', $filters['status'])
                ->when('reprint', $filters['reprint'])
                ->when('revise', $filters['revise'])
                ->join('draft')
                ->count(),
        ];
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data) {
            if ($params == 'keyword') {
                $this->group_start();
                $this->like('draft_title', $data);
                $this->or_like('worksheet_num', $data);
                $this->group_end();
            }

            if ($params == 'status') {
                if ($data == 'waiting') {
                    $status_code = 0;
                } elseif ($data == 'approved') {
                    $status_code = 1;
                } else {
                    $status_code = 2;
                }
                $this->where('worksheet_status', $status_code);
            }

            if ($params == 'reprint') {
                $this->where('worksheet.is_reprint', $data);
            }

            if ($params == 'revise') {
                $this->where('is_revise', $data);
            }
        }
        return $this;
    }
}