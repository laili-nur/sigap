<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{
    protected $pages = '';

    protected $username   = '';
    protected $level      = '';
    protected $level_asli = '';
    protected $is_login   = '';
    protected $user_id    = '';
    protected $role_id    = '';

    public function __construct()
    {
        parent::__construct();
        $this->_hmvc_fixes();

        $model  = strtolower(get_class($this));
        $models = ucwords(get_class($this));
        if (file_exists(APPPATH . 'models/' . $models . '_model.php')) {
            $this->load->model($model . '_model', $model, true);
        }

        // load toast message
        $this->lang->load('toast', 'indonesian');
    }

    public function _hmvc_fixes()
    {
        //fix callback form_validation
        //https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
        $this->load->library('form_validation');
        $this->form_validation->CI = &$this;
    }

    public function download_file($folder, $file_name)
    {
        $file = realpath($folder) . "\\" . $file_name;
        if (file_exists($file)) {
            $data = file_get_contents($file);
            force_download($file_name, $data);
        } else {
            echo $this->lang->line('toast_error_file_not_found');
            // $this->session->set_flashdata('warning', $this->lang->line('toast_error_file_not_found'));
            // redirect($redirect ?? $this->pages);
        }
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */