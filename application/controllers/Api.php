<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
  public function dashboard_stats() {
    $this->output->set_content_type('application/json');
    echo json_encode([
      'masuk'      => 3,
      'proses'     => 1,
      'selesai'    => 2,
      'pendapatan' => 125000
    ]);
  }
}
