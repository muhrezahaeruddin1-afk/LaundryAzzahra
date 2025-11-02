<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function is_logged_in(){
  $CI =& get_instance();
  return (bool)$CI->session->userdata('user_id');
}

function current_user(){
  $CI =& get_instance();
  return (object)[
    'id'       => $CI->session->userdata('user_id'),
    'nama'     => $CI->session->userdata('nama'),
    'username' => $CI->session->userdata('username'),
    'role'     => $CI->session->userdata('role')
  ];
}

function require_login(){
  if (!is_logged_in()){
    redirect('login');
    exit;
  }
}

function require_role($roles = []){
  require_login();
  $CI =& get_instance();
  $role = $CI->session->userdata('role');
  if (!in_array($role, (array)$roles, true)){
    // Akses ditolak → balik ke dashboard
    redirect('dashboard');
    exit;
  }
}
