<?php
class MY_Controller extends CI_Controller
{
    protected $pages = '';

    protected $username = '';
    protected $level = '';
    protected $level_asli = '';
    protected $is_login = '';
    protected $user_id = '';
    protected $role_id = '';

    public function __construct()
    {
        parent::__construct();
        $model = strtolower(get_class($this));
        $models = ucwords(get_class($this));
        if (file_exists(APPPATH . 'models/' . $models . '_model.php')) {
            $this->load->model($model . '_model',$model,true);
        }

    }
}
