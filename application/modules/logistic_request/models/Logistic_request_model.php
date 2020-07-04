<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_request_model extends MY_Model
{
    public $per_page = 10;

    public function filter_logistic_request($filters,$page){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang'):
        $logistic_request = $this->select(['logistic_request_id','logistic_request.logistic_id','name','entry_date','logistic_request.type','order_number','total','status'])
        ->when('keyword',$filters['keyword'])
        ->when('status',$filters['status'])
        ->when('type',$filters['type'])
        ->join_table('logistic', 'logistic_request','logistic')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('name')
        ->paginate($page)
        ->get_all();
        
        $total = $this->select(['logistic_request_id','logistic_request.logistic_id','name','entry_date','logistic_request.type','order_number','total','status'])
        ->when('keyword',$filters['keyword'])
        ->when('status',$filters['status'])
        ->when('type',$filters['type'])
        ->join_table('logistic', 'logistic_request','logistic')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('name')
        ->count();
        elseif($_SESSION['level'] == 'admin_keuangan'):
        $logistic_request = $this->select(['logistic_request_id','logistic_request.logistic_id','name','entry_date','logistic_request.type','order_number','total','status'])
        ->when('keyword',$filters['keyword'])
        ->when('status',$filters['status'])
        ->when('type',$filters['type'])
        ->where('logistic_request.type',1)
        ->join_table('logistic', 'logistic_request','logistic')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('name')
        ->paginate($page)
        ->get_all();

        $total = $this->select(['logistic_request_id','logistic_request.logistic_id','name','entry_date','logistic_request.type','order_number','total','status'])
        ->when('keyword',$filters['keyword'])
        ->when('status',$filters['status'])
        ->when('type',$filters['type'])
        ->where('logistic_request.type',1)
        ->join_table('logistic', 'logistic_request','logistic')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('name')
        ->count();
        elseif($_SESSION['level'] == 'admin_percetakan'):
        $logistic_request = $this->select(['logistic_request_id','logistic_request.logistic_id','name','entry_date','logistic_request.type','order_number','total','status'])
        ->when('keyword',$filters['keyword'])
        ->when('status',$filters['status'])
        ->when('type',$filters['type'])
        ->where('logistic_request.type',0)
        ->join_table('logistic', 'logistic_request','logistic')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('name')
        ->paginate($page)
        ->get_all();

        $total = $this->select(['logistic_request_id','logistic_request.logistic_id','name','entry_date','logistic_request.type','order_number','total','status'])
        ->when('keyword',$filters['keyword'])
        ->when('status',$filters['status'])
        ->when('type',$filters['type'])
        ->where('logistic_request.type',0)
        ->join_table('logistic', 'logistic_request','logistic')
        ->order_by('UNIX_TIMESTAMP(entry_date)','DESC')
        ->order_by('name')
        ->count();
        endif;

        return [
            'logistic_request'  => $logistic_request,
            'total'             => $total,
        ];
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data != '') {
            if($params == 'keyword'){
                $this->group_start();
                $this->or_like('name',$data);
                $this->or_like('order_number',$data);
                $this->or_like('total',$data);
                $this->group_end();
            }

            if($params == 'status'){
                $this->where('status', $data);
            }

            if($params == 'type'){
                $this->where('type', $data);
            }
        }
        return $this;
    }

    public function add_logistic_request(){
        $add = [
            'logistic_id'       => $this->input->post('logistic_id'),
            'order_number'      => $this->input->post('order_number'),
            'total'             => $this->input->post('total'),
            'notes'             => $this->input->post('notes'),
            'user_entry'        => $_SESSION['username'],
            'entry_date'        => date('Y-m-d H:i:s'),
            'request_status'    => 1,
        ];

        if($_SESSION['level'] == 'superadmin'){
            $add['type']    = $this->input->post('type');
        }elseif($_SESSION['level'] == 'admin_percetakan'){
            $add['type']    = 0;
        }elseif($_SESSION['level'] == 'admin_gudang' || $_SESSION['level'] == 'admin_keuangan'){
            $add['type']    = 1;
        }
        
        $this->db->insert('logistic_request', $add);
        return TRUE;
    }

    public function edit_logistic_request($logistic_request_id){
        $set = [
            'logistic_id'       => $this->input->post('logistic_id'),
            'order_number'      => $this->input->post('order_number'),
            'total'             => $this->input->post('total'),
            'notes'             => $this->input->post('notes')
        ];

        $this->db->set($set)->where('logistic_request_id',$logistic_request_id)->update('logistic_request');
        return TRUE;
    }

    public function delete_logistic_request($logistic_request_id){
        $this->db->where('logistic_request_id',$logistic_request_id)->delete('logistic_request');
        return TRUE;
    }

    public function fetch_logistic_id($postData){
        $response = array();

        if(isset($postData['search']) ){
            $records = $this->db->select('logistic_id, name')->order_by('name','ASC')->like('name', $postData['search'],'both')->limit(5)->get('logistic')->result();
            foreach($records as $row ){
                $response[] = array("value"=>$row->logistic_id,"label"=>$row->name);
            }
        }

        return $response;
    }

    public function fetch_logistic_request_id($logistic_request_id){
        return $this->db
        ->select('logistic_request.*, logistic.name')
        ->from('logistic_request')
        ->join('logistic', 'logistic_request.logistic_id = logistic.logistic_id', 'left')
        ->where('logistic_request_id', $logistic_request_id)
        ->get()->row();
    }
}