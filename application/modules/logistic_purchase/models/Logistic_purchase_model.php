<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_purchase_model extends MY_Model{
    public $per_page = 10;

    public function when($params, $data)
    {
        // jika data null, maka skip
        // if ($data != '') {
        //     if($params == 'keyword'){
        //         $this->group_start();
        //         $this->or_like('name',$data);
        //         $this->or_like('order_number',$data);
        //         $this->or_like('total',$data);
        //         $this->group_end();
        //     }

        //     if($params == 'status'){
        //         $this->where('status', $data);
        //     }

        //     if($params == 'type'){
        //         $this->where('type', $data);
        //     }
        // }
        // return $this;
    }
}