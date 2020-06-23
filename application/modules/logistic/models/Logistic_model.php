<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_model extends MY_Model
{
    public function add_logistic(){
        $add = [
            'name'          => $this->input->post('name'),
            'type'          => $this->input->post('type'),
            'category'      => $this->input->post('category'),
            'notes'         => $this->input->post('notes'),
            'date_created'  => date('Y-m-d H:i:s'),
            'user_created'  => $_SESSION['username']
        ];
        
        $this->db->insert('logistic', $add);
        return TRUE;
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
        
        $stock_history    = $this->db->select('*')->from('logistic_stock')->where('logistic_id',$logistic_id)->order_by("UNIX_TIMESTAMP(input_date)","ASC")->get()->result();
        $stock_last       = $this->db->select('*')->from('logistic_stock')->where('logistic_id',$logistic_id)->order_by("UNIX_TIMESTAMP(input_date)","DESC")->limit(1)->get()->row();
        return [
            'stock_history' => $stock_history,
            'stock_last'    => $stock_last
        ];
    }

    public function add_logistic_stock(){
        $add    =   [
            'logistic_id'       => $this->input->post('logistic_id'),
            'stock_warehouse'   => $this->input->post('stock_warehouse'),
            'stock_production'  => $this->input->post('stock_production'),
            'stock_other'       => $this->input->post('stock_other'),
            'input_notes'       => $this->input->post('input_notes'),
            'input_type'        => 0,
            'input_user'        => $_SESSION['username'],
            'input_date'        => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('logistic_stock', $add);
        return TRUE;
    }

    public function delete_logistic_stock($logistic_stock_id){
        $this->db->where('logistic_stock_id',$logistic_stock_id)->delete('logistic_stock');
        return TRUE;
    }
}