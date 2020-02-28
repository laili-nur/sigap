<?php

function check_if_admin()
{
    $CI    = &get_instance();
    $level = $CI->session->userdata('level');
    if ($level === 'author' || $level === 'reviewer' || $level === 'editor' || $level === 'layouter') {
        redirect('home');
    }
}