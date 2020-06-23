<?php defined('BASEPATH') or exit('No direct script access allowed');

class Printing_model extends MY_Model
{
    public $per_page = 10;

    public function add_printing(){
        $add = [
            'book_id'           => $this->input->post('book_id'),
            'print_type'        => $this->input->post('print_type'),
            'print_total'       => $this->input->post('print_total'),
            'print_category'    => $this->input->post('print_category'),
            'print_edition'     => $this->input->post('print_edition'),
            'paper_content'     => $this->input->post('paper_content'),
            'paper_cover'       => $this->input->post('paper_cover'),
            'paper_size'        => $this->input->post('paper_size'),
            'print_priority'    => $this->input->post('print_priority'),
            'order_number'      => $this->input->post('order_number'),
            'entry_date'        => date('Y-m-d H:i:s'),
            'user_entry'        => $_SESSION['username'],
            'progress_status'   => 0
        ];
        
        $this->db->insert('printing', $add);
        return TRUE;
    }

    public function to_new_book($print_id,$book_file){
        $add = [
            'draft_id'          => $this->input->post('draft_id'),
            'book_code'         => $this->input->post('book_code'),
            'book_title'        => $this->input->post('book_title'),
            'book_edition'      => $this->input->post('book_edition'),
            'book_pages'        => $this->input->post('book_pages'),
            'isbn'              => $this->input->post('isbn'),
            'eisbn'             => $this->input->post('eisbn'),
            'published_date'    => $this->input->post('published_date'),
            'harga'             => $this->input->post('harga'),
            'book_file'         => $book_file,
            'book_file_link'    => $this->input->post('book_file_link'),
            'book_notes'        => $this->input->post('book_notes')
        ];
        
        $this->db->insert('book', $add);
        $this->db->set('book_id',$this->db->insert_id())->where('print_id',$print_id)->update('printing');

        return TRUE;
    }

    public function edit_printing($print_id){
        $edit = [
            'book_id'               => $this->input->post('book_id'),
            'print_type'            => $this->input->post('print_type'),
            'print_total'           => $this->input->post('print_total'),
            'print_category'        => $this->input->post('print_category'),
            'print_edition'         => $this->input->post('print_edition'),
            'paper_content'         => $this->input->post('paper_content'),
            'paper_cover'           => $this->input->post('paper_cover'),
            'paper_size'            => $this->input->post('paper_size'),
            'print_priority'        => $this->input->post('print_priority'),
            'order_number'          => $this->input->post('order_number'),
            'entry_date'            => $this->input->post('entry_date'),
            'finish_date'           => $this->input->post('finish_date'),
            'preprint_status'       => $this->input->post('preprint_status'),
            'preprint_start_date'   => $this->input->post('preprint_start_date'),
            'preprint_end_date'     => $this->input->post('preprint_end_date'),
            'print_status'          => $this->input->post('print_status'),
            'print_start_date'      => $this->input->post('print_start_date'),
            'print_end_date'        => $this->input->post('print_end_date'),
            'binding_status'        => $this->input->post('binding_status'),
            'binding_start_date'    => $this->input->post('binding_start_date'),
            'binding_end_date'      => $this->input->post('binding_end_date'),
        ];

        if($this->input->post('preprint_status') == 0){//preprint belum
            $edit['preprint_flag']      = 0;
            $edit['print_flag']         = 0;
            $edit['print_status']       = 0;
            $edit['binding_flag']       = 0;
            $edit['binding_status']     = 0;
            $edit['final_status']       = 0;
            $edit['progress_status']    = 0;
        }elseif($this->input->post('preprint_status') == 2){//preprint sudah
            $edit['preprint_flag']      = 2;
            $edit['print_flag']         = 0;
            $edit['print_status']       = 1;
            $edit['binding_flag']       = 0;
            $edit['binding_status']     = 0;
            $edit['final_status']       = 0;
            $edit['progress_status']    = 2;
        }elseif($this->input->post('print_status') == 0){//print belum
            $edit['print_flag']         = 0;
            $edit['binding_flag']       = 0;
            $edit['binding_status']     = 0;
            $edit['final_status']       = 0;
        }elseif($this->input->post('print_status') == 2){//print sudah
            $edit['print_flag']         = 2;
            $edit['binding_flag']       = 0;
            $edit['binding_status']     = 1;
            $edit['final_status']       = 0;
            $edit['progress_status']    = 3;
        }elseif($this->input->post('binding_status') == 0){//binding belum
            $edit['binding_flag']       = 0;
            $edit['final_status']       = 0;
        }elseif($this->input->post('binding_status') == 2){//binding sudah
            $edit['binding_flag']       = 2;
            $edit['final_status']       = 1;
            $edit['progress_status']    = 4;
        }
        
        $this->db->set($edit)->where('print_id',$print_id)->update('printing');
        return TRUE;
    }

