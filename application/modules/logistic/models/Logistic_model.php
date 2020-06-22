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
}