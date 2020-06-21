<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_request_model extends MY_Model{
    public function add_book_request(){
        $add = [
            'book_id'           => $this->input->post('book_id'),
            'order_number'      => $this->input->post('order_number'),
            'total'             => $this->input->post('total'),
            'notes'             => $this->input->post('notes'),
            'user_entry'        => $_SESSION['username'],
            'entry_date'        => date('Y-m-d H:i:s'),
            'request_status'    => 1,
        ];
        
        $this->db->insert('book_request', $add);
        return TRUE;
    }

    public function edit_book_request($book_request_id){
        $edit = [
            'book_id'           => $this->input->post('book_id'),
            'order_number'      => $this->input->post('order_number'),
            'total'             => $this->input->post('total'),
            'notes'             => $this->input->post('notes')
        ];

        $this->db->set($set)->where('book_request_id',$book_request_id)->update('book_request');
        return TRUE;
    }

    public function delete_book_request($book_request_id){
        $this->db->where('book_request_id',$book_request_id)->delete('book_request');
        return TRUE;
    }

    public function fetch_book_request_id($book_request_id){
        
    }

    public function action_request($book_request_id){
        $set = [
            'flag'                  => $this->input->post('flag'),
            'request_status'        => 2,
            'request_notes_admin'   => $this->input->post('request_notes_admin'),
            'request_user'          => $_SESSION['username'],
            'request_date'          => date('Y-m-d H:i:s')
        ];

        if($this->input->post('flag') == 2){//setuju
            $set['final_status']    = 1;//request status menjadi sedang dalam proses
            $set['status']          = 1;//status menjadi Proses Final
        }elseif($this->input->post('flag') == 1){//tolak
            $set['status']          = 2;//status menjadi ditolak
        }

        $this->db->set($set)->where('book_request_id',$book_request_id)->update('book_request');
        return TRUE;
    }

    public function action_final($book_request_id){
        $add    =   [
            'book_id'               => $this->input->post('book_id'),
            'stock_in_warehouse'    => $this->input->post('stock_in_warehouse'),
            'stock_out_warehouse'   => $this->input->post('stock_out_warehouse'),
            'stock_marketing'       => $this->input->post('stock_marketing'),
            'stock_input_notes'     => $this->input->post('stock_input_notes'),
            'stock_input_type'      => 2,
            'stock_input_user'      => $_SESSION['username'],
            'stock_input_date'      => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('book_stock', $add);

        $set    =   [
            'final_status'      => 2,
            'final_notes_admin' => $this->input->post('stock_input_notes'),
            'final_user'        => $_SESSION['username'],
            'final_date'        => date('Y-m-d H:i:s'),
            'status'            => 3
        ];

        $this->db->set($set)->where('book_request_id',$book_request_id)->update('book_request');
        return TRUE;
    }

    public function fetch_book_id($postData){
        $response = array();

        if(isset($postData['search']) ){
            $records = $this->db->select('book_id, book_title')->order_by('book_title','ASC')->like('book_title', $postData['search'],'both')->limit(5)->get('book')->result();
            foreach($records as $row ){
                $response[] = array("value"=>$row->book_id,"label"=>$row->book_title);
            }
        }

        return $response;
    }
}