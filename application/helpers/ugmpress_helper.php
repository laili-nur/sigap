<?php
function konversiTanggal($input=null){
    if($input==null || $input=='0000-00-00 00:00:00'){
        return "-";
    }
    $timeStamp = $input;
    return $timeStamp = date( "d/m/Y H:i:s", strtotime($timeStamp));
}


// konversi id ke nama
function konversiID($table,$vars,$id)
{
    $CI =& get_instance();
    $query = $CI->db->from($table)->where($vars, $id)->get();
    return $query->row();
}

// Get list of editor
function getDropdownListEditor($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->where('level','editor')->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of layouter
function getDropdownListLayouter($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->where('level','layouter')->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Khusus untuk category, mengambil yang aktif saja
function getDropdownListCategory($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->from($table)->where('category_status','y')->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of option for dropdown.
function getDropdownList($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

function getDropdownReviewerList($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->from($table)->where('level', 'reviewer')->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '- Choose -'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Choose -'];
}

function getDropdownBankList($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->from($table)->order_by("bank_name", "asc")->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '- Choose -'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Choose -'];
}



// Show form error validation message for "file" input.
function fileFormError($field, $prefix = '', $suffix = '')
{
    $CI =& get_instance();
    $error_field = $CI->form_validation->error_array();

    if (!empty($error_field[$field])) {
        return $prefix . $error_field[$field] . $suffix;
    }
    return '';
}

