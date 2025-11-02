<?php
// Kelompok 4 ptik B
class Blog extends CI_Controller{
    function construct()
{
parent:: construct();
}
function index(){
$data['title'] = "This Is Title";
$data['content'] = "This Is The Contents";
$this->load->view('blog_view',$data);
}
}