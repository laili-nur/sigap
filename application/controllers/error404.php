<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error404 extends MY_Controller
{
    public function index()
    {
        $this->load->view('errors/error404');
    }
}