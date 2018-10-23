<?php
class MY_Model extends CI_Model
{
    protected $table          = '';
    protected $perPage        = 0;

    public function __construct()
    {
        parent::__construct();

        if (!$this->table) {
            $this->table = strtolower(str_replace('_model', '', get_class($this)));
        }
    }

    public function checkTable($table) {
        if ($table == "") {
            $table = $this->table;
        }

        return $table;
    }

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function count($table = "")
    {
        $table = $this->checkTable($table);
        return $this->db->count_all_results($table);
    }

    public function get($table = "")
    {
        $table = $this->checkTable($table);
        return $this->db->get($table)->row();
    }

    public function getRowArray($table = "") {
        $table = $this->checkTable($table);
        return $this->db->get($table)->row_array();
    }

    public function getAll($table = "")
    {
        $table = $this->checkTable($table);
        return $this->db->get($table)->result();
    }

    public function getAllArray($table = "")
    {
        $table = $this->checkTable($table);
        return $this->db->get($table)->result_array();
    }

    public function getWhere($data, $table = "") {
        $table = $this->checkTable($table);
        return $this->db->get_where($table, $data)->row();
    }

    public function getAllWhere($data, $table = "") {
        $table = $this->checkTable($table);
        return $this->db->get_where($table, $data)->result();
    }

    public function paginate($page)
    {
        $this->db->limit($this->perPage, $this->calculateRealOffset($page));
        return $this;
    }

    public function calculateRealOffset($page)
    {
        if (is_null($page) || empty($page)) {
            $offset = 0;
        } else {
            $offset = ($page * $this->perPage) - $this->perPage;
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
    
    public function whereNot($column, $condition)
    {
        $this->db->where($column.' !=', $condition);
        return $this;
    }

    public function orWhere($column, $condition)
    {
        $this->db->or_where($column, $condition);
        return $this;
    }

    public function orWhereNot($column, $condition)
    {
        $this->db->or_where($column.' !=', $condition);
        return $this;
    }

    public function whereRelation($table_middle, $condition, $table_from = "")
    {
        $table = $this->checkTable($table_from);
        $this->db->where("$table_middle.{$table}_id", $condition);
        return $this;
    }

    public function orWhereRelation($table_middle, $condition, $table_from = "")
    {
        $table = $this->checkTable($table_from);
        $this->db->or_where("$table_middle.{$table}_id", $condition);
        return $this;
    }
    
        public function like($column, $condition)
    {
        $this->db->like($column, $condition);
        return $this;
    }

    public function orLike($column, $condition)
    {
        $this->db->or_like($column, $condition);
        return $this;
    }

    public function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        $validationRules = $this->getValidationRules();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();

        // return false;
    }

    public function insert($data, $table = "")
    {
        $table = $this->checkTable($table);
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($data, $table = "")
    {
        $table = $this->checkTable($table);
        return $this->db->update($table, $data);
    }

    public function delete($table = "")
    {
        $table = $this->checkTable($table);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function join($table, $type = 'left')
    {
        $this->db->join($table, "$this->table.{$table}_id = $table.{$table}_id", $type);
        return $this;
    }

    public function join3($table1, $table2, $column, $type = 'left')
    {
        $this->db->join($table1, "$table1.{$column}_id = $table2.{$column}_id", $type);
        return $this;
    }

    public function joinRelationMiddle($table_dest, $table_middle) {
        $this->db->join($table_middle, "$table_dest.{$table_dest}_id = $table_middle.{$table_dest}_id", "left");
        return $this;
    }

    public function joinRelationDest($table_dest, $table_middle) {
        $this->db->join($table_dest, "$table_middle.{$table_dest}_id = $table_dest.{$table_dest}_id", "left");
        return $this;
    }

    public function orderBy($column_name, $order = 'asc')
    {
        $this->db->order_by($column_name, $order);
        return $this;
    }

    public function limit($limit)
    {
        $this->db->limit($limit);
        return $this;
    }

    public function makePagination($baseURL, $uriSegment, $totalRows = null)
    {
        $args = func_get_args();

        $this->load->library('pagination');

        $config = [
            'base_url'          => $baseURL,
            'uri_segment'       => $uriSegment,
            'per_page'          => $this->perPage,
            'total_rows'        => $totalRows,
            'use_page_numbers'  => true,
            'num_links'         => 5,
            'first_link'        => 'First',
            'last_link'         => 'Last',
            'next_link'         => '<i class="fa fa-lg fa-angle-right"></i>',
            'prev_link'         => '<i class="fa fa-lg fa-angle-left"></i>',
            'full_tag_open'     => '<ul class="pagination justify-content-center mt-4">',
            'full_tag_close'    => '</ul>',
            'num_tag_open'      => '<li class="page-item"><span class="page-link">',
            'num_tag_close'     => '</span></li>',
            'cur_tag_open'      => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close'     => '<span class="sr-only">(current)</span></span></li>',
            'next_tag_open'     => '<li class="page-item"><span class="page-link">',
            'next_tagl_close'   => '<span aria-hidden="true">&raquo;yyyy</span></span></li>',
            'prev_tag_open'     => '<li class="page-item"><span class="page-link">',
            'prev_tagl_close'   => '</span>Next</li>',
            'first_tag_open'    => '<li class="page-item"><span class="page-link">',
            'first_tagl_close'  => '</span></li>',
            'last_tag_open'     => '<li class="page-item"><span class="page-link">',
            'last_tagl_close'   => '</span></li>',
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

    public function getIdAndName($table_dest, $table_middle, $id_table_middle, $table_from = "") {
        $table = $this->checkTable($table_from);
        return $this->select("$table_dest.{$table_dest}_id")
                    ->select("$table_dest.{$table_dest}_name")
                    ->joinRelationMiddle($table_dest, $table_middle)
                    ->whereRelation($table_middle, $id_table_middle, $table)
                    ->getAll($table_dest);
    }

    public function updateDraftStatus($draft_id, $status) {
        $this->where('draft_id', $draft_id)
             ->update($status, 'draft');
    }

    public function getDraftFromRelation($table_dest, $table_middle) {
        return $this->joinRelationMiddle('draft', $table_middle)
                    ->joinRelationDest($table_dest, $table_middle);
    }

    public function getPKTableId($table_dest, $table_from, $table_middle, $id_table_dest, $id_table_from) {
        $query = $this->select("{$table_middle}_id")
                      ->where("{$table_dest}_id", $id_table_dest)
                      ->where("{$table_from}_id", $id_table_from)
                      ->getRowArray($table_middle);

        if ($query) {
            $data = $query;

            return $data["{$table_middle}_id"];
        } else {
            return 0;
        }
    }

    public function editDraftDate($id, $column, $date = '') {
        if ($date == "") {
            $date = date('Y-m-d H:i:s');
        }

        $data = array($column => $date);
        $this->where('draft_id', $id)
             ->update($data, 'draft');
    }

    public function getIdRoleFromUserId($user_id, $role) {
        $id = 0;

        $data =  $this->select($role . '_id')
                      ->joinRelationDest('user', $role)
                      ->whereRelation($role, $user_id, 'user')
                      ->getRowArray($role);

        if ($data) {
            $id = $data[$role . '_id'];
        }

        return $id;
    }

    public function getIdDraftFromDraftId($draft_id, $role) {
        $id = 0;

        $data =  $this->select($role . '_id')
                      ->joinRelationDest('draft', $role)
                      ->whereRelation($role, $draft_id, 'draft')
                      ->getRowArray($role);

        if ($data) {
            $id = $data[$role . '_id'];
        }

        return $id;
    }
}