<?php
class Dashboard_model extends CI_Model {

  public function count_pelanggan(){
    return $this->db->count_all('pelanggan');
  }

  public function count_pesanan_hari_ini(){
    $today = date('Y-m-d');
    return $this->db->where('DATE(created_at)',$today)->count_all_results('pesanan');
  }

  public function count_sedang_proses(){
    return $this->db->where('status','PROSES')->count_all_results('pesanan');
  }

  public function count_selesai_hari_ini(){
    $today = date('Y-m-d');
    return $this->db->where('status','SELESAI')
                    ->where('DATE(updated_at)',$today)
                    ->count_all_results('pesanan');
  }

  public function sum_omzet_hari_ini(){
    $today = date('Y-m-d');
    $row = $this->db->select_sum('total')
                    ->where('status','SELESAI')
                    ->where('DATE(updated_at)',$today)
                    ->get('transaksi')->row();
    return $row && $row->total ? (float)$row->total : 0;
  }

  public function get_pesanan_terbaru($limit=5){
    return $this->db->order_by('created_at','DESC')->limit($limit)->get('pesanan')->result();
  }
}
