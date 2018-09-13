<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller{
    public function index(){
        $main_view  = 'errors/error404';
		$this->load->view('template', compact( 'main_view'));
    }
}