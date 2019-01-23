<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api_category extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data draft
    function index_get() {
        $id = $this->get('category_id');


        if (!is_null($id)) {
            $query = $this->db->where('category_id', $id);
        }

        $query = $this->db->get('category');

        $category = $query->result();

        if (count($category) > 0) {
            foreach ($category as $key) {
                $draft = $this->db->get_where('draft', array('category_id' => $key->category_id))->result();
                
                $key->draft = $draft;
            }
        } else {
            $category = 'data category tidak ada';
        }

        $this->response($category, 200);
    }
}
?>
