<?php

namespace App\Models;

use CodeIgniter\Model;

class DistribusiModel extends Model
{
  public function getInvoice()
  {
    return $this->db->table('tb_invoice')
      ->select('tb_customer.nama_customer, tb_invoice.*')
      ->join('tb_customer', 'tb_customer.kode_customer = tb_invoice.kode_customer')
      ->orderBy('id', 'desc')
      ->get()->getResultArray();
  }

  public function getAlat()
  {
    return $this->db->table('tb_alat')->get()->getResultArray();
  }

  public function getCustomer()
  {
    return $this->db->table('tb_customer')->get()->getResultArray();
  }

  public function getSementara()
  {
    return $this->db->table('tb_sementara')->get()->getResultArray();
  }

  public function getSementaraAlat()
  {
    return $this->db->table('tb_sementara')->join('tb_alat', 'tb_sementara.kode_alat = tb_alat.kode_alat')->get()->getResultArray();
  }
}
