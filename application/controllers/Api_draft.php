<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api_draft extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data draft
    function index_get() {
        $id = $this->get('draft_id');
        if ($id == '') {
            $draft = $this->db->select(['draft_id', 'draft_title', 'draft_file', 'entry_date', 'finish_date', 'is_review'])->get('draft')->result();
        } else {
            $this->db->where('draft_id', $id);
            $draft = $this->db->get('draft')->result();
        }
        $this->response($draft, 200);
    }
}
?>
