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

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */