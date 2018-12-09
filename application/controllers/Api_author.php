<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api_author extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data author
    function index_get() {
        $id = $this->get('author_id');
        if ($id == '') {
            $author = $this->db->get('author')->result();
        } else {
            $this->db->where('author_id', $id);
            $author = $this->db->get('author')->result();
        }
        $this->response($author, 200);
    }
}
?>
