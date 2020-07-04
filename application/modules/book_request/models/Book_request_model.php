<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_request_model extends MY_Model{
    public $per_page = 10;

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
        $set = [
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
        return $this->db
        ->select('book_request.*, book.book_title, book.book_file, book.book_file_link')
        ->from('book_request')
        ->join('book', 'book_request.book_id = book.book_id', 'left')
        ->where('book_request_id', $book_request_id)
        ->get()->row();
    }

    public function fetch_book_stock_id($book_id){
        return $this->db
        ->select('*')
        ->from('book_stock')
        ->where('book_id',$book_id)
        ->order_by("UNIX_TIMESTAMP(stock_input_date)","DESC")
        ->limit(1)->get()->row();
    }
    
    public function action_request($book_request_id){
        $date = date('Y-m-d H:i:s');
        $user = $_SESSION['username'];
        $note = $this->input->post('request_notes_admin');

        $set = [
            'flag'                  => $this->input->post('flag'),
            'request_status'        => 2,
            'request_user'          => $user,
            'request_notes_admin'   => $note,
            'request_date'          => $date
        ];

        if($this->input->post('flag') == 2){//setuju
            $set['final_status']        = 1;
            $set['final_user']          = '';
            $set['final_date']          = '';
            $set['final_notes_admin']   = '';
            $set['finish_date']         = '';
            $set['status']              = 1;
        }elseif($this->input->post('flag') == 1){//tolak
            $set['final_status']        = 0;
            $set['final_user']          = $user;
            $set['final_date']          = $date;
            $set['final_notes_admin']   = $note;
            $set['finish_date']         = $date;
            $set['status']              = 2;
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

    public function filter_book_request($filters, $page){
        $book_request = $this->select(['book_request_id','book_request.book_id','book_title','entry_date','order_number','total','status'])
        ->when('keyword',$filters['keyword'])
        ->when('status',$filters['status'])
        ->join_table('book','book_request','book')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('book_title')
        ->paginate($page)
        ->get_all();

        $total = $this->select(['book_request_id','book_request.book_id','book_title','entry_date','order_number','total','status'])
        ->when('keyword',$filters['keyword'])
        ->when('status',$filters['status'])
        ->join_table('book','book_request','book')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('book_title')
        ->count();

        return [
            'book_request'  => $book_request,
            'total'         => $total,
        ];
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data != '') {
            if($params == 'keyword'){
                $this->group_start();
                $this->or_like('book_title',$data);
                $this->or_like('order_number',$data);
                $this->or_like('total',$data);
                $this->group_end();
            }

            if($params == 'status'){
                $this->where('status', $data);
            }
        }
        return $this;
    }
}