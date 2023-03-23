<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
  protected $table      = 'tb_customer';
  protected $allowedFields = ['kode_customer', 'nama_customer', 'alamat', 'telp', 'faks', 'email', 'konfir'];
  protected $primarykey = 'kode_customer';
}
