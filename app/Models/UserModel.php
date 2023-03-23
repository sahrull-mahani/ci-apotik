<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  public function getLogin()
  {
    return $this->db->table('login')->where('level', 2)->get()->getResultArray();
  }
}
