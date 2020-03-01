<?php
class MY_Model extends CI_Model
{
    protected $table    = '';
    protected $per_page = 0;

    public function __construct()
    {
        parent::__construct();

        if (!$this->table) {
            $this->table = strtolower(str_replace('_model', '', get_class($this)));
        }

        $this->lang->load('form', 'indonesian');
    }

    public function check_table($table)
    {
        if ($table == "") {
            $table = $this->table;
        }

        return $table;
    }

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function group_start()
    {
        $this->db->group_start();
        return $this;
    }

    public function group_end()
    {
        $this->db->group_end();
        return $this;
    }

    public function count($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->count_all_results($table);
    }

    public function get_only($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table);
    }

    public function get($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table)->row();
    }

    public function get_row_array($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table)->row_array();
    }

    public function get_all($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table)->result();
    }

    public function get_all_array($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table)->result_array();
    }

    public function get_where($data, $table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get_where($table, $data)->row();
    }

    public function get_all_where($data, $table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get_where($table, $data)->result();
    }

    public function paginate($page)
    {
        $this->db->limit($this->per_page, $this->calculate_real_offset($page));
        return $this;
    }

    public function calculate_real_offset($page)
    {
        if (is_null($page) || empty($page)) {
            $offset = 0;
        } else {
            $offset = ($page * $this->per_page) - $this->per_page;
        }

        return $offset;
    }

    public function select($columns)
    {
        $this->db->select($columns);
        return $this;
    }

    public function from($table)
    {
        $this->db->from($table);
        return $this;
    }

    public function where($column, $condition)
    {
        $this->db->where($column, $condition);
        return $this;
    }

    public function where_not($column, $condition)
    {
        $this->db->where($column . ' !=', $condition);
        return $this;
    }

    public function or_where($column, $condition)
    {
        $this->db->or_where($column, $condition);
        return $this;
    }

    // public function or_where_not($column, $condition)
    // {
    //     $this->db->or_where($column . ' !=', $condition);
    //     return $this;
    // }

    public function where_not_in($column, $condition)
    {
        $this->db->where_not_in($column, $condition);
        return $this;
    }

    public function where_relation($table_middle, $condition, $table_from = "")
    {
        $table = $this->check_table($table_from);
        $this->db->where("$table_middle.{$table}_id", $condition);
        return $this;
    }

    // public function or_where_relation($table_middle, $condition, $table_from = "")
    // {
    //     $table = $this->check_table($table_from);
    //     $this->db->or_where("$table_middle.{$table}_id", $condition);
    //     return $this;
    // }

    public function having($column, $condition = "")
    {
        $this->db->having($column, $condition);
        return $this;
    }

    public function or_having($column, $condition)
    {
        $this->db->or_having($column, $condition);
        return $this;
    }

    public function group_by($column)
    {
        $this->db->group_by($column);
        return $this;
    }

    public function like($column, $condition)
    {
        $this->db->like($column, $condition);
        return $this;
    }

    public function or_like($column, $condition)
    {
        $this->db->or_like($column, $condition);
        return $this;
    }

    public function validate()
    {
        // $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
        $validation_rules = $this->get_validation_rules(); // in child model
        $this->form_validation->set_rules($validation_rules);
        return $this->form_validation->run();
    }

    public function insert($data, $table = "")
    {
        $table = $this->check_table($table);
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($data, $table = "")
    {
        $table = $this->check_table($table);
        return $this->db->update($table, $data);
    }

    public function delete($table = "")
    {
        $table = $this->check_table($table);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function join($table, $type = 'left')
    {
        $this->db->join($table, "$this->table.{$table}_id = $table.{$table}_id", $type);
        return $this;
    }

    /**
     * Menggabungkan tabel secara fleksibel
     *
     * contoh:
     * input:  join_table('draft_author', 'author', 'author')
     * output: join('draft_author','draft_author.author_id == author.author_id')
     *
     * @param string $table_dest
     * @param string $table_middle
     * @return this
     **/
    public function join_table($table_to, $table_from, $column, $type = 'left')
    {
        $this->db->join($table_to, "$table_to.{$column}_id = $table_from.{$column}_id", $type);
        return $this;
    }

    /**
     * Menggabungkan tabel middle
     *
     * contoh:
     * input: join_relation_middle('user', 'reviewer')
     * output: join('reviewer','reviewer.user_id == user.user_id')
     *
     * @param string $table_dest
     * @param string $table_middle
     * @return this
     **/
    public function join_relation_middle($table_dest, $table_middle)
    {
        $this->db->join($table_middle, "$table_dest.{$table_dest}_id = $table_middle.{$table_dest}_id", "left");
        return $this;
    }

    /**
     * Menggabungkan tabel destination
     *
     * contoh:
     * input: join_relation_dest('reviewer', 'user')
     * output: join('reviewer','reviewer.user_id == user.user_id')
     *
     * @param string $table_dest
     * @param string $table_middle
     * @return this
     **/
    public function join_relation_dest($table_dest, $table_middle)
    {
        $this->db->join($table_dest, "$table_middle.{$table_dest}_id = $table_dest.{$table_dest}_id", "left");
        return $this;
    }

    public function order_by($column_name, $order = 'asc')
    {
        $this->db->order_by($column_name, $order);
        return $this;
    }

    public function limit($limit)
    {
        $this->db->limit($limit);
        return $this;
    }

    public function make_pagination($baseURL, $uriSegment, $totalRows = null)
    {
        $args = func_get_args();

        $this->load->library('pagination');

        $config = [
            'base_url'         => $baseURL,
            'uri_segment'      => $uriSegment,
            'per_page'         => $this->per_page,
            'total_rows'       => $totalRows,
            'use_page_numbers' => true,
            'num_links'        => 2,
            'attributes'       => array('class' => 'page-link'),
            'first_link'       => 'First',
            'last_link'        => 'Last',
            'next_link'        => '<i class="fa fa-lg fa-angle-right"></i>',
            'prev_link'        => '<i class="fa fa-lg fa-angle-left"></i>',
            'full_tag_open'    => '<ul class="pagination justify-content-center mt-4">',
            'full_tag_close'   => '</ul>',
            'num_tag_open'     => '<li class="page-item">',
            'num_tag_close'    => '</li>',
            'cur_tag_open'     => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close'    => '</span></li>',
            'next_tag_open'    => '<li class="page-item">',
            'next_tagl_close'  => '</li>',
            'prev_tag_open'    => '<li class="page-item">',
            'prev_tagl_close'  => 'Next</li>',
            'first_tag_open'   => '<li class="page-item">',
            'first_tag_close'  => '</li>',
            'last_tag_open'    => '<li class="page-item">',
            'last_tagl_close'  => '</li>',
        ];

        if (count($_GET) > 0) {
            $config['suffix']    = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        } else {
            $config['suffix']    = http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'];
        }

        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    public function get_id_and_name($table_dest, $table_middle, $id_table_middle, $table_from = "")
    {
        $table = $this->check_table($table_from);
        return $this->select("$table_dest.{$table_dest}_id")
            ->select("$table_dest.{$table_dest}_name")
            ->join_relation_middle($table_dest, $table_middle)
            ->where_relation($table_middle, $id_table_middle, $table)
            ->get_all($table_dest);
    }

    public function update_draft_status($draft_id, $status)
    {
        $this->where('draft_id', $draft_id)
            ->update($status, 'draft');
    }

    // public function get_draft_from_relation($table_dest, $table_middle)
    // {
    //     return $this->join_relation_middle('draft', $table_middle)
    //         ->join_relation_dest($table_dest, $table_middle);
    // }

    public function get_pk_table_id($table_dest, $table_from, $table_middle, $id_table_dest, $id_table_from)
    {
        $query = $this->select("{$table_middle}_id")
            ->where("{$table_dest}_id", $id_table_dest)
            ->where("{$table_from}_id", $id_table_from)
            ->get_row_array($table_middle);

        if ($query) {
            $data = $query;

            return $data["{$table_middle}_id"];
        } else {
            return 0;
        }
    }

    public function edit_draft_date($id, $column, $date = '')
    {
        if ($date == "") {
            $date = date('Y-m-d H:i:s');
        }

        $data = array($column => $date);
        if ($this->where('draft_id', $id)->update($data, 'draft')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Mencari reviewer_id atau author_id berdasarkan user_id dan tipe role
     *
     * @param int $user_id
     * @param string $role ('reviewer' atau 'author')
     * @return int
     **/
    public function get_id_role_from_user_id($user_id, $role)
    {
        $id = 0;

        $data = $this->select($role . '_id')
            ->join_relation_dest('user', $role)
            ->where_relation($role, $user_id, 'user')
            ->get_row_array($role);

        if ($data) {
            $id = $data[$role . '_id'];
        }

        return $id;
    }

    public function get_id_draft_from_draft_id($draft_id, $role)
    {
        $id = 0;

        $data = $this->select($role . '_id')
            ->join_relation_dest('draft', $role)
            ->where_relation($role, $draft_id, 'draft')
            ->get_row_array($role);

        if ($data) {
            $id = $data[$role . '_id'];
        }

        return $id;
    }
}