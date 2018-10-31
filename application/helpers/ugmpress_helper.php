<?php

function konversi_username_level($username){
    if($username=='' || $username == null){
        return "-";
    }else{
        $CI =& get_instance();
        $query = $CI->db->from('user')->where('username', $username)->get();
        if(!$query){
            return "-";
        }else{
            if(isset($query->row()->level)){
                return $query->row()->level;
            }else{
                return "-";
            }
        }
    }
    
}

function konversiTanggal($input=null,$opsi=''){
    if($input==null || $input=='0000-00-00 00:00:00'){
        return "-";
    }
    $timeStamp = $input;
    if(!$opsi){
        return $timeStamp = date( "d/m/Y H:i:s", strtotime($timeStamp));
    }elseif($opsi=='dateonly'){
        return $timeStamp = date( "d/m/Y", strtotime($timeStamp));
    }else{}
}


// konversi id ke nama
function konversiID($table,$vars,$id)
{
    if($id==''){
        return "";
    }else{
        $CI =& get_instance();
        $query = $CI->db->from($table)->where($vars, $id)->get();
        if($query){
            return $query->row();
        }else{
            return "";
        }
    }
    
}

// Get list of option for dropdown.
function getDropdownListBook($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->from($table)->where('draft_status','14')->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of editor
function getDropdownListReviewer($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->where('level','reviewer')->or_where('level','author_reviewer')->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of editor
function getDropdownListAuthor($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->where('level','author')->or_where('level','author_reviewer')->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
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

