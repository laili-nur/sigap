<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_request extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'logistic_request';
        $this->load->model('logistic_request_model', 'logistic_request');
    }

    public function index(){

    }
}