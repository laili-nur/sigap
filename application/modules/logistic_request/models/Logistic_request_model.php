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
        elseif($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_keuangan'):
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
}