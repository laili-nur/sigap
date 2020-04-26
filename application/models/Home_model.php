<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends MY_Model
{
    public function count_progress($progress)
    {
        return $this
            ->when('progress', $progress)
            ->count('draft');
    }

    public function when($params, $data)
    {
        // ambil logic dari model draft
        $this->load->model('Draft_model', 'draft');
        return $this->draft->when($params, $data);
    }
}

/* End of file Home_model.php */
/* Location: ./application/models/Home_model.php */
