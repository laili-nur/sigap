<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api_book extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data buku
    function index_get() {
        $id = $this->get('book_id');
        if ($id == '') {
            $book = $this->db->select(['book_id', 'draft_id', 'book_code', 'book_title', 'book_file_link', 'status_hak_cipta'])->get('book')->result();
        } else {
            $this->db->where('book_id', $id);
            $book = $this->db->get('book')->result();
        }
        $this->response($book, 200);
    }
}
?>
