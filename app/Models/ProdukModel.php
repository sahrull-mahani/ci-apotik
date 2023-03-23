<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
  protected $table      = 'tb_alat';
  protected $allowedFields = ['nama_alat', 'kode_alat', 'satuan', 'expired', 'harga', 'stok'];
}
