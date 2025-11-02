<?php
class MY_Controller extends CI_Controller {
  protected function render($view, $data = []){
    $this->load->view('partials/header', $data);
    $this->load->view($view, $data);
    $this->load->view('partials/footer');
  }
}
