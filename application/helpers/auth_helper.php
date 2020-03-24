<?php

function is_admin()
{
    $CI    = &get_instance();
    $level = $CI->session->userdata('level');
    if ($level === 'author' || $level === 'reviewer' || $level === 'editor' || $level === 'layouter') {
        return false;
    }
    return true;
}

function is_superadmin()
{
    $CI    = &get_instance();
    $level = $CI->session->userdata('level');
    if ($level === 'superadmin') {
        return true;
    }
    return false;
}

function is_staff()
{
    $CI    = &get_instance();
    $level = $CI->session->userdata('level');
    if (is_admin() || $level === 'editor' || $level === 'layouter') {
        return true;
    }
    return false;
}

function check_level()
{
    $CI = &get_instance();
    return $CI->session->userdata('level');
}

function check_role()
{
    $CI = &get_instance();
    return $CI->session->userdata('role');
}

// function is_authorized()
// {
//     $CI       = &get_instance();
//     $username = $CI->session->userdata('username');
//     $level    = $CI->session->userdata('level');
// }