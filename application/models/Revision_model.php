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

    public function is_revision_in_progress($draft_id, $staff_level)
    {
        $count =  $this->where('revision_role', $staff_level)
            ->where('draft_id', $draft_id)
            ->where('revision_end_date', null)
            ->count();

        return $count > 0 ? true : false;
    }
}

/* End of file Revision_model.php */