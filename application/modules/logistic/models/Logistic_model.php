<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_model extends MY_Model
{
    public $per_page = 10;

    public function add_logistic(){
        $stock_warehouse    = $this->input->post('stock_warehouse');
        $stock_production   = $this->input->post('stock_production');
        $stock_other        = $this->input->post('stock_other');
        $date_created       = date('Y-m-d H:i:s');
        $user_created       = $_SESSION['username'];

        $add = [
            'name'              => $this->input->post('name'),
            'type'              => $this->input->post('type'),
            'category'          => $this->input->post('category'),
            'notes'             => $this->input->post('notes'),
            'stock_warehouse'   => abs($stock_warehouse),
            'stock_production'  => abs($stock_production),
            'stock_other'       => abs($stock_other),
            'date_created'      => $date_created,
            'user_created'      => $user_created
        ];
        
        $this->db->insert('logistic', $add);

        if(empty($stock_warehouse) == FALSE || empty($stock_production) == FALSE || empty($stock_other) == FALSE){
            $logistic_id = $this->db->insert_id();
            $this->initial_stock($logistic_id,abs($stock_warehouse),abs($stock_production),abs($stock_other),$user_created,$date_created);
        }

        return TRUE;
    }

    public function initial_stock($logistic_id,$stock_warehouse,$stock_production,$stock_other,$user_created,$date_created){
        $insert = [
            'logistic_id'       => $logistic_id,
            'stock_warehouse'   => $stock_warehouse,
            'stock_production'  => $stock_production,
            'stock_other'       => $stock_other,
            'input_notes'       => 'Input awal dari stok logistik.',
            'input_type'        => 'logistic',
            'input_user'        => $user_created,
            'input_date'        => $date_created
        ];

        $this->db->insert('logistic_stock', $insert);
    }

    public function edit_logistic($logistic_id){
        $edit = [
            'name'          => $this->input->post('name'),
            'type'          => $this->input->post('type'),
            'category'      => $this->input->post('category'),
            'notes'         => $this->input->post('notes'),
            'date_edited'   => date('Y-m-d H:i:s'),
            'user_edited'   => $_SESSION['username']
        ];
        
        $this->db->set($edit)->where('logistic_id',$logistic_id)->update('logistic');
        return TRUE;
    }

    public function delete_logistic($logistic_id){
        $this->db->where('logistic_id',$logistic_id)->delete('logistic');
        return TRUE;
    }

    public function fetch_logistic_id($logistic_id){
        return $this->db
        ->select('*')
        ->from('logistic')
        ->where('logistic_id', $logistic_id)
        ->get()
        ->row();
    }

    public function fetch_stock_by_id($logistic_id){
        
        $stock_history    = $this->db->select('*')->from('logistic_stock')->where('logistic_id',$logistic_id)->order_by("UNIX_TIMESTAMP(input_date)","DESC")->get()->result();
        $stock_last       = $this->db->select('*')->from('logistic_stock')->where('logistic_id',$logistic_id)->order_by("UNIX_TIMESTAMP(input_date)","DESC")->limit(1)->get()->row();
        return [
            'stock_history' => $stock_history,
            'stock_last'    => $stock_last
        ];
    }

    public function add_logistic_stock(){
        $logistic_id            = $this->input->post('logistic_id');
        $initial_warehouse      = intval($this->input->post('initial_warehouse'));
        $initial_production     = intval($this->input->post('initial_production'));
        $initial_other          = intval($this->input->post('initial_other'));
        $modifier_warehouse     = intval($this->input->post('modifier_warehouse'));
        $modifier_production    = intval($this->input->post('modifier_production'));
        $modifier_other         = intval($this->input->post('modifier_other'));
        $final_warehouse        = $initial_warehouse + $modifier_warehouse;
        $final_production       = $initial_production + $modifier_production;
        $final_other            = $initial_other + $modifier_other;

        if($modifier_warehouse < 0){
            $modifier_warehouse  =   ' - '.abs($modifier_warehouse);
        }elseif($modifier_warehouse >= 0){
            $modifier_warehouse  =   ' + '.abs($modifier_warehouse);
        }

        if($modifier_production < 0){
            $modifier_production  =   ' - '.abs($modifier_production);
        }elseif($modifier_production >= 0){
            $modifier_production  =   ' + '.abs($modifier_production);
        }

        if($modifier_other < 0){
            $modifier_other  =   ' - '.abs($modifier_other);
        }elseif($modifier_other >= 0){
            $modifier_other  =   ' + '.abs($modifier_other);
        }

        $edit   =   [
            'stock_warehouse'   => intval($final_warehouse),
            'stock_production'  => intval($final_production),
            'stock_other'       => intval($final_other)
        ];

        $add    =   [
            'logistic_id'       => $logistic_id,
            'stock_warehouse'   => $initial_warehouse.$modifier_warehouse,
            'stock_production'  => $initial_production.$modifier_production,
            'stock_other'       => $initial_other.$modifier_other,
            'input_notes'       => $this->input->post('input_notes'),
            'input_type'        => 'logistic_stock',
            'input_user'        => $_SESSION['username']
        ];
        
        $this->db->set($edit)->where('logistic_id',$logistic_id)->update('logistic');
        $this->db->insert('logistic_stock', $add);
        return TRUE;
    }

    public function delete_logistic_stock($logistic_stock_id){
        $this->db->where('logistic_stock_id',$logistic_stock_id)->delete('logistic_stock');
        return TRUE;
    }

    public function filter_logistic($filters, $page){
        $logistic = $this->select(['logistic_id','name','type','category'])
        ->when('keyword',$filters['keyword'])
        ->order_by('name')
        ->order_by('UNIX_TIMESTAMP(date_created)','ASC')
        ->paginate($page)
        ->get_all();

        $total = $this->select(['logistic_id','name','type','category'])
        ->when('keyword',$filters['keyword'])
        ->order_by('name')
        ->order_by('UNIX_TIMESTAMP(date_created)','ASC')
        ->count();

        return [
            'logistic'  => $logistic,
            'total'     => $total,
        ];
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data != '') {
            if($params == 'keyword'){
                $this->group_start();
                $this->or_like('name',$data);
                $this->or_like('type',$data);
                $this->or_like('category',$data);
                $this->group_end();
            }
        }
        return $this;
    }
}