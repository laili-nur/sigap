<?php defined('BASEPATH') or exit('No direct script access allowed');

class Printing_model extends MY_Model
{
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
            'user_entry'        => $_SESSION['username']
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
            'is_preprint'           => $this->input->post('is_preprint'),
            'preprint_start_date'   => $this->input->post('preprint_start_date'),
            'preprint_end_date'     => $this->input->post('preprint_end_date'),
            'is_print'              => $this->input->post('is_print'),
            'print_start_date'      => $this->input->post('print_start_date'),
            'print_end_date'        => $this->input->post('print_end_date'),
            'is_binding'            => $this->input->post('is_binding'),
            'binding_start_date'    => $this->input->post('binding_start_date'),
            'binding_end_date'      => $this->input->post('binding_end_date'),
        ];
        
        $this->db->set($edit)->where('print_id',$print_id)->update('printing');
        return TRUE;
    }

    public function delete_printing($print_id){
        $this->db->where('print_id',$print_id)->delete('printing');
        return TRUE;
    }

    public function fetch_print_id($print_id){
        return $this->db
        ->select('a.*, a.book_id as a_book_id, book_title')
        ->from('printing a')
        ->join('book b', 'b.book_id = a.book_id', 'left')
        ->where('print_id', $print_id)
        ->get();
    }

    public function fetch_book_data($book_id){
        return $this->db
        ->select('*')
        ->from('book')
        ->where('book_id',$book_id)
        ->get();
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

    public function fetch_all_data(){
        return $this->db
        ->select('print_id, a.book_id as a_book_id, book_title, print_edition, print_type, print_total, print_priority, entry_date, print_category, is_preprint, is_print, is_binding, is_final, printing_flag')
        ->from('printing a')
        ->join('book b', 'b.book_id = a.book_id', 'left')
        ->order_by('book_title', 'ASC')
        ->get();
    }//result() untuk fetch, num_rows() untuk total

    public function fetch_jilid_data(){
        return $this->db
        ->select('print_id, a.book_id as a_book_id, book_title, print_edition, print_type, print_total, print_priority, entry_date, print_category, is_preprint, is_print, is_binding, is_final, printing_flag')
        ->from('printing a')
        ->join('book b', 'b.book_id = a.book_id', 'left')
        ->order_by('book_title', 'ASC')
        ->where('jilid_user_id',$_SESSION['user_id'])
        ->get();
    }//result() untuk fetch, num_rows() untuk total

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



    public function start_progress($print_id,$progress_name){
        $this->db->set(
            [
                'is_'.$progress_name        =>  1,
                $progress_name.'_status'    =>  1,
                $progress_name.'_start_date' =>  date('Y-m-d H:i:s')
            ]
            )->where('print_id',$print_id)->update('printing');
        return TRUE;
    }

    public function stop_progress($print_id,$progress_name){
        $this->db->set(
            [
                'is_'.$progress_name        =>  1,
                $progress_name.'_status'    =>  2,
                $progress_name.'_end_date'  =>  date('Y-m-d H:i:s'),
                $progress_name.'_user'      =>  $_SESSION['username']
            ]
            )->where('print_id',$print_id)->update('printing');
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
        
        if($this->input->post($progress_name.'_flag') == 1){
            $set['printing_flag']  =   1;
        }

        if($progress_name == 'preprint'){
            $set['is_preprint'] =   0;
            $set['is_print']    =   1;
            $set['is_binding']  =   0;
            $set['is_final']    =   0;
        }elseif($progress_name == 'print'){
            $set['is_preprint'] =   0;
            $set['is_print']    =   0;
            $set['is_binding']  =   1;
            $set['is_final']    =   0;
        }elseif($progress_name == 'binding'){
            $set['is_preprint'] =   0;
            $set['is_print']    =   0;
            $set['is_binding']  =   0;
            $set['is_final']    =   1;
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
        $add = [
            'book_id'               => $this->input->post('book_id'),
            'stock_in_warehouse'    => $this->input->post('stok_dalam_gudang'),
            'stock_out_warehouse'   => $this->input->post('stok_luar_gudang'),
            'stock_marketing'       => $this->input->post('stok_pemasaran'),
            'stock_input_notes'     => $this->input->post('stok_input_notes'),
            'stock_input_type'      => 1,
            'stock_input_user'      => $_SESSION['username'],
            'stock_input_date'      => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('book_stock', $add);
        $this->db->set(
            [
                'is_final'          => 0,
                'final_status'      => 1,
                'printing_flag'     => 2,
                'finish_date'       => date('Y-m-d H:i:s')
            ]
        )->where('print_id',$print_id)->update('printing');
        return TRUE;
    }
}
