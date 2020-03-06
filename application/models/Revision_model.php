<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Revision_model extends MY_Model
{
    public function count_revision($draft_id, $staff_level)
    {
        return $this->where('revision_role', $staff_level)
            ->where('draft_id', $draft_id)
            ->count();
    }
}

/* End of file Revision_model.php */