    public function delete_printing($print_id){
        $this->db->where('print_id',$print_id)->delete('printing');
        return TRUE;
    }

    public function fetch_print_id($print_id){
        return $this->db
        ->select('printing.*, book.book_title')
        ->from('printing')
        ->join('book', 'printing.book_id = book.book_id', 'left')
        ->where('print_id', $print_id)
        ->get()
        ->row();
    }

    public function fetch_book_data($book_id){
        return $this->db
        ->select('*')
        ->from('book')
        ->where('book_id',$book_id)
        ->get()
        ->row();
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

    public function fetch_draft_id($postData){
        $response = array();

        if(isset($postData['search']) ){
            $records = $this->db->select('draft_id, draft_title')->where('draft_status', '14')->order_by('draft_title','ASC')->like('draft_title', $postData['search'],'both')->limit(5)->get('draft')->result();
            foreach($records as $row ){
                $response[] = array("value"=>$row->draft_id,"label"=>$row->draft_title);
            }
        }

        return $response;
    }

    public function start_progress($print_id,$progress_name){
        $set    =   [
            $progress_name.'_status'        =>  1,
            $progress_name.'_start_date'    =>  date('Y-m-d H:i:s')
        ];

        if($progress_name == 'preprint'){
            $set['progress_status'] = 1; //preprint
        }elseif($progress_name == 'print'){
            $set['progress_status'] = 2; //print
        }elseif($progress_name == 'binding'){
            $set['progress_status'] = 3; //binding
        }

        $this->db->set($set)->where('print_id',$print_id)->update('printing');
        return TRUE;
    }

    public function stop_progress($print_id,$progress_name){
        $set    =   [
            $progress_name.'_status'    =>  2,
            $progress_name.'_end_date'  =>  date('Y-m-d H:i:s'),
            $progress_name.'_user'      =>  $_SESSION['username']
        ];

        if($progress_name == 'preprint'){
            $set['progress_status'] = 1; //preprint
        }elseif($progress_name == 'print'){
            $set['progress_status'] = 2; //print
        }elseif($progress_name == 'binding'){
            $set['progress_status'] = 3; //binding
        }

        $this->db->set($set)->where('print_id',$print_id)->update('printing');
        return TRUE;
    }

    public function set_deadline($print_id,$progress_name){
        $this->db
        ->set($progress_name.'_deadline',$this->input->post($progress_name.'_deadline'))
        ->where('print_id',$print_id)
        ->update('printing');
        return TRUE;
    }
    
    public function add_notes($print_id,$progress_name){
        $this->db
        ->set($progress_name.'_notes',$this->input->post($progress_name.'_notes'))
        ->where('print_id',$print_id)
        ->update('printing');
        return TRUE;
    }

    public function choose_action($print_id,$progress_name){
        $set    =   [
                        $progress_name.'_flag'          =>  $this->input->post($progress_name.'_flag'),
                        $progress_name.'_status'        =>  2,
                        $progress_name.'_notes_admin'   =>  $this->input->post($progress_name.'_notes_admin'),
                    ];

        if($progress_name == 'preprint' && $this->input->post($progress_name.'_flag') == 2){
            $set['progress_status'] =   2; //print
        }elseif($progress_name == 'print' && $this->input->post($progress_name.'_flag') == 2){
            $set['progress_status'] =   3; //binding
        }elseif($progress_name == 'binding' && $this->input->post($progress_name.'_flag') == 2){
            $set['progress_status'] =   4; //final
        }elseif($this->input->post($progress_name.'_flag') == 1 ){
            $set['printing_flag']   =   1;
            $set['progress_status'] =   5; //tolak
        }

        $this->db
        ->set($set)
        ->where('print_id',$print_id)
        ->update('printing');
        return TRUE;
    }

    public function set_book($print_id){
        $this->db
        ->set('book_id',$this->input->post('book_id'))
        ->where('print_id',$print_id)
        ->update('printing');
        return TRUE;
    }

    public function finalisasi_printing($print_id){
        $add    =   [
            'book_id'               => $this->input->post('book_id'),
            'stock_in_warehouse'    => $this->input->post('stock_in_warehouse'),
            'stock_out_warehouse'   => $this->input->post('stock_out_warehouse'),
            'stock_marketing'       => $this->input->post('stock_marketing'),
            'stock_input_notes'     => $this->input->post('stock_input_notes'),
            'stock_input_type'      => 1,
            'stock_input_user'      => $_SESSION['username'],
            'stock_input_date'      => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('book_stock', $add);

        $set    =   [
            'is_final'          => 0,
            'final_status'      => 1,
            'printing_flag'     => 2,
            'finish_date'       => date('Y-m-d H:i:s'),
            'progress_status'   => 6
        ];

        $this->db->set($set)->where('print_id',$print_id)->update('printing');
        return TRUE;
    }

    public function filter_printing($filters, $page){
        $printing = $this->select(['printing.print_id','printing.book_id','book.book_title','printing.print_edition','printing.print_category','printing.print_type','printing.print_total','printing.print_priority','printing.entry_date','printing.progress_status','printing.order_number'])
        ->when('keyword', $filters['keyword'])//book_title dan print edition
        ->when('print_category',$filters['print_category'])
        ->when('print_type',$filters['print_type'])
        ->when('print_priority',$filters['print_priority'])
        ->when('progress_status',$filters['progress_status'])
        ->join_table('book','printing','book')
        ->order_by('print_priority','DESC')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('book_title')
        ->paginate($page)
        ->get_all();

        $total = $this->select(['printing.print_id','printing.book_id','book.book_title','printing.print_edition','printing.print_category','printing.print_type','printing.print_total','printing.print_priority','printing.entry_date','printing.progress_status','printing.order_number'])
        ->when('keyword', $filters['keyword'])//book_title dan print edition
        ->when('print_category',$filters['print_category'])
        ->when('print_type',$filters['print_type'])
        ->when('print_priority',$filters['print_priority'])
        ->when('progress_status',$filters['progress_status'])
        ->join_table('book','printing','book')
        ->order_by('print_priority','DESC')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('book_title')
        ->count();

        return [
            'printing'  => $printing,
            'total'     => $total,
        ];
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data != '') {
            if($params == 'keyword'){
                $this->group_start();
                $this->or_like('book_title',$data);
                $this->or_like('print_edition',$data);
                $this->or_like('order_number',$data);
                $this->group_end();
            }

            if($params == 'print_category'){
                $this->where('print_category', $data);
            }

            if($params == 'print_type'){
                $this->where('print_type', $data);
            }

            if($params == 'print_priority'){
                $this->where('print_priority', $data);
            }

            if($params == 'progress_status'){
                $this->where('progress_status', $data);
            }
        }
        return $this;
    }
}